<?php

namespace App\Core\Module\Contracts;

interface ModuleInterface
{
    public function getName(): string;

    public function getSlug(): string;

    public function isEnabled(): bool;

    /** @return list<string> */
    public function getDependencies(): array;
}
