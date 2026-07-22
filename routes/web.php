<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendHomeController;
use App\Http\Controllers\FrontendDataPemetaanController;

Route::get('/', [FrontendHomeController::class, 'index'])->name('home');

Route::get('/data-pemetaan', [FrontendDataPemetaanController::class, 'index'])->name('frontend.data-pemetaan');
Route::get('/api/deforestasi-karhutla', [FrontendDataPemetaanController::class, 'getDeforestasiKarhutla'])->name('api.deforestasi-karhutla');

use App\Http\Controllers\FrontendProgramController;

Route::get('/program-strategi-redd', [FrontendProgramController::class, 'index'])->name('frontend.program-strategi');

use App\Http\Controllers\FrontendNewsController;

Route::get('/berita-agenda', [FrontendNewsController::class, 'index'])->name('frontend.berita-agenda');

Route::get('/berita-agenda/{id}', [FrontendNewsController::class, 'show'])->name('frontend.berita.detail');

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
