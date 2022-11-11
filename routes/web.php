<?php

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
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
Route::controller(App\Http\Controllers\AuthController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/logout', function () {
    Auth::logout();
    return;
});

Route::get('/login', function () {return view('auth.login');})->name('login');
Route::get('/register', function () { return view('auth.register');})->name('register');
Route::get('/forgot-password', function () {return view('auth.forgot_password');})->name('forgot-password') ;

Route::get('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPasswordView'])->name('password.reset');
Route::prefix('/api')->middleware(['verified'])->group(function () {
    Route::post('/uploadsinglefile', [App\Http\Controllers\FileController::class, 'uploadsinglefile']);
    Route::post('/changeuserpassword', [App\Http\Controllers\ProfileController::class, 'changeuserpassword']);
   
    
});

// Route::get('/reset-password', function () {return view('auth.reset-password');})->name('password.reset');
// Route::get('/dashboard/profile',  [App\Http\Controllers\DashboardController::class, 'index'])->where('any','.*')->middleware('auth');

Route::get('/dashboard/{any?}',  [App\Http\Controllers\DashboardController::class, 'index'])->where('any','.*')->middleware('verified');