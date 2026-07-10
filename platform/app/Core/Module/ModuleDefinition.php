<?php

namespace App\Core\Module;

use App\Core\Module\Contracts\ModuleInterface;
use Illuminate\Support\Str;

class ModuleDefinition implements ModuleInterface
{
    public function __construct(
        protected string $name,
        protected array $config = [],
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->config['slug'] ?? Str::kebab($this->name);
    }

    public function isEnabled(): bool
    {
        return (bool) ($this->config['enabled'] ?? false);
    }

    public function getDependencies(): array
    {
        return $this->config['dependencies'] ?? [];
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
