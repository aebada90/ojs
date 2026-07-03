<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJournalRequest;
use App\Models\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(Request $request): View
    {
        $journals = $request->user()->isAdmin()
            ? Journal::with('editor')->withCount('articles')->latest()->paginate(12)
            : $request->user()->journals()->withCount('articles')->latest()->paginate(12);

        return view('journals.index', compact('journals'));
    }

    public function create(): View
    {
        return view('journals.create');
    }

    public function store(StoreJournalRequest $request): RedirectResponse
    {
        $slug = Str::slug($request->name);
        $baseSlug = $slug;
        $counter = 1;

        while (Journal::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        $journal = Journal::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'slug' => $slug,
        ]);

        return redirect()->route('journals.show', $journal)
            ->with('success', 'Journal created successfully.');
    }

    public function show(Journal $journal): View
    {
        $journal->load(['editor']);
        $articles = $journal->articles()->with(['author', 'review'])->latest()->paginate(10);

        return view('journals.show', compact('journal', 'articles'));
    }

    public function edit(Journal $journal): View
    {
        $this->authorizeJournal($journal);

        return view('journals.edit', compact('journal'));
    }

    public function update(StoreJournalRequest $request, Journal $journal): RedirectResponse
    {
        $this->authorizeJournal($journal);

        $journal->update($request->validated());

        return redirect()->route('journals.show', $journal)
            ->with('success', 'Journal updated successfully.');
    }

    public function destroy(Journal $journal): RedirectResponse
    {
        $this->authorizeJournal($journal);

        $journal->delete();

        return redirect()->route('journals.index')
            ->with('success', 'Journal deleted successfully.');
    }

    private function authorizeJournal(Journal $journal): void
    {
        $user = auth()->user();

        if (! $user->isAdmin() && $journal->user_id !== $user->id) {
            abort(403);
        }
    }
}
