<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MasterData\LsmController;

Route::middleware(['auth'])->prefix('cms')->group(function(){
    Route::middleware('check_role:superadmin,admin')->group(function(){
        Route::prefix('dashboard')->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('cms.dashboard.index');
        });
    });
    Route::middleware('check_role:superadmin')->group(function(){
        Route::prefix('master-data')->group(function(){
            Route::prefix('lsm')->group(function(){
                Route::get('/', [LsmController::class, 'index'])->name('cms.master-data.lsm.index');
            });
        });
    });
});
