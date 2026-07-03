<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Review;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiReviewService
{
    private const CRITERIA = [
        'originality' => 'Originality & Contribution',
        'methodology' => 'Methodology Rigor',
        'clarity' => 'Clarity & Writing Quality',
        'structure' => 'Structure & Organization',
        'references' => 'Literature & References',
        'ethics' => 'Research Ethics',
        'reproducibility' => 'Reproducibility',
    ];

    public function review(Article $article): Review
    {
        $settings = $article->journal->reviewSettings();

        $review = Review::create([
            'article_id' => $article->id,
            'status' => Review::STATUS_PROCESSING,
        ]);

        $article->update(['status' => Article::STATUS_UNDER_REVIEW]);

        try {
            $analysis = $this->analyze($article, $settings);

            $review->update([
                'status' => Review::STATUS_COMPLETED,
                'recommendation' => $analysis['recommendation'],
                'overall_score' => $analysis['overall_score'],
                'criteria_scores' => $analysis['criteria_scores'],
                'feedback' => $analysis['feedback'],
                'flags' => $analysis['flags'],
                'summary' => $analysis['summary'],
                'completed_at' => now(),
            ]);

            $article->update([
                'status' => match ($analysis['recommendation']) {
                    Review::RECOMMEND_ACCEPT => Article::STATUS_ACCEPTED,
                    Review::RECOMMEND_REJECT => Article::STATUS_REJECTED,
                    default => Article::STATUS_REVISION,
                },
            ]);
        } catch (\Throwable $e) {
            Log::error('AI review failed', ['article_id' => $article->id, 'error' => $e->getMessage()]);

            $review->update([
                'status' => Review::STATUS_FAILED,
                'summary' => 'Review processing failed. Please try again.',
            ]);

            $article->update(['status' => Article::STATUS_SUBMITTED]);
        }

        return $review->fresh();
    }

    private function analyze(Article $article, array $settings): array
    {
        if ($openAiResult = $this->tryOpenAiAnalysis($article)) {
            return $openAiResult;
        }

        return $this->ruleBasedAnalysis($article, $settings);
    }

    private function tryOpenAiAnalysis(Article $article): ?array
    {
        $apiKey = config('services.openai.key');

        if (empty($apiKey)) {
            return null;
        }

        try {
            $prompt = $this->buildPrompt($article);

            $response = Http::withToken($apiKey)
                ->timeout(60)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => config('services.openai.model', 'gpt-4o-mini'),
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are an expert academic peer reviewer. Respond only with valid JSON.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.3,
                    'response_format' => ['type' => 'json_object'],
                ]);

            if (! $response->successful()) {
                return null;
            }

            $content = $response->json('choices.0.message.content');
            $parsed = json_decode($content, true);

            if (! is_array($parsed) || ! isset($parsed['overall_score'])) {
                return null;
            }

            return $this->normalizeAnalysis($parsed);
        } catch (\Throwable $e) {
            Log::warning('OpenAI review unavailable, falling back to rule-based', ['error' => $e->getMessage()]);

            return null;
        }
    }

    private function buildPrompt(Article $article): string
    {
        $criteria = implode(', ', array_values(self::CRITERIA));
        $keywords = $article->keywords ? implode(', ', $article->keywords) : 'None';

        return <<<PROMPT
Review this academic manuscript and return JSON with:
- overall_score (0-100)
- recommendation (accept|minor_revision|major_revision|reject)
- criteria_scores: object with keys originality, methodology, clarity, structure, references, ethics, reproducibility (each 0-100)
- feedback: object with keys strengths, weaknesses, suggestions (each array of strings)
- flags: array of issue objects with type (warning|error|info) and message
- summary: string (2-3 sentences)

Title: {$article->title}
Abstract: {$article->abstract}
Keywords: {$keywords}
Word count: {$article->word_count}

Content (excerpt):
{$this->contentExcerpt($article->content)}

Evaluate on: {$criteria}
PROMPT;
    }

    private function ruleBasedAnalysis(Article $article, array $settings): array
    {
        $content = $article->content;
        $abstract = $article->abstract;
        $wordCount = $article->word_count;
        $abstractWords = str_word_count($abstract);

        $criteriaScores = [];
        $flags = [];
        $feedback = [
            'strengths' => [],
            'weaknesses' => [],
            'suggestions' => [],
        ];

        // Originality
        $originalityScore = 70;
        $uniqueTerms = count(array_unique(str_word_count(strtolower($content), 1)));
        if ($uniqueTerms > 500) {
            $originalityScore += 10;
            $feedback['strengths'][] = 'Manuscript demonstrates rich vocabulary and diverse terminology, suggesting original treatment of the topic.';
        }
        if ($this->containsAny($content, ['novel', 'innovative', 'first to', 'new approach', 'contribution'])) {
            $originalityScore += 8;
            $feedback['strengths'][] = 'Authors explicitly articulate the novelty and contribution of their work.';
        }
        $criteriaScores['originality'] = min(100, $originalityScore);

        // Methodology
        $methodScore = 55;
        $methodTerms = ['method', 'methodology', 'experiment', 'sample', 'data collection', 'analysis', 'hypothesis', 'participants', 'procedure'];
        $methodMatches = $this->countTermMatches($content, $methodTerms);
        $methodScore += min(30, $methodMatches * 5);
        if ($methodMatches >= 4) {
            $feedback['strengths'][] = 'Methodology section appears well-developed with clear description of research procedures.';
        } else {
            $feedback['weaknesses'][] = 'Methodology description appears insufficient. Expand on data collection, sample size, and analytical procedures.';
            $flags[] = ['type' => 'warning', 'message' => 'Limited methodology terminology detected in manuscript.'];
        }
        if ($settings['check_methodology'] && $methodMatches < 2) {
            $methodScore -= 15;
        }
        $criteriaScores['methodology'] = min(100, max(20, $methodScore));

        // Clarity
        $clarityScore = 65;
        $avgSentenceLength = $this->averageSentenceLength($content);
        if ($avgSentenceLength > 35) {
            $clarityScore -= 15;
            $feedback['weaknesses'][] = 'Sentences are lengthy on average. Consider breaking complex sentences for improved readability.';
            $flags[] = ['type' => 'warning', 'message' => 'Average sentence length exceeds recommended academic writing guidelines.'];
        } elseif ($avgSentenceLength < 25) {
            $clarityScore += 10;
            $feedback['strengths'][] = 'Writing demonstrates good readability with appropriately structured sentences.';
        }
        if ($this->containsAny($content, ['therefore', 'however', 'furthermore', 'consequently', 'in contrast'])) {
            $clarityScore += 8;
            $feedback['strengths'][] = 'Effective use of transitional phrases improves logical flow between sections.';
        }
        $criteriaScores['clarity'] = min(100, max(30, $clarityScore));

        // Structure
        $structureScore = 50;
        $sections = ['introduction', 'literature', 'method', 'result', 'discussion', 'conclusion', 'reference'];
        $sectionFound = 0;
        foreach ($sections as $section) {
            if ($this->containsSection($content, $section)) {
                $sectionFound++;
            }
        }
        $structureScore += $sectionFound * 7;
        if ($sectionFound >= 5) {
            $feedback['strengths'][] = 'Manuscript follows standard IMRaD structure with clearly identifiable sections.';
        } else {
            $feedback['weaknesses'][] = 'Some standard sections appear missing or unclear. Ensure Introduction, Methods, Results, Discussion, and Conclusion are distinct.';
            $flags[] = ['type' => 'warning', 'message' => 'Incomplete section structure detected.'];
        }
        $criteriaScores['structure'] = min(100, $structureScore);

        // References
        $refScore = 50;
        $citationPatterns = preg_match_all('/\(\d{4}\)|\[\d+\]|et al\.|doi:|https?:\/\/doi\.org/i', $content);
        $refScore += min(35, $citationPatterns * 3);
        if ($citationPatterns >= 8) {
            $feedback['strengths'][] = 'Adequate citation density suggests engagement with existing literature.';
        } else {
            $feedback['weaknesses'][] = 'Citation density appears low. Strengthen engagement with relevant prior work.';
            if ($settings['check_references']) {
                $flags[] = ['type' => 'warning', 'message' => 'Low citation count detected.'];
            }
        }
        $criteriaScores['references'] = min(100, max(25, $refScore));

        // Ethics
        $ethicsScore = 70;
        $ethicsTerms = ['ethics', 'ethical', 'consent', 'irb', 'institutional review', 'conflict of interest', 'funding', 'declaration'];
        $ethicsMatches = $this->countTermMatches($content, $ethicsTerms);
        if ($ethicsMatches >= 2) {
            $ethicsScore += 20;
            $feedback['strengths'][] = 'Ethical considerations and declarations are addressed in the manuscript.';
        } else {
            if ($settings['check_ethics']) {
                $ethicsScore -= 20;
                $feedback['weaknesses'][] = 'Ethics statement, consent procedures, or conflict of interest declarations not clearly identified.';
                $flags[] = ['type' => 'error', 'message' => 'Missing or insufficient ethics declarations.'];
            }
        }
        $criteriaScores['ethics'] = min(100, max(30, $ethicsScore));

        // Reproducibility
        $reproScore = 55;
        $reproTerms = ['dataset', 'code', 'replication', 'reproducib', 'supplementary', 'open access', 'github', 'available upon request'];
        $reproMatches = $this->countTermMatches($content, $reproTerms);
        $reproScore += min(30, $reproMatches * 8);
        if ($reproMatches >= 1) {
            $feedback['strengths'][] = 'Authors indicate availability of data or materials supporting reproducibility.';
        } else {
            $feedback['suggestions'][] = 'Consider providing data availability statement and sharing code or supplementary materials.';
        }
        $criteriaScores['reproducibility'] = min(100, max(30, $reproScore));

        // Abstract checks
        if ($abstractWords < ($settings['min_abstract_words'] ?? 150)) {
            $flags[] = ['type' => 'warning', 'message' => "Abstract is short ({$abstractWords} words). Recommended minimum: {$settings['min_abstract_words']} words."];
            $feedback['weaknesses'][] = 'Abstract should be expanded to include background, methods, key results, and conclusions.';
        } else {
            $feedback['strengths'][] = 'Abstract meets recommended length requirements.';
        }

        // Word count
        if ($wordCount < ($settings['min_word_count'] ?? 3000)) {
            $flags[] = ['type' => 'warning', 'message' => "Manuscript word count ({$wordCount}) is below journal minimum ({$settings['min_word_count']})."];
            $feedback['weaknesses'][] = 'Manuscript length is below typical requirements for full research articles.';
        }

        // Keywords
        if (empty($article->keywords) || count($article->keywords) < 3) {
            $feedback['suggestions'][] = 'Add 4-6 descriptive keywords to improve discoverability.';
        }

        // Generate suggestions
        $feedback['suggestions'][] = 'Ensure all figures and tables are referenced in the text and include descriptive captions.';
        $feedback['suggestions'][] = 'Review statistical reporting for completeness (effect sizes, confidence intervals, p-values).';
        $feedback['suggestions'][] = 'Verify that the discussion addresses study limitations and future research directions.';

        $overallScore = round(array_sum($criteriaScores) / count($criteriaScores), 2);
        $recommendation = $this->determineRecommendation($overallScore, $flags, $criteriaScores);

        $summary = $this->generateSummary($overallScore, $recommendation, count($flags));

        return $this->normalizeAnalysis([
            'overall_score' => $overallScore,
            'recommendation' => $recommendation,
            'criteria_scores' => $criteriaScores,
            'feedback' => $feedback,
            'flags' => $flags,
            'summary' => $summary,
        ]);
    }

    private function normalizeAnalysis(array $data): array
    {
        $criteriaScores = [];
        foreach (array_keys(self::CRITERIA) as $key) {
            $criteriaScores[$key] = (float) ($data['criteria_scores'][$key] ?? 50);
        }

        return [
            'overall_score' => round((float) ($data['overall_score'] ?? 50), 2),
            'recommendation' => $data['recommendation'] ?? Review::RECOMMEND_MAJOR,
            'criteria_scores' => $criteriaScores,
            'feedback' => [
                'strengths' => $data['feedback']['strengths'] ?? [],
                'weaknesses' => $data['feedback']['weaknesses'] ?? [],
                'suggestions' => $data['feedback']['suggestions'] ?? [],
            ],
            'flags' => $data['flags'] ?? [],
            'summary' => $data['summary'] ?? 'Review completed.',
        ];
    }

    private function determineRecommendation(float $score, array $flags, array $criteriaScores): string
    {
        $errorFlags = count(array_filter($flags, fn ($f) => ($f['type'] ?? '') === 'error'));
        $lowCriteria = count(array_filter($criteriaScores, fn ($s) => $s < 45));

        if ($errorFlags >= 2 || $score < 45 || $lowCriteria >= 3) {
            return Review::RECOMMEND_REJECT;
        }

        if ($score >= 80 && $errorFlags === 0 && $lowCriteria === 0) {
            return Review::RECOMMEND_ACCEPT;
        }

        if ($score >= 65) {
            return Review::RECOMMEND_MINOR;
        }

        return Review::RECOMMEND_MAJOR;
    }

    private function generateSummary(float $score, string $recommendation, int $flagCount): string
    {
        $recLabel = match ($recommendation) {
            Review::RECOMMEND_ACCEPT => 'acceptance',
            Review::RECOMMEND_MINOR => 'minor revisions before acceptance',
            Review::RECOMMEND_MAJOR => 'major revisions',
            Review::RECOMMEND_REJECT => 'rejection',
            default => 'further review',
        };

        return "AI review completed with an overall quality score of {$score}/100. "
            ."Based on automated analysis across ".count(self::CRITERIA)." criteria, the recommendation is {$recLabel}. "
            .($flagCount > 0 ? "{$flagCount} issue(s) were flagged for editorial attention." : 'No critical issues were flagged.');
    }

    private function containsAny(string $text, array $terms): bool
    {
        $lower = strtolower($text);

        foreach ($terms as $term) {
            if (str_contains($lower, strtolower($term))) {
                return true;
            }
        }

        return false;
    }

    private function countTermMatches(string $text, array $terms): int
    {
        $lower = strtolower($text);
        $count = 0;

        foreach ($terms as $term) {
            if (str_contains($lower, strtolower($term))) {
                $count++;
            }
        }

        return $count;
    }

    private function containsSection(string $content, string $section): bool
    {
        return (bool) preg_match('/\b'.preg_quote($section, '/').'s?\b/i', $content);
    }

    private function averageSentenceLength(string $text): float
    {
        $sentences = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $sentences = array_filter($sentences, fn ($s) => str_word_count($s) > 3);

        if (empty($sentences)) {
            return 20;
        }

        $totalWords = array_sum(array_map('str_word_count', $sentences));

        return $totalWords / count($sentences);
    }

    private function contentExcerpt(string $content, int $maxChars = 4000): string
    {
        return Str::limit(strip_tags($content), $maxChars);
    }

    public static function criteriaLabels(): array
    {
        return self::CRITERIA;
    }
}
