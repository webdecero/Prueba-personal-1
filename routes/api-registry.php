<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registry\UserController;
use App\Http\Controllers\Registry\AdminController;
use App\Http\Controllers\Registry\GroupController;
use App\Http\Controllers\Registry\LoginController;
use App\Http\Controllers\Registry\AccessController;
use App\Http\Controllers\Manager\LocationController;
use App\Http\Controllers\Registry\RegistryController;
use App\Http\Controllers\Registry\FingerprintController;
use Webdecero\Package\Core\Controllers\File\FileController;
use Webdecero\Package\Core\Controllers\Image\ImageController;


Route::name('admin.')->prefix('admin')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::name('terminal.')->prefix('terminal')->group(function () {
    Route::post('/setup', [RegistryController::class, 'setup'])->name('setup');
});


Route::middleware(['auth:admin'])->group(function () {
// Route::middleware(['api'])->group(function () {


    Route::name('admin.')->prefix('admin')->group(function () {

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/info', [AdminController::class, 'info'])->name('info');
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


    Route::name('user.')->prefix('user')->group(function () {
        Route::post('/search', [UserController::class, 'search'])->name('search');
        Route::get('/config', [UserController::class, 'config'])->name('config');
        Route::put('/{id}/status', [UserController::class, 'status'])->name('status');

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

        // Route::get('/{id}/fingerprints', [UserController::class, 'showFingerprints'])->name('show-fingerprints');
        // Route::post('/fingerprint/matcher', [UserController::class, 'fingerprintMatcher'])->name('fingerprint-matcher');

        // Route::get('/parent/{parentIndex}', [UserController::class, 'findByParent'])->name('find-by-parent');

        // Route::post('/keys/validation', [UserController::class, 'keysValidation'])->name('keys-validation');
    });



    Route::name('fingerprint.')->prefix('fingerprint')->group(function () {

        Route::post('/search', [FingerprintController::class, 'search'])->name('search');
        Route::get('/config', [FingerprintController::class, 'config'])->name('config');

        Route::get('/', [FingerprintController::class, 'index'])->name('index');
        Route::post('/', [FingerprintController::class, 'store'])->name('store');
        // Route::put('/{id}', [FingerprintController::class, 'update'])->name('update');
        Route::get('/{id}', [FingerprintController::class, 'show'])->name('show');
        Route::delete('/{id}', [FingerprintController::class, 'destroy'])->name('destroy');
    });

    Route::name('location.')->prefix('location')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
    });

    Route::name('terminal.')->prefix('terminal')->group(function () {
        Route::put('/{id}/status', [RegistryController::class, 'status'])->name('status');
        Route::get('/{id}', [RegistryController::class, 'show'])->name('show');
    });



    ///////////////////////// Finalizados ///////////////////////////////////////


    Route::name('access.')->prefix('access')->group(function () {

        Route::post('/search', [AccessController::class, 'search'])->name('search');
        Route::get('/config', [AccessController::class, 'config'])->name('config');

        Route::get('/', [AccessController::class, 'index'])->name('index');
        Route::post('/', [AccessController::class, 'store'])->name('store');
        Route::put('/{id}', [AccessController::class, 'update'])->name('update');
        Route::get('/{id}', [AccessController::class, 'show'])->name('show');
        Route::delete('/{id}', [AccessController::class, 'destroy'])->name('destroy');
    });




    Route::name('image.')->prefix('image')->group(function () {

        Route::post('/search', [ImageController::class, 'search'])->name('search');
        Route::get('/config', [ImageController::class, 'config'])->name('config');
        Route::post('/delete', [ImageController::class, 'delete'])->name('delete');

        Route::post('/', [ImageController::class, 'store'])->name('store');
        Route::put('/{id}', [ImageController::class, 'update'])->name('update');
        Route::get('/{id}', [ImageController::class, 'show'])->name('show');
        Route::delete('/{id}', [ImageController::class, 'destroy'])->name('destroy');
    });

    Route::name('file.')->prefix('file')->group(function () {

        Route::post('/search', [FileController::class, 'search'])->name('search');
        Route::get('/config', [FileController::class, 'config'])->name('config');
        Route::post('/delete', [FileController::class, 'delete'])->name('delete');

        // Route::post('/parts', [FileController::class, 'uploadParts'])->name('parts');

        Route::post('/', [FileController::class, 'store'])->name('store');
        Route::put('/{id}', [FileController::class, 'update'])->name('update');
        Route::get('/{id}', [FileController::class, 'show'])->name('show');
        Route::delete('/{id}', [FileController::class, 'destroy'])->name('destroy');
    });
});
