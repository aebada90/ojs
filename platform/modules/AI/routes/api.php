<?php

use Illuminate\Support\Facades\Route;
use Modules\AI\Http\Controllers\Api\ChatController;

Route::prefix('v1/ai')->name('api.ai.')->group(function (): void {
    Route::get('/status', [ChatController::class, 'status'])->name('status');
    Route::post('/chat', [ChatController::class, 'chat'])->name('chat');
    Route::get('/history/{sessionId}', [ChatController::class, 'history'])->name('history');
});
