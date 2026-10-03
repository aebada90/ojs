<?php

namespace Modules\CMS\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class CMSServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'CMS';

    public function registerModule(): void
    {
        // Register CMS bindings
    }

    public function bootModule(): void
    {
        // Boot CMS services
    }
}