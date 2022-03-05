<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->middleware('checklogin')->name('home');

Route::prefix('user')->group(function () {
    Route::match(['get', 'post'], 'login', [UserController::class, 'login'])->name('user.login');
    Route::match(['get', 'post'], 'register', [UserController::class, 'register'])->name('user.register');
    Route::match(['get', 'post'], 'forgot', [UserController::class, 'forgot'])->name('user.forgot');
    Route::match(['get', 'post'], 'reset', [UserController::class, 'reset'])->name('user.reset');
    Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
});//middleware(['auth', 'second'])->
