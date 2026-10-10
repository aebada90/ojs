<?php

namespace Modules\Rental\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class RentalServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Rental';

    public function registerModule(): void
    {
        // Register Rental bindings
    }

    public function bootModule(): void
    {
        // Boot Rental services
    }
}