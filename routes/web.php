<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendHomeController;
use App\Http\Controllers\FrontendDataPemetaanController;
use App\Http\Controllers\FrontendProgramController;
use App\Http\Controllers\FrontendNewsController;
use App\Http\Controllers\FrontendLibraryController;
use App\Http\Controllers\FrontendSisReddController;
use App\Http\Controllers\FrontendPetaController;

Route::get('/', [FrontendHomeController::class, 'index'])->name('home');

Route::get('/data-pemetaan', [FrontendDataPemetaanController::class, 'index'])->name('frontend.data-pemetaan');
Route::get('/api/deforestasi-karhutla', [FrontendDataPemetaanController::class, 'getDeforestasiKarhutla'])->name('api.deforestasi-karhutla');


Route::get('/program-strategi-redd', [FrontendProgramController::class, 'index'])->name('frontend.program-strategi');
Route::get('/berita-agenda', [FrontendNewsController::class, 'index'])->name('frontend.berita-agenda');
Route::get('/berita-agenda/{id}', [FrontendNewsController::class, 'show'])->name('frontend.berita.detail');
Route::get('/api/lsm', [FrontendNewsController::class, 'getLsmData'])->name('api.lsm');
Route::get('/api/agenda/{id}', [FrontendNewsController::class, 'getAgendaDetail'])->name('api.agenda.detail');

Route::get('/perpustakaan-publikasi', [FrontendLibraryController::class, 'index'])->name('frontend.perpustakaan-publikasi');

Route::get('/sis-redd', [FrontendSisReddController::class, 'index'])->name('frontend.sis-redd');
Route::post('/sis-redd/laporan', [FrontendSisReddController::class, 'submitReport'])->name('frontend.sis-redd.report');

Route::get('/peta', [FrontendPetaController::class, 'index'])->name('frontend.peta');

Route::prefix('login')->group(function(){
    Route::get('/', function () {
        return view('frontend.login');
    })->name('login');
    Route::post('/', [LoginController::class, 'loginProcess'])->name('login-process');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

@include('backend.php');
