<?php

namespace App\Http\Controllers;

use App\Models\MatchmakingConnection;
use App\Models\MatchmakingProfile;
use App\Support\ConnectDemoProfiles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MatchmakingController extends Controller
{
    public function index(): View
    {
        return view('matchmaking.index', [
            'nexora' => config('connect.nexora'),
            'intents' => config('connect.intents'),
            'peopleCount' => $this->peopleCount(),
        ]);
    }

    public function people(Request $request): View
    {
        $intent = $request->string('intent')->toString();
        $profiles = $this->listProfiles($intent);

        return view('matchmaking.people', [
            'profiles' => $profiles,
            'intent' => $intent,
            'intents' => config('connect.intents'),
            'nexora' => config('connect.nexora'),
            'usingDemo' => ! $this->tablesReady(),
        ]);
    }

    public function show(string $slug): View
    {
        $profile = $this->findProfile($slug);
        abort_if(! $profile, 404);

        return view('matchmaking.show', [
            'profile' => $profile,
            'nexora' => config('connect.nexora'),
            'isDemo' => ! ($profile instanceof MatchmakingProfile),
        ]);
    }

    public function editProfile(Request $request): View
    {
        $profile = $this->ensureProfile($request->user());

        return view('matchmaking.profile-edit', [
            'profile' => $profile,
            'intents' => config('connect.intents'),
            'nexora' => config('connect.nexora'),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        if (! $this->tablesReady()) {
            return back()->with('error', 'Matchmaking profiles are being set up. Try again shortly, or open Nexora Connect.');
        }

        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:80'],
            'headline' => ['nullable', 'string', 'max:140'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:80'],
            'age' => ['nullable', 'integer', 'min:18', 'max:99'],
            'intent' => ['required', 'in:dating,friends,business,events,travel'],
            'interests' => ['nullable', 'string', 'max:300'],
            'languages' => ['nullable', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'role_title' => ['nullable', 'string', 'max:120'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'nexora_url' => ['nullable', 'url', 'max:255'],
            'avatar_url' => ['nullable', 'url', 'max:255'],
            'is_public' => ['nullable', 'boolean'],
            'open_to_connect' => ['nullable', 'boolean'],
        ]);

        $profile = $this->ensureProfile($request->user());
        $profile->fill([
            ...$data,
            'interests' => $this->csvToArray($data['interests'] ?? null),
            'languages' => $this->csvToArray($data['languages'] ?? null),
            'is_public' => $request->boolean('is_public', true),
            'open_to_connect' => $request->boolean('open_to_connect', true),
        ])->save();

        return redirect()
            ->route('matchmaking.show', $profile->slug)
            ->with('success', 'Your Connect profile is live.');
    }

    public function connections(Request $request): View
    {
        $profile = $this->ensureProfile($request->user());
        $pending = collect();
        $accepted = collect();

        if ($this->tablesReady() && $profile instanceof MatchmakingProfile) {
            $pending = MatchmakingConnection::query()
                ->with('requester')
                ->where('receiver_profile_id', $profile->id)
                ->where('status', 'pending')
                ->latest()
                ->get();

            $accepted = MatchmakingConnection::query()
                ->with(['requester', 'receiver'])
                ->where('status', 'accepted')
                ->where(function ($q) use ($profile) {
                    $q->where('requester_profile_id', $profile->id)
                        ->orWhere('receiver_profile_id', $profile->id);
                })
                ->latest()
                ->get();
        }

        return view('matchmaking.connections', [
            'profile' => $profile,
            'pending' => $pending,
            'accepted' => $accepted,
            'nexora' => config('connect.nexora'),
        ]);
    }

    public function connect(Request $request, string $slug): RedirectResponse
    {
        if (! $this->tablesReady()) {
            return redirect()->away(config('connect.nexora.register'));
        }

        $me = $this->ensureProfile($request->user());
        $them = MatchmakingProfile::query()->where('slug', $slug)->firstOrFail();

        if ($me->id === $them->id) {
            return back()->with('error', 'You cannot connect with yourself.');
        }

        MatchmakingConnection::query()->firstOrCreate(
            [
                'requester_profile_id' => $me->id,
                'receiver_profile_id' => $them->id,
            ],
            [
                'status' => 'pending',
                'message' => $request->string('message')->toString() ?: null,
            ]
        );

        return back()->with('success', 'Connection request sent.');
    }

    public function accept(Request $request, string $slug): RedirectResponse
    {
        return $this->updateConnectionStatus($request, $slug, 'accepted');
    }

    public function decline(Request $request, string $slug): RedirectResponse
    {
        return $this->updateConnectionStatus($request, $slug, 'declined');
    }

    private function updateConnectionStatus(Request $request, string $slug, string $status): RedirectResponse
    {
        if (! $this->tablesReady()) {
            return back();
        }

        $me = $this->ensureProfile($request->user());
        $them = MatchmakingProfile::query()->where('slug', $slug)->firstOrFail();

        MatchmakingConnection::query()
            ->where('receiver_profile_id', $me->id)
            ->where('requester_profile_id', $them->id)
            ->where('status', 'pending')
            ->update(['status' => $status]);

        return back()->with('success', $status === 'accepted' ? 'You are now connected.' : 'Request declined.');
    }

    private function tablesReady(): bool
    {
        try {
            return Schema::hasTable('matchmaking_profiles');
        } catch (\Throwable) {
            return false;
        }
    }

    private function peopleCount(): int
    {
        if (! $this->tablesReady()) {
            return count(ConnectDemoProfiles::all());
        }

        try {
            return max(
                MatchmakingProfile::query()->where('is_public', true)->count(),
                count(ConnectDemoProfiles::all())
            );
        } catch (\Throwable) {
            return count(ConnectDemoProfiles::all());
        }
    }

    private function listProfiles(string $intent = ''): array
    {
        if ($this->tablesReady()) {
            try {
                $query = MatchmakingProfile::query()
                    ->where('is_public', true)
                    ->where('open_to_connect', true)
                    ->latest();

                if ($intent !== '') {
                    $query->where('intent', $intent);
                }

                $rows = $query->limit(48)->get();
                if ($rows->isNotEmpty()) {
                    return $rows->all();
                }
            } catch (\Throwable) {
                // fall through to demo
            }
        }

        $demo = ConnectDemoProfiles::all();
        if ($intent !== '') {
            $demo = array_values(array_filter($demo, fn ($p) => ($p['intent'] ?? '') === $intent));
        }

        return $demo;
    }

    private function findProfile(string $slug): MatchmakingProfile|array|null
    {
        if ($this->tablesReady()) {
            try {
                $row = MatchmakingProfile::query()->where('slug', $slug)->first();
                if ($row) {
                    return $row;
                }
            } catch (\Throwable) {
                // demo fallback
            }
        }

        return ConnectDemoProfiles::find($slug);
    }

    private function ensureProfile($user): MatchmakingProfile|array
    {
        if (! $user) {
            abort(403);
        }

        if (! $this->tablesReady()) {
            return [
                'slug' => 'you',
                'display_name' => $user->name,
                'headline' => '',
                'bio' => $user->bio,
                'city' => 'Munich',
                'age' => null,
                'intent' => 'friends',
                'interests' => [],
                'languages' => [$user->locale ?? 'en'],
                'avatar_url' => $user->avatar,
                'company' => null,
                'role_title' => null,
                'linkedin_url' => null,
                'nexora_url' => null,
                'is_public' => true,
                'open_to_connect' => true,
            ];
        }

        return MatchmakingProfile::query()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'slug' => Str::slug($user->username ?: $user->name).'-'.Str::lower(Str::random(4)),
                'display_name' => $user->name,
                'headline' => 'Oktoberfest Connect profile',
                'bio' => $user->bio,
                'city' => 'Munich',
                'intent' => 'friends',
                'interests' => [],
                'languages' => array_filter([$user->locale ?? 'en']),
                'avatar_url' => $user->avatar,
                'is_public' => true,
                'open_to_connect' => true,
            ]
        );
    }

    private function csvToArray(?string $value): array
    {
        if (blank($value)) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn ($part) => trim($part),
            explode(',', $value)
        )));
    }
}
