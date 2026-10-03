<?php

namespace Modules\Core\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class CoreServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Core';

    public function registerModule(): void
    {
        // Register Core bindings
    }

    public function bootModule(): void
    {
        // Boot Core services
    }
}