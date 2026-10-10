<?php

namespace Modules\Messaging\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class MessagingServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Messaging';

    public function registerModule(): void
    {
        // Register Messaging bindings
    }

    public function bootModule(): void
    {
        // Boot Messaging services
    }
}