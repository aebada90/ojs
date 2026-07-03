<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Journal;
use App\Services\AiReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isJournalEditor()) {
            $journalIds = $user->journals()->pluck('id');
            $articles = Article::whereIn('journal_id', $journalIds)
                ->with(['journal', 'author', 'review'])
                ->latest()
                ->paginate(15);
        } elseif ($user->isAdmin()) {
            $articles = Article::with(['journal', 'author', 'review'])->latest()->paginate(15);
        } else {
            $articles = $user->articles()->with(['journal', 'review'])->latest()->paginate(15);
        }

        return view('articles.index', compact('articles'));
    }

    public function create(Request $request): View
    {
        $journals = Journal::where('is_active', true)->orderBy('name')->get();

        return view('articles.create', compact('journals'));
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $keywords = array_filter(array_map('trim', explode(',', $request->keywords ?? '')));

        $article = Article::create([
            'journal_id' => $request->journal_id,
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'abstract' => $request->abstract,
            'content' => $request->content,
            'keywords' => $keywords,
            'authors' => [['name' => $request->user()->name, 'email' => $request->user()->email]],
            'status' => Article::STATUS_SUBMITTED,
            'word_count' => str_word_count(strip_tags($request->content)),
            'submitted_at' => now(),
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article submitted successfully. You can now request an AI review.');
    }

    public function show(Article $article): View
    {
        $this->authorizeArticle($article);

        $article->load(['journal', 'author', 'review']);

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article): View
    {
        $this->authorizeArticle($article, authorOnly: true);

        $journals = Journal::where('is_active', true)->orderBy('name')->get();

        return view('articles.edit', compact('article', 'journals'));
    }

    public function update(StoreArticleRequest $request, Article $article): RedirectResponse
    {
        $this->authorizeArticle($article, authorOnly: true);

        $keywords = array_filter(array_map('trim', explode(',', $request->keywords ?? '')));

        $article->update([
            'journal_id' => $request->journal_id,
            'title' => $request->title,
            'abstract' => $request->abstract,
            'content' => $request->content,
            'keywords' => $keywords,
            'word_count' => str_word_count(strip_tags($request->content)),
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorizeArticle($article, authorOnly: true);

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    private function authorizeArticle(Article $article, bool $authorOnly = false): void
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return;
        }

        if ($authorOnly && $article->user_id === $user->id) {
            return;
        }

        if ($user->isJournalEditor() && $article->journal->user_id === $user->id) {
            return;
        }

        if ($article->user_id === $user->id) {
            return;
        }

        abort(403);
    }
}
