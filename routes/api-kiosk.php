<?php


use App\Http\Controllers\Kiosk\AccessController;
use App\Http\Controllers\Kiosk\FingerprintController;
use App\Http\Controllers\Kiosk\GroupController;
use Illuminate\Support\Facades\Route;


Route::middleware('api')->group(function () {

    Route::name('access.')->prefix('access')->group(function () {

        Route::post('/search', [AccessController::class, 'search'])->name('search');
        Route::get('/config', [AccessController::class, 'config'])->name('config');

        Route::get('/', [AccessController::class, 'index'])->name('index');
        Route::post('/', [AccessController::class, 'store'])->name('store');
        Route::put('/{id}', [AccessController::class, 'update'])->name('update');
        Route::get('/{id}', [AccessController::class, 'show'])->name('show');
        Route::delete('/{id}', [AccessController::class, 'destroy'])->name('destroy');

    });

    Route::name('group.')->prefix('group')->group(function () {

        Route::post('/search', [GroupController::class, 'search'])->name('search');
        Route::get('/config', [GroupController::class, 'config'])->name('config');
        Route::put('/{id}/status', [GroupController::class, 'status'])->name('status');

        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::post('/', [GroupController::class, 'store'])->name('store');
        Route::put('/{id}', [GroupController::class, 'update'])->name('update');
        Route::get('/{id}', [GroupController::class, 'show'])->name('show');
        Route::delete('/{id}', [GroupController::class, 'destroy'])->name('destroy');
    });

    Route::name('fingerprint.')->prefix('fingerprint')->group(function () {

        Route::post('/search', [FingerprintController::class, 'search'])->name('search');
        Route::get('/config', [FingerprintController::class, 'config'])->name('config');

        Route::get('/', [FingerprintController::class, 'index'])->name('index');
        Route::post('/', [FingerprintController::class, 'store'])->name('store');
        Route::put('/{id}', [FingerprintController::class, 'update'])->name('update');
        Route::get('/{id}', [FingerprintController::class, 'show'])->name('show');
        Route::delete('/{id}', [FingerprintController::class, 'destroy'])->name('destroy');

    });
});
