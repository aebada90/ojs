<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Journal;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isJournalEditor()) {
            return $this->editorDashboard($user);
        }

        return $this->authorDashboard($user);
    }

    private function adminDashboard(): View
    {
        $stats = [
            'users' => \App\Models\User::count(),
            'journals' => Journal::count(),
            'articles' => Article::count(),
            'reviews' => Review::where('status', Review::STATUS_COMPLETED)->count(),
        ];

        $recentArticles = Article::with(['journal', 'author', 'review'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentArticles'));
    }

    private function editorDashboard($user): View
    {
        $journals = $user->journals()->withCount('articles')->get();

        $articles = Article::whereIn('journal_id', $journals->pluck('id'))
            ->with(['author', 'journal', 'review'])
            ->latest()
            ->take(15)
            ->get();

        $stats = [
            'journals' => $journals->count(),
            'pending' => $articles->whereIn('status', [Article::STATUS_SUBMITTED, Article::STATUS_UNDER_REVIEW])->count(),
            'reviewed' => $articles->whereIn('status', [Article::STATUS_REVIEWED, Article::STATUS_ACCEPTED, Article::STATUS_REVISION, Article::STATUS_REJECTED])->count(),
            'avg_score' => Review::whereHas('article', fn ($q) => $q->whereIn('journal_id', $journals->pluck('id')))
                ->where('status', Review::STATUS_COMPLETED)
                ->avg('overall_score'),
        ];

        return view('dashboard.editor', compact('journals', 'articles', 'stats'));
    }

    private function authorDashboard($user): View
    {
        $articles = $user->articles()->with(['journal', 'review'])->latest()->get();

        $journals = Journal::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'submitted' => $articles->count(),
            'under_review' => $articles->where('status', Article::STATUS_UNDER_REVIEW)->count(),
            'accepted' => $articles->where('status', Article::STATUS_ACCEPTED)->count(),
            'revision' => $articles->where('status', Article::STATUS_REVISION)->count(),
        ];

        return view('dashboard.author', compact('articles', 'journals', 'stats'));
    }
}
