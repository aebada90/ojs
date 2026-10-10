<?php

use Illuminate\Support\Facades\Route;

use Modules\Search\Http\Controllers\Web\SearchController;

Route::prefix('search')->name('search.')->group(function (): void {
    Route::get('/', [SearchController::class, 'index'])->name('results');
});