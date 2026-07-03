<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Review;
use App\Services\AiReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(private AiReviewService $reviewService) {}

    public function show(Review $review): View
    {
        $review->load(['article.journal', 'article.author']);

        $this->authorizeReview($review);

        $criteriaLabels = AiReviewService::criteriaLabels();

        return view('reviews.show', compact('review', 'criteriaLabels'));
    }

    public function store(Request $request, Article $article): RedirectResponse
    {
        $this->authorizeArticleReview($article);

        if ($article->status === Article::STATUS_UNDER_REVIEW) {
            return back()->with('error', 'This article is already being reviewed.');
        }

        $review = $this->reviewService->review($article);

        return redirect()->route('reviews.show', $review)
            ->with('success', 'AI review completed successfully.');
    }

    public function updateNotes(Request $request, Review $review): RedirectResponse
    {
        $this->authorizeReview($review, editorOnly: true);

        $request->validate([
            'editor_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $review->update(['editor_notes' => $request->editor_notes]);

        return back()->with('success', 'Editor notes saved.');
    }

    private function authorizeReview(Review $review, bool $editorOnly = false): void
    {
        $user = auth()->user();
        $article = $review->article;

        if ($user->isAdmin()) {
            return;
        }

        if ($editorOnly) {
            if ($user->isJournalEditor() && $article->journal->user_id === $user->id) {
                return;
            }
            abort(403);
        }

        if ($article->user_id === $user->id) {
            return;
        }

        if ($user->isJournalEditor() && $article->journal->user_id === $user->id) {
            return;
        }

        abort(403);
    }

    private function authorizeArticleReview(Article $article): void
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return;
        }

        if ($article->user_id === $user->id) {
            return;
        }

        if ($user->isJournalEditor() && $article->journal->user_id === $user->id) {
            return;
        }

        abort(403);
    }
}
