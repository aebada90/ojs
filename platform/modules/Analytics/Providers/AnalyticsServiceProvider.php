<?php

namespace Modules\Analytics\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class AnalyticsServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Analytics';

    public function registerModule(): void
    {
        // Register Analytics bindings
    }

    public function bootModule(): void
    {
        // Boot Analytics services
    }
}