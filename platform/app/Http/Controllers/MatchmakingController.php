<?php

namespace App\Http\Controllers;

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
            'nexora' => $this->nexora(),
            'intents' => $this->intents(),
            'peopleCount' => count($this->demoProfiles()),
        ]);
    }

    public function people(Request $request): View
    {
        $intent = $request->string('intent')->toString();
        $profiles = $this->demoProfiles();
        if ($intent !== '') {
            $profiles = array_values(array_filter($profiles, fn ($p) => ($p['intent'] ?? '') === $intent));
        }

        // Prefer DB profiles when the table exists and has rows.
        if ($this->tablesReady()) {
            try {
                $query = \App\Models\MatchmakingProfile::query()
                    ->where('is_public', true)
                    ->where('open_to_connect', true)
                    ->latest();
                if ($intent !== '') {
                    $query->where('intent', $intent);
                }
                $rows = $query->limit(48)->get();
                if ($rows->isNotEmpty()) {
                    return view('matchmaking.people', [
                        'profiles' => $rows->all(),
                        'intent' => $intent,
                        'intents' => $this->intents(),
                        'nexora' => $this->nexora(),
                        'usingDemo' => false,
                    ]);
                }
            } catch (\Throwable) {
                // fall back to demo
            }
        }

        return view('matchmaking.people', [
            'profiles' => $profiles,
            'intent' => $intent,
            'intents' => $this->intents(),
            'nexora' => $this->nexora(),
            'usingDemo' => true,
        ]);
    }

    public function show(string $slug): View
    {
        $profile = null;
        if ($this->tablesReady()) {
            try {
                $profile = \App\Models\MatchmakingProfile::query()->where('slug', $slug)->first();
            } catch (\Throwable) {
                $profile = null;
            }
        }

        $isDemo = false;
        if (! $profile) {
            foreach ($this->demoProfiles() as $row) {
                if ($row['slug'] === $slug) {
                    $profile = $row;
                    $isDemo = true;
                    break;
                }
            }
        }

        abort_if(! $profile, 404);

        return view('matchmaking.show', [
            'profile' => $profile,
            'nexora' => $this->nexora(),
            'isDemo' => $isDemo,
        ]);
    }

    public function editProfile(Request $request): View
    {
        return view('matchmaking.profile-edit', [
            'profile' => $this->ensureProfileArray($request->user()),
            'intents' => $this->intents(),
            'nexora' => $this->nexora(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        if (! $this->tablesReady()) {
            return redirect()->away($this->nexora()['register']);
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
            'nexora' => $this->nexora(),
        ]);
    }

    public function connect(Request $request, string $slug): RedirectResponse
    {
        return redirect()->away($this->nexora()['register']);
    }

    public function accept(Request $request, string $slug): RedirectResponse
    {
        return back();
    }

    public function decline(Request $request, string $slug): RedirectResponse
    {
        return back();
    }

    private function nexora(): array
    {
        $cfg = config('connect.nexora');
        if (is_array($cfg) && ! empty($cfg['home'])) {
            return $cfg;
        }

        return [
            'name' => 'Nexora',
            'tagline' => 'Connect. Discover. Meet.',
            'home' => 'https://nexora.ehopn.com',
            'register' => 'https://nexora.ehopn.com/register',
            'login' => 'https://nexora.ehopn.com/login',
            'reels' => 'https://nexora.ehopn.com/discover/reels',
        ];
    }

    private function intents(): array
    {
        $cfg = config('connect.intents');
        if (is_array($cfg) && $cfg !== []) {
            return $cfg;
        }

        return [
            'dating' => 'Dating',
            'friends' => 'Friends',
            'business' => 'Business networking',
            'events' => 'Events & parties',
            'travel' => 'Travel buddies',
        ];
    }

    private function tablesReady(): bool
    {
        try {
            return Schema::hasTable('matchmaking_profiles');
        } catch (\Throwable) {
            return false;
        }
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

    private function demoProfiles(): array
    {
        return [
            [
                'slug' => 'lena-munich',
                'display_name' => 'Lena K.',
                'headline' => 'First Wiesn — looking for tent buddies',
                'bio' => 'Flying in from Berlin. Love live music, photography, and a good Maß.',
                'city' => 'Munich',
                'age' => 28,
                'intent' => 'friends',
                'interests' => ['music', 'photography', 'tents'],
                'languages' => ['de', 'en'],
                'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop',
                'company' => null,
                'role_title' => null,
            ],
            [
                'slug' => 'marco-business',
                'display_name' => 'Marco S.',
                'headline' => 'Hospitality founder — open to networking',
                'bio' => 'Building tourism tech. Happy to meet founders, vendors, and EXPO guests.',
                'city' => 'Munich',
                'age' => 34,
                'intent' => 'business',
                'interests' => ['startups', 'hospitality', 'ai'],
                'languages' => ['en', 'de', 'it'],
                'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop',
                'company' => 'Alpine Labs',
                'role_title' => 'Founder',
            ],
            [
                'slug' => 'sofia-travel',
                'display_name' => 'Sofia R.',
                'headline' => 'Solo traveler — brunch & bar crawls',
                'bio' => 'Here for opening weekend. Looking for a friendly crew for food and nightlife.',
                'city' => 'Munich',
                'age' => 26,
                'intent' => 'travel',
                'interests' => ['food', 'nightlife', 'coffee'],
                'languages' => ['en', 'es'],
                'avatar_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop',
                'company' => null,
                'role_title' => null,
            ],
            [
                'slug' => 'jonas-events',
                'display_name' => 'Jonas W.',
                'headline' => 'Event producer — after-parties & tents',
                'bio' => 'Know the best after-hours spots. Always happy to share tips and connect crews.',
                'city' => 'Munich',
                'age' => 31,
                'intent' => 'events',
                'interests' => ['parties', 'dj', 'networking'],
                'languages' => ['de', 'en'],
                'avatar_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop',
                'company' => 'Wiesn Nights',
                'role_title' => 'Producer',
            ],
            [
                'slug' => 'amina-dating',
                'display_name' => 'Amina H.',
                'headline' => 'Here for the vibes — open to meeting someone new',
                'bio' => 'Dirndl ready. Love dancing, good conversation, and ferris-wheel views.',
                'city' => 'Munich',
                'age' => 29,
                'intent' => 'dating',
                'interests' => ['dancing', 'festivals', 'coffee'],
                'languages' => ['en', 'de', 'fr'],
                'avatar_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400&h=400&fit=crop',
                'company' => null,
                'role_title' => null,
            ],
            [
                'slug' => 'erik-network',
                'display_name' => 'Erik P.',
                'headline' => 'Investor visiting MunichTech EXPO + Wiesn',
                'bio' => 'In town for EXPO and Oktoberfest. Open to coffee chats with builders.',
                'city' => 'Munich',
                'age' => 38,
                'intent' => 'business',
                'interests' => ['venture', 'ai', 'travel'],
                'languages' => ['en', 'sv'],
                'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop',
                'company' => 'Northpeak Capital',
                'role_title' => 'Partner',
            ],
        ];
    }
}
