<?php

use Illuminate\Support\Facades\Route;

use Modules\Admin\Http\Controllers\Web\DashboardController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin|super_admin'])
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
    });