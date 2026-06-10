<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DokumenGaleriController;
use App\Http\Controllers\Backend\MasterData\LsmController;
use App\Http\Controllers\Backend\MasterData\WilayahCakupanController;
use App\Http\Controllers\Backend\MasterData\KategoriDokumenController;

Route::middleware(['auth'])->prefix('cms')->group(function(){
    Route::middleware('check_role:superadmin,admin')->group(function(){
        Route::prefix('dashboard')->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('cms.dashboard.index');
        });
    });
    Route::middleware('check_role:superadmin')->group(function(){
        Route::prefix('dokumen-galeri')->group(function(){
            Route::get('/', [DokumenGaleriController::class, 'index'])->name('cms.dokumen-galeri.index');
            Route::get('/datatable', [DokumenGaleriController::class, 'datatable'])->name('cms.dokumen-galeri.datatable');
            Route::post('/', [DokumenGaleriController::class, 'store'])->name('cms.dokumen-galeri.store');
        });

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

            Route::prefix('kategori-dokumen')->group(function(){
                Route::get('/', [KategoriDokumenController::class, 'index'])->name('cms.master-data.kategori-dokumen.index');
                Route::get('/datatable', [KategoriDokumenController::class, 'datatable'])->name('cms.master-data.kategori-dokumen.datatable');
                Route::get('/detail/{id}', [KategoriDokumenController::class, 'show'])->name('cms.master-data.kategori-dokumen.show');
                Route::post('/',[KategoriDokumenController::class, 'store'])->name('cms.master-data.kategori-dokumen.store');
                Route::get('/edit/{id}',[KategoriDokumenController::class, 'edit'])->name('cms.master-data.kategori-dokumen.edit');
                Route::post('/update',[KategoriDokumenController::class, 'update'])->name('cms.master-data.kategori-dokumen.update');
                Route::get('/destroy/{id}',[KategoriDokumenController::class, 'destroy'])->name('cms.master-data.kategori-dokumen.destroy');
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
