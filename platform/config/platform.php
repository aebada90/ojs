<?php

return [
  'name' => env('PLATFORM_NAME', 'Oktoberhub'),
  'tagline' => env('PLATFORM_TAGLINE', 'Munich Festivals 2027 — hotels, tents, markets, and AI trip planning'),
  'default_locale' => env('PLATFORM_DEFAULT_LOCALE', 'en'),
  'default_currency' => env('PLATFORM_DEFAULT_CURRENCY', 'EUR'),
  'default_timezone' => env('PLATFORM_DEFAULT_TIMEZONE', 'Europe/Berlin'),
  'default_city' => env('PLATFORM_DEFAULT_CITY', 'Munich'),
  'locales' => ['en', 'de'],
  'locale_names' => [
    'en' => 'English',
    'de' => 'Deutsch',
  ],
  'commission_rate' => (float) env('PLATFORM_COMMISSION_RATE', 10.0),
  'white_label' => (bool) env('PLATFORM_WHITE_LABEL', false),
  // When true, always show an on-page verify button (useful until Hostinger SMTP works).
  'verify_inline_fallback' => (bool) env('VERIFY_EMAIL_INLINE', true),
  'seo' => [
    'title_suffix' => ' | '.env('PLATFORM_NAME', 'Oktoberhub'),
    'default_description' => 'Munich Festivals 2027 — Oktoberfest, Frühlingsfest, Starkbierfest, Tollwood, Auer Dult, and Christkindlmarkt. Hotels, Tracht, tickets, and AI trip planning.',
    'twitter_handle' => env('PLATFORM_TWITTER', '@oktoberfestai'),
  ],
  'hosting' => [
    'queue_connection' => env('QUEUE_CONNECTION', 'database'),
    'cache_store' => env('CACHE_STORE', 'database'),
    'session_driver' => env('SESSION_DRIVER', 'database'),
    'filesystem_disk' => env('FILESYSTEM_DISK', 'local'),
  ],
  'roles' => [
    'guest',
    'customer',
    'vendor',
    'hotel',
    'restaurant',
    'property_owner',
    'rental_provider',
    'service_provider',
    'employer',
    'job_seeker',
    'event_organizer',
    'influencer',
    'corporate',
    'moderator',
    'admin',
    'super_admin',
  ],
];
