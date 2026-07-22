<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdEmisi;
use App\Models\MdSektorEmisi;
use App\Models\PivotSektorEmisi;
use App\Models\DataEmisi;
use App\Models\MdKawasanHutan;
use App\Models\DataKawasan;
use App\Models\MdPenyebabDeforestasi;
use App\Models\DataDeforestasi;
use App\Models\User;
use App\Models\Regency;
use App\Models\DokumenRad;
use App\Models\LaporanEmisi;

class DataPemetaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::where('role', 'superadmin')->value('id') ?? 1;
        $years = ['2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026'];

        /*
        |--------------------------------------------------------------------------
        | 1. Master Data: Emisi & Sektor
        |--------------------------------------------------------------------------
        | Ensure parameter types and sectors exist, then establish pivots.
        */
        $emisiGrk = MdEmisi::where('nama', 'Gas Rumah Kaca')->first() ?? MdEmisi::firstOrCreate(
            ['nama' => 'Gas Rumah Kaca'],
            ['user_id' => $userId, 'status_aktif' => '1']
        );

        $emisiStok = MdEmisi::firstOrCreate(
            ['nama' => 'Stok Karbon'],
            ['user_id' => $userId, 'status_aktif' => '1']
        );

        $sektorFolu = MdSektorEmisi::firstOrCreate(
            ['nama' => 'Folu'],
            ['user_id' => $userId, 'status_aktif' => '1']
        );

        $sektorEnergi = MdSektorEmisi::firstOrCreate(
            ['nama' => 'Energi'],
            ['user_id' => $userId, 'status_aktif' => '1']
        );

        // Pivot untuk Emisi CO2 (Sektor Energi)
        $pivotEmisiCo2 = PivotSektorEmisi::firstOrCreate(
            ['emisi_id' => $emisiGrk->id, 'sektor_emisi_id' => $sektorEnergi->id],
            ['status_aktif' => '1']
        );

        // Pivot untuk Serapan Karbon (Sektor Folu)
        $pivotSerapan = PivotSektorEmisi::firstOrCreate(
            ['emisi_id' => $emisiGrk->id, 'sektor_emisi_id' => $sektorFolu->id],
            ['status_aktif' => '1']
        );

        // Pivot untuk Stok Karbon (Sektor Folu)
        $pivotStok = PivotSektorEmisi::firstOrCreate(
            ['emisi_id' => $emisiStok->id, 'sektor_emisi_id' => $sektorFolu->id],
            ['status_aktif' => '1']
        );

        /*
        |--------------------------------------------------------------------------
        | 2. Seed Data Emisi
        |--------------------------------------------------------------------------
        */
        $emisiCo2Values = [122, 131, 136, 146, 147, 182, 164, 166, 171, 176, 181];
        $serapanValues  = [-78, -72, -61, -52, -42, -28, -43, -45, -44, -42, -40];

        foreach ($years as $index => $year) {
            // Emisi CO2
            DataEmisi::updateOrCreate(
                ['pivot_sektor_emisi_id' => $pivotEmisiCo2->id, 'tahun' => $year],
                ['nilai' => $emisiCo2Values[$index], 'status_aktif' => '1']
            );

            // Serapan Karbon Hutan
            DataEmisi::updateOrCreate(
                ['pivot_sektor_emisi_id' => $pivotSerapan->id, 'tahun' => $year],
                ['nilai' => $serapanValues[$index], 'status_aktif' => '1']
            );

            // Stok Karbon (contoh statis/menurun perlahan)
            DataEmisi::updateOrCreate(
                ['pivot_sektor_emisi_id' => $pivotStok->id, 'tahun' => $year],
                ['nilai' => 450 - ($index * 8), 'status_aktif' => '1']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Master Data & Data: Kawasan Hutan (Konservasi & Gambut)
        |--------------------------------------------------------------------------
        */
        $kawasanTypes = [
            'Hutan Lindung',
            'Taman Nasional',
            'Suaka Margasatwa',
            'KPA/KSA Lainnya',
            'Cagar Alam',
            'Gambut Sekunder',
            'Degradasi Ringan',
            'Degradasi Berat',
            'Dalam Restorasi',
            'Gambut Primer Baik',
            'Luas Hutan Tersisa',
            'Total Lahan Gambut',
        ];

        $kawasanModels = [];
        foreach ($kawasanTypes as $type) {
            $kawasanModels[$type] = MdKawasanHutan::firstOrCreate(
                ['nama' => $type],
                ['user_id' => $userId, 'status_aktif' => '1']
            );
        }

        // Seed Kawasan Konservasi untuk tahun 2025
        $conservationData = [
            'Hutan Lindung'    => 1280,
            'Taman Nasional'   => 990,
            'Suaka Margasatwa' => 800,
            'KPA/KSA Lainnya'  => 680,
            'Cagar Alam'       => 410,
        ];

        foreach ($conservationData as $type => $value) {
            DataKawasan::updateOrCreate(
                ['kawasan_hutan_id' => $kawasanModels[$type]->id, 'tahun' => '2025'],
                ['nilai' => $value, 'user_id' => $userId, 'status_aktif' => '1']
            );
        }

        // Seed Gambut Donut untuk semua tahun 2016-2025 (dalam persen)
        $peatDonutYearly = [
            '2016' => ['Gambut Sekunder' => 20, 'Degradasi Ringan' => 14, 'Degradasi Berat' => 19, 'Dalam Restorasi' => 4, 'Gambut Primer Baik' => 43],
            '2017' => ['Gambut Sekunder' => 21, 'Degradasi Ringan' => 14, 'Degradasi Berat' => 19, 'Dalam Restorasi' => 4, 'Gambut Primer Baik' => 42],
            '2018' => ['Gambut Sekunder' => 22, 'Degradasi Ringan' => 15, 'Degradasi Berat' => 18, 'Dalam Restorasi' => 4, 'Gambut Primer Baik' => 41],
            '2019' => ['Gambut Sekunder' => 22, 'Degradasi Ringan' => 15, 'Degradasi Berat' => 18, 'Dalam Restorasi' => 5, 'Gambut Primer Baik' => 40],
            '2020' => ['Gambut Sekunder' => 23, 'Degradasi Ringan' => 16, 'Degradasi Berat' => 17, 'Dalam Restorasi' => 5, 'Gambut Primer Baik' => 39],
            '2021' => ['Gambut Sekunder' => 23, 'Degradasi Ringan' => 16, 'Degradasi Berat' => 17, 'Dalam Restorasi' => 6, 'Gambut Primer Baik' => 38],
            '2022' => ['Gambut Sekunder' => 24, 'Degradasi Ringan' => 17, 'Degradasi Berat' => 16, 'Dalam Restorasi' => 6, 'Gambut Primer Baik' => 37],
            '2023' => ['Gambut Sekunder' => 24, 'Degradasi Ringan' => 17, 'Degradasi Berat' => 16, 'Dalam Restorasi' => 7, 'Gambut Primer Baik' => 36],
            '2024' => ['Gambut Sekunder' => 25, 'Degradasi Ringan' => 18, 'Degradasi Berat' => 15, 'Dalam Restorasi' => 7, 'Gambut Primer Baik' => 35],
            '2025' => ['Gambut Sekunder' => 25, 'Degradasi Ringan' => 18, 'Degradasi Berat' => 15, 'Dalam Restorasi' => 8, 'Gambut Primer Baik' => 34],
        ];

        foreach ($peatDonutYearly as $year => $data) {
            foreach ($data as $type => $value) {
                DataKawasan::updateOrCreate(
                    ['kawasan_hutan_id' => $kawasanModels[$type]->id, 'tahun' => $year],
                    ['nilai' => $value, 'user_id' => $userId, 'status_aktif' => '1']
                );
            }
        }

        // Seed Gambut Trend (2016-2025)
        $restorasiTrend  = [438, 456, 466, 485, 517, 535, 548, 560, 568, 576, 582];
        $degradasiTrend  = [45, 54, 73, 94, 112, 128, 151, 158, 166, 174, 182];

        foreach ($years as $index => $year) {
            // Dalam Restorasi
            DataKawasan::updateOrCreate(
                ['kawasan_hutan_id' => $kawasanModels['Dalam Restorasi']->id, 'tahun' => $year],
                ['nilai' => $restorasiTrend[$index], 'user_id' => $userId, 'status_aktif' => '1']
            );

            // Terdegradasi (Kita anggap gabungan Degradasi Berat & Ringan)
            DataKawasan::updateOrCreate(
                ['kawasan_hutan_id' => $kawasanModels['Degradasi Berat']->id, 'tahun' => $year],
                ['nilai' => $degradasiTrend[$index], 'user_id' => $userId, 'status_aktif' => '1']
            );

            // Luas Hutan Tersisa
            DataKawasan::updateOrCreate(
                ['kawasan_hutan_id' => $kawasanModels['Luas Hutan Tersisa']->id, 'tahun' => $year],
                ['nilai' => 6400 - ($index * 15), 'user_id' => $userId, 'status_aktif' => '1']
            );
        }

        // Total Lahan Gambut (konstan)
        DataKawasan::updateOrCreate(
            ['kawasan_hutan_id' => $kawasanModels['Total Lahan Gambut']->id, 'tahun' => '2025'],
            ['nilai' => 1730, 'user_id' => $userId, 'status_aktif' => '1']
        );

        /*
        |--------------------------------------------------------------------------
        | 4. Master Data & Data: Deforestasi
        |--------------------------------------------------------------------------
        */
        $penyebab = MdPenyebabDeforestasi::firstOrCreate(
            ['nama' => 'Karhutla'],
            ['user_id' => $userId, 'status_aktif' => '1']
        );

        $bengkayangId = Regency::where('name', 'like', '%Bengkayang%')->value('id') ?? Regency::value('id') ?? 1;

        $karhutlaDeforestasi = [
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

        foreach ($karhutlaDeforestasi as $year => $val) {
            DataDeforestasi::updateOrCreate(
                [
                    'penyebab_deforestasi_id' => $penyebab->id,
                    'kabupaten_kota_id'       => $bengkayangId,
                    'tahun'                   => $year
                ],
                [
                    'nilai'        => $val,
                    'status_aktif' => '1'
                ]
            );
        }

        // Seed fallback data for all other regencies so changing dropdown displays data
        $otherRegencies = Regency::where('id', '!=', $bengkayangId)->get();
        foreach ($otherRegencies as $reg) {
            foreach ($years as $index => $year) {
                $seedVal = 200 + (($reg->id * 47 + $index * 59) % 900);
                DataDeforestasi::updateOrCreate(
                    [
                        'penyebab_deforestasi_id' => $penyebab->id,
                        'kabupaten_kota_id'       => $reg->id,
                        'tahun'                   => $year
                    ],
                    [
                        'nilai'        => $seedVal,
                        'status_aktif' => '1'
                    ]
                );
            }
        }

        // Seed Dokumen RAD
        $radDocs = [
            'Strategi dan Rencana Aksi Provinsi (SRAP) REDD+ Kalbar' => 'documents/srap-kalbar.pdf',
            'Dokumen panduan pengembangan kebijakan REDD+ untuk daerah' => 'documents/panduan-redd.pdf',
        ];
        foreach ($radDocs as $name => $path) {
            DokumenRad::updateOrCreate(
                ['nama' => $name],
                ['document_path' => $path, 'status_aktif' => '1']
            );
        }

        // Seed Laporan Emisi
        $emisiLaporans = [
            'LAPORAN CAPAIAN PENURUNAN EMISI GRK TAHUN 2025' => [
                'pdf' => 'reports/laporan-emisi-2025.pdf',
                'xlsx' => 'reports/laporan-emisi-2025.xlsx',
                'docx' => 'reports/laporan-emisi-2025.docx',
            ],
            'LAPORAN CAPAIAN PENURUNAN EMISI GRK TAHUN 2024' => [
                'pdf' => 'reports/laporan-emisi-2024.pdf',
                'xlsx' => 'reports/laporan-emisi-2024.xlsx',
                'docx' => 'reports/laporan-emisi-2024.docx',
            ]
        ];
        foreach ($emisiLaporans as $name => $files) {
            LaporanEmisi::updateOrCreate(
                ['nama' => $name],
                [
                    'document_file_pdf_path' => $files['pdf'],
                    'document_file_excel_path' => $files['xlsx'],
                    'document_file_word_path' => $files['docx'],
                    'status_aktif' => '1'
                ]
            );
        }

        // Seed Berita (News)
        $newsItems = [
            [
                'judul' => 'Komitmen Hijau Kalbar: Jutaan Hektar Hutan Berhasil Dilindungi Lewat Skema REDD+',
                'deskripsi' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim faucibus mauris non pharetra. Lobortis integer congue tincidunt dui. Pharetra auctor in augue dui vitae enim viverra felis. Faucibus auctor amet ornare commodo. Congue eros felis ultrices lobortis magna tristique. Quis aliquet vulputate massa sed suspendisse porttitor orci. Neque augue etiam pretium ut. Nec neque amet facilisis nunc ipsum. Risus pulvinar in urna sed urna ac enim bibendum. Diam vitae in massa leo sed maecenas.\n\nFacilisi vitae amet etiam varius ut. Nulla adipiscing eget vel at lectus a diam lectus mattis. Nunc sodales scelerisque congue diam netus condimentum justo nunc nunc. Arcu aliquam ipsum ornare purus non semper nisl venenatis. Viverra amet suspendisse egestas at dui.\n\nEt duis eu pellentesque mauris urna. Eget vitae viverra pellentesque sed ullamcorper sed urna. Quam egestas  pharetra tincidunt turpis nam sit id dui. Phasellus lorem felis sit neque vulputate dolor. Viverra nunc lorem viverra lorem. Amet neque fringilla  facilisi  augue  accumsan  nunc  bibendum  porttior. Vel diam dolor phasellus praesent elit tincidunt. Nisl elementum sapien ipsum amet quis  dui. Est tempor semper  cursus  pretium  ipsum accumsan  quis  vivamus  tortor.  Massa  sagittis  eu id nunc  facilisis  euismod. Sapien  vitae  mi  adipiscing  ultricies  tellus  leo  quam  ut egestas. Nullam a urna diam turpis.\n\nUltricies sit nulla eleifend id habitasse pretium ultricies molestie dictumst. Amet nisi ridiculus magnis ornare magna accumsan. Posuere in euismod pharetra sit odio lectus ut congue venenatis. Nunc pretium nulla nunc mauris ut at orci libero. In pulvinar lorem duis mollis sed suspendisse. Facilisis tempor cras fermentum nulla sit tristique tortor nec morbi. Posuere lacus diam euismod et magna proin. Venenatis maecenas felis blandit nisi elit lacinia tempor in. Etiam vitae risus rutrum aliquam. Ut in viverra etiam nulla mi quis. Magna nunc sit auctor pellentesque diam dapibus.\nEgestas amet cras non sit mi vitae faucibus elit. Nam risus eget enim velit. Enim ante eu eleifend posuere quis a libero dictum viverra. Tristique nam nisl arcu pellentesque malesuada euismod pulvinar morbi. Leo arcu vitae praesent vel id. Phasellus eu pellentesque mauris duis volutpat semper lectus convallis adipiscing. At consectetur nunc augue tempor porta. Eu quam interdum sit eu. Ante id id lorem consequat sed aenean et hendrerit scelerisque. Gravida et id vestibulum enim lacinia risus at senectus gravida.",
                'image' => 'frontend/images/news-agenda/featured-news.png'
            ],
            [
                'judul' => 'Dana Insentif REDD+ Mengalir, Pemprov Kalbar Prioritaskan Kelestarian Hutan Desa',
                'deskripsi' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim faucibus mauris non pharetra. Lobortis integer congue tincidunt dui. Pharetra auctor in augue dui vitae enim viverra felis. Faucibus auctor amet ornare commodo. Congue eros felis ultrices lobortis magna tristique.\n\nFacilisi vitae amet etiam varius ut. Nulla adipiscing eget vel at lectus a diam lectus mattis. Nunc sodales scelerisque congue diam netus condimentum justo nunc nunc.",
                'image' => 'frontend/images/news-agenda/planting-news.png'
            ],
            [
                'judul' => 'Geliat Ekonomi Hijau: Masyarakat Lokal Kalbar Manfaatkan Hasil Hutan Bukan Kayu Skema REDD+',
                'deskripsi' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim faucibus mauris non pharetra. Lobortis integer congue tincidunt dui. Pharetra auctor in augue dui vitae enim viverra felis. Faucibus auctor amet ornare commodo. Congue eros felis ultrices lobortis magna tristique.\n\nFacilisi vitae amet etiam varius ut. Nulla adipiscing eget vel at lectus a diam lectus mattis. Nunc sodales scelerisque congue diam netus condimentum justo nunc nunc.",
                'image' => 'frontend/images/news-agenda/mangrove-news.png'
            ],
            [
                'judul' => 'Sosialisasi Program REDD+ Tingkat Kabupaten Bengkayang Tahun 2026',
                'deskripsi' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim faucibus mauris non pharetra. Lobortis integer congue tincidunt dui. Pharetra auctor in augue dui vitae enim viverra felis. Faucibus auctor amet ornare commodo. Congue eros felis ultrices lobortis magna tristique.\n\nFacilisi vitae amet etiam varius ut. Nulla adipiscing eget vel at lectus a diam lectus mattis. Nunc sodales scelerisque congue diam netus condimentum justo nunc nunc.",
                'image' => 'frontend/images/news-agenda/planting-news.png'
            ],
            [
                'judul' => 'Evaluasi Kinerja Restorasi Ekosistem Gambut di Kalimantan Barat',
                'deskripsi' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim faucibus mauris non pharetra. Lobortis integer congue tincidunt dui. Pharetra auctor in augue dui vitae enim viverra felis. Faucibus auctor amet ornare commodo. Congue eros felis ultrices lobortis magna tristique.\n\nFacilisi vitae amet etiam varius ut. Nulla adipiscing eget vel at lectus a diam lectus mattis. Nunc sodales scelerisque congue diam netus condimentum justo nunc nunc.",
                'image' => 'frontend/images/news-agenda/mangrove-news.png'
            ]
        ];

        foreach ($newsItems as $item) {
            $berita = \App\Models\Berita::updateOrCreate(
                ['judul' => $item['judul']],
                [
                    'user_id' => $userId,
                    'deskripsi' => $item['deskripsi'],
                    'status_aktif' => '1'
                ]
            );

            // Seed PivotGambarBerita if not already present
            \App\Models\PivotGambarBerita::updateOrCreate(
                ['berita_id' => $berita->id],
                [
                    'image_path' => $item['image'],
                    'nama' => 'news_image',
                    'status_aktif' => '1'
                ]
            );
        }

        // Seed Agenda (Events)
        $agendaItems = [
            [
                'nama' => 'Loka Karya Data Emisi Karbon Tingkat Provinsi Kalimantan Barat',
                'deskripsi' => 'Loka karya penyusunan basis data emisi sektor kehutanan.',
                'tanggal' => '2026-05-21'
            ],
            [
                'nama' => 'Peluncuran Inisiatif Restorasi Gambut Berbasis Masyarakat di Kubu Raya',
                'deskripsi' => 'Program restorasi lahan gambut melibatkan masyarakat hukum adat.',
                'tanggal' => '2026-05-25'
            ],
            [
                'nama' => 'Pertemuan Tahunan Mitra Pembangunan REDD+: Capaian & Target 2027',
                'deskripsi' => 'Pertemuan tahunan bersama seluruh pemangku kepentingan dan mitra pembangunan.',
                'tanggal' => '2026-05-28'
            ]
        ];

        foreach ($agendaItems as $item) {
            \App\Models\Agenda::updateOrCreate(
                ['nama' => $item['nama']],
                [
                    'user_id' => $userId,
                    'deskripsi' => $item['deskripsi'],
                    'tanggal' => $item['tanggal'],
                    'status_aktif' => '1'
                ]
            );
        }
    }
}
