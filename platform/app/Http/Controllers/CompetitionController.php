<?php

namespace App\Http\Controllers;

use App\Support\DirndlContest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompetitionController extends Controller
{
    public function index(): View
    {
        $contestants = DirndlContest::contestants();
        $voter = DirndlContest::voterKey();

        return view('competition.index', [
            'contestants' => $contestants,
            'votedFor' => DirndlContest::votedFor($voter),
            'totalVotes' => DirndlContest::totalVotes(),
            'leader' => $contestants[0] ?? null,
        ]);
    }

    public function show(string $slug): View
    {
        $contestant = DirndlContest::find($slug);
        abort_if($contestant === null, 404);

        return view('competition.show', [
            'contestant' => $contestant,
            'votedFor' => DirndlContest::votedFor(DirndlContest::voterKey()),
            'totalVotes' => DirndlContest::totalVotes(),
        ]);
    }

    public function vote(Request $request, string $slug): RedirectResponse
    {
        $contestant = DirndlContest::find($slug);
        abort_if($contestant === null, 404);

        $result = DirndlContest::vote($slug, DirndlContest::voterKey());

        if (! $result['ok']) {
            return back()->with('error', __('platform.competition.vote_limit'));
        }

        $message = $result['previous']
            ? __('platform.competition.vote_moved', ['name' => $contestant['name']])
            : __('platform.competition.vote_thanks', ['name' => $contestant['name']]);

        return back()->with('success', $message);
    }

    public function enterForm(): View
    {
        return view('competition.enter');
    }

    public function enter(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'city' => ['nullable', 'string', 'max:80'],
            'age' => ['required', 'integer', 'min:18', 'max:99'],
            'dirndl' => ['nullable', 'string', 'max:120'],
            'bio' => ['nullable', 'string', 'max:400'],
            'photo' => ['nullable', 'url', 'max:255'],
        ]);

        $entry = DirndlContest::enter($data);
        abort_if($entry === null, 422);

        return redirect()->route('competition.show', $entry['slug'])
            ->with('success', __('platform.competition.enter_thanks', ['name' => $entry['name']]));
    }
}
