<?php

namespace Modules\AI\Services\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\AI\Contracts\AiProviderInterface;

class AnthropicProvider implements AiProviderInterface
{
    public function __construct(protected array $config) {}

    public function chat(array $messages, array $context = []): ?string
    {
        if (! $this->isAvailable()) {
            return null;
        }

        $system = collect($messages)->firstWhere('role', 'system')['content'] ?? '';
        $conversation = collect($messages)->reject(fn ($m) => $m['role'] === 'system')->values()->all();

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->config['api_key'],
                'anthropic-version' => '2023-06-01',
            ])
                ->timeout($this->config['timeout'] ?? 30)
                ->post($this->config['endpoint'], [
                    'model' => $this->config['model'],
                    'max_tokens' => 1024,
                    'system' => $system,
                    'messages' => $conversation,
                ]);

            if ($response->successful()) {
                return $response->json('content.0.text');
            }

            Log::warning('Anthropic provider error', ['status' => $response->status()]);
        } catch (\Throwable $e) {
            Log::warning('Anthropic provider exception', ['error' => $e->getMessage()]);
        }

        return null;
    }

    public function isAvailable(): bool
    {
        return ! empty($this->config['api_key']);
    }

    public function name(): string
    {
        return 'anthropic';
    }
}
