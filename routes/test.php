<?php


use Illuminate\Support\Facades\Route;



use App\Http\Controllers\TestController;

Route::middleware('api')->prefix('api')->group(function () {

    Route::name('test.')->prefix('test')->group(function () {

        Route::post('/search', [TestController::class, 'search'])->name('search');
        Route::get('/config', [TestController::class, 'config'])->name('config');

        Route::get('/', [TestController::class, 'index'])->name('index');
        Route::post('/', [TestController::class, 'store'])->name('store');
        Route::put('/{id}', [TestController::class, 'update'])->name('update');
        Route::get('/{id}', [TestController::class, 'show'])->name('show');
        Route::delete('/{id}', [TestController::class, 'destroy'])->name('destroy');

    });

});
