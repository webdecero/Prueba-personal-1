<?php


use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Kiosk\BancomerController;

Route::middleware('api')->prefix('api')->group(function () {

    Route::name('bancomer.')->prefix('bancomer')->group(function () {

        Route::post('/search', [BancomerController::class, 'search'])->name('search');
        Route::get('/config', [BancomerController::class, 'config'])->name('config');

        Route::get('/', [BancomerController::class, 'index'])->name('index');
        Route::post('/', [BancomerController::class, 'store'])->name('store');
        Route::put('/{id}', [BancomerController::class, 'update'])->name('update');
        Route::get('/{id}', [BancomerController::class, 'show'])->name('show');
        Route::delete('/{id}', [BancomerController::class, 'destroy'])->name('destroy');

    });

});
