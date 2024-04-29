<?php

use App\Http\Controllers\Manager\AccessController;
use App\Http\Controllers\Manager\FingerprintController;
use App\Http\Controllers\Manager\GroupController;
use App\Http\Controllers\Manager\CompanyController;
use App\Http\Controllers\Manager\KioskController;
use App\Http\Controllers\Manager\LicenseController;
use App\Http\Controllers\Manager\LocationController;
use App\Http\Controllers\Manager\RegistryController;
use App\Http\Controllers\Manager\TorniquetController;
use App\Http\Controllers\Manager\UserController;
use App\Models\Fingerprint;
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


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/handle500', function () {
        abort(500, 'Error interno de servidor');
    });




    Route::name('registry.')->prefix('registry')->group(function () {

        Route::post('/search', [RegistryController::class, 'search'])->name('search');
        Route::get('/config', [RegistryController::class, 'config'])->name('config');
        Route::put('/{id}/status', [RegistryController::class, 'status'])->name('status');

        Route::get('/', [RegistryController::class, 'index'])->name('index');
        Route::post('/', [RegistryController::class, 'store'])->name('store');
        Route::put('/{id}', [RegistryController::class, 'update'])->name('update');
        Route::get('/{id}', [RegistryController::class, 'show'])->name('show');
        Route::delete('/{id}', [RegistryController::class, 'destroy'])->name('destroy');

    });


    Route::name('kiosk.')->prefix('kiosk')->group(function () {

        Route::post('/search', [KioskController::class, 'search'])->name('search');
        Route::get('/config', [KioskController::class, 'config'])->name('config');
        Route::put('/{id}/status', [KioskController::class, 'status'])->name('status');

        Route::get('/', [KioskController::class, 'index'])->name('index');
        Route::post('/', [KioskController::class, 'store'])->name('store');
        Route::put('/{id}', [KioskController::class, 'update'])->name('update');
        Route::get('/{id}', [KioskController::class, 'show'])->name('show');
        Route::delete('/{id}', [KioskController::class, 'destroy'])->name('destroy');

    });




    Route::name('torniquet.')->prefix('torniquet')->group(function () {

        Route::post('/search', [TorniquetController::class, 'search'])->name('search');
        Route::get('/config', [TorniquetController::class, 'config'])->name('config');
        Route::put('/{id}/status', [TorniquetController::class, 'status'])->name('status');

        Route::get('/', [TorniquetController::class, 'index'])->name('index');
        Route::post('/', [TorniquetController::class, 'store'])->name('store');
        Route::put('/{id}', [TorniquetController::class, 'update'])->name('update');
        Route::get('/{id}', [TorniquetController::class, 'show'])->name('show');
        Route::delete('/{id}', [TorniquetController::class, 'destroy'])->name('destroy');

    });


    Route::name('location.')->prefix('location')->group(function () {

        Route::post('/search', [LocationController::class, 'search'])->name('search');
        Route::get('/config', [LocationController::class, 'config'])->name('config');
        // Route::put('/{id}/status', [LocationController::class, 'status'])->name('status');
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::put('/{id}', [LocationController::class, 'update'])->name('update');
        Route::get('/{id}', [LocationController::class, 'show'])->name('show');
        Route::delete('/{id}', [LocationController::class, 'destroy'])->name('destroy');
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


///////////////////////// Finalizados ///////////////////////////////////////





    Route::name('user.')->prefix('user')->group(function(){
        Route::post('/search', [UserController::class, 'search'])->name('search');
        //Route::get('/config', [UserController::class, 'config'])->name('config');
        Route::put('/{id}/status', [UserController::class, 'status'])->name('status');

        //Route::get('/', [UserController::class, 'index'])->name('index');
        //Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::name('company.')->prefix('company')->group(function(){
        //Route::post('/search', [CompanyController::class, 'search'])->name('search');
        //Route::get('/config', [CompanyController::class, 'config'])->name('config');
        //Route::put('/{id}/status', [CompanyController::class, 'status'])->name('status');

        //Route::get('/', [CompanyController::class, 'index'])->name('index');
        //Route::post('/',[CompanyController::class, 'store'])->name('store');
        Route::put('/{id}',[CompanyController::class, 'update'])->name('update');
        Route::get('/{id}',[CompanyController::class, 'show'])->name('show');
        //Route::delete('/{id}',[CompanyController::class, 'destroy'])->name('destroy');
    });




    Route::name('license.')->prefix('license')->group(function () {

        Route::post('/search', [LicenseController::class, 'search'])->name('search');
        Route::get('/config', [LicenseController::class, 'config'])->name('config');

        Route::get('/', [LicenseController::class, 'index'])->name('index');
        Route::put('/{id}', [LicenseController::class, 'update'])->name('update');
        Route::get('/{id}', [LicenseController::class, 'show'])->name('show');

    });

    Route::name('fingerprint.')->prefix('fingerprint')->group(function () {
        Route::post('/search', [FingerprintController::class, 'search'])->name('search');
        //Route::get('/config', [FingerprintController::class, 'config'])->name('config');
        //Route::get('/', [FingerprintController::class, 'index'])->name('index');
        Route::get('/{id}', [FingerprintController::class, 'show'])->name('show');
        Route::delete('/{id}', [FingerprintController::class, 'destroy'])->name('destroy');
    });

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

