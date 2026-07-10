<?php

namespace App\Http\Middleware;

use App\Core\Module\ModuleManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleEnabled
{
    public function __construct(protected ModuleManager $moduleManager) {}

    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (! $this->moduleManager->isEnabled($module)) {
            abort(404);
        }

        return $next($request);
    }
}
