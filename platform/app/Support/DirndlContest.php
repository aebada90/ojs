<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Best Dirndl competition + file/cache-backed online votes.
 * Works on Hostinger without running migrations.
 */
class DirndlContest
{
    public static function title(): string
    {
        return __('platform.competition.title');
    }

    public static function year(): int
    {
        return 2026;
    }

    /** @return array<int, array<string, mixed>> */
    public static function seeded(): array
    {
        return [
            [
                'slug' => 'anna-munich',
                'name' => 'Anna M.',
                'city' => 'Munich',
                'age' => 27,
                'dirndl' => 'Classic Bavarian blue with gold apron',
                'bio' => 'Wiesn regular in a family-made dirndl. Loves brass bands, pretzels, and the Ferris wheel at dusk.',
                'photo' => 'https://images.pexels.com/photos/5638732/pexels-photo-5638732.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 148,
            ],
            [
                'slug' => 'clara-vienna',
                'name' => 'Clara B.',
                'city' => 'Vienna',
                'age' => 29,
                'dirndl' => 'Ruby silk with cream lace',
                'bio' => 'Brought a Viennese twist to Tracht. Here for opening weekend and the after-parties.',
                'photo' => 'https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 132,
            ],
            [
                'slug' => 'sophie-salzburg',
                'name' => 'Sophie L.',
                'city' => 'Salzburg',
                'age' => 24,
                'dirndl' => 'Forest green with floral embroidery',
                'bio' => 'First Wiesn in a grandmother’s dirndl, restyled for 2026. Always smiling in Schottenhamel.',
                'photo' => 'https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 121,
            ],
            [
                'slug' => 'mia-nuremberg',
                'name' => 'Mia K.',
                'city' => 'Nuremberg',
                'age' => 26,
                'dirndl' => 'Blush pink with white blouse',
                'bio' => 'Festival photographer by day, dirndl devotee by night. Votes for authentic Tracht, not costumes.',
                'photo' => 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 109,
            ],
            [
                'slug' => 'elena-berlin',
                'name' => 'Elena V.',
                'city' => 'Berlin',
                'age' => 31,
                'dirndl' => 'Modern black dirndl, gold buttons',
                'bio' => 'City style meets Wiesn tradition. Looking for the best Maß and the best brass set.',
                'photo' => 'https://images.pexels.com/photos/1382734/pexels-photo-1382734.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 97,
            ],
            [
                'slug' => 'hannah-stuttgart',
                'name' => 'Hannah R.',
                'city' => 'Stuttgart',
                'age' => 23,
                'dirndl' => 'Sky-blue check with coral apron',
                'bio' => 'Came with friends for tent hopping. This dirndl is her lucky piece every September.',
                'photo' => 'https://images.pexels.com/photos/1858175/pexels-photo-1858175.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 88,
            ],
            [
                'slug' => 'julia-innsbruck',
                'name' => 'Julia S.',
                'city' => 'Innsbruck',
                'age' => 28,
                'dirndl' => 'Alpine red with silver edelweiss',
                'bio' => 'Alpine Tracht with a Munich twist. Dances until last call and still makes brunch.',
                'photo' => 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 76,
            ],
            [
                'slug' => 'nina-hamburg',
                'name' => 'Nina W.',
                'city' => 'Hamburg',
                'age' => 25,
                'dirndl' => 'Ivory linen with navy bow',
                'bio' => 'North-sea girl in south-Bavaria dress. First time voting — and first time wearing a dirndl.',
                'photo' => 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
                'seed_votes' => 64,
            ],
        ];
    }

    /** @return array<int, array<string, mixed>> */
    public static function contestants(): array
    {
        $payload = self::load();
        $votes = is_array($payload['votes'] ?? null) ? $payload['votes'] : [];
        $entries = is_array($payload['entries'] ?? null) ? $payload['entries'] : [];

        $rows = array_merge(self::seeded(), array_values($entries));
        foreach ($rows as &$row) {
            $slug = (string) ($row['slug'] ?? '');
            $seed = (int) ($row['seed_votes'] ?? 0);
            $row['votes'] = $seed + (int) ($votes[$slug] ?? 0);
        }
        unset($row);

        usort($rows, function (array $a, array $b): int {
            return ($b['votes'] ?? 0) <=> ($a['votes'] ?? 0);
        });

        foreach ($rows as $i => &$row) {
            $row['rank'] = $i + 1;
        }
        unset($row);

        return $rows;
    }

    /** @return array<string, mixed>|null */
    public static function find(string $slug): ?array
    {
        foreach (self::contestants() as $row) {
            if (($row['slug'] ?? '') === $slug) {
                return $row;
            }
        }

        return null;
    }

    public static function voterKey(): string
    {
        $key = session()->get('dirndl_voter_id');
        if (! is_string($key) || $key === '') {
            $key = 'voter-'.Str::lower(Str::random(16));
            session()->put('dirndl_voter_id', $key);
        }

        return $key;
    }

    public static function votedFor(string $voterKey): ?string
    {
        $payload = self::load();
        $choice = $payload['voters'][$voterKey] ?? null;

        return is_string($choice) && $choice !== '' ? $choice : null;
    }

    /**
     * Cast or move a single vote. One vote per visitor.
     *
     * @return array{ok:bool,changed:bool,previous:?string}
     */
    public static function vote(string $slug, string $voterKey): array
    {
        if (self::find($slug) === null) {
            return ['ok' => false, 'changed' => false, 'previous' => null];
        }

        $payload = self::load();
        $previous = is_string($payload['voters'][$voterKey] ?? null) ? $payload['voters'][$voterKey] : null;

        if ($previous === $slug) {
            return ['ok' => true, 'changed' => false, 'previous' => $previous];
        }

        $changes = (int) ($payload['changes'][$voterKey] ?? 0);
        if ($changes >= 20) {
            return ['ok' => false, 'changed' => false, 'previous' => $previous];
        }

        if (is_string($previous) && $previous !== '') {
            $payload['votes'][$previous] = max(0, (int) ($payload['votes'][$previous] ?? 0) - 1);
        }

        $payload['votes'][$slug] = (int) ($payload['votes'][$slug] ?? 0) + 1;
        $payload['voters'][$voterKey] = $slug;
        $payload['changes'][$voterKey] = $changes + 1;
        self::save($payload);

        return ['ok' => true, 'changed' => true, 'previous' => $previous];
    }

    /** @param array<string, mixed> $data @return array<string, mixed>|null */
    public static function enter(array $data): ?array
    {
        $name = trim((string) ($data['name'] ?? ''));
        $city = trim((string) ($data['city'] ?? 'Munich'));
        $bio = trim((string) ($data['bio'] ?? ''));
        $dirndl = trim((string) ($data['dirndl'] ?? ''));
        $photo = trim((string) ($data['photo'] ?? ''));
        $age = (int) ($data['age'] ?? 0);

        if ($name === '' || $age < 18 || $age > 99) {
            return null;
        }

        $payload = self::load();
        $slug = Str::slug($name).'-'.Str::lower(Str::random(4));
        $entry = [
            'slug' => $slug,
            'name' => Str::limit($name, 80, ''),
            'city' => Str::limit($city !== '' ? $city : 'Munich', 80, ''),
            'age' => $age,
            'dirndl' => Str::limit($dirndl !== '' ? $dirndl : 'Custom dirndl', 120, ''),
            'bio' => Str::limit($bio !== '' ? $bio : 'Entered the Best Dirndl competition on Oktoberhub.', 400, ''),
            'photo' => $photo !== '' && filter_var($photo, FILTER_VALIDATE_URL) ? $photo : 'https://images.pexels.com/photos/5638732/pexels-photo-5638732.jpeg?auto=compress&cs=tinysrgb&w=900&h=1100&fit=crop',
            'seed_votes' => 0,
            'entered' => true,
        ];

        $payload['entries'][$slug] = $entry;
        self::save($payload);

        return $entry;
    }

    public static function totalVotes(): int
    {
        return array_sum(array_map(fn ($row) => (int) ($row['votes'] ?? 0), self::contestants()));
    }

    /** @return array{votes:array<string,int>,voters:array<string,string>,entries:array<string,array<string,mixed>>,changes:array<string,int>} */
    private static function load(): array
    {
        $empty = ['votes' => [], 'voters' => [], 'entries' => [], 'changes' => []];
        $path = self::path();

        try {
            if (is_file($path)) {
                $decoded = json_decode((string) file_get_contents($path), true);
                if (is_array($decoded)) {
                    return array_merge($empty, $decoded);
                }
            }
        } catch (\Throwable) {
            // try cache
        }

        $cached = cache()->get('dirndl-contest');
        if (is_array($cached)) {
            return array_merge($empty, $cached);
        }

        return $empty;
    }

    /** @param array<string, mixed> $payload */
    private static function save(array $payload): void
    {
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $path = self::path();

        try {
            $dir = dirname($path);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($path, $json === false ? '{}' : $json);
        } catch (\Throwable) {
            // storage may be locked on some hosts
        }

        try {
            cache()->put('dirndl-contest', $payload, now()->addDays(30));
        } catch (\Throwable) {
            // ignore
        }
    }

    private static function path(): string
    {
        return storage_path('app/dirndl-contest.json');
    }
}
