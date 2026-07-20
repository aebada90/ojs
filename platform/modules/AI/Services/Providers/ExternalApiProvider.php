<?php

namespace Modules\AI\Services\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\AI\Contracts\AiProviderInterface;

/**
 * Connects to AI/chatbot APIs from your other projects.
 */
class ExternalApiProvider implements AiProviderInterface
{
    public function __construct(protected array $config, protected string $providerName = 'external') {}

    public function chat(array $messages, array $context = []): ?string
    {
        if (! $this->isAvailable()) {
            return null;
        }

        $url = rtrim($this->config['base_url'], '/').'/'.ltrim($this->config['endpoint'], '/');
        $lastUserMessage = collect($messages)->reverse()->firstWhere('role', 'user')['content'] ?? '';

        $payload = [
            'message' => $lastUserMessage,
            'messages' => $messages,
            'conversation' => $messages,
            'context' => array_merge($context, [
                'platform' => config('platform.name'),
                'locale' => app()->getLocale(),
                'city' => config('platform.default_city'),
            ]),
        ];

        try {
            $request = Http::timeout($this->config['timeout'] ?? 30);
            $request = $this->applyAuth($request);

            $response = $request->post($url, $payload);

            if ($response->successful()) {
                return $this->extractResponse($response->json());
            }

            Log::warning("External AI provider [{$this->providerName}] error", [
                'url' => $url,
                'status' => $response->status(),
            ]);
        } catch (\Throwable $e) {
            Log::warning("External AI provider [{$this->providerName}] exception", [
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }

    public function isAvailable(): bool
    {
        return ($this->config['enabled'] ?? true)
            && ! empty($this->config['base_url']);
    }

    public function name(): string
    {
        return $this->providerName;
    }

    protected function applyAuth($request)
    {
        $key = $this->config['api_key'] ?? null;
        if (! $key) {
            return $request;
        }

        return match ($this->config['auth_type'] ?? 'bearer') {
            'api-key' => $request->withHeaders([$this->config['auth_header'] ?? 'X-API-Key' => $key]),
            'header' => $request->withHeaders([$this->config['auth_header'] ?? 'Authorization' => $key]),
            default => $request->withToken($key),
        };
    }

    protected function extractResponse(?array $data): ?string
    {
        if (! $data) {
            return null;
        }

        $key = $this->config['response_key'] ?? 'reply';

        // Support dot notation: data.reply, choices.0.message.content
        $value = Arr::get($data, $key);

        if (is_string($value) && $value !== '') {
            return $value;
        }

        // Common fallback keys from other projects
        foreach (['reply', 'message', 'response', 'content', 'text', 'answer', 'output'] as $fallback) {
            $candidate = Arr::get($data, $fallback);
            if (is_string($candidate) && $candidate !== '') {
                return $candidate;
            }
        }

        return null;
    }
}
