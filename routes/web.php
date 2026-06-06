<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/data-pemetaan', function () {
    return view('frontend.data-pemetaan');
})->name('frontend.data-pemetaan');

Route::prefix('login')->group(function(){
    Route::get('/', function () {
        return view('frontend.login');
    })->name('login');
    Route::post('/', [LoginController::class, 'loginProcess'])->name('login-process');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

@include('backend.php');
