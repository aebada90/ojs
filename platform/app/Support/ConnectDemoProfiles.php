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
                'bio' => 'Flying in from Berlin. Love live music, photography, and a good Maß. Always up for a ferris-wheel sunset.',
                'city' => 'Munich',
                'age' => 28,
                'intent' => 'friends',
                'interests' => ['music', 'photography', 'tents'],
                'languages' => ['de', 'en'],
                'avatar_url' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => null,
                'role_title' => null,
                'instagram' => 'lena.at.wiesn',
                'tiktok' => 'lenakfest',
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'single',
                'looking_for' => 'friends',
                'status' => 'at_wiesn',
                'status_quote' => 'Hofbräu today — who’s in?',
            ],
            [
                'slug' => 'marco-business',
                'display_name' => 'Marco S.',
                'headline' => 'Hospitality founder — open to networking',
                'bio' => 'Building tourism tech. Happy to meet founders, vendors, and EXPO guests over espresso or a Maß.',
                'city' => 'Munich',
                'age' => 34,
                'intent' => 'business',
                'interests' => ['startups', 'hospitality', 'ai'],
                'languages' => ['en', 'de', 'it'],
                'avatar_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => 'Alpine Labs',
                'role_title' => 'Founder',
                'instagram' => 'marco.alpine',
                'tiktok' => null,
                'website' => 'https://oktoberhub.de',
                'linkedin_url' => 'https://www.linkedin.com',
                'relationship' => 'taken',
                'looking_for' => 'business',
                'status' => 'open_to_meet',
                'status_quote' => 'Coffee at EXPO before the tents.',
            ],
            [
                'slug' => 'sofia-travel',
                'display_name' => 'Sofia R.',
                'headline' => 'Solo traveler — brunch & bar crawls',
                'bio' => 'Here for opening weekend. Looking for a friendly crew for food, rooftops, and nightlife.',
                'city' => 'Munich',
                'age' => 26,
                'intent' => 'travel',
                'interests' => ['food', 'nightlife', 'coffee'],
                'languages' => ['en', 'es'],
                'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => null,
                'role_title' => null,
                'instagram' => 'sofia.roams',
                'tiktok' => 'sofiaroadtrip',
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'single',
                'looking_for' => 'travel',
                'status' => 'traveling',
                'status_quote' => 'Landing Friday — brunch in Maxvorstadt?',
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
                'avatar_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => 'Wiesn Nights',
                'role_title' => 'Producer',
                'instagram' => 'wiesn.nights',
                'tiktok' => 'jonasbeats',
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'open',
                'looking_for' => 'events',
                'status' => 'at_wiesn',
                'status_quote' => 'After-hours lineup drops tonight.',
            ],
            [
                'slug' => 'amina-dating',
                'display_name' => 'Amina H.',
                'headline' => 'Here for the vibes — open to meeting someone new',
                'bio' => 'Dirndl ready. Love dancing, good conversation, and ferris-wheel views at dusk.',
                'city' => 'Munich',
                'age' => 29,
                'intent' => 'dating',
                'interests' => ['dancing', 'festivals', 'coffee'],
                'languages' => ['en', 'de', 'fr'],
                'avatar_url' => 'https://images.pexels.com/photos/5638732/pexels-photo-5638732.jpeg?auto=compress&cs=tinysrgb&w=900&h=1200&fit=crop',
                'company' => null,
                'role_title' => null,
                'instagram' => 'amina.dirndl',
                'tiktok' => 'aminahfest',
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'single',
                'looking_for' => 'dating',
                'status' => 'at_wiesn',
                'status_quote' => 'Save me a dance in Schottenhamel.',
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
                'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => 'Northpeak Capital',
                'role_title' => 'Partner',
                'instagram' => null,
                'tiktok' => null,
                'website' => 'https://oktoberhub.de/connect',
                'linkedin_url' => 'https://www.linkedin.com',
                'relationship' => 'taken',
                'looking_for' => 'business',
                'status' => 'open_to_meet',
                'status_quote' => '15-minute coffee after the keynotes.',
            ],
            [
                'slug' => 'klara-dirndl',
                'display_name' => 'Klara V.',
                'headline' => 'Dirndl collector — looking for festival friends',
                'bio' => 'Three dirndls packed. I know the quiet beer-garden corners and the loudest brass bands.',
                'city' => 'Salzburg',
                'age' => 27,
                'intent' => 'friends',
                'interests' => ['tracht', 'brass', 'photography'],
                'languages' => ['de', 'en'],
                'avatar_url' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => null,
                'role_title' => null,
                'instagram' => 'klara.tracht',
                'tiktok' => 'klaravienna',
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'single',
                'looking_for' => 'friends',
                'status' => 'at_wiesn',
                'status_quote' => 'Gold apron energy today.',
            ],
            [
                'slug' => 'tom-lederhosen',
                'display_name' => 'Tom B.',
                'headline' => 'Lederhosen, pretzels, and a table for five',
                'bio' => 'Munich local hosting a tent hop. Bring good energy — I’ll bring the reservations.',
                'city' => 'Munich',
                'age' => 32,
                'intent' => 'friends',
                'interests' => ['tents', 'football', 'beer'],
                'languages' => ['de', 'en'],
                'avatar_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => null,
                'role_title' => null,
                'instagram' => 'tom.wiesn',
                'tiktok' => null,
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'open',
                'looking_for' => 'friends',
                'status' => 'at_wiesn',
                'status_quote' => 'Table of 5 at Augustiner — two seats left.',
            ],
            [
                'slug' => 'yuki-tokyo',
                'display_name' => 'Yuki T.',
                'headline' => 'Tokyo → Munich for the full festival season',
                'bio' => 'First Oktoberfest, then Christkindlmarkt. Looking for travel buddies who like cameras and late trains.',
                'city' => 'Tokyo',
                'age' => 30,
                'intent' => 'travel',
                'interests' => ['travel', 'film', 'cafes'],
                'languages' => ['ja', 'en', 'de'],
                'avatar_url' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => null,
                'role_title' => null,
                'instagram' => 'yuki.on.rails',
                'tiktok' => 'yukifest',
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'single',
                'looking_for' => 'travel',
                'status' => 'traveling',
                'status_quote' => 'S-Bahn selfies and pretzel stops.',
            ],
            [
                'slug' => 'nico-expo',
                'display_name' => 'Nico A.',
                'headline' => 'Product designer at MunichTech EXPO',
                'bio' => 'Here for the conference by day and tents by night. Swap Figma files or Ferris-wheel tickets.',
                'city' => 'Zurich',
                'age' => 33,
                'intent' => 'business',
                'interests' => ['design', 'ai', 'festivals'],
                'languages' => ['en', 'de', 'fr'],
                'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => 'Studio Nord',
                'role_title' => 'Product designer',
                'instagram' => 'nico.studio',
                'tiktok' => null,
                'website' => 'https://oktoberhub.de',
                'linkedin_url' => 'https://www.linkedin.com',
                'relationship' => 'prefer_not',
                'looking_for' => 'business',
                'status' => 'online',
                'status_quote' => 'Ping me for a booth walkthrough.',
            ],
            [
                'slug' => 'mira-flirt',
                'display_name' => 'Mira S.',
                'headline' => 'Wiesn flirt — dancing until last call',
                'bio' => 'Red dirndl, gold jewelry, and a playlist for the tent. Looking for chemistry, not a business card.',
                'city' => 'Hamburg',
                'age' => 25,
                'intent' => 'dating',
                'interests' => ['dancing', 'fashion', 'sunsets'],
                'languages' => ['de', 'en'],
                'avatar_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => null,
                'role_title' => null,
                'instagram' => 'mira.dirndl',
                'tiktok' => 'mirawiesn',
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'single',
                'looking_for' => 'dating',
                'status' => 'open_to_meet',
                'status_quote' => 'Ferris wheel at 7 if the sky is gold.',
            ],
            [
                'slug' => 'felix-crew',
                'display_name' => 'Felix D.',
                'headline' => 'Tent-hop captain looking for a crew of 8',
                'bio' => 'I plan the route, you bring the jokes. Oktoberfest, Frühlingsfest, and Christmas markets — I’m in.',
                'city' => 'Munich',
                'age' => 36,
                'intent' => 'events',
                'interests' => ['tents', 'meetups', 'photography'],
                'languages' => ['de', 'en'],
                'avatar_url' => 'https://images.unsplash.com/photo-1463453091185-61582044d556?auto=format&fit=crop&w=900&h=1200&q=80',
                'company' => null,
                'role_title' => null,
                'instagram' => 'felix.crew',
                'tiktok' => null,
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'open',
                'looking_for' => 'events',
                'status' => 'online',
                'status_quote' => 'Meet at Bavaria statue, 14:00.',
            ],
        ];
    }

    /** @return array<int, string> */
    public static function presetPortraits(): array
    {
        return array_values(array_unique(array_filter(array_map(
            fn (array $row) => (string) ($row['avatar_url'] ?? ''),
            self::all()
        ))));
    }

    public static function find(string $slug): ?array
    {
        foreach (self::catalog() as $profile) {
            if ($profile['slug'] === $slug) {
                return $profile;
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
                    $fromDb = $rows->map(fn ($row) => self::fromModel($row))->all();
                    $members = MemberProfileStore::all();
                    $merged = self::mergeBySlug($fromDb, $members);
                    if ($intent !== null && $intent !== '') {
                        $merged = array_values(array_filter($merged, fn ($p) => ($p['intent'] ?? '') === $intent));
                    }

                    return $merged;
                }
            } catch (\Throwable) {
                // fall back to demo
            }
        }

        $profiles = self::catalog();
        if ($intent !== null && $intent !== '') {
            $profiles = array_values(array_filter($profiles, fn ($p) => ($p['intent'] ?? '') === $intent));
        }

        return $profiles;
    }

    /** @return array<string, mixed>|null */
    public static function resolve(string $slug): ?array
    {
        $member = MemberProfileStore::find($slug);
        if ($member !== null) {
            return $member;
        }

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
        return self::normalize([
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
            'instagram' => $profile->instagram ?? null,
            'tiktok' => $profile->tiktok ?? null,
            'website' => $profile->website ?? $profile->nexora_url ?? null,
            'linkedin_url' => $profile->linkedin_url ?? null,
            'relationship' => $profile->relationship ?? 'prefer_not',
            'looking_for' => $profile->looking_for ?? $profile->intent ?? 'friends',
            'status' => $profile->status ?? 'online',
            'status_quote' => $profile->status_quote ?? null,
            '_demo' => false,
        ]);
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

    /** @return array<string, string> */
    public static function relationships(): array
    {
        return [
            'single' => __('platform.profiles.relationship.single'),
            'taken' => __('platform.profiles.relationship.taken'),
            'open' => __('platform.profiles.relationship.open'),
            'prefer_not' => __('platform.profiles.relationship.prefer_not'),
        ];
    }

    /** @return array<string, string> */
    public static function statuses(): array
    {
        return [
            'at_wiesn' => __('platform.profiles.status.at_wiesn'),
            'online' => __('platform.profiles.status.online'),
            'open_to_meet' => __('platform.profiles.status.open_to_meet'),
            'traveling' => __('platform.profiles.status.traveling'),
        ];
    }

    /** @return array<int, array{network:string,label:string,url:string}> */
    public static function socialLinks(array $profile): array
    {
        $links = [];

        $instagram = self::socialUrl('instagram', $profile['instagram'] ?? null);
        if ($instagram !== null) {
            $links[] = [
                'network' => 'instagram',
                'label' => self::handleLabel($profile['instagram'] ?? ''),
                'url' => $instagram,
            ];
        }

        $tiktok = self::socialUrl('tiktok', $profile['tiktok'] ?? null);
        if ($tiktok !== null) {
            $links[] = [
                'network' => 'tiktok',
                'label' => self::handleLabel($profile['tiktok'] ?? ''),
                'url' => $tiktok,
            ];
        }

        $linkedin = trim((string) ($profile['linkedin_url'] ?? ''));
        if ($linkedin !== '' && filter_var($linkedin, FILTER_VALIDATE_URL)) {
            $links[] = [
                'network' => 'linkedin',
                'label' => 'LinkedIn',
                'url' => $linkedin,
            ];
        }

        $website = trim((string) ($profile['website'] ?? $profile['nexora_url'] ?? ''));
        if ($website !== '' && filter_var($website, FILTER_VALIDATE_URL)) {
            $links[] = [
                'network' => 'website',
                'label' => __('platform.profiles.website'),
                'url' => $website,
            ];
        }

        return $links;
    }

    public static function socialUrl(string $network, ?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        $handle = ltrim($value, '@');
        $handle = trim($handle, '/');
        if ($handle === '') {
            return null;
        }

        return match ($network) {
            'instagram' => 'https://instagram.com/'.$handle,
            'tiktok' => 'https://www.tiktok.com/@'.$handle,
            default => null,
        };
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
            [
                'title' => 'Meet 5 · Ferris-wheel sunset',
                'description' => 'Five seats, golden hour, then a Maß. Spontacts-style drop-in.',
                'intent' => 'events',
                'city' => 'Munich',
                'capacity' => 5,
            ],
        ];
    }

    /** @return array<int, array<string, mixed>> */
    public static function catalog(): array
    {
        $demo = array_map(fn (array $row) => self::normalize($row) + ['_demo' => true], self::all());

        return self::mergeBySlug($demo, MemberProfileStore::all());
    }

    /**
     * @param  array<int, array<string, mixed>>  $base
     * @param  array<int, array<string, mixed>>  $overlay
     * @return array<int, array<string, mixed>>
     */
    public static function mergeBySlug(array $base, array $overlay): array
    {
        $bySlug = [];
        foreach ($base as $row) {
            $slug = (string) ($row['slug'] ?? '');
            if ($slug !== '') {
                $bySlug[$slug] = $row;
            }
        }
        foreach ($overlay as $row) {
            $slug = (string) ($row['slug'] ?? '');
            if ($slug !== '') {
                $bySlug[$slug] = $row;
            }
        }

        return array_values($bySlug);
    }

    /** @param  array<string, mixed>  $row @return array<string, mixed> */
    public static function normalize(array $row): array
    {
        $intent = (string) ($row['intent'] ?? 'friends');

        return [
            'slug' => (string) ($row['slug'] ?? ''),
            'display_name' => (string) ($row['display_name'] ?? 'Member'),
            'headline' => (string) ($row['headline'] ?? ''),
            'bio' => (string) ($row['bio'] ?? ''),
            'city' => (string) ($row['city'] ?? 'Munich'),
            'age' => isset($row['age']) ? (int) $row['age'] : null,
            'intent' => $intent,
            'interests' => array_values(array_filter((array) ($row['interests'] ?? []))),
            'languages' => array_values(array_filter((array) ($row['languages'] ?? []))),
            'avatar_url' => $row['avatar_url'] ?? null,
            'company' => $row['company'] ?? null,
            'role_title' => $row['role_title'] ?? null,
            'instagram' => $row['instagram'] ?? null,
            'tiktok' => $row['tiktok'] ?? null,
            'website' => $row['website'] ?? $row['nexora_url'] ?? null,
            'linkedin_url' => $row['linkedin_url'] ?? null,
            'relationship' => (string) ($row['relationship'] ?? 'prefer_not'),
            'looking_for' => (string) ($row['looking_for'] ?? $intent),
            'status' => (string) ($row['status'] ?? 'online'),
            'status_quote' => $row['status_quote'] ?? null,
            'is_public' => (bool) ($row['is_public'] ?? true),
            'open_to_connect' => (bool) ($row['open_to_connect'] ?? true),
            '_demo' => (bool) ($row['_demo'] ?? false),
            '_member' => (bool) ($row['_member'] ?? false),
        ];
    }

    private static function handleLabel(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }
        if (str_starts_with($value, 'http')) {
            $host = parse_url($value, PHP_URL_PATH) ?: $value;

            return '@'.trim((string) $host, '/@');
        }

        return '@'.ltrim($value, '@');
    }
}
