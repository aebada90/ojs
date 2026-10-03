<?php

/**
 * AI provider & external project API configuration.
 *
 * Connect APIs from your other projects by setting AI_PROVIDER=external
 * and configuring the matching project block below (or add your own).
 */
return [

    'default' => env('AI_PROVIDER', 'openai'),

    'fallback_chain' => array_filter(explode(',', env('AI_FALLBACK_CHAIN', 'external,openai'))),

    'providers' => [

        'openai' => [
            'driver' => 'openai',
            'api_key' => env('AI_API_KEY'),
            'model' => env('AI_MODEL', 'gpt-4o-mini'),
            'endpoint' => env('AI_OPENAI_ENDPOINT', 'https://api.openai.com/v1/chat/completions'),
            'timeout' => (int) env('AI_TIMEOUT', 30),
        ],

        'anthropic' => [
            'driver' => 'anthropic',
            'api_key' => env('AI_ANTHROPIC_API_KEY', env('AI_API_KEY')),
            'model' => env('AI_ANTHROPIC_MODEL', 'claude-3-5-haiku-20241022'),
            'endpoint' => env('AI_ANTHROPIC_ENDPOINT', 'https://api.anthropic.com/v1/messages'),
            'timeout' => (int) env('AI_TIMEOUT', 30),
        ],

        /*
        |--------------------------------------------------------------------------
        | External project APIs — plug in your other platforms here
        |--------------------------------------------------------------------------
        */
        'external' => [
            'driver' => 'external',
            'enabled' => env('AI_EXTERNAL_ENABLED', false),
            'base_url' => env('AI_EXTERNAL_BASE_URL'),
            'endpoint' => env('AI_EXTERNAL_CHAT_ENDPOINT', '/api/v1/chat'),
            'api_key' => env('AI_EXTERNAL_API_KEY'),
            'auth_type' => env('AI_EXTERNAL_AUTH_TYPE', 'bearer'), // bearer | api-key | header
            'auth_header' => env('AI_EXTERNAL_AUTH_HEADER', 'Authorization'),
            'response_key' => env('AI_EXTERNAL_RESPONSE_KEY', 'reply'),
            'timeout' => (int) env('AI_EXTERNAL_TIMEOUT', 30),
            'extra_headers' => [],
        ],

        'tourism_os' => [
            'driver' => 'external',
            'enabled' => env('AI_TOURISM_OS_ENABLED', false),
            'base_url' => env('AI_TOURISM_OS_URL'),
            'endpoint' => env('AI_TOURISM_OS_CHAT_ENDPOINT', '/api/ai/chat'),
            'api_key' => env('AI_TOURISM_OS_API_KEY'),
            'auth_type' => env('AI_TOURISM_OS_AUTH_TYPE', 'bearer'),
            'auth_header' => env('AI_TOURISM_OS_AUTH_HEADER', 'Authorization'),
            'response_key' => env('AI_TOURISM_OS_RESPONSE_KEY', 'message'),
            'timeout' => (int) env('AI_TOURISM_OS_TIMEOUT', 30),
        ],

        'eventos' => [
            'driver' => 'external',
            'enabled' => env('AI_EVENTOS_ENABLED', false),
            'base_url' => env('AI_EVENTOS_URL'),
            'endpoint' => env('AI_EVENTOS_CHAT_ENDPOINT', '/api/v1/assistant/chat'),
            'api_key' => env('AI_EVENTOS_API_KEY'),
            'auth_type' => env('AI_EVENTOS_AUTH_TYPE', 'bearer'),
            'auth_header' => env('AI_EVENTOS_AUTH_HEADER', 'X-API-Key'),
            'response_key' => env('AI_EVENTOS_RESPONSE_KEY', 'response'),
            'timeout' => (int) env('AI_EVENTOS_TIMEOUT', 30),
        ],

        'marketplace_ai' => [
            'driver' => 'external',
            'enabled' => env('AI_MARKETPLACE_ENABLED', false),
            'base_url' => env('AI_MARKETPLACE_URL'),
            'endpoint' => env('AI_MARKETPLACE_CHAT_ENDPOINT', '/api/chatbot'),
            'api_key' => env('AI_MARKETPLACE_API_KEY'),
            'auth_type' => env('AI_MARKETPLACE_AUTH_TYPE', 'bearer'),
            'auth_header' => env('AI_MARKETPLACE_AUTH_HEADER', 'Authorization'),
            'response_key' => env('AI_MARKETPLACE_RESPONSE_KEY', 'reply'),
            'timeout' => (int) env('AI_MARKETPLACE_TIMEOUT', 30),
        ],
    ],
];
