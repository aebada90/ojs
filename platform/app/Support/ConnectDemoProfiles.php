<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;

/**
 * Shared people directory for Network, matchmaking, and profile chat.
 * Falls back to demo profiles when tables are missing or empty.
 */
class ConnectDemoProfiles
{
    public static function all(): array
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

    public static function find(string $slug): ?array
    {
        foreach (self::all() as $profile) {
            if ($profile['slug'] === $slug) {
                return $profile + ['_demo' => true];
            }
        }

        return null;
    }

    public static function tablesReady(): bool
    {
        try {
            return Schema::hasTable('matchmaking_profiles');
        } catch (\Throwable) {
            return false;
        }
    }

    /** @return array<int, array<string, mixed>> */
    public static function publicProfiles(?string $intent = null): array
    {
        if (self::tablesReady()) {
            try {
                $query = \App\Models\MatchmakingProfile::query()
                    ->where('is_public', true)
                    ->where('open_to_connect', true)
                    ->latest();
                if ($intent !== null && $intent !== '') {
                    $query->where('intent', $intent);
                }
                $rows = $query->limit(48)->get();
                if ($rows->isNotEmpty()) {
                    return $rows->map(fn ($row) => self::fromModel($row))->all();
                }
            } catch (\Throwable) {
                // fall back to demo
            }
        }

        $profiles = array_map(fn (array $row) => $row + ['_demo' => true], self::all());
        if ($intent !== null && $intent !== '') {
            $profiles = array_values(array_filter($profiles, fn ($p) => ($p['intent'] ?? '') === $intent));
        }

        return $profiles;
    }

    /** @return array<string, mixed>|null */
    public static function resolve(string $slug): ?array
    {
        if (self::tablesReady()) {
            try {
                $row = \App\Models\MatchmakingProfile::query()->where('slug', $slug)->first();
                if ($row) {
                    return self::fromModel($row);
                }
            } catch (\Throwable) {
                // fall back to demo
            }
        }

        return self::find($slug);
    }

    /** @return array<string, mixed> */
    public static function fromModel(object $profile): array
    {
        return [
            'slug' => $profile->slug,
            'display_name' => $profile->display_name,
            'headline' => $profile->headline,
            'bio' => $profile->bio,
            'city' => $profile->city,
            'age' => $profile->age,
            'intent' => $profile->intent,
            'interests' => $profile->interests ?? [],
            'languages' => $profile->languages ?? [],
            'avatar_url' => $profile->avatar_url,
            'company' => $profile->company,
            'role_title' => $profile->role_title,
            '_demo' => false,
        ];
    }

    /** @return array<string, string> */
    public static function intents(): array
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

    /** @return array{name:string,tagline:string,home:string,register:string,login:string,reels:string} */
    public static function nexora(): array
    {
        $cfg = config('connect.nexora');
        if (is_array($cfg) && ! empty($cfg['home'])) {
            return $cfg + [
                'name' => 'Nexora',
                'tagline' => 'Connect. Discover. Meet.',
                'home' => 'https://nexora.ehopn.com',
                'register' => 'https://nexora.ehopn.com/register',
                'login' => 'https://nexora.ehopn.com/login',
                'reels' => 'https://nexora.ehopn.com/discover/reels',
            ];
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

    /** @return array<int, array<string, mixed>> */
    public static function demoGroups(): array
    {
        return [
            [
                'title' => 'Founder coffee · Marienplatz',
                'description' => 'Morning espresso with builders, vendors, and EXPO guests.',
                'intent' => 'business',
                'city' => 'Munich',
                'capacity' => 12,
            ],
            [
                'title' => 'Opening-day tent crew',
                'description' => 'Meet at the Bavaria statue, then hop Hofbräu and Schottenhamel.',
                'intent' => 'friends',
                'city' => 'Munich',
                'capacity' => 16,
            ],
            [
                'title' => 'EXPO + Wiesn circle',
                'description' => 'Trade-show days, then tents after 5. Open to founders and operators.',
                'intent' => 'business',
                'city' => 'Munich',
                'capacity' => 20,
            ],
        ];
    }
}
