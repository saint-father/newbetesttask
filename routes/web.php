<?php

use App\Http\Controllers\ParserController;
use Illuminate\Support\Facades\Route;

/**
 * Web Routes
 */

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

        Route::get('/parse',[ParserController::class, 'index'])->name('parse');
    });
