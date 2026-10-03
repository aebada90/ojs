<?php

namespace Modules\AI\Services\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\AI\Contracts\AiProviderInterface;

class OpenAiProvider implements AiProviderInterface
{
    public function __construct(protected array $config) {}

    public function chat(array $messages, array $context = []): ?string
    {
        if (! $this->isAvailable()) {
            return null;
        }

        try {
            $response = Http::withToken($this->config['api_key'])
                ->timeout($this->config['timeout'] ?? 30)
                ->post($this->config['endpoint'], [
                    'model' => $this->config['model'],
                    'messages' => $messages,
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::warning('OpenAI provider error', ['status' => $response->status(), 'body' => $response->body()]);
        } catch (\Throwable $e) {
            Log::warning('OpenAI provider exception', ['error' => $e->getMessage()]);
        }

        return null;
    }

    public function isAvailable(): bool
    {
        return ! empty($this->config['api_key']);
    }

    public function name(): string
    {
        return 'openai';
    }
}
