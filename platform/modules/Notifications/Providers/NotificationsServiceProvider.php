<?php

namespace Modules\Notifications\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class NotificationsServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Notifications';

    public function registerModule(): void
    {
        // Register Notifications bindings
    }

    public function bootModule(): void
    {
        // Boot Notifications services
    }
}