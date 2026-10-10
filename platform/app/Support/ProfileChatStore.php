<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * File/cache-backed profile chat so Network messaging works without migrations.
 */
class ProfileChatStore
{
    public static function ownerKey(): string
    {
        $user = auth()->user();
        if ($user) {
            return 'user-'.$user->id;
        }

        $key = session()->get('profile_chat_id');
        if (! is_string($key) || $key === '') {
            $key = 'guest-'.Str::lower(Str::random(12));
            session()->put('profile_chat_id', $key);
        }

        return $key;
    }

    public static function displayName(): string
    {
        return auth()->user()?->name ?: __('platform.chat.you');
    }

    /** @return array<int, array<string, mixed>> */
    public static function inbox(string $ownerKey): array
    {
        $payload = self::load($ownerKey);
        $threads = [];

        foreach ($payload['threads'] ?? [] as $slug => $thread) {
            $messages = is_array($thread['messages'] ?? null) ? $thread['messages'] : [];
            $last = $messages === [] ? null : $messages[array_key_last($messages)];
            $threads[] = [
                'slug' => (string) $slug,
                'profile' => ConnectDemoProfiles::resolve((string) $slug),
                'last' => $last,
                'count' => count($messages),
            ];
        }

        usort($threads, function (array $a, array $b): int {
            return strcmp((string) ($b['last']['at'] ?? ''), (string) ($a['last']['at'] ?? ''));
        });

        return $threads;
    }

    /** @param array<string, mixed> $profile @return array<int, array<string, mixed>> */
    public static function ensureThread(string $ownerKey, array $profile): array
    {
        $payload = self::load($ownerKey);
        $slug = (string) $profile['slug'];

        if (! isset($payload['threads'][$slug]['messages']) || $payload['threads'][$slug]['messages'] === []) {
            $payload['threads'][$slug]['messages'] = [
                self::message((string) $profile['display_name'], $slug, self::greeting($profile), false),
            ];
            self::save($ownerKey, $payload);
        }

        return $payload['threads'][$slug]['messages'];
    }

    /** @param array<string, mixed> $profile @return array<int, array<string, mixed>> */
    public static function send(string $ownerKey, array $profile, string $body, string $fromName): array
    {
        $body = trim($body);
        $messages = self::ensureThread($ownerKey, $profile);
        $payload = self::load($ownerKey);
        $slug = (string) $profile['slug'];

        if (count($messages) >= 80) {
            return $messages;
        }

        $payload['threads'][$slug]['messages'][] = self::message($fromName, 'me', $body, true);
        $payload['threads'][$slug]['messages'][] = self::message(
            (string) $profile['display_name'],
            $slug,
            self::reply($profile, $body, count($payload['threads'][$slug]['messages'])),
            false
        );
        self::save($ownerKey, $payload);

        return $payload['threads'][$slug]['messages'];
    }

    /** @return array{from:string,from_slug:string,body:string,mine:bool,at:string} */
    private static function message(string $from, string $fromSlug, string $body, bool $mine): array
    {
        return [
            'from' => $from,
            'from_slug' => $fromSlug,
            'body' => $body,
            'mine' => $mine,
            'at' => now()->toIso8601String(),
        ];
    }

    /** @param array<string, mixed> $profile */
    private static function greeting(array $profile): string
    {
        $first = strtok((string) $profile['display_name'], ' ') ?: (string) $profile['display_name'];
        $de = app()->getLocale() === 'de';

        return match ($profile['intent'] ?? 'friends') {
            'business' => $de
                ? "Servus, ich bin {$first}. Offen für einen Kaffee auf der EXPO oder ein kurzes Networking vor den Zelten."
                : "Hi, I'm {$first}. Open to a coffee at EXPO or a quick chat before the tents.",
            'dating' => $de
                ? "Hey, ich bin {$first}. Schreib mir gern — Dirndl ist schon parat."
                : "Hey, I'm {$first}. Say hi — dirndl is ready.",
            'events' => $de
                ? "Servus, {$first} hier. Wenn ihr Afterhours oder Zelte plant, chattet mich an."
                : "Hey, {$first} here. If you're planning after-hours or tents, ping me.",
            'travel' => $de
                ? "Hi, ich bin {$first} — solo unterwegs. Brunch, Bars oder Zelte, alles easy."
                : "Hi, I'm {$first} — traveling solo. Brunch, bars, or tents, I'm in.",
            default => $de
                ? "Servus! Ich bin {$first}. Zelt-Buddies und Wiesn-Crews gesucht."
                : "Servus! I'm {$first}. Looking for tent buddies and a Wiesn crew.",
        };
    }

    /** @param array<string, mixed> $profile */
    private static function reply(array $profile, string $body, int $turn): string
    {
        $de = app()->getLocale() === 'de';
        $lower = Str::lower($body);
        $first = strtok((string) $profile['display_name'], ' ') ?: (string) $profile['display_name'];

        if (str_contains($lower, 'tent') || str_contains($lower, 'zelt') || str_contains($lower, 'maß') || str_contains($lower, 'mass')) {
            return $de
                ? 'Hofbräu oder Schottenhamel? Ich bin flexibel — sag wann.'
                : 'Hofbräu or Schottenhamel? I am flexible — tell me when.';
        }
        if (str_contains($lower, 'expo') || str_contains($lower, 'coffee') || str_contains($lower, 'kaffee')) {
            return $de
                ? 'Kaffee auf der EXPO klingt gut. Vormittags oder nach den Keynotes?'
                : 'Coffee at EXPO sounds good. Morning or after the keynotes?';
        }
        if (str_contains($lower, 'brunch') || str_contains($lower, 'bar')) {
            return $de
                ? 'Brunch in der Maxvorstadt, danach Bars. Passt dir Samstag?'
                : 'Brunch in Maxvorstadt, then bars. Saturday work for you?';
        }

        $pool = match ($profile['intent'] ?? 'friends') {
            'business' => $de
                ? [
                    "Klingt gut, {$first} hier — lass uns Intent und Slot kurz klären.",
                    'Ich bin die Woche um EXPO + Wiesn. Wann passt ein 20-Minuten-Chat?',
                    'Schick mir deine Firma und Rolle, dann finden wir einen Kaffee.',
                ]
                : [
                    "Sounds good — {$first} here. Let's lock a slot.",
                    'I am around EXPO + Wiesn this week. When works for a 20-minute chat?',
                    'Share your company and role and we can find a coffee.',
                ],
            'dating' => $de
                ? [
                    'Mag ich. Ferris-wheel bei Sonnenuntergang oder doch erst ein Tanz?',
                    'Erzähl mir, welchen Tag du auf der Wiesn bist.',
                    'Klingt nach einer guten Energie. Wo triffst du dich am liebsten?',
                ]
                : [
                    'I like that. Ferris-wheel at sunset, or a dance first?',
                    'Tell me which day you are at the Wiesn.',
                    'Good energy. Where do you like to meet first?',
                ],
            default => $de
                ? [
                    'Geht klar. Welcher Tag passt dir am besten?',
                    'Ich bringe Tipps für Zelte mit — du die Crew?',
                    'Schreib mir einfach Zeit und Treffpunkt.',
                ]
                : [
                    'Deal. Which day works best for you?',
                    'I will bring tent tips — you bring the crew?',
                    'Just send a time and a meeting point.',
                ],
        };

        return $pool[$turn % count($pool)];
    }

    /** @return array{threads: array<string, array{messages: array<int, array<string, mixed>>}>} */
    private static function load(string $ownerKey): array
    {
        $safe = self::safeKey($ownerKey);
        $path = self::path($safe);

        try {
            if (is_file($path)) {
                $decoded = json_decode((string) file_get_contents($path), true);
                if (is_array($decoded) && isset($decoded['threads']) && is_array($decoded['threads'])) {
                    return $decoded;
                }
            }
        } catch (\Throwable) {
            // try cache
        }

        $cached = cache()->get('profile-chat:'.$safe);
        if (is_array($cached) && isset($cached['threads']) && is_array($cached['threads'])) {
            return $cached;
        }

        return ['threads' => []];
    }

    /** @param array{threads: array<string, mixed>} $payload */
    private static function save(string $ownerKey, array $payload): void
    {
        $safe = self::safeKey($ownerKey);
        $path = self::path($safe);
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        try {
            $dir = dirname($path);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($path, $json === false ? '{"threads":{}}' : $json);
        } catch (\Throwable) {
            // Hostinger storage may be read-only in some layouts.
        }

        try {
            cache()->put('profile-chat:'.$safe, $payload, now()->addDays(14));
        } catch (\Throwable) {
            // ignore
        }
    }

    private static function safeKey(string $ownerKey): string
    {
        $safe = preg_replace('/[^a-zA-Z0-9_-]/', '', $ownerKey) ?: 'guest';

        return substr($safe, 0, 80);
    }

    private static function path(string $safeKey): string
    {
        return storage_path('app/profile-chats/'.$safeKey.'.json');
    }
}
