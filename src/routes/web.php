<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;


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

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show.register');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function(){
    Route::get('/mypage', [UserController::class, 'showMypage'])->name('show.mypage');
    Route::get('/mypage/profile_change', [UserController::class, 'showProfile'])->name('show.profile');
    Route::put('/mypage/profile_change', [UserController::class, 'editProfile'])->name('edit.profile');
});