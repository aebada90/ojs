<?php

namespace Modules\Hotel\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class HotelServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Hotel';

    public function registerModule(): void
    {
        // Register Hotel bindings
    }

    public function bootModule(): void
    {
        // Boot Hotel services
    }
}