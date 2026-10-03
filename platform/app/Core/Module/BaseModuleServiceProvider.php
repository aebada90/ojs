<?php

namespace App\Core\Module;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

abstract class BaseModuleServiceProvider extends ServiceProvider
{
    protected string $module;

    abstract public function registerModule(): void;

    abstract public function bootModule(): void;

    public function register(): void
    {
        if (! $this->moduleIsEnabled()) {
            return;
        }

        $this->mergeConfigFrom(
            $this->modulePath('config/module.php'),
            "modules.{$this->moduleSlug()}"
        );

        $this->registerModule();
    }

    public function boot(): void
    {
        if (! $this->moduleIsEnabled()) {
            return;
        }

        $this->loadViewsFrom($this->modulePath('Resources/views'), $this->moduleSlug());
        $this->loadMigrationsFrom($this->modulePath('Database/Migrations'));

        $webRoutes = $this->modulePath('routes/web.php');
        if (file_exists($webRoutes)) {
            Route::middleware('web')->group($webRoutes);
        }

        $apiRoutes = $this->modulePath('routes/api.php');
        if (file_exists($apiRoutes)) {
            Route::middleware('api')->prefix('api')->group($apiRoutes);
        }

        $this->bootModule();
    }

    protected function modulePath(string $path = ''): string
    {
        $base = config('modules.module_path').'/'.$this->module;

        return $path ? $base.'/'.$path : $base;
    }

    protected function moduleSlug(): string
    {
        return config("modules.{$this->module}.slug")
            ?? $this->moduleConfigSlug()
            ?? str($this->module)->snake('-');
    }

    protected function moduleConfigSlug(): ?string
    {
        $path = $this->modulePath('config/module.php');

        if (! file_exists($path)) {
            return null;
        }

        $config = require $path;

        return $config['slug'] ?? null;
    }

    protected function moduleIsEnabled(): bool
    {
        return app(ModuleManager::class)->isEnabled($this->module);
    }
}
