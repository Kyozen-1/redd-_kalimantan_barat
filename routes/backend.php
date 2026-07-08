<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\AgendaController;
use App\Http\Controllers\Backend\DokumenGaleriController;
use App\Http\Controllers\Backend\GaleriController;
use App\Http\Controllers\Backend\LaporanEmisiController;
use App\Http\Controllers\Backend\DokumenRadController;
use App\Http\Controllers\Backend\LandingPageController;
use App\Http\Controllers\Backend\DataEmisiController;
use App\Http\Controllers\Backend\DataKawasanController;
use App\Http\Controllers\Backend\MasterData\LsmController;
use App\Http\Controllers\Backend\MasterData\WilayahCakupanController;
use App\Http\Controllers\Backend\MasterData\KategoriDokumenController;
use App\Http\Controllers\Backend\MasterData\SectionLandingPageController;
use App\Http\Controllers\Backend\MasterData\EmisiController;
use App\Http\Controllers\Backend\MasterData\SektorEmisiController;
use App\Http\Controllers\Backend\MasterData\KawasanHutanController;
use App\Http\Controllers\Backend\MasterData\PenyebabDeforestasiController;

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

        Route::prefix('dokumen-rad')->group(function(){
            Route::get('/', [DokumenRadController::class, 'index'])->name('cms.dokumen-rad.index');
            Route::get('/datatable', [DokumenRadController::class, 'datatable'])->name('cms.dokumen-rad.datatable');
            Route::post('/', [DokumenRadController::class, 'store'])->name('cms.dokumen-rad.store');
            Route::get('/edit/{id}', [DokumenRadController::class, 'edit'])->name('cms.dokumen-rad.edit');
            Route::post('/update', [DokumenRadController::class, 'update'])->name('cms.dokumen-rad.update');
            Route::get('/destroy/{id}', [DokumenRadController::class, 'destroy'])->name('cms.dokumen-rad.destroy');
        });

        Route::prefix('data-emisi')->group(function(){
            Route::get('/', [DataEmisiController::class, 'index'])->name('cms.data-emisi.index');
            Route::post('/', [DataEmisiController::class, 'store'])->name('cms.data-emisi.store');
            Route::get('/datatable', [DataEmisiController::class, 'datatable'])->name('cms.data-emisi.datatable');
            Route::get('/destroy/data/{id}',[DataEmisiController::class, 'destroyData'])->name('cms.data-emisi.destroy.data');
            Route::post('/update/nilai', [DataEmisiController::class, 'updateNilai'])->name('cms.data-emisi.update.nilai');
            Route::get('/destroy/nilai/{id}',[DataEmisiController::class, 'destroyNilai'])->name('cms.data-emisi.destroy.nilai');
        });

        Route::prefix('data-kawasan')->group(function(){
            Route::get('/', [DataKawasanController::class, 'index'])->name('cms.data-kawasan.index');
            Route::post('/', [DataKawasanController::class, 'store'])->name('cms.data-kawasan.store');
            Route::get('/datatable', [DataKawasanController::class, 'datatable'])->name('cms.data-kawasan.datatable');
            Route::get('/destroy/data/{id}',[DataKawasanController::class, 'destroyData'])->name('cms.data-kawasan.destroy.data');
            Route::post('/update/nilai', [DataKawasanController::class, 'updateNilai'])->name('cms.data-kawasan.update.nilai');
            Route::get('/destroy/nilai/{id}',[DataKawasanController::class, 'destroyNilai'])->name('cms.data-kawasan.destroy.nilai');
        });
    });
    Route::middleware('check_role:superadmin')->group(function(){
        Route::prefix('landing-page')->group(function(){
            Route::get('/', [LandingPageController::class, 'index'])->name('cms.landing-page.index');
            Route::get('/datatable', [LandingPageController::class, 'datatable'])->name('cms.landing-page.datatable');
            Route::get('/create', [LandingPageController::class, 'create'])->name('cms.landing-page.create');
            Route::post('/', [LandingPageController::class, 'store'])->name('cms.landing-page.store');
            Route::get('/edit/{id}', [LandingPageController::class, 'edit'])->name('cms.landing-page.edit');
            Route::post('/update/{id}', [LandingPageController::class, 'update'])->name('cms.landing-page.update');
            Route::get('/destroy/{id}', [LandingPageController::class, 'destroy'])->name('cms.landing-page.destroy');
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

            Route::prefix('section-landing-page')->group(function(){
                Route::get('/', [SectionLandingPageController::class, 'index'])->name('cms.master-data.section-landing-page.index');
                Route::get('/datatable', [SectionLandingPageController::class, 'datatable'])->name('cms.master-data.section-landing-page.datatable');
                Route::get('/detail/{id}', [SectionLandingPageController::class, 'show'])->name('cms.master-data.section-landing-page.show');
                Route::post('/',[SectionLandingPageController::class, 'store'])->name('cms.master-data.section-landing-page.store');
                Route::get('/edit/{id}',[SectionLandingPageController::class, 'edit'])->name('cms.master-data.section-landing-page.edit');
                Route::post('/update',[SectionLandingPageController::class, 'update'])->name('cms.master-data.section-landing-page.update');
                Route::get('/destroy/{id}',[SectionLandingPageController::class, 'destroy'])->name('cms.master-data.section-landing-page.destroy');
            });

            Route::prefix('emisi')->group(function(){
                Route::get('/', [EmisiController::class, 'index'])->name('cms.master-data.emisi.index');
                Route::get('/datatable', [EmisiController::class, 'datatable'])->name('cms.master-data.emisi.datatable');
                Route::get('/detail/{id}', [EmisiController::class, 'show'])->name('cms.master-data.emisi.show');
                Route::post('/',[EmisiController::class, 'store'])->name('cms.master-data.emisi.store');
                Route::get('/edit/{id}',[EmisiController::class, 'edit'])->name('cms.master-data.emisi.edit');
                Route::post('/update',[EmisiController::class, 'update'])->name('cms.master-data.emisi.update');
                Route::get('/destroy/{id}',[EmisiController::class, 'destroy'])->name('cms.master-data.emisi.destroy');
            });

            Route::prefix('sektor-emisi')->group(function(){
                Route::get('/', [SektorEmisiController::class, 'index'])->name('cms.master-data.sektor-emisi.index');
                Route::get('/datatable', [SektorEmisiController::class, 'datatable'])->name('cms.master-data.sektor-emisi.datatable');
                Route::get('/detail/{id}', [SektorEmisiController::class, 'show'])->name('cms.master-data.sektor-emisi.show');
                Route::post('/',[SektorEmisiController::class, 'store'])->name('cms.master-data.sektor-emisi.store');
                Route::get('/edit/{id}',[SektorEmisiController::class, 'edit'])->name('cms.master-data.sektor-emisi.edit');
                Route::post('/update',[SektorEmisiController::class, 'update'])->name('cms.master-data.sektor-emisi.update');
                Route::get('/destroy/{id}',[SektorEmisiController::class, 'destroy'])->name('cms.master-data.sektor-emisi.destroy');
            });

            Route::prefix('kawasan-hutan')->group(function(){
                Route::get('/', [KawasanHutanController::class, 'index'])->name('cms.master-data.kawasan-hutan.index');
                Route::get('/datatable', [KawasanHutanController::class, 'datatable'])->name('cms.master-data.kawasan-hutan.datatable');
                Route::get('/detail/{id}', [KawasanHutanController::class, 'show'])->name('cms.master-data.kawasan-hutan.show');
                Route::post('/',[KawasanHutanController::class, 'store'])->name('cms.master-data.kawasan-hutan.store');
                Route::get('/edit/{id}',[KawasanHutanController::class, 'edit'])->name('cms.master-data.kawasan-hutan.edit');
                Route::post('/update',[KawasanHutanController::class, 'update'])->name('cms.master-data.kawasan-hutan.update');
                Route::get('/destroy/{id}',[KawasanHutanController::class, 'destroy'])->name('cms.master-data.kawasan-hutan.destroy');
            });

            Route::prefix('kawasan-hutan')->group(function(){
                Route::get('/', [KawasanHutanController::class, 'index'])->name('cms.master-data.kawasan-hutan.index');
                Route::get('/datatable', [KawasanHutanController::class, 'datatable'])->name('cms.master-data.kawasan-hutan.datatable');
                Route::get('/detail/{id}', [KawasanHutanController::class, 'show'])->name('cms.master-data.kawasan-hutan.show');
                Route::post('/',[KawasanHutanController::class, 'store'])->name('cms.master-data.kawasan-hutan.store');
                Route::get('/edit/{id}',[KawasanHutanController::class, 'edit'])->name('cms.master-data.kawasan-hutan.edit');
                Route::post('/update',[KawasanHutanController::class, 'update'])->name('cms.master-data.kawasan-hutan.update');
                Route::get('/destroy/{id}',[KawasanHutanController::class, 'destroy'])->name('cms.master-data.kawasan-hutan.destroy');
            });

            Route::prefix('penyebab-deforestasi')->group(function(){
                Route::get('/', [PenyebabDeforestasiController::class, 'index'])->name('cms.master-data.penyebab-deforestasi.index');
                Route::get('/datatable', [PenyebabDeforestasiController::class, 'datatable'])->name('cms.master-data.penyebab-deforestasi.datatable');
                Route::get('/detail/{id}', [PenyebabDeforestasiController::class, 'show'])->name('cms.master-data.penyebab-deforestasi.show');
                Route::post('/',[PenyebabDeforestasiController::class, 'store'])->name('cms.master-data.penyebab-deforestasi.store');
                Route::get('/edit/{id}',[PenyebabDeforestasiController::class, 'edit'])->name('cms.master-data.penyebab-deforestasi.edit');
                Route::post('/update',[PenyebabDeforestasiController::class, 'update'])->name('cms.master-data.penyebab-deforestasi.update');
                Route::get('/destroy/{id}',[PenyebabDeforestasiController::class, 'destroy'])->name('cms.master-data.penyebab-deforestasi.destroy');
            });
        });
    });
});
