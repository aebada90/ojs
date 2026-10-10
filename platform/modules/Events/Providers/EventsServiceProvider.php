<?php

namespace Modules\Events\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class EventsServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Events';

    public function registerModule(): void
    {
        // Register Events bindings
    }

    public function bootModule(): void
    {
        // Boot Events services
    }
}