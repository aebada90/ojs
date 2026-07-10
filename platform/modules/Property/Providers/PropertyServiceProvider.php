<?php

namespace Modules\Property\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class PropertyServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Property';

    public function registerModule(): void
    {
        // Register Property bindings
    }

    public function bootModule(): void
    {
        // Boot Property services
    }
}