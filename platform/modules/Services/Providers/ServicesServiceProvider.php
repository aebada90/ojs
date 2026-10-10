<?php

namespace Modules\Services\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class ServicesServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Services';

    public function registerModule(): void
    {
        // Register Services bindings
    }

    public function bootModule(): void
    {
        // Boot Services services
    }
}