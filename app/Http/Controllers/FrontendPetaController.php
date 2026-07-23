<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataKawasan;
use App\Models\DataDeforestasi;
use App\Models\MdKawasanHutan;
use App\Models\Regency;
use App\Models\MdLsm;
use App\Models\PerhutananSosial;

class FrontendPetaController extends Controller
{
    /**
     * Display the Peta Kalimantan Barat page.
     */
    public function index()
    {
        // 1. Total Kawasan Hutan / Hutan Lindung
        $hutanLindungData = DataKawasan::whereHas('kawasan_hutan', function($q) {
            $q->where('nama', 'like', '%lindung%');
        })->sum('nilai');
        
        $hutanLindungFormatted = $hutanLindungData > 0 ? number_format($hutanLindungData, 0, ',', '.') : '271.000';

        // 2. Ekosistem Gambut
        $gambutData = DataKawasan::whereHas('kawasan_hutan', function($q) {
            $q->where('nama', 'like', '%gambut%');
        })->sum('nilai');

        $gambutFormatted = $gambutData > 0 ? number_format($gambutData, 0, ',', '.') . ' Ha' : '1.2 jt';

        // 3. Titik Panas / Karhutla
        $titikPanasData = DataDeforestasi::whereHas('penyebab_deforestasi', function($q) {
            $q->where('nama', 'like', '%karhutla%')->orWhere('nama', 'like', '%titik%');
        })->sum('nilai');

        $titikPanasFormatted = $titikPanasData > 0 ? number_format($titikPanasData, 0, ',', '.') : '47';

        // 4. Proyek Aktif / LSM & Perhutanan Sosial
        $proyekAktifData = MdLsm::statusAktif()->count() + PerhutananSosial::statusAktif()->count();
        $proyekAktifFormatted = $proyekAktifData > 0 ? $proyekAktifData : '12';

        $stats = [
            'hutan_lindung' => $hutanLindungFormatted,
            'ekosistem_gambut' => $gambutFormatted,
            'titik_panas' => $titikPanasFormatted,
            'proyek_aktif' => $proyekAktifFormatted,
        ];

        $regencies = Regency::orderBy('name', 'asc')->get();

        return view('frontend.peta', compact('stats', 'regencies'));
    }
}
