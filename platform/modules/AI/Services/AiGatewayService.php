<?php

namespace Modules\AI\Services;

use Modules\AI\Contracts\AiProviderInterface;
use Modules\AI\Services\Providers\AnthropicProvider;
use Modules\AI\Services\Providers\ExternalApiProvider;
use Modules\AI\Services\Providers\OpenAiProvider;

class AiGatewayService
{
    /** @param list<array{role: string, content: string}> $messages */
    public function chat(array $messages, array $context = []): string
    {
        $providerName = config('ai-providers.default', 'openai');
        $chain = config('ai-providers.fallback_chain', [$providerName]);

        // If default is a specific provider, try it first
        $providers = array_unique(array_merge([$providerName], $chain));

        foreach ($providers as $name) {
            $provider = $this->resolveProvider($name);

            if ($provider && $provider->isAvailable()) {
                $response = $provider->chat($messages, $context);

                if ($response !== null && $response !== '') {
                    return $response;
                }
            }
        }

        return $this->fallbackResponse($messages, $context);
    }

    public function resolveProvider(string $name): ?AiProviderInterface
    {
        $config = config("ai-providers.providers.{$name}");

        if (! $config) {
            return null;
        }

        return match ($config['driver'] ?? 'openai') {
            'anthropic' => new AnthropicProvider($config),
            'external' => new ExternalApiProvider($config, $name),
            default => new OpenAiProvider($config),
        };
    }

    /** @return list<string> */
    public function availableProviders(): array
    {
        return collect(config('ai-providers.providers', []))
            ->keys()
            ->filter(fn (string $name) => $this->resolveProvider($name)?->isAvailable())
            ->values()
            ->all();
    }

    /** @param list<array{role: string, content: string}> $messages */
    protected function fallbackResponse(array $messages, array $context): string
    {
        $locale = app()->getLocale();

        return match ($locale) {
            'de' => 'Ich helfe dir bei der Reiseplanung, Hotels, Erlebnissen, Marktplatz-Shopping und Oktoberfest-Events. Bitte konfiguriere deine KI-API in den Einstellungen. Wie kann ich dir helfen?',
            default => 'I can help you plan your trip, find hotels, book experiences, shop the marketplace, and discover Oktoberfest events. Configure your AI API in settings for full responses. How can I assist you today?',
        };
    }
}
