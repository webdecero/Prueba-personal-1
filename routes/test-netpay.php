<?php


use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Manager\Kiosk\TestNetpayController;

Route::middleware('api')->prefix('api')->group(function () {

    Route::name('test-netpay.')->prefix('test-netpay')->group(function () {

        Route::post('/search', [TestNetpayController::class, 'search'])->name('search');
        Route::get('/config', [TestNetpayController::class, 'config'])->name('config');

        Route::get('/', [TestNetpayController::class, 'index'])->name('index');
        Route::post('/', [TestNetpayController::class, 'store'])->name('store');
        Route::put('/{id}', [TestNetpayController::class, 'update'])->name('update');
        Route::get('/{id}', [TestNetpayController::class, 'show'])->name('show');
        Route::delete('/{id}', [TestNetpayController::class, 'destroy'])->name('destroy');

    });

});
