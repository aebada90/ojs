<?php

namespace Modules\AI\Services;

class AiAssistantService
{
    public function __construct(protected AiGatewayService $gateway) {}

    public function chat(string $prompt, array $context = []): string
    {
        return $this->gateway->chat([
            ['role' => 'system', 'content' => $this->systemPrompt($context)],
            ['role' => 'user', 'content' => $prompt],
        ], $context);
    }

    /** @param list<array{role: string, content: string}> $conversation */
    public function chatWithHistory(array $conversation, array $context = []): string
    {
        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt($context)],
            ...$conversation,
        ];

        return $this->gateway->chat($messages, $context);
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
        $locale = app()->getLocale();
        $lang = $locale === 'de' ? 'German' : 'English';

        return "You are the {$platform} AI assistant. Respond in {$lang}. Help users discover hotels, events, rentals, marketplace products, restaurants, experiences, and tourism services in Munich and Oktoberfest. Be friendly, concise, and actionable. Context: ".json_encode($context);
    }
}
