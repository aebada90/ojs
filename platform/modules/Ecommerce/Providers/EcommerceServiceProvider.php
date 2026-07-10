<?php

namespace Modules\Ecommerce\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class EcommerceServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Ecommerce';

    public function registerModule(): void
    {
        // Register Ecommerce bindings
    }

    public function bootModule(): void
    {
        // Boot Ecommerce services
    }
}