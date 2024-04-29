<?php


use App\Http\Controllers\Torniquet\AccessController;
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

});
