<?php

namespace Modules\Vendor\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class VendorServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Vendor';

    public function registerModule(): void
    {
        // Register Vendor bindings
    }

    public function bootModule(): void
    {
        // Boot Vendor services
    }
}