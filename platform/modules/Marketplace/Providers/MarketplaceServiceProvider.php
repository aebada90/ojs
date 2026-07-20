<?php

namespace Modules\Marketplace\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class MarketplaceServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Marketplace';

    public function registerModule(): void
    {
        // Register Marketplace bindings
    }

    public function bootModule(): void
    {
        // Boot Marketplace services
    }
}