<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TempEmailController;

// Main temporary email page
Route::get('/', [TempEmailController::class, 'index'])->name('temp-email.index');

// API Documentation page
Route::get('/api-docs', [TempEmailController::class, 'apiDocs'])->name('api.docs');

// API README file
Route::get('/API_README.md', function () {
    $path = base_path('API_README.md');
    if (!file_exists($path)) {
        abort(404);
    }
    
    $content = file_get_contents($path);
    return response($content)
        ->header('Content-Type', 'text/plain; charset=utf-8')
        ->header('Content-Disposition', 'inline; filename="API_README.md"');
})->name('api.readme');

// Web routes for temporary email functionality
Route::prefix('temp-email')->name('temp-email.')->group(function () {
    Route::get('/', [TempEmailController::class, 'index'])->name('home');
    Route::get('/{emailId}/inbox', [TempEmailController::class, 'getInbox'])->name('inbox');
    Route::get('/{emailId}/email/{messageId}', [TempEmailController::class, 'getEmail'])->name('email.show');
});

// Direct email access route (must be last to avoid conflicts)
Route::get('/{emailAddress}', [TempEmailController::class, 'directEmailAccess'])
    ->where('emailAddress', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}')
    ->name('temp-email.direct');
