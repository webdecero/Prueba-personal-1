<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Webdecero\Manager\Api\Models\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $user = Admin::first();
    Auth::login($user, $remember = true);

    return Auth::user();
});
