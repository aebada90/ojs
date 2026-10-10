<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('roles', 'permissions');
});

Route::prefix('v1')->group(function (): void {
    Route::get('/health', fn () => response()->json([
        'status' => 'ok',
        'platform' => config('platform.name'),
        'modules' => app(\App\Core\Module\ModuleManager::class)->enabled()->keys()->values(),
    ]));
});
