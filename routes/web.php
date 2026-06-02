<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('backend.dashboard.index');
});

Route::get('/login', fn () => view('auth.login.index'))->name('login');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
