<?php

namespace Modules\Payments\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class PaymentsServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Payments';

    public function registerModule(): void
    {
        // Register Payments bindings
    }

    public function bootModule(): void
    {
        // Boot Payments services
    }
}