<?php

namespace App\Services;

/**
 * Munich festival news ticker — 2027 season focus.
 * Keeps a stable local feed so the marquee never depends on flaky scrapes.
 */
class FestivalNewsService
{
    /** @return array<int, object{title:string,url:?string,source:?string}> */
    public function marqueeItems(?string $locale = null, int $limit = 28): array
    {
        $locale = str_starts_with((string) $locale, 'de') ? 'de' : 'en';
        $items = $locale === 'de' ? $this->german() : $this->english();

        return array_slice(array_map(fn (array $row) => (object) $row, $items), 0, max(1, $limit));
    }

    /** @return array<int, array{title:string,url:?string,source:?string}> */
    private function english(): array
    {
        return [
            [
                'title' => 'Munich Festivals 2027 calendar is live — Starkbierfest through Christkindlmarkt',
                'url' => url('/festivals'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Oktoberfest 2027 dates locked: 18 September – 3 October on the Theresienwiese',
                'url' => url('/festivals/oktoberfest'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Frühlingsfest 2027: 16 April – 2 May — spring tents before the Wiesn',
                'url' => url('/festivals/fruehlingsfest'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Starkbierfest 2027 opens mid-March at Nockherberg and Munich beer gardens',
                'url' => url('/festivals/starkbierfest'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Tollwood Summer 2027 returns to Olympiapark with music, food, and culture tents',
                'url' => url('/festivals/tollwood-summer'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Best Dirndl 2027 voting is open — cast your vote online',
                'url' => url('/competition'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Network at every Munich festival season — create a profile and chat',
                'url' => url('/network'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Christkindlmarkt 2027: Marienplatz and city markets from late November',
                'url' => url('/festivals/christkindlmarkt'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Auer Dult 2027: three folk markets at Mariahilfplatz this year',
                'url' => url('/festivals/auer-dult'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Plan hotels near Theresienwiese early for Oktoberfest 2027',
                'url' => url('/hotels'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Tracht tip: reserve Dirndl and Lederhosen before Frühlingsfest and Wiesn',
                'url' => url('/rentals'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Tollwood Winter 2027 lights up the Theresienwiese for the holidays',
                'url' => url('/festivals/tollwood-winter'),
                'source' => 'Oktoberhub',
            ],
        ];
    }

    /** @return array<int, array{title:string,url:?string,source:?string}> */
    private function german(): array
    {
        return [
            [
                'title' => 'Münchner Festivals 2027 live — vom Starkbierfest bis zum Christkindlmarkt',
                'url' => url('/festivals'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Oktoberfest 2027: 18. September – 3. Oktober auf der Theresienwiese',
                'url' => url('/festivals/oktoberfest'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Frühlingsfest 2027: 16. April – 2. Mai — Frühlingszelte vor der Wiesn',
                'url' => url('/festivals/fruehlingsfest'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Starkbierfest 2027 startet Mitte März am Nockherberg und in Biergärten',
                'url' => url('/festivals/starkbierfest'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Tollwood Sommer 2027 im Olympiapark mit Musik, Essen und Kultur',
                'url' => url('/festivals/tollwood-summer'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Beste Dirndl 2027: Online-Voting ist geöffnet',
                'url' => url('/competition'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Network für jede Festivalsaison — Profil erstellen und chatten',
                'url' => url('/network'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Christkindlmarkt 2027: Marienplatz und Stadt-Märkte ab Ende November',
                'url' => url('/festivals/christkindlmarkt'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Auer Dult 2027: drei Volksfeste am Mariahilfplatz',
                'url' => url('/festivals/auer-dult'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Hotels an der Theresienwiese früh für Oktoberfest 2027 sichern',
                'url' => url('/hotels'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Tracht-Tipp: Dirndl und Lederhosen vor Frühlingsfest und Wiesn reservieren',
                'url' => url('/rentals'),
                'source' => 'Oktoberhub',
            ],
            [
                'title' => 'Tollwood Winter 2027 bringt Lichter auf die Theresienwiese',
                'url' => url('/festivals/tollwood-winter'),
                'source' => 'Oktoberhub',
            ],
        ];
    }
}
