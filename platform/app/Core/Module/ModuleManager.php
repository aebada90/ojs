<?php

namespace App\Core\Module;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RuntimeException;

class ModuleManager
{
    /** @var Collection<string, ModuleDefinition>|null */
    protected ?Collection $modules = null;

    public function all(): Collection
    {
        return $this->loadModules();
    }

    public function get(string $name): ?ModuleDefinition
    {
        return $this->loadModules()->get($name);
    }

    public function isEnabled(string $name): bool
    {
        $module = $this->get($name);

        return $module?->isEnabled() ?? false;
    }

    /** @return Collection<string, ModuleDefinition> */
    public function enabled(): Collection
    {
        return $this->loadModules()->filter(fn (ModuleDefinition $module) => $module->isEnabled());
    }

    public function path(string $name): string
    {
        return config('modules.module_path').'/'.$name;
    }

    public function configPath(string $name): string
    {
        return $this->path($name).'/config/module.php';
    }

    public function providerClass(string $name): string
    {
        return "Modules\\{$name}\\Providers\\{$name}ServiceProvider";
    }

    public function resolveEnabledProviders(): array
    {
        return $this->enabled()
            ->keys()
            ->map(fn (string $name) => $this->providerClass($name))
            ->filter(fn (string $class) => class_exists($class))
            ->values()
            ->all();
    }

    protected function loadModules(): Collection
    {
        if ($this->modules !== null) {
            return $this->modules;
        }

        $registry = config('modules.modules', []);
        $this->modules = collect($registry)->map(function (array $config, string $name) {
            $moduleConfigPath = $this->configPath($name);

            if (File::exists($moduleConfigPath)) {
                $config = array_merge(require $moduleConfigPath, $config);
            }

            return new ModuleDefinition($name, $config);
        });

        $this->validateDependencies();

        return $this->modules;
    }

    protected function validateDependencies(): void
    {
        foreach ($this->modules as $module) {
            if (! $module->isEnabled()) {
                continue;
            }

            foreach ($module->getDependencies() as $dependency) {
                if (! $this->isEnabled($dependency)) {
                    throw new RuntimeException(
                        "Module [{$module->getName()}] requires [{$dependency}] to be enabled."
                    );
                }
            }
        }
    }
}
