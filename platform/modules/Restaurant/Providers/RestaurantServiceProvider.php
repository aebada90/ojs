<?php

namespace Modules\Restaurant\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class RestaurantServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Restaurant';

    public function registerModule(): void
    {
        // Register Restaurant bindings
    }

    public function bootModule(): void
    {
        // Boot Restaurant services
    }
}