<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Manager\GroupController;


Route::name('group.')->prefix('group')->group(function () {
    Route::get('/', [GroupController::class, 'index'])->name('index');
    Route::post('/', [GroupController::class, 'store'])->name('store');
    Route::put('/{id}', [GroupController::class, 'update'])->name('update');
    Route::get('/{id}', [GroupController::class, 'show'])->name('show');
    Route::delete('/{id}', [GroupController::class, 'destroy'])->name('destroy');


    Route::post('/search', [GroupController::class, 'search'])->name('search');

});

