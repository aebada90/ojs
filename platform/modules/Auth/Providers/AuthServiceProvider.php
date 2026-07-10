<?php

namespace Modules\Auth\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class AuthServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Auth';

    public function registerModule(): void
    {
        // Register Auth bindings
    }

    public function bootModule(): void
    {
        // Boot Auth services
    }
}