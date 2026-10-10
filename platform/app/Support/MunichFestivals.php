<?php

namespace App\Support;

/**
 * Year-round Munich festival seasons — 2027 focus.
 */
class MunichFestivals
{
    public static function seasonYear(): int
    {
        return 2027;
    }

    public static function brandName(): string
    {
        return __('platform.name');
    }

    /** Primary upcoming / featured festival for hero badge. */
    public static function featuredSlug(): string
    {
        $now = now();
        foreach (self::all() as $festival) {
            if ($now->lt($festival['ends_at'])) {
                return $festival['slug'];
            }
        }

        return 'oktoberfest';
    }

    /** @return array<string, mixed>|null */
    public static function featured(): ?array
    {
        return self::find(self::featuredSlug());
    }

    /** @return array<string, mixed>|null */
    public static function find(string $slug): ?array
    {
        foreach (self::all() as $festival) {
            if ($festival['slug'] === $slug) {
                return $festival;
            }
        }

        return null;
    }

    /** @return array<int, array<string, mixed>> */
    public static function all(): array
    {
        $year = self::seasonYear();

        return [
            [
                'slug' => 'starkbierfest',
                'name' => __('platform.festivals.items.starkbierfest.name'),
                'short' => __('platform.festivals.items.starkbierfest.short'),
                'season' => __('platform.festivals.seasons.spring'),
                'dates_label' => __('platform.festivals.items.starkbierfest.dates'),
                'starts_at' => "{$year}-03-12",
                'ends_at' => "{$year}-04-03",
                'location' => 'Nockherberg & beer gardens',
                'blurb' => __('platform.festivals.items.starkbierfest.blurb'),
                'image' => 'https://images.unsplash.com/photo-1608270586620-248524c67de9?auto=format&fit=crop&w=1200&h=800&q=80',
                'accent' => 'beer',
                'tags' => ['beer', 'tradition', 'spring'],
            ],
            [
                'slug' => 'fruehlingsfest',
                'name' => __('platform.festivals.items.fruehlingsfest.name'),
                'short' => __('platform.festivals.items.fruehlingsfest.short'),
                'season' => __('platform.festivals.seasons.spring'),
                'dates_label' => __('platform.festivals.items.fruehlingsfest.dates'),
                'starts_at' => "{$year}-04-16",
                'ends_at' => "{$year}-05-02",
                'location' => 'Theresienwiese',
                'blurb' => __('platform.festivals.items.fruehlingsfest.blurb'),
                'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1200&h=800&q=80',
                'accent' => 'gold',
                'tags' => ['rides', 'tents', 'spring'],
            ],
            [
                'slug' => 'auer-dult',
                'name' => __('platform.festivals.items.auer_dult.name'),
                'short' => __('platform.festivals.items.auer_dult.short'),
                'season' => __('platform.festivals.seasons.year_round'),
                'dates_label' => __('platform.festivals.items.auer_dult.dates'),
                'starts_at' => "{$year}-04-24",
                'ends_at' => "{$year}-10-25",
                'location' => 'Mariahilfplatz',
                'blurb' => __('platform.festivals.items.auer_dult.blurb'),
                'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&h=800&q=80',
                'accent' => 'cream',
                'tags' => ['market', 'food', 'local'],
            ],
            [
                'slug' => 'tollwood-summer',
                'name' => __('platform.festivals.items.tollwood_summer.name'),
                'short' => __('platform.festivals.items.tollwood_summer.short'),
                'season' => __('platform.festivals.seasons.summer'),
                'dates_label' => __('platform.festivals.items.tollwood_summer.dates'),
                'starts_at' => "{$year}-06-17",
                'ends_at' => "{$year}-07-18",
                'location' => 'Olympiapark Süd',
                'blurb' => __('platform.festivals.items.tollwood_summer.blurb'),
                'image' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?auto=format&fit=crop&w=1200&h=800&q=80',
                'accent' => 'green',
                'tags' => ['music', 'culture', 'summer'],
            ],
            [
                'slug' => 'oktoberfest',
                'name' => __('platform.festivals.items.oktoberfest.name'),
                'short' => __('platform.festivals.items.oktoberfest.short'),
                'season' => __('platform.festivals.seasons.autumn'),
                'dates_label' => __('platform.festivals.items.oktoberfest.dates'),
                'starts_at' => "{$year}-09-18",
                'ends_at' => "{$year}-10-03",
                'location' => 'Theresienwiese',
                'blurb' => __('platform.festivals.items.oktoberfest.blurb'),
                'image' => 'https://images.pexels.com/photos/5638732/pexels-photo-5638732.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'accent' => 'gold',
                'tags' => ['wiesn', 'tents', 'tracht'],
                'featured' => true,
            ],
            [
                'slug' => 'tollwood-winter',
                'name' => __('platform.festivals.items.tollwood_winter.name'),
                'short' => __('platform.festivals.items.tollwood_winter.short'),
                'season' => __('platform.festivals.seasons.winter'),
                'dates_label' => __('platform.festivals.items.tollwood_winter.dates'),
                'starts_at' => "{$year}-11-24",
                'ends_at' => "{$year}-12-31",
                'location' => 'Theresienwiese',
                'blurb' => __('platform.festivals.items.tollwood_winter.blurb'),
                'image' => 'https://images.unsplash.com/photo-1482517967863-00e15c9b44be?auto=format&fit=crop&w=1200&h=800&q=80',
                'accent' => 'winter',
                'tags' => ['music', 'market', 'winter'],
            ],
            [
                'slug' => 'christkindlmarkt',
                'name' => __('platform.festivals.items.christkindlmarkt.name'),
                'short' => __('platform.festivals.items.christkindlmarkt.short'),
                'season' => __('platform.festivals.seasons.winter'),
                'dates_label' => __('platform.festivals.items.christkindlmarkt.dates'),
                'starts_at' => "{$year}-11-22",
                'ends_at' => "{$year}-12-24",
                'location' => 'Marienplatz & city markets',
                'blurb' => __('platform.festivals.items.christkindlmarkt.blurb'),
                'image' => 'https://images.unsplash.com/photo-1512389142860-9c449e58a543?auto=format&fit=crop&w=1200&h=800&q=80',
                'accent' => 'red',
                'tags' => ['christmas', 'market', 'winter'],
            ],
        ];
    }

    /** ISO datetime for countdown (Oktoberfest 2027 opening). */
    public static function oktoberfestOpensAt(): string
    {
        return self::seasonYear().'-09-18T12:00:00';
    }

    public static function heroBadge(): string
    {
        $featured = self::featured();
        if ($featured) {
            return $featured['short'].' '.self::seasonYear().' • Munich';
        }

        return 'Munich Festivals '.self::seasonYear();
    }
}
