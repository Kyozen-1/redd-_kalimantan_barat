<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Berita;
use App\Models\LandingPageSection;
use App\Models\MdSectionLandingPage;

class FrontendHomeController extends Controller
{
    /**
     * Display the home / landing page with dynamic data from the CMS.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Landing Page Sections
        | Group all active LandingPageSection records by their section's slug
        | (derived from MdSectionLandingPage.nama, lowercased & stripped).
        |--------------------------------------------------------------------------
        */
        $allSections = LandingPageSection::statusAktif()
            ->with('section')
            ->orderBy('sort_order')
            ->get();

        // Build a keyed map: slug => collection of sections
        $sectionMap = $allSections->groupBy(function ($item) {
            return Str::slug($item->section?->nama ?? 'unknown');
        });

        /*
        |--------------------------------------------------------------------------
        | Hero Stats
        | Expects a section named "hero" (or "Hero") with content keys:
        |   luas_hutan, penurunan_emisi, stok_karbon, update_date
        |--------------------------------------------------------------------------
        */
        $heroSection = $sectionMap->get('hero')?->first();
        $heroContent = $heroSection?->content ?? [];

        $heroStats = [
            'luas_hutan'       => $heroContent['luas_hutan']       ?? null,
            'penurunan_emisi'  => $heroContent['penurunan_emisi']  ?? null,
            'stok_karbon'      => $heroContent['stok_karbon']       ?? null,
            'update_date'      => $heroContent['update_date']       ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Sambutan (Governor's Quote)
        | Expects a section named "sambutan" with content keys:
        |   title (person/title), description (the quote text)
        |--------------------------------------------------------------------------
        */
        $sambutanSection = $sectionMap->get('sambutan')?->first();
        $sambutanContent = $sambutanSection?->content ?? [];

        $sambutan = [
            'title'       => $sambutanContent['title']       ?? null,
            'description' => $sambutanContent['description'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Statistik (Dashboard Badges)
        | Expects a section named "statistik" with content keys:
        |   luas_hutan_tersisa, emisi, tahun
        |--------------------------------------------------------------------------
        */
        $statistikSection = $sectionMap->get('statistik')?->first();
        $statistikContent = $statistikSection?->content ?? [];

        $statistik = [
            'luas_hutan_tersisa' => $statistikContent['luas_hutan_tersisa'] ?? null,
            'emisi'              => $statistikContent['emisi']              ?? null,
            'tahun'              => $statistikContent['tahun']              ?? null,
            'image'              => isset($statistikContent['image'])
                                        ? Storage::disk('minio')->url($statistikContent['image'])
                                        : null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Forest Band / Quote Banner
        | Expects a section named "forest-band" with content key: description
        |--------------------------------------------------------------------------
        */
        $forestBandSection = $sectionMap->get('forest-band')?->first();
        $forestBandContent = $forestBandSection?->content ?? [];

        $forestBand = [
            'description' => $forestBandContent['description'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Floating Card
        | Expects a section named "floating-card" with content key: description
        |--------------------------------------------------------------------------
        */
        $floatingCardSection = $sectionMap->get('floating-card')?->first();
        $floatingCardContent = $floatingCardSection?->content ?? [];

        $floatingCard = [
            'description' => $floatingCardContent['description'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Inisiatif Unggulan
        | Expects multiple sections named "inisiatif-unggulan" with content keys:
        |   title, icon
        |--------------------------------------------------------------------------
        */
        $inisiatifList = $sectionMap->get('inisiatif-unggulan') ?? collect();
        $initiatives = $inisiatifList->map(function ($item) {
            return [
                'title' => $item->content['title'] ?? null,
                'icon'  => $item->content['icon'] ?? 'fas fa-tree',
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Mekanisme
        | Expects a section named "mekanisme" with content keys:
        |   description_1, description_2, image
        |--------------------------------------------------------------------------
        */
        $mekanismeSection = $sectionMap->get('mekanisme')?->first();
        $mekanismeContent = $mekanismeSection?->content ?? [];
        $mekanisme = [
            'description_1' => $mekanismeContent['description_1'] ?? $mekanismeContent['description'] ?? null,
            'description_2' => $mekanismeContent['description_2'] ?? null,
            'image'         => isset($mekanismeContent['image'])
                                ? Storage::disk('minio')->url($mekanismeContent['image'])
                                : null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Footer
        | Expects a section named "footer" with content keys: title, description
        |--------------------------------------------------------------------------
        */
        $footerSection = $sectionMap->get('footer')?->first();
        $footerContent = $footerSection?->content ?? [];
        $footerData = [
            'title'       => $footerContent['title'] ?? null,
            'description' => $footerContent['description'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Berita Terbaru (Latest News)
        | Fetch the 3 latest active news articles with their images.
        |--------------------------------------------------------------------------
        */
        $beritaList = Berita::statusAktif()
            ->with('pivot_gambar_berita')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($berita) {
                $firstImage = $berita->pivot_gambar_berita->first();
                return [
                    'id'          => $berita->id,
                    'judul'       => $berita->judul,
                    'deskripsi'   => $berita->deskripsi,
                    'gambar_url'  => $firstImage ? $firstImage->gambar_url : null,
                    'tanggal'     => $berita->created_at
                                        ? Carbon::parse($berita->created_at)->diffForHumans()
                                        : null,
                    'penulis'     => 'Admin',
                ];
            });

        $featuredBerita = $beritaList->first();
        $sideBerita     = $beritaList->skip(1)->values();

        return view('welcome', compact(
            'heroStats',
            'sambutan',
            'statistik',
            'forestBand',
            'floatingCard',
            'initiatives',
            'mekanisme',
            'footerData',
            'featuredBerita',
            'sideBerita'
        ));
    }
}
