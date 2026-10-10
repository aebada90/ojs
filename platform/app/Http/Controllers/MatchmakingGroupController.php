<?php

namespace App\Http\Controllers;

use App\Models\MatchmakingGroup;
use App\Models\MatchmakingGroupMember;
use App\Models\MatchmakingProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MatchmakingGroupController extends Controller
{
    public function index(): View
    {
        $groups = collect();

        if ($this->tablesReady()) {
            try {
                $groups = MatchmakingGroup::query()
                    ->with('owner')
                    ->where('is_public', true)
                    ->latest()
                    ->limit(40)
                    ->get();
            } catch (\Throwable) {
                $groups = collect();
            }
        }

        return view('matchmaking.groups.index', [
            'groups' => $groups,
            'nexora' => config('connect.nexora'),
        ]);
    }

    public function create(): View
    {
        return view('matchmaking.groups.create', [
            'intents' => config('connect.intents'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (! $this->tablesReady()) {
            return redirect()->away(config('connect.nexora.register'));
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'intent' => ['required', 'in:dating,friends,business,events,travel'],
            'city' => ['nullable', 'string', 'max:80'],
            'meets_at' => ['nullable', 'date'],
            'capacity' => ['nullable', 'integer', 'min:2', 'max:200'],
        ]);

        $profile = MatchmakingProfile::query()->firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'slug' => Str::slug($request->user()->name).'-'.Str::lower(Str::random(4)),
                'display_name' => $request->user()->name,
                'intent' => 'friends',
                'city' => 'Munich',
                'is_public' => true,
                'open_to_connect' => true,
            ]
        );

        $group = MatchmakingGroup::query()->create([
            ...$data,
            'owner_profile_id' => $profile->id,
            'city' => $data['city'] ?? 'Munich',
            'capacity' => $data['capacity'] ?? 12,
            'is_public' => true,
        ]);

        MatchmakingGroupMember::query()->create([
            'group_id' => $group->id,
            'profile_id' => $profile->id,
            'role' => 'owner',
            'status' => 'joined',
        ]);

        return redirect()->route('matchmaking.groups.show', $group->slug)
            ->with('success', 'Networking group created.');
    }

    public function show(string $slug): View
    {
        abort_unless($this->tablesReady(), 404);
        $group = MatchmakingGroup::query()->with(['owner', 'members.profile'])->where('slug', $slug)->firstOrFail();

        return view('matchmaking.groups.show', [
            'group' => $group,
            'nexora' => config('connect.nexora'),
        ]);
    }

    public function join(Request $request, string $slug): RedirectResponse
    {
        if (! $this->tablesReady()) {
            return redirect()->away(config('connect.nexora.register'));
        }

        $group = MatchmakingGroup::query()->where('slug', $slug)->firstOrFail();
        $profile = MatchmakingProfile::query()->firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'slug' => Str::slug($request->user()->name).'-'.Str::lower(Str::random(4)),
                'display_name' => $request->user()->name,
                'intent' => 'friends',
                'city' => 'Munich',
                'is_public' => true,
                'open_to_connect' => true,
            ]
        );

        MatchmakingGroupMember::query()->firstOrCreate(
            ['group_id' => $group->id, 'profile_id' => $profile->id],
            ['role' => 'member', 'status' => 'joined']
        );

        return back()->with('success', 'You joined this networking group.');
    }

    public function leave(Request $request, string $slug): RedirectResponse
    {
        if (! $this->tablesReady()) {
            return back();
        }

        $group = MatchmakingGroup::query()->where('slug', $slug)->firstOrFail();
        $profile = MatchmakingProfile::query()->where('user_id', $request->user()->id)->first();

        if ($profile) {
            MatchmakingGroupMember::query()
                ->where('group_id', $group->id)
                ->where('profile_id', $profile->id)
                ->where('role', '!=', 'owner')
                ->delete();
        }

        return back()->with('success', 'You left the group.');
    }

    private function tablesReady(): bool
    {
        try {
            return Schema::hasTable('matchmaking_groups') && Schema::hasTable('matchmaking_profiles');
        } catch (\Throwable) {
            return false;
        }
    }
}
