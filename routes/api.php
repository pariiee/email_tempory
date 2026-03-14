<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TempEmailController;
use App\Http\Controllers\EmailReceiverController;

// API routes for temporary email functionality
Route::prefix('v1')->group(function () {
    
    // Global platform statistics
    Route::get('stats', [TempEmailController::class, 'globalStats']);

    // Temporary email management
    Route::prefix('temp-emails')->group(function () {
        Route::post('generate', [TempEmailController::class, 'generateEmail']);
        Route::post('check-availability', [TempEmailController::class, 'checkAvailability']);
        Route::get('{emailId}/inbox', [TempEmailController::class, 'getInbox']);
        Route::get('{emailId}/email/{messageId}', [TempEmailController::class, 'getEmail']);
        Route::delete('{emailId}', [TempEmailController::class, 'deleteEmail']);
        Route::put('{emailId}/extend', [TempEmailController::class, 'extendExpiration']);
        Route::get('{emailId}/check-new', [TempEmailController::class, 'checkNewEmails']);
        Route::get('{emailId}/stats', [TempEmailController::class, 'getStats']);
    });

    // Email receiving endpoints (for email server integration)
    Route::prefix('receive')->group(function () {
        Route::post('email', [EmailReceiverController::class, 'receiveEmail']);
        Route::post('bulk-emails', [EmailReceiverController::class, 'bulkReceiveEmails']);
    });

    // Testing/simulation endpoints
    Route::prefix('simulate')->group(function () {
        Route::post('email', [EmailReceiverController::class, 'simulateEmail']);
    });
});