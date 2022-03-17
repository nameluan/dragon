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

Route::middleware('checklogin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/explore', [HomeController::class, 'explore'])->name('explore');
    Route::get('/messages', [HomeController::class, 'messages'])->name('messages');
    Route::get('/market', [HomeController::class, 'market'])->name('market');
    Route::get('/trending', [HomeController::class, 'trending'])->name('trending');
    Route::get('/setting', [HomeController::class, 'setting'])->name('setting');
    Route::get('/postDisplay', [HomeController::class, 'display'])->name('postDisplay');

});
Route::prefix('user')->group(function () {
    Route::match(['get', 'post'], 'login', [UserController::class, 'login'])->name('user.login');
    Route::match(['get', 'post'], 'register', [UserController::class, 'register'])->name('user.register');
    Route::match(['get', 'post'], 'forgot', [UserController::class, 'forgot'])->name('user.forgot');
    Route::match(['get', 'post'], 'reset/{token}', [UserController::class, 'reset'])->name('user.reset');
    Route::middleware('checklogin')->group(function () {
        Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
        Route::get('friend', [UserController::class, 'friend'])->name('user.friend');
    });
});
