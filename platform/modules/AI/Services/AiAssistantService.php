<?php

namespace Modules\AI\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAssistantService
{
    public function chat(string $prompt, array $context = []): string
    {
        $provider = config('modules.ai.provider', 'openai');
        $apiKey = config('modules.ai.api_key');

        if (! $apiKey) {
            return $this->fallbackResponse($prompt, $context);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post($this->endpoint($provider), [
                    'model' => config('modules.ai.model', 'gpt-4o-mini'),
                    'messages' => [
                        ['role' => 'system', 'content' => $this->systemPrompt($context)],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content', $this->fallbackResponse($prompt, $context));
            }
        } catch (\Throwable $e) {
            Log::warning('AI assistant request failed', ['error' => $e->getMessage()]);
        }

        return $this->fallbackResponse($prompt, $context);
    }

    public function generateSeo(string $title, string $description): array
    {
        $content = $this->chat("Generate SEO meta title (max 60 chars) and description (max 160 chars) for: {$title}. Description: {$description}");

        return [
            'meta_title' => str($title)->limit(60)->toString(),
            'meta_description' => str($description)->limit(160)->toString(),
            'ai_suggestions' => $content,
        ];
    }

    protected function systemPrompt(array $context): string
    {
        $platform = config('platform.name');

        return "You are the {$platform} AI assistant. Help users discover hotels, events, rentals, marketplace products, restaurants, experiences, and tourism services. Be concise and actionable. Context: ".json_encode($context);
    }

    protected function endpoint(string $provider): string
    {
        return match ($provider) {
            'anthropic' => 'https://api.anthropic.com/v1/messages',
            default => 'https://api.openai.com/v1/chat/completions',
        };
    }

    protected function fallbackResponse(string $prompt, array $context): string
    {
        return 'I can help you plan your trip, find hotels, book experiences, shop the marketplace, and discover Oktoberfest events. Configure your AI API key in Admin → AI Settings for full responses. How can I assist you today?';
    }
}
