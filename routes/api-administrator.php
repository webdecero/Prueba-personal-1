<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrator\CompanyController;

Route::middleware(['api', 'client'])->group(function () {

    Route::name('company.')->prefix('company')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::post('/',[CompanyController::class, 'store'])->name('store');
        Route::put('/{key}', [CompanyController::class, 'update'])->name('update');
        Route::get('/{key}', [CompanyController::class, 'show'])->name('show');
    });
});
