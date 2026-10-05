<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * File/cache-backed member profiles so create/edit works on shared hosting.
 */
class MemberProfileStore
{
    /** @return array<int, array<string, mixed>> */
    public static function all(): array
    {
        $payload = self::load();
        $out = [];
        foreach ($payload['profiles'] as $row) {
            if (is_array($row) && ! empty($row['slug'])) {
                $out[] = ConnectDemoProfiles::normalize($row + ['_member' => true, '_demo' => false]);
            }
        }

        return $out;
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

    public static function current(Request $request): ?array
    {
        $slug = (string) $request->session()->get('member_profile_slug', '');
        if ($slug !== '') {
            $found = self::find($slug);
            if ($found !== null) {
                return $found;
            }
        }

        $user = $request->user();
        if ($user) {
            $userSlug = 'member-'.(int) $user->id;
            $found = self::find($userSlug);
            if ($found !== null) {
                return $found;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function save(Request $request, array $data): array
    {
        $payload = self::load();
        $existing = self::current($request);
        $user = $request->user();

        $slug = $existing['slug'] ?? null;
        if (! is_string($slug) || $slug === '') {
            $slug = $user ? 'member-'.(int) $user->id : Str::slug((string) ($data['display_name'] ?? 'member')).'-'.Str::lower(Str::random(4));
        }

        $profile = ConnectDemoProfiles::normalize([
            'slug' => $slug,
            'display_name' => $data['display_name'] ?? ($user->name ?? 'Member'),
            'headline' => $data['headline'] ?? '',
            'bio' => $data['bio'] ?? '',
            'city' => $data['city'] ?? 'Munich',
            'age' => $data['age'] ?? null,
            'intent' => $data['intent'] ?? 'friends',
            'interests' => is_array($data['interests'] ?? null)
                ? $data['interests']
                : self::csvToArray($data['interests'] ?? null),
            'languages' => is_array($data['languages'] ?? null)
                ? $data['languages']
                : self::csvToArray($data['languages'] ?? null),
            'avatar_url' => self::safeUrl($data['avatar_url'] ?? null) ?? ($existing['avatar_url'] ?? ConnectDemoProfiles::presetPortraits()[0] ?? null),
            'company' => $data['company'] ?? null,
            'role_title' => $data['role_title'] ?? null,
            'instagram' => self::cleanHandle($data['instagram'] ?? null),
            'tiktok' => self::cleanHandle($data['tiktok'] ?? null),
            'website' => self::safeUrl($data['website'] ?? $data['nexora_url'] ?? null),
            'linkedin_url' => self::safeUrl($data['linkedin_url'] ?? null),
            'relationship' => $data['relationship'] ?? 'prefer_not',
            'looking_for' => $data['looking_for'] ?? ($data['intent'] ?? 'friends'),
            'status' => $data['status'] ?? 'open_to_meet',
            'status_quote' => $data['status_quote'] ?? null,
            'is_public' => (bool) ($data['is_public'] ?? true),
            'open_to_connect' => (bool) ($data['open_to_connect'] ?? true),
            '_member' => true,
            '_demo' => false,
        ]);

        $payload['profiles'][$slug] = $profile;
        self::persist($payload);
        $request->session()->put('member_profile_slug', $slug);

        return $profile;
    }

    public static function csvToArray(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /** @return array{profiles: array<string, array<string, mixed>>} */
    private static function load(): array
    {
        $empty = ['profiles' => []];
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

        $cached = cache()->get('member-profiles');
        if (is_array($cached)) {
            return array_merge($empty, $cached);
        }

        return $empty;
    }

    /** @param array<string, mixed> $payload */
    private static function persist(array $payload): void
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
            cache()->put('member-profiles', $payload, now()->addDays(30));
        } catch (\Throwable) {
            // ignore
        }
    }

    private static function path(): string
    {
        return storage_path('app/member-profiles.json');
    }

    private static function cleanHandle(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        return ltrim($value, '@');
    }

    private static function safeUrl(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '' || ! filter_var($value, FILTER_VALIDATE_URL)) {
            return null;
        }

        return $value;
    }
}
