<?php

return [
    'name' => 'Oktoberfest AI',
    'tagline' => 'Das ultimative KI-gestützte Tourismus- & Festival-Ökosystem',
    'tagline_short' => 'KI-Tourismus & Festival OS',

    'nav' => [
        'hotels' => 'Hotels',
        'rentals' => 'Vermietung',
        'marketplace' => 'Marktplatz',
        'events' => 'Events',
        'experiences' => 'Erlebnisse',
        'search' => 'Suche',
        'digital_twin' => 'Digital Twin',
        'login' => 'Anmelden',
        'register' => 'Jetzt starten',
        'dashboard' => 'Dashboard',
    ],

    'hero' => [
        'badge' => 'Oktoberfest 2026 • München',
        'title' => 'Entdecken. Buchen. Feiern.',
        'title_highlight' => 'Alles auf einer KI-Plattform.',
        'subtitle' => 'Hotels, Vermietungen, Marktplatz, Events, Restaurants, Erlebnisse, Jobs und eine Live-Digital-Twin-Karte — KI-gestützt für die größten Festivals und Reiseziele der Welt.',
        'cta_planner' => 'Reise mit KI planen',
        'cta_explore' => 'Alles entdecken',
        'stats' => [
            ['value' => '500+', 'label' => 'Hotels'],
            ['value' => '1.2k', 'label' => 'Anbieter'],
            ['value' => '50k', 'label' => 'Events'],
        ],
    ],

    'planner' => [
        'title' => 'KI-Reiseplaner',
        'subtitle' => 'Personalisierte Reiserouten, Restaurant-Tipps und Festival-Empfehlungen in Sekunden.',
        'placeholder' => 'Plane eine 3-tägige München-Reise mit Hotels und Biertouren...',
        'empty' => 'Frag mich nach deiner Oktoberfest-Reise, Hotelempfehlungen oder den besten Bierzelten.',
        'send' => 'KI fragen',
    ],

    'sections' => [
        'hotels' => [
            'title' => 'Empfohlene Hotels',
            'subtitle' => 'Von Luxussuiten bis gemütlichen Gästehäusern an der Theresienwiese.',
        ],
        'rentals' => [
            'title' => 'Empfohlene Vermietungen',
            'subtitle' => 'Autos, Fahrräder, Tracht, Party-Equipment und mehr.',
        ],
        'marketplace' => [
            'title' => 'Empfohlene Produkte',
            'subtitle' => 'Authentische bayerische Produkte von verifizierten Anbietern.',
        ],
        'experiences' => [
            'title' => 'Empfohlene Erlebnisse',
            'subtitle' => 'Biertouren, Schiffsfahrten, Kochkurse und Nachtleben.',
        ],
        'restaurants' => [
            'title' => 'Restaurants',
            'subtitle' => 'Tische reservieren, digitale Speisekarten und Lieferung.',
        ],
        'events' => [
            'title' => 'Events & Tickets',
            'subtitle' => 'Oktoberfest-Zelte, Konzerte, Fußball und Firmenevents.',
        ],
        'jobs' => [
            'title' => 'Saisonjobs',
            'subtitle' => 'Finde temporäre und Festival-Jobs in München.',
        ],
        'properties' => [
            'title' => 'Immobilien',
            'subtitle' => 'Kaufen, verkaufen oder mieten — Wohn- und Gewerbeimmobilien.',
        ],
        'view_all' => 'Alle anzeigen',
        'empty_listings' => 'Empfohlene :type-Einträge erscheinen hier nach dem Seeding.',
        'empty_products' => 'Marktplatz-Produkte erscheinen hier nach dem Seeding.',
    ],

    'types' => [
        'all' => 'Alles',
        'hotel' => 'Hotels',
        'rental' => 'Vermietung',
        'product' => 'Produkte',
        'event' => 'Events',
        'property' => 'Immobilien',
        'restaurant' => 'Restaurants',
        'experience' => 'Erlebnisse',
        'service' => 'Dienstleistungen',
        'job' => 'Jobs',
    ],

    'map' => [
        'title' => 'Digital Twin Live-Karte',
        'subtitle' => 'Interaktive Ebenen für Menschenmengen, Wetter, Verkehr, Parkplätze, Hotels, Restaurants, Toiletten, Medizin, Ladestationen, Events und Notfallnavigation.',
        'ready_title' => 'Kartenmodul bereit',
        'ready_subtitle' => 'Echtzeit-APIs einbinden ohne Architekturänderungen.',
        'layers' => ['Menschenmengen', 'Wetter', 'Verkehr', 'Parkplätze', 'Hotels', 'Events', 'Notfall'],
    ],

    'partners' => [
        'title' => 'Sponsoren & Partner',
        'names' => ['Bayern Tourismus', 'Münchner Hotels', 'Festival-Brauereien', 'Lokale Handwerker', 'Verkehrsverbund', 'EventTech'],
    ],

    'testimonials' => [
        'title' => 'Stimmen unserer Gäste',
        'items' => [
            [
                'quote' => 'Wir haben unser Hotel gebucht, Lederhosen gemietet und KI-Restaurant-Tipps bekommen — alles an einem Ort.',
                'author' => 'Sarah K., Festivalbesucherin',
            ],
            [
                'quote' => 'Unser Vendor-Shop, Analytics und Auszahlungen sind endlich vereint. Perfekt für Shared Hosting.',
                'author' => 'Hans M., Marktplatz-Anbieter',
            ],
        ],
    ],

    'mobile' => [
        'title' => 'Die Plattform überall dabei',
        'subtitle' => 'REST-APIs bereit für Flutter, iOS, Android, React und Vue Mobile Apps.',
        'app_store' => 'App Store demnächst',
        'google_play' => 'Google Play demnächst',
    ],

    'search' => [
        'label' => 'Alles durchsuchen',
        'placeholder' => 'Hotels, Events, Vermietung, Produkte, Jobs...',
        'city_placeholder' => 'Stadt (z.B. München)',
        'submit' => 'Plattform durchsuchen',
        'page_title' => 'Universelle Suche',
        'page_subtitle' => 'Suche Hotels, Produkte, Events, Immobilien, Vermietungen, Restaurants, Jobs und mehr.',
        'no_results' => 'Keine Ergebnisse. Versuche eine andere Suche oder seede Demo-Daten.',
    ],

    'footer' => [
        'discover' => 'Entdecken',
        'business' => 'Für Unternehmen',
        'become_vendor' => 'Anbieter werden',
        'list_property' => 'Immobilie inserieren',
        'post_job' => 'Job veröffentlichen',
        'event_organizer' => 'Event-Veranstalter',
        'newsletter' => 'Newsletter',
        'newsletter_text' => 'KI-kuratierte Festival-Tipps und exklusive Angebote.',
        'email_placeholder' => 'E-Mail-Adresse',
        'join' => 'Anmelden',
        'rights' => 'Alle Rechte vorbehalten.',
        'privacy' => 'Datenschutz',
        'terms' => 'AGB',
        'cookies' => 'Cookies',
    ],

    'meta' => [
        'home_title' => 'KI-gestützte Tourismus- & Festival-Plattform',
        'description' => 'Entdecken, buchen, kaufen, verkaufen und mieten — Hotels, Events, Erlebnisse, Marktplatz und mehr. Mit KI.',
    ],

    'chatbot' => [
        'title' => 'Oktoberfest KI-Assistent',
        'online' => 'Online',
        'open' => 'Chat öffnen',
        'clear' => 'Chat löschen',
        'welcome' => 'Willkommen! Wie kann ich helfen?',
        'welcome_hint' => 'Frag nach Hotels, Events, Vermietungen, Restaurants oder plane deine München-Reise.',
        'placeholder' => 'Nachricht eingeben...',
        'quick_hotels' => 'Hotels nahe Wiesn finden',
        'quick_events' => 'Oktoberfest Events & Tickets',
        'quick_rentals' => 'Tracht mieten',
        'quick_restaurants' => 'Beste Biergärten',
    ],

    'verify' => [
        'title' => 'E-Mail bestätigen',
        'body' => 'Bitte bestätige deine E-Mail-Adresse, um auf dein Dashboard zuzugreifen.',
        'sent' => 'Ein neuer Bestätigungslink wurde an deine E-Mail-Adresse gesendet.',
        'hint' => 'Prüfe Posteingang und Spam-Ordner. Der Link ist nur kurze Zeit gültig.',
        'resend' => 'Bestätigungs-E-Mail erneut senden',
        'logout' => 'Abmelden und anderes Konto verwenden',
        'send_failed' => 'Die E-Mail konnte nicht gesendet werden (Mailserver-Fehler). Nutze den Button unten zur Sofort-Bestätigung, oder ein Admin führt aus: php artisan users:verify deine@email.com',
        'inline_title' => 'Ohne E-Mail bestätigen',
        'inline_hint' => 'Der Mailversand ist gerade nicht verfügbar. Klicke unten, um diese Sitzung zu bestätigen.',
        'inline_action' => 'E-Mail jetzt bestätigen',
        'mail_subject' => 'Bestätige dein Oktoberfest-Konto',
        'mail_line' => 'Bitte klicke auf den Button unten, um deine E-Mail-Adresse zu bestätigen.',
        'mail_action' => 'E-Mail-Adresse bestätigen',
        'mail_outro' => 'Falls du kein Konto erstellt hast, ist keine weitere Aktion nötig.',
    ],
];
