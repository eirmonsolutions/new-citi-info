<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\LogoutController;

Route::get('/', function () {
    return view('pages.homepage');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('superadmin.dashboard');
})->middleware('auth')->name('superadmin.dashboard');


Route::get('/register', function () {
    return view('auth.register');
});
