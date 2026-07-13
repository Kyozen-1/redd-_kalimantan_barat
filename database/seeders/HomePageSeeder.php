<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdSectionLandingPage;
use App\Models\LandingPageSection;
use App\Models\Berita;
use App\Models\PivotGambarBerita;
use App\Models\User;

class HomePageSeeder extends Seeder
{
    /**
     * Seed example data for the home page (welcome.blade.php) dynamic sections.
     *
     * Section slugs used by FrontendHomeController:
     *   hero          → hero stats block
     *   sambutan      → governor's quote
     *   statistik     → dashboard badge values
     *   forest-band   → full-width text band
     *   floating-card → card below forest band
     */
    public function run(): void
    {
        // Resolve a user to attach to records (use first superadmin, or id=1 as fallback)
        $userId = User::where('role', 'superadmin')->value('id') ?? 1;

        /*
        |--------------------------------------------------------------------------
        | 1. Master Section Types (MdSectionLandingPage)
        |--------------------------------------------------------------------------
        */
        $sections = [
            ['nama' => 'Hero',         'slug_key' => 'hero'],
            ['nama' => 'Sambutan',     'slug_key' => 'sambutan'],
            ['nama' => 'Statistik',    'slug_key' => 'statistik'],
            ['nama' => 'Forest Band',  'slug_key' => 'forest-band'],
            ['nama' => 'Floating Card','slug_key' => 'floating-card'],
        ];

        $sectionModels = [];
        foreach ($sections as $s) {
            $model = MdSectionLandingPage::firstOrCreate(
                ['nama' => $s['nama']],
                ['user_id' => $userId, 'status_aktif' => '1']
            );
            $sectionModels[$s['slug_key']] = $model;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Landing Page Section Content
        |--------------------------------------------------------------------------
        */

        // --- Hero ---
        LandingPageSection::updateOrCreate(
            ['section_id' => $sectionModels['hero']->id, 'section_key' => 'hero-1'],
            [
                'user_id'     => $userId,
                'sort_order'  => 1,
                'status_aktif'=> '1',
                'content'     => [
                    'luas_hutan'      => '8.2 jt Ha',
                    'penurunan_emisi' => '12.5 %',
                    'stok_karbon'     => '450 Mt',
                    'update_date'     => '* Update 24 Mei 2024',
                ],
            ]
        );

        // --- Sambutan ---
        LandingPageSection::updateOrCreate(
            ['section_id' => $sectionModels['sambutan']->id, 'section_key' => 'sambutan-1'],
            [
                'user_id'     => $userId,
                'sort_order'  => 1,
                'status_aktif'=> '1',
                'content'     => [
                    'title'       => 'Gubernur Kalimantan Barat',
                    'description' => 'Melalui portal ini, kami mengundang seluruh elemen masyarakat untuk mengawal transparansi data emisi dan pelestarian hutan Kalimantan Barat demi masa depan generasi mendatang',
                ],
            ]
        );

        // --- Statistik ---
        LandingPageSection::updateOrCreate(
            ['section_id' => $sectionModels['statistik']->id, 'section_key' => 'statistik-1'],
            [
                'user_id'     => $userId,
                'sort_order'  => 1,
                'status_aktif'=> '1',
                'content'     => [
                    'luas_hutan_tersisa' => '6.4 jt ha',
                    'emisi'              => '187 Mt',
                    'tahun'              => '2025',
                    // 'image' => 'landing-page/images/your-image.jpg' // upload via CMS to override
                ],
            ]
        );

        // --- Forest Band ---
        LandingPageSection::updateOrCreate(
            ['section_id' => $sectionModels['forest-band']->id, 'section_key' => 'forest-band-1'],
            [
                'user_id'     => $userId,
                'sort_order'  => 1,
                'status_aktif'=> '1',
                'content'     => [
                    'description' => 'Sebagai salah satu "Paru-paru Dunia", Kalimantan Barat memiliki ekosistem hutan tropis dan Lahan Gambut Strategis seluas jutaan hektar yang berfungsi sebagai penyerap karbon raksasa bagi stabilitas iklim global',
                ],
            ]
        );

        // --- Floating Card ---
        LandingPageSection::updateOrCreate(
            ['section_id' => $sectionModels['floating-card']->id, 'section_key' => 'floating-card-1'],
            [
                'user_id'     => $userId,
                'sort_order'  => 1,
                'status_aktif'=> '1',
                'content'     => [
                    'description' => 'Dikelola melalui kolaborasi multipihak di bawah koordinasi Pemerintah Provinsi Kalimantan Barat, melibatkan instansi kehutanan, lembaga adat, serta mitra pembangunan internasional untuk memastikan transparansi dan akuntabilitas data emisi.',
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Berita (News Articles)
        |--------------------------------------------------------------------------
        */
        $newsItems = [
            [
                'judul'    => 'Komitmen Hijau Kalbar: Jutaan Hektar Hutan Berhasil Dilindungi Lewat Skema REDD+',
                'deskripsi'=> '<p>Pemerintah Provinsi Kalimantan Barat berhasil mengamankan jutaan hektar kawasan hutan melalui implementasi skema REDD+. Program ini melibatkan masyarakat adat lokal sebagai ujung tombak pemantauan dan perlindungan kawasan hutan secara berkelanjutan.</p><p>Capaian ini merupakan hasil dari kolaborasi antara pemerintah daerah, lembaga internasional, dan komunitas lokal yang telah berlangsung selama lebih dari satu dekade.</p>',
            ],
            [
                'judul'    => 'Dinas Intensif REDD+ Mengajak Pemprov Kalbar Prioritaskan Kelestarian Hutan Desa',
                'deskripsi'=> '<p>Dinas terkait mendorong Pemerintah Provinsi Kalimantan Barat untuk menjadikan kelestarian hutan desa sebagai prioritas utama dalam agenda pembangunan daerah. Langkah ini sejalan dengan komitmen nasional dalam pengendalian perubahan iklim.</p>',
            ],
            [
                'judul'    => 'Geliat Ekonomi Hijau: Masyarakat Lokal Kalbar Manfaatkan Hasil Hutan Bukan Kayu Skema REDD+',
                'deskripsi'=> '<p>Masyarakat lokal di Kalimantan Barat semakin aktif memanfaatkan hasil hutan bukan kayu (HHBK) sebagai sumber pendapatan alternatif. Dengan dukungan skema REDD+, kegiatan ini tidak hanya meningkatkan kesejahteraan warga tetapi juga menjaga kelestarian ekosistem hutan.</p>',
            ],
        ];

        foreach ($newsItems as $item) {
            Berita::firstOrCreate(
                ['judul' => $item['judul']],
                [
                    'user_id'     => $userId,
                    'deskripsi'   => $item['deskripsi'],
                    'status_aktif'=> '1',
                ]
            );
        }

        $this->command->info('✅  HomePageSeeder selesai — contoh data halaman beranda berhasil dibuat.');
    }
}
