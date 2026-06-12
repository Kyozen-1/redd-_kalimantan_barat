<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\AgendaController;
use App\Http\Controllers\Backend\DokumenGaleriController;
use App\Http\Controllers\Backend\GaleriController;
use App\Http\Controllers\Backend\LaporanEmisiController;
use App\Http\Controllers\Backend\MasterData\LsmController;
use App\Http\Controllers\Backend\MasterData\WilayahCakupanController;
use App\Http\Controllers\Backend\MasterData\KategoriDokumenController;

Route::middleware(['auth'])->prefix('cms')->group(function(){
    Route::middleware('check_role:superadmin,admin')->group(function(){
        Route::prefix('dashboard')->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('cms.dashboard.index');
        });

        Route::prefix('galeri')->group(function(){
            Route::get('/',[GaleriController::class, 'index'])->name('cms.galeri.index');
            Route::get('/datatable',[GaleriController::class, 'datatable'])->name('cms.galeri.datatable');
            Route::post('/',[GaleriController::class, 'store'])->name('cms.galeri.store');
            Route::get('/edit/{id}',[GaleriController::class, 'edit'])->name('cms.galeri.edit');
            Route::post('/update',[GaleriController::class, 'update'])->name('cms.galeri.update');
            Route::get('/destroy/{id}',[GaleriController::class, 'destroy'])->name('cms.galeri.destroy');
        });

        Route::prefix('dokumen-galeri')->group(function(){
            Route::get('/', [DokumenGaleriController::class, 'index'])->name('cms.dokumen-galeri.index');
            Route::get('/datatable', [DokumenGaleriController::class, 'datatable'])->name('cms.dokumen-galeri.datatable');
            Route::post('/', [DokumenGaleriController::class, 'store'])->name('cms.dokumen-galeri.store');
            Route::get('/edit/{id}', [DokumenGaleriController::class, 'edit'])->name('cms.dokumen-galeri.edit');
            Route::post('/update', [DokumenGaleriController::class, 'update'])->name('cms.dokumen-galeri.update');
            Route::get('/destroy/{id}', [DokumenGaleriController::class, 'destroy'])->name('cms.dokumen-galeri.destroy');
        });

        Route::prefix('agenda')->group(function(){
            Route::get('/', [AgendaController::class, 'index'])->name('cms.agenda.index');
            Route::get('/datatable', [AgendaController::class, 'datatable'])->name('cms.agenda.datatable');
            Route::get('/detail/{id}', [AgendaController::class, 'show'])->name('cms.agenda.show');
            Route::post('/',[AgendaController::class, 'store'])->name('cms.agenda.store');
            Route::get('/edit/{id}',[AgendaController::class, 'edit'])->name('cms.agenda.edit');
            Route::post('/update',[AgendaController::class, 'update'])->name('cms.agenda.update');
            Route::get('/destroy/{id}',[AgendaController::class, 'destroy'])->name('cms.agenda.destroy');
        });

        Route::prefix('berita')->group(function(){
            Route::get('/',[BeritaController::class, 'index'])->name('cms.berita.index');
            Route::get('/create',[BeritaController::class, 'create'])->name('cms.berita.create');
            Route::get('/datatable',[BeritaController::class, 'datatable'])->name('cms.berita.datatable');
            Route::post('/',[BeritaController::class, 'store'])->name('cms.berita.store');
            Route::get('/edit/{id}',[BeritaController::class, 'edit'])->name('cms.berita.edit');
            Route::post('/update/{id}',[BeritaController::class, 'update'])->name('cms.berita.update');
            Route::get('/destroy/{id}',[BeritaController::class, 'destroy'])->name('cms.berita.destroy');
        });

        Route::prefix('laporan-emisi')->group(function(){
            Route::get('/', [LaporanEmisiController::class, 'index'])->name('cms.laporan-emisi.index');
            Route::get('/datatable', [LaporanEmisiController::class, 'datatable'])->name('cms.laporan-emisi.datatable');
            Route::post('/', [LaporanEmisiController::class, 'store'])->name('cms.laporan-emisi.store');
            Route::get('/edit/{id}', [LaporanEmisiController::class, 'edit'])->name('cms.laporan-emisi.edit');
            Route::post('/update', [LaporanEmisiController::class, 'update'])->name('cms.laporan-emisi.update');
            Route::get('/destroy/{id}', [LaporanEmisiController::class, 'destroy'])->name('cms.laporan-emisi.destroy');
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
