<?php

namespace App\Providers;

use App\Core\Module\ModuleManager;
use Illuminate\Support\ServiceProvider;

class PlatformServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ModuleManager::class);

        foreach (app(ModuleManager::class)->resolveEnabledProviders() as $provider) {
            $this->app->register($provider);
        }
    }

    public function boot(): void
    {
        //
    }
}
