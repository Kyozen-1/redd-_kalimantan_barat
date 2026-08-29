<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenGaleri;
use App\Models\Galeri;
use App\Models\MdKategoriDokumen;
use App\Models\Regency;
use Carbon\Carbon;

class FrontendLibraryController extends Controller
{
    /**
     * Display the Perpustakaan & Publikasi page.
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('tab') === 'dokumen' ? 'dokumen' : 'media';
        $search = trim($request->query('search', ''));
        $selectedKategori = $request->query('kategori', '');
        $selectedKabupaten = $request->query('kabupaten', '');
        $selectedTahun = $request->query('tahun', '');

        // Fetch categories & regencies for dynamic toolbar filters
        $categories = MdKategoriDokumen::statusAktif()->orderBy('nama', 'asc')->get();
        $regencies = Regency::orderBy('name', 'asc')->get();

        if ($activeTab === 'dokumen') {
            $query = DokumenGaleri::statusAktif()->with(['pivot_kategori_dokumen.md_kategori_dokumen']);

            if ($search) {
                $query->where('nama', 'like', "%{$search}%");
            }

            if ($selectedKategori) {
                $query->whereHas('pivot_kategori_dokumen', function ($q) use ($selectedKategori) {
                    $q->where('kategori_id', $selectedKategori);
                });
            }

            if ($selectedTahun) {
                $query->whereYear('created_at', $selectedTahun);
            }

            $documents = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
            $galleryMedia = collect();
        } else {
            $query = Galeri::statusAktif()->with('kabupaten_kota');

            if ($search) {
                $query->where('deskripsi', 'like', "%{$search}%");
            }

            if ($selectedKabupaten) {
                $query->where('kabupaten_kota_id', $selectedKabupaten);
            }

            if ($selectedTahun) {
                $query->whereYear('tanggal', $selectedTahun);
            }

            $galleryMedia = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
            $documents = collect();
        }

        return view('frontend.perpustakaan-publikasi', compact(
            'activeTab',
            'categories',
            'regencies',
            'documents',
            'galleryMedia',
            'search',
            'selectedKategori',
            'selectedKabupaten',
            'selectedTahun'
        ));
    }
}
