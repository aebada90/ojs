<?php

namespace App\Support;

/**
 * Demo profiles shown when matchmaking tables are empty or unavailable.
 * Keeps /matchmaking and /connect from 500ing on shared hosting.
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
                return $profile;
            }
        }

        return null;
    }
}
