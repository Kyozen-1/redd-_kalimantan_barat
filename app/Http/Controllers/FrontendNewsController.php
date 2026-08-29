<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Agenda;
use App\Models\MdLsm;
use App\Models\PivotGambarBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrontendNewsController extends Controller
{
    /**
     * Display the Berita & Agenda page.
     */
    public function index()
    {
        $newsList = Berita::statusAktif()->with(['pivot_gambar_berita' => function($query) {
            $query->statusAktif();
        }])->orderBy('created_at', 'desc')->get();

        $agendas = Agenda::statusAktif()->orderBy('tanggal', 'asc')->get();

        // Separate news list:
        $featuredNews = $newsList->first();
        $sideStories = $newsList->slice(1, 2);
        $otherStories = $newsList->slice(3);

        return view('frontend.berita-agenda', compact('featuredNews', 'sideStories', 'otherStories', 'agendas'));
    }

    /**
     * Display a specific Berita (News) detail.
     */
    public function show($id)
    {
        $berita = Berita::statusAktif()->with(['pivot_gambar_berita' => function($query) {
            $query->statusAktif();
        }])->findOrFail($id);

        // Retrieve other active news items to populate the sidebar
        $otherStories = Berita::statusAktif()->with(['pivot_gambar_berita' => function($query) {
            $query->statusAktif();
        }])->where('id', '!=', $id)->latest()->take(3)->get();

        return view('frontend.berita-detail', compact('berita', 'otherStories'));
    }

    /**
     * Get active LSM data for Ruang Kolaborasi LSM modal.
     */
    public function getLsmData(Request $request)
    {
        $query = MdLsm::statusAktif()->with(['kabupaten_kota', 'md_wilayah_cakupan']);

        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('kabupaten_kota', function($k) use ($search) {
                      $k->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('md_wilayah_cakupan', function($w) use ($search) {
                      $w->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $lsms = $query->orderBy('nama', 'asc')->get()->values()->map(function($item, $index) {
            $sektor = $item->kabupaten_kota ? str_replace(['Kabupaten ', 'Kota '], '', $item->kabupaten_kota->name) : '-';
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'sektor' => $sektor,
                'wilayah_cakupan' => $item->md_wilayah_cakupan ? $item->md_wilayah_cakupan->nama : '-',
                'link' => $item->link,
                'link_label' => 'Link ' . ($index + 1),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $lsms
        ]);
    }

    /**
     * Get Agenda detail for Agenda modal.
     */
    public function getAgendaDetail($id)
    {
        $agenda = Agenda::statusAktif()->findOrFail($id);
        $carbonDate = $agenda->tanggal ? \Carbon\Carbon::parse($agenda->tanggal) : null;

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $agenda->id,
                'nama' => $agenda->nama,
                'deskripsi' => $agenda->deskripsi,
                'tanggal' => $agenda->tanggal,
                'formatted_date' => $carbonDate ? $carbonDate->translatedFormat('d F Y') : '-',
                'day' => $carbonDate ? $carbonDate->format('d') : '-',
                'month' => $carbonDate ? $carbonDate->translatedFormat('M') : '-',
                'year' => $carbonDate ? $carbonDate->format('Y') : '-',
                'penyelenggara' => 'Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat'
            ]
        ]);
    }

    /**
     * Serve news image locally by streaming it from MinIO for the frontend.
     */
    public function gambarBerita($id)
    {
        try {
            $gambar = PivotGambarBerita::findOrFail($id);

            if (!$gambar->image_path) {
                abort(404);
            }

            $disk = Storage::disk('minio');

            if (!$disk->exists($gambar->image_path)) {
                abort(404);
            }

            return $disk->response($gambar->image_path);
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
