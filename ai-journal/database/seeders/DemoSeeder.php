<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Journal;
use App\Models\Review;
use App\Models\User;
use App\Services\AiReviewService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@aijournal.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'organization' => 'AI Journal Platform',
            'email_verified_at' => now(),
        ]);

        $editor = User::create([
            'name' => 'Dr. Sarah Chen',
            'email' => 'editor@aijournal.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_EDITOR,
            'organization' => 'Stanford University Press',
            'email_verified_at' => now(),
        ]);

        $author = User::create([
            'name' => 'Dr. James Wilson',
            'email' => 'author@aijournal.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_AUTHOR,
            'organization' => 'MIT Research Lab',
            'email_verified_at' => now(),
        ]);

        $journal = Journal::create([
            'user_id' => $editor->id,
            'name' => 'Journal of Artificial Intelligence Research',
            'slug' => 'jair',
            'issn' => '1234-5678',
            'description' => 'A leading open-access journal publishing cutting-edge research in artificial intelligence, machine learning, and computational sciences.',
            'subject_area' => 'Computer Science / AI',
            'website' => 'https://example.com/jair',
            'is_active' => true,
        ]);

        $journal2 = Journal::create([
            'user_id' => $editor->id,
            'name' => 'International Review of Data Science',
            'slug' => 'irds',
            'issn' => '9876-5432',
            'description' => 'Peer-reviewed journal focusing on data science methodologies, big data analytics, and statistical computing applications.',
            'subject_area' => 'Data Science',
            'is_active' => true,
        ]);

        $sampleContent = $this->sampleManuscript();

        $article = Article::create([
            'journal_id' => $journal->id,
            'user_id' => $author->id,
            'title' => 'Deep Learning Approaches for Automated Scientific Manuscript Review',
            'abstract' => $this->sampleAbstract(),
            'content' => $sampleContent,
            'keywords' => ['deep learning', 'peer review', 'natural language processing', 'scientific publishing', 'automation'],
            'authors' => [
                ['name' => 'Dr. James Wilson', 'email' => 'author@aijournal.test'],
                ['name' => 'Dr. Emily Park', 'email' => 'emily@example.com'],
            ],
            'status' => Article::STATUS_SUBMITTED,
            'word_count' => str_word_count(strip_tags($sampleContent)),
            'submitted_at' => now()->subDays(2),
        ]);

        $reviewService = new AiReviewService();
        $reviewService->review($article);

        Article::create([
            'journal_id' => $journal2->id,
            'user_id' => $author->id,
            'title' => 'A Survey of Ethical Frameworks in AI-Assisted Academic Publishing',
            'abstract' => 'This paper surveys existing ethical frameworks governing the use of artificial intelligence in academic publishing workflows. We examine consent, transparency, bias mitigation, and accountability requirements across major publishing standards. Our analysis covers 45 institutional policies and proposes a unified ethical checklist for AI-assisted peer review systems.',
            'content' => 'Introduction. The integration of artificial intelligence into academic publishing raises significant ethical concerns that require careful consideration by journal editors, authors, and technology providers...',
            'keywords' => ['ethics', 'AI publishing', 'peer review', 'accountability'],
            'status' => Article::STATUS_SUBMITTED,
            'word_count' => 2500,
            'submitted_at' => now()->subDay(),
        ]);
    }

    private function sampleAbstract(): string
    {
        return 'The peer review process is a cornerstone of academic publishing, yet it faces growing challenges including reviewer shortages, inconsistent quality, and lengthy turnaround times. This study presents a novel deep learning framework for automated preliminary manuscript assessment. Our approach combines transformer-based language models with domain-specific feature extraction to evaluate manuscripts across seven quality dimensions including originality, methodology rigor, clarity, and ethical compliance. We trained and validated our system on a corpus of 12,000 peer-reviewed articles across multiple disciplines. Results demonstrate that our model achieves 87% agreement with human editorial decisions on accept/revise/reject recommendations. The system provides detailed, structured feedback that assists both authors and editors in the review process. We discuss limitations, ethical considerations, and the role of AI as a complement to — rather than replacement for — human peer review. Our findings suggest that AI-assisted review can reduce editorial workload by 40% while maintaining quality standards.';
    }

    private function sampleManuscript(): string
    {
        return <<<'MANUSCRIPT'
Introduction

The peer review process remains the gold standard for validating scholarly research, yet the academic publishing ecosystem faces unprecedented pressure. The number of submissions to major journals has increased by 150% over the past decade, while the pool of available reviewers has remained relatively static. This imbalance has resulted in review times stretching to 6-12 months for many journals, creating significant delays in the dissemination of important research findings.

Artificial intelligence and natural language processing technologies have advanced dramatically, offering new possibilities for automating aspects of the manuscript evaluation process. However, existing automated tools focus primarily on plagiarism detection and formatting compliance, leaving the substantive quality assessment to human reviewers. There is a clear need for intelligent systems that can provide meaningful preliminary review while respecting the nuanced judgment that human experts bring to the process.

This paper introduces ReviewNet, a deep learning framework designed for automated preliminary manuscript assessment. Our contributions are threefold: (1) a multi-criteria evaluation architecture that assesses manuscripts across seven quality dimensions, (2) a large-scale training dataset derived from published articles and their associated review outcomes, and (3) a comprehensive evaluation demonstrating strong agreement with human editorial decisions.

Literature Review

Previous work on automated scientific review has explored various approaches. Wang et al. (2020) proposed using BERT-based models for review recommendation, achieving moderate success in matching manuscripts to appropriate reviewers. Liu and Zhang (2021) developed a system for automated review generation, though their approach produced generic feedback lacking specificity. More recently, GPT-based models have been applied to various scientific text processing tasks (Brown et al., 2022), demonstrating the potential of large language models in this domain.

Our work differs from prior approaches by focusing on structured, multi-dimensional quality assessment rather than free-form review generation. We draw on established peer review criteria used by major publishers and academic societies to define our evaluation framework.

Methodology

We collected a dataset of 12,000 manuscripts from five major open-access journals, paired with their editorial decisions and anonymized reviewer scores. Each manuscript was annotated across seven criteria: originality, methodology, clarity, structure, references, ethics, and reproducibility.

Our model architecture combines a fine-tuned SciBERT encoder with a multi-task learning head that simultaneously predicts scores for each criterion and an overall recommendation. Training was conducted using the Adam optimizer with a learning rate of 2e-5 over 10 epochs. We employed 5-fold cross-validation and report results on a held-out test set of 2,400 manuscripts.

Data collection followed ethical guidelines approved by our institutional review board. All manuscript data was obtained from publicly available sources with appropriate permissions. Informed consent was obtained where required, and we declare no conflicts of interest. This research was funded by grant NSF-2024-AI-4521.

Results

ReviewNet achieved an overall accuracy of 87% in predicting editorial decisions (accept, minor revision, major revision, reject) on the test set. Per-criterion scoring showed strong correlation with human reviewer scores (Pearson r > 0.75 for all criteria). The model demonstrated particular strength in identifying methodological weaknesses and structural issues.

Analysis of processing time revealed that ReviewNet can complete a full manuscript review in approximately 45 seconds, compared to an average of 4-6 weeks for traditional peer review. Error analysis identified that the model struggles most with highly interdisciplinary manuscripts and those presenting genuinely novel methodological approaches.

Discussion

Our results demonstrate that AI-assisted preliminary review can provide valuable support to the academic publishing workflow. The structured feedback generated by ReviewNet offers specific, actionable guidance that can help authors improve their manuscripts before formal peer review. For editors, the system provides a consistent first-pass assessment that can help prioritize manuscripts and identify potential issues early.

However, we emphasize that AI review should complement, not replace, human expertise. The model cannot assess the true novelty of groundbreaking ideas, evaluate the significance of results within a field, or make nuanced judgments about theoretical contributions. These limitations must be clearly communicated to all stakeholders.

Study limitations include the focus on STEM disciplines, potential bias in training data toward English-language publications, and the inability to evaluate figures, tables, and supplementary materials. Future work will address multimodal analysis and expand coverage to humanities and social sciences.

Conclusion

We have presented ReviewNet, a deep learning framework for automated preliminary manuscript review that achieves strong agreement with human editorial decisions. By providing structured, multi-dimensional feedback, the system can reduce editorial workload and accelerate the publishing process while maintaining quality standards. We release our code and evaluation benchmarks to support further research in this important area.

References

Brown, T., et al. (2022). Language models are few-shot learners. Journal of AI Research, 45(3), 201-220.

Liu, H., & Zhang, Y. (2021). Automated peer review generation using neural networks. Computational Linguistics, 47(2), 89-112.

Wang, L., et al. (2020). BERT-based reviewer recommendation for academic manuscripts. Proceedings of ACL 2020, 3421-3430.
MANUSCRIPT;
    }
}
