<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ContactController;

Route::group([
    'as' => 'contacts.'
], function() {
    Route::get('/contacts', [ContactController::class, 'index'])
        ->name('index');

    Route::get('/contacts/{contact}', [ContactController::class, 'show'])
        ->name('show');

    Route::post('/contacts', [ContactController::class, 'store'])
        ->name('store');

    Route::patch('/contacts/{contact}', [ContactController::class, 'update'])
        ->name('update');

    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])
        ->name('delete');
});
