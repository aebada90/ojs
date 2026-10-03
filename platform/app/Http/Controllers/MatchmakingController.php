<?php

namespace App\Http\Controllers;

use App\Support\ConnectDemoProfiles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MatchmakingController extends Controller
{
    public function index(): View
    {
        return view('matchmaking.index', [
            'nexora' => ConnectDemoProfiles::nexora(),
            'intents' => ConnectDemoProfiles::intents(),
            'peopleCount' => count(ConnectDemoProfiles::publicProfiles()),
        ]);
    }

    public function people(Request $request): View
    {
        $intent = $request->string('intent')->toString();
        $profiles = ConnectDemoProfiles::publicProfiles($intent !== '' ? $intent : null);

        return view('matchmaking.people', [
            'profiles' => $profiles,
            'intent' => $intent,
            'intents' => ConnectDemoProfiles::intents(),
            'nexora' => ConnectDemoProfiles::nexora(),
            'usingDemo' => collect($profiles)->contains(fn ($p) => ($p['_demo'] ?? false) === true),
        ]);
    }

    public function show(string $slug): View
    {
        $profile = ConnectDemoProfiles::resolve($slug);
        abort_if($profile === null, 404);

        return view('matchmaking.show', [
            'profile' => $profile,
            'nexora' => ConnectDemoProfiles::nexora(),
            'isDemo' => (bool) ($profile['_demo'] ?? false),
        ]);
    }

    public function editProfile(Request $request): View
    {
        return view('matchmaking.profile-edit', [
            'profile' => $this->ensureProfileArray($request->user()),
            'intents' => ConnectDemoProfiles::intents(),
            'nexora' => ConnectDemoProfiles::nexora(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        if (! ConnectDemoProfiles::tablesReady()) {
            return redirect()->away(ConnectDemoProfiles::nexora()['register']);
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

        $profile = \App\Models\MatchmakingProfile::query()->firstOrCreate(
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

        $profile->fill([
            ...$data,
            'interests' => $this->csvToArray($data['interests'] ?? null),
            'languages' => $this->csvToArray($data['languages'] ?? null),
            'is_public' => $request->boolean('is_public', true),
            'open_to_connect' => $request->boolean('open_to_connect', true),
        ])->save();

        return redirect()->route('matchmaking.show', $profile->slug)
            ->with('success', 'Your Connect profile is live.');
    }

    public function connections(Request $request): View
    {
        return view('matchmaking.connections', [
            'profile' => $this->ensureProfileArray($request->user()),
            'pending' => collect(),
            'accepted' => collect(),
            'nexora' => ConnectDemoProfiles::nexora(),
        ]);
    }

    public function connect(Request $request, string $slug): RedirectResponse
    {
        return redirect()->route('chat.show', $slug);
    }

    public function accept(Request $request, string $slug): RedirectResponse
    {
        return back();
    }

    public function decline(Request $request, string $slug): RedirectResponse
    {
        return back();
    }

    private function ensureProfileArray($user): array
    {
        return [
            'slug' => 'you',
            'display_name' => $user->name ?? 'Member',
            'headline' => '',
            'bio' => $user->bio ?? '',
            'city' => 'Munich',
            'age' => null,
            'intent' => 'friends',
            'interests' => [],
            'languages' => [$user->locale ?? 'en'],
            'avatar_url' => $user->avatar ?? null,
            'company' => null,
            'role_title' => null,
            'linkedin_url' => null,
            'nexora_url' => null,
            'is_public' => true,
            'open_to_connect' => true,
        ];
    }

    private function csvToArray(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }
}
