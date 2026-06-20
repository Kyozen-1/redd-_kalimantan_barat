<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/data-pemetaan', function () {
    return view('frontend.data-pemetaan');
})->name('frontend.data-pemetaan');

Route::get('/program-strategi-redd', function () {
    return view('frontend.program-strategi-redd');
})->name('frontend.program-strategi');

Route::get('/berita-agenda', function () {
    return view('frontend.berita-agenda');
})->name('frontend.berita-agenda');

Route::get('/perpustakaan-publikasi', function () {
    return view('frontend.perpustakaan-publikasi');
})->name('frontend.perpustakaan-publikasi');

Route::get('/sis-redd', function () {
    return view('frontend.sis-redd');
})->name('frontend.sis-redd');

Route::get('/peta', function () {
    return view('frontend.peta');
})->name('frontend.peta');

Route::prefix('login')->group(function(){
    Route::get('/', function () {
        return view('frontend.login');
    })->name('login');
    Route::post('/', [LoginController::class, 'loginProcess'])->name('login-process');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

@include('backend.php');
