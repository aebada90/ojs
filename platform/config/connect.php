<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Connect / Nexora (sister Connect app)
    |--------------------------------------------------------------------------
    |
    | Nexora is the HOPn Connect app for AI matchmaking, dating, friends,
    | and business networking. Oktoberhub deep-links into it for Meet Up.
    |
    */
    'nexora' => [
        'name' => 'Nexora',
        'tagline' => 'Connect. Discover. Meet.',
        'home' => env('NEXORA_URL', 'https://nexora.ehopn.com'),
        'register' => env('NEXORA_REGISTER_URL', 'https://nexora.ehopn.com/register'),
        'login' => env('NEXORA_LOGIN_URL', 'https://nexora.ehopn.com/login'),
        'reels' => env('NEXORA_REELS_URL', 'https://nexora.ehopn.com/discover/reels'),
    ],

    'models' => [
        'name' => 'HOPn Models',
        'home' => env('HOPN_MODELS_URL', 'https://models.ehopn.com'),
    ],

    'intents' => [
        'dating' => 'Dating',
        'friends' => 'Friends',
        'business' => 'Business networking',
        'events' => 'Events & parties',
        'travel' => 'Travel buddies',
    ],
];
