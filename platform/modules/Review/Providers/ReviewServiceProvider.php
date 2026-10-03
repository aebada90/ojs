<?php

namespace Modules\Review\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class ReviewServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Review';

    public function registerModule(): void
    {
        // Register Review bindings
    }

    public function bootModule(): void
    {
        // Boot Review services
    }
}