<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MasterData\LsmController;
use App\Http\Controllers\Backend\MasterData\WilayahCakupanController;

Route::middleware(['auth'])->prefix('cms')->group(function(){
    Route::middleware('check_role:superadmin,admin')->group(function(){
        Route::prefix('dashboard')->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('cms.dashboard.index');
        });
    });
    Route::middleware('check_role:superadmin')->group(function(){
        Route::prefix('master-data')->group(function(){
            Route::prefix('wilayah-cakupan')->group(function(){
                Route::get('/', [WilayahCakupanController::class, 'index'])->name('cms.master-data.wilayah-cakupan.index');
                Route::get('/datatable', [WilayahCakupanController::class, 'datatable'])->name('cms.master-data.wilayah-cakupan.datatable');
                Route::get('/detail/{id}', [WilayahCakupanController::class, 'show'])->name('cms.master-data.wilayah-cakupan.show');
                Route::post('/',[WilayahCakupanController::class, 'store'])->name('cms.master-data.wilayah-cakupan.store');
                Route::get('/edit/{id}',[WilayahCakupanController::class, 'edit'])->name('cms.master-data.wilayah-cakupan.edit');
                Route::post('/update',[WilayahCakupanController::class, 'update'])->name('cms.master-data.wilayah-cakupan.update');
                Route::get('/destroy/{id}',[WilayahCakupanController::class, 'destroy'])->name('cms.master-data.wilayah-cakupan.destroy');
            });

            Route::prefix('lsm')->group(function(){
                Route::get('/', [LsmController::class, 'index'])->name('cms.master-data.lsm.index');
                Route::get('/datatable', [LsmController::class, 'datatable'])->name('cms.master-data.lsm.datatable');
                Route::get('/detail/{id}', [LsmController::class, 'show'])->name('cms.master-data.lsm.show');
                Route::post('/',[LsmController::class, 'store'])->name('cms.master-data.lsm.store');
                Route::get('/edit/{id}',[LsmController::class, 'edit'])->name('cms.master-data.lsm.edit');
                Route::post('/update',[LsmController::class, 'update'])->name('cms.master-data.lsm.update');
                Route::get('/destroy/{id}',[LsmController::class, 'destroy'])->name('cms.master-data.lsm.destroy');
            });
        });
    });
});
