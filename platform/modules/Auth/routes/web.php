<?php

use Illuminate\Support\Facades\Route;

use Modules\Auth\Http\Controllers\Web\SocialAuthController;

Route::prefix('auth')->name('auth.')->group(function (): void {
    Route::get('google/setup-check', [SocialAuthController::class, 'googleSetupCheck'])->name('google.setup-check');
    Route::get('{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
});