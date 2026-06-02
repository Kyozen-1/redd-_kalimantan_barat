<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('backend.dashboard.index');
});

Route::prefix('login')->group(function(){
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'loginProcess'])->name('login-process');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

@include('backend.php');
