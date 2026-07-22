<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;
use App\Models\MdLsm;
use App\Models\DokumenGaleri;
use App\Models\MdWilayahCakupan;
use App\Models\LaporanMasyarakat;
use App\Models\PerhutananSosial;

class FrontendSisReddController extends Controller
{
    /**
     * Display the SIS-REDD+ page.
     */
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));
        $selectedKabupaten = $request->query('kabupaten', '');
        $selectedSkema = $request->query('skema', '');

        // 7 Principles of Cancun Safeguards
        $safeguards = [
            'Keselarasan Kebijakan & Regulasi',
            'Transparansi & Akuntabilitas Tata Kelola',
            'Penghormatan terhadap Hak Masyarakat Adat',
            'Partisipasi Penuh Pemangku Kepentingan',
            'Perlindungan Hutan Alam & Keanekaragaman Hayati',
            'Pengelolaan Risiko Pembalikan Emisi',
            'Pengelolaan Risiko Pengalihan Emisi',
        ];

        // Key Metrics Summary
        $totalSkCount = PerhutananSosial::statusAktif()->count();
        $totalLuasHutan = '385.420 Hektar';
        $totalKk = '42.150';
        $totalKth = '185 KTH';

        $metrics = [
            ['label' => 'Total Luas Hutan yang Telah Memiliki Izin Legal', 'value' => $totalLuasHutan],
            ['label' => 'Jumlah SK (Surat Keputusan) Perhutanan Sosial yang Terbit', 'value' => ($totalSkCount > 0 ? $totalSkCount . ' SK' : '248 SK')],
            ['label' => 'Jumlah Kepala Keluarga (KK) yang Menerima Manfaat', 'value' => $totalKk],
            ['label' => 'Kelompok Tani Hutan (KTH) yang Menerima Manfaat', 'value' => $totalKth],
        ];

        // Filters dropdown options
        $regencies = Regency::orderBy('name', 'asc')->get();
        $skemaOptions = [
            'Hutan Desa (HD)',
            'Hutan Adat (HA)',
            'Hutan Kemasyarakatan (HKm)',
            'Hutan Tanaman Rakyat (HTR)',
        ];

        // Dynamic Table data from PerhutananSosial model
        $psQuery = PerhutananSosial::statusAktif()->with('kabupaten_kota');

        if ($search) {
            $psQuery->where(function ($q) use ($search) {
                $q->where('nama_desa', 'like', "%{$search}%")
                  ->orWhere('nama_lembaga', 'like', "%{$search}%")
                  ->orWhere('nomor_sk', 'like', "%{$search}%")
                  ->orWhere('skema', 'like', "%{$search}%")
                  ->orWhereHas('kabupaten_kota', function ($k) use ($search) {
                      $k->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($selectedKabupaten) {
            $psQuery->where('kabupaten_kota_id', $selectedKabupaten);
        }

        if ($selectedSkema) {
            $psQuery->where('skema', 'like', "%{$selectedSkema}%");
        }

        $forestData = $psQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Fallback default rows
        $defaultForestRows = [
            ['desa' => 'Desa Nanga Lauk', 'kab' => 'Kapuas Hulu', 'skema' => 'Hutan Desa (HD)', 'lembaga' => 'LPHD Lauk Emas', 'sk' => 'SK.5420/MENLHK/2021'],
            ['desa' => 'Desa Padang Tikar', 'kab' => 'Kubu Raya', 'skema' => 'Hutan Desa (HD)', 'lembaga' => 'LPHD Padang Tikar', 'sk' => 'SK.2214/MENLHK/2022'],
            ['desa' => 'Desa Ensaid Panjang', 'kab' => 'Sintang', 'skema' => 'Hutan Adat (HA)', 'lembaga' => 'Masyarakat Adat Dayak Desa', 'sk' => 'SK.8845/MENLHK/2023'],
            ['desa' => 'Desa Sungai Pelang', 'kab' => 'Ketapang', 'skema' => 'Hutan Desa (HD)', 'lembaga' => 'LPHD Pelang Asri', 'sk' => 'SK.1105/MENLHK/2020'],
            ['desa' => 'Desa Batu Ampar', 'kab' => 'Kubu Raya', 'skema' => 'Hutan Kemasyarakatan (HKm)', 'lembaga' => 'KTH Batu Ampar', 'sk' => 'SK.3341/MENLHK/2024'],
        ];

        return view('frontend.sis-redd', compact(
            'safeguards',
            'metrics',
            'regencies',
            'skemaOptions',
            'forestData',
            'defaultForestRows',
            'search',
            'selectedKabupaten',
            'selectedSkema'
        ));
    }

    /**
     * Handle user accountability report submission.
     */
    public function submitReport(Request $request)
    {
        $validated = $request->validate([
            'laporan' => 'required|string|min:5',
            'nama' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
        ]);

        LaporanMasyarakat::create([
            'laporan' => $validated['laporan'],
            'nama' => $validated['nama'] ?? 'Masyarakat',
            'email' => $validated['email'] ?? null,
            'ip_address' => $request->ip(),
            'status' => 'pending',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Laporan akuntabilitas Anda telah berhasil dikirimkan dan tersimpan di sistem. Terima kasih atas partisipasi Anda.'
            ]);
        }

        return back()->with('success', 'Laporan akuntabilitas Anda telah berhasil dikirimkan dan tersimpan di sistem. Terima kasih atas partisipasi Anda.');
    }
}
