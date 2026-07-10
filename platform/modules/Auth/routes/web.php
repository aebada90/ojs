<?php

use Illuminate\Support\Facades\Route;

use Modules\Auth\Http\Controllers\Web\SocialAuthController;

Route::prefix('auth')->name('auth.')->group(function (): void {
    Route::get('{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
});