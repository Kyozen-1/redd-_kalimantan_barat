<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataEmisi;
use App\Models\DataKawasan;
use App\Models\DataDeforestasi;
use App\Models\MdKawasanHutan;
use App\Models\Regency;

class FrontendDataPemetaanController extends Controller
{
    /**
     * Display the dynamic data and mapping page.
     */
    public function index()
    {
        $years = ['2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026'];

        /*
        |--------------------------------------------------------------------------
        | 1. Query: Emisi CO2
        |--------------------------------------------------------------------------
        */
        $emisiCo2Data = DataEmisi::whereHas('pivot_sektor_emisi', function($q) {
            $q->whereHas('emisi', function($q) {
                $q->where('nama', 'Gas Rumah Kaca');
            })->whereHas('sektor_emisi', function($q) {
                $q->where('nama', 'Energi');
            });
        })
        ->whereIn('tahun', $years)
        ->orderBy('tahun')
        ->pluck('nilai', 'tahun')
        ->toArray();

        // Fill years or fallback to mock if completely empty
        $emisiCo2List = [];
        $mockEmisiCo2 = [122, 131, 136, 146, 147, 182, 164, 166, 171, 176, 180];
        foreach ($years as $index => $year) {
            $emisiCo2List[] = isset($emisiCo2Data[$year]) ? (float)$emisiCo2Data[$year] : ($mockEmisiCo2[$index] ?? 0);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Query: Serapan Karbon Hutan
        |--------------------------------------------------------------------------
        */
        $serapanData = DataEmisi::whereHas('pivot_sektor_emisi', function($q) {
            $q->whereHas('emisi', function($q) {
                $q->where('nama', 'Gas Rumah Kaca');
            })->whereHas('sektor_emisi', function($q) {
                $q->where('nama', 'Folu');
            });
        })
        ->whereIn('tahun', $years)
        ->orderBy('tahun')
        ->pluck('nilai', 'tahun')
        ->toArray();

        $serapanList = [];
        $mockSerapan = [-78, -72, -61, -52, -42, -28, -43, -45, -44, -42, -40];
        foreach ($years as $index => $year) {
            $serapanList[] = isset($serapanData[$year]) ? (float)$serapanData[$year] : ($mockSerapan[$index] ?? 0);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Query: Deforestasi Trend
        |--------------------------------------------------------------------------
        */
        $deforestasiData = DataDeforestasi::whereIn('tahun', $years)
            ->groupBy('tahun')
            ->selectRaw('tahun, sum(nilai) as total')
            ->pluck('total', 'tahun')
            ->toArray();

        $deforestasiList = [];
        $mockDeforestasi = [390, 370, 382, 412, 380, 500, 382, 360, 335, 312, 295];
        foreach ($years as $index => $year) {
            $deforestasiList[] = isset($deforestasiData[$year]) ? (float)$deforestasiData[$year] : ($mockDeforestasi[$index] ?? 0);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Query: Peatland Conditions (Donut Chart)
        |--------------------------------------------------------------------------
        */
        $peatDonutKeys = ['Gambut Sekunder', 'Degradasi Ringan', 'Degradasi Berat', 'Dalam Restorasi', 'Gambut Primer Baik'];
        $peatDonutYearly = [];

        // Mock data patterns for 2016-2025 in case database is empty
        $mockYearlyDonut = [
            '2016' => [20, 14, 19, 4, 43],
            '2017' => [21, 14, 19, 4, 42],
            '2018' => [22, 15, 18, 4, 41],
            '2019' => [22, 15, 18, 5, 40],
            '2020' => [23, 16, 17, 5, 39],
            '2021' => [23, 16, 17, 6, 38],
            '2022' => [24, 17, 16, 6, 37],
            '2023' => [24, 17, 16, 7, 36],
            '2024' => [25, 18, 15, 7, 35],
            '2025' => [25, 18, 15, 8, 34],
            '2026' => [25, 18, 15, 8, 34],
        ];

        foreach ($years as $year) {
            $yearData = DataKawasan::whereHas('kawasan_hutan', function($q) use ($peatDonutKeys) {
                $q->whereIn('nama', $peatDonutKeys);
            })
            ->where('tahun', $year)
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->kawasan_hutan->nama => (float)$item->nilai];
            })
            ->toArray();

            $yearList = [];
            foreach ($peatDonutKeys as $index => $key) {
                $yearList[] = isset($yearData[$key]) ? $yearData[$key] : (($mockYearlyDonut[$year] ?? [])[$index] ?? 0);
            }
            $peatDonutYearly[$year] = $yearList;
        }

        $peatDonutList = $peatDonutYearly['2016']; // Default to 2016 to match the selected dropdown in view

        /*
        |--------------------------------------------------------------------------
        | 5. Query: Peatland Degradation vs Restorasi (Trend Line Chart)
        |--------------------------------------------------------------------------
        */
        $restorasiTrendData = DataKawasan::whereHas('kawasan_hutan', function($q) {
            $q->where('nama', 'Dalam Restorasi');
        })
        ->whereIn('tahun', $years)
        ->orderBy('tahun')
        ->pluck('nilai', 'tahun')
        ->toArray();

        $degradasiTrendData = DataKawasan::whereHas('kawasan_hutan', function($q) {
            $q->where('nama', 'Degradasi Berat');
        })
        ->whereIn('tahun', $years)
        ->orderBy('tahun')
        ->pluck('nilai', 'tahun')
        ->toArray();

        $restorasiTrend = [];
        $degradasiTrend = [];
        $mockRestorasiTrend = [438, 456, 466, 485, 517, 535, 548, 560, 568, 576, 582];
        $mockDegradasiTrend = [45, 54, 73, 94, 112, 128, 151, 158, 166, 174, 182];

        foreach ($years as $index => $year) {
            $restorasiTrend[] = isset($restorasiTrendData[$year]) ? (float)$restorasiTrendData[$year] : ($mockRestorasiTrend[$index] ?? 0);
            $degradasiTrend[] = isset($degradasiTrendData[$year]) ? (float)$degradasiTrendData[$year] : ($mockDegradasiTrend[$index] ?? 0);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Query: Conservation Areas (Horizontal Bar Chart)
        |--------------------------------------------------------------------------
        */
        $conservationKeys = ['Hutan Lindung', 'Taman Nasional', 'Suaka Margasatwa', 'KPA/KSA Lainnya', 'Cagar Alam'];
        $conservationData = DataKawasan::whereHas('kawasan_hutan', function($q) use ($conservationKeys) {
            $q->whereIn('nama', $conservationKeys);
        })
        ->where('tahun', '2025')
        ->get()
        ->mapWithKeys(function($item) {
            return [$item->kawasan_hutan->nama => (float)$item->nilai];
        })
        ->toArray();

        $conservationList = [];
        $mockConservation = [1280, 990, 800, 680, 410];
        foreach ($conservationKeys as $index => $key) {
            $conservationList[] = isset($conservationData[$key]) ? $conservationData[$key] : ($mockConservation[$index] ?? 0);
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Query: Top Metrics Badges (Calculated or Latest Values)
        |--------------------------------------------------------------------------
        */
        $luasHutan = '8.2 jt ha';
        $stokKarbon = '450 Mt';
        $stokKarbonDiff = '▼ 18 %';
        $emisi2025 = (end($emisiCo2List)) . ' Mt';
        $deforestasi2025 = (end($deforestasiList)) . ' rb ha';
        $serapan2025 = (end($serapanList)) . ' Mt';

        $luasHutanTersisaValue = DataKawasan::whereHas('kawasan_hutan', function($q) {
            $q->where('nama', 'Luas Hutan Tersisa');
        })
        ->where('tahun', '2025')
        ->value('nilai');

        $luasHutanTersisa = $luasHutanTersisaValue ? ($luasHutanTersisaValue / 1000) . ' jt ha' : '6.4 jt ha';

        // Lahan Gambut Metrics
        $totalGambutValue = DataKawasan::whereHas('kawasan_hutan', function($q) {
            $q->where('nama', 'Total Lahan Gambut');
        })
        ->where('tahun', '2025')
        ->value('nilai');

        $totalGambut = $totalGambutValue ? ($totalGambutValue / 1000) . ' jt ha' : '1.73 jt ha';

        // Fetch regencies for dropdown
        $regencies = Regency::orderBy('name')->get();

        // Default initial data for Karhutla Deforestation (Kabupaten Bengkayang, 2019-2026)
        $bengkayang = Regency::where('name', 'like', '%Bengkayang%')->first() ?? Regency::first();
        $defaultKarhutlaYears = ['2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026'];
        $defaultKarhutlaData = DataDeforestasi::where('kabupaten_kota_id', $bengkayang->id)
            ->whereHas('penyebab_deforestasi', function($q) {
                $q->where('nama', 'Karhutla');
            })
            ->whereIn('tahun', $defaultKarhutlaYears)
            ->orderBy('tahun')
            ->pluck('nilai', 'tahun')
            ->toArray();

        $defaultKarhutlaList = [];
        $mockKarhutla = [1500, 1350, 300, 750, 2777.91, 1500, 1200, 1350];
        foreach ($defaultKarhutlaYears as $idx => $yr) {
            $defaultKarhutlaList[] = isset($defaultKarhutlaData[$yr]) ? (float)$defaultKarhutlaData[$yr] : ($mockKarhutla[$idx] ?? 0);
        }

        return view('frontend.data-pemetaan', compact(
            'emisiCo2List',
            'serapanList',
            'deforestasiList',
            'peatDonutList',
            'peatDonutYearly',
            'restorasiTrend',
            'degradasiTrend',
            'conservationList',
            'luasHutan',
            'stokKarbon',
            'stokKarbonDiff',
            'emisi2025',
            'deforestasi2025',
            'serapan2025',
            'luasHutanTersisa',
            'totalGambut',
            'regencies',
            'years',
            'defaultKarhutlaYears',
            'defaultKarhutlaList'
        ));
    }

    /**
     * AJAX endpoint to query deforestation by Karhutla for a specific regency and year range.
     */
    public function getDeforestasiKarhutla(Request $request)
    {
        $regencyId = $request->query('regency_id');
        $startYear = $request->query('start_year');
        $endYear = $request->query('end_year');

        $years = [];
        for ($yr = (int)$startYear; $yr <= (int)$endYear; $yr++) {
            $years[] = (string)$yr;
        }

        $data = DataDeforestasi::where('kabupaten_kota_id', $regencyId)
            ->whereHas('penyebab_deforestasi', function($q) {
                $q->where('nama', 'Karhutla');
            })
            ->whereIn('tahun', $years)
            ->orderBy('tahun')
            ->pluck('nilai', 'tahun')
            ->toArray();

        $values = [];
        // Default mock value lookup for Bengkayang if it matches and database falls back
        $mockValues = [
            '2016' => 1200,
            '2017' => 1100,
            '2018' => 1350,
            '2019' => 1500,
            '2020' => 1350,
            '2021' => 300,
            '2022' => 750,
            '2023' => 2777.91,
            '2024' => 1500,
            '2025' => 1200,
            '2026' => 1350
        ];

        foreach ($years as $yr) {
            if (isset($data[$yr])) {
                $values[] = (float)$data[$yr];
            } else {
                // Return mock values if it is Bengkayang or fallback to generated values
                $bengkayang = Regency::where('name', 'like', '%Bengkayang%')->first();
                if ($bengkayang && $regencyId == $bengkayang->id && isset($mockValues[$yr])) {
                    $values[] = $mockValues[$yr];
                } else {
                    $values[] = 200 + (($regencyId * 47 + (int)$yr * 59) % 900);
                }
            }
        }

        return response()->json([
            'years' => $years,
            'values' => $values
        ]);
    }
}
