<?php

namespace Modules\Jobs\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class JobsServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Jobs';

    public function registerModule(): void
    {
        // Register Jobs bindings
    }

    public function bootModule(): void
    {
        // Boot Jobs services
    }
}