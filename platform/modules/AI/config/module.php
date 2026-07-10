<?php

return [
    'name' => 'AI',
    'slug' => 'ai',
    'description' => 'AI assistant, recommendations, and content generation',
    'version' => '1.0.0',
    'enabled' => true,
    'dependencies' => ['Core'],
    'provider' => env('AI_PROVIDER', 'openai'),
    'api_key' => env('AI_API_KEY'),
    'model' => env('AI_MODEL', 'gpt-4o-mini'),
];
