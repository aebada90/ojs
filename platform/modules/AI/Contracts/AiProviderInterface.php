<?php

namespace Modules\AI\Contracts;

interface AiProviderInterface
{
    /** @param list<array{role: string, content: string}> $messages */
    public function chat(array $messages, array $context = []): ?string;

    public function isAvailable(): bool;

    public function name(): string;
}
