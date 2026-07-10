<?php

namespace Modules\Admin\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class AdminServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Admin';

    public function registerModule(): void
    {
        // Register Admin bindings
    }

    public function bootModule(): void
    {
        // Boot Admin services
    }
}