<?php

namespace Modules\DigitalTwin\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class DigitalTwinServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'DigitalTwin';

    public function registerModule(): void
    {
        // Register DigitalTwin bindings
    }

    public function bootModule(): void
    {
        // Boot DigitalTwin services
    }
}