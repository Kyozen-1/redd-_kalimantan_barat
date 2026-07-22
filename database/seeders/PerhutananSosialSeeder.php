<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerhutananSosial;
use App\Models\Regency;

class PerhutananSosialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kapuasHulu = Regency::where('name', 'like', '%Kapuas Hulu%')->first();
        $kubuRaya = Regency::where('name', 'like', '%Kubu Raya%')->first();
        $sintang = Regency::where('name', 'like', '%Sintang%')->first();
        $ketapang = Regency::where('name', 'like', '%Ketapang%')->first();

        $rows = [
            [
                'nama_desa' => 'Desa Nanga Lauk',
                'kabupaten_kota_id' => $kapuasHulu?->id,
                'skema' => 'Hutan Desa (HD)',
                'nama_lembaga' => 'LPHD Lauk Emas',
                'nomor_sk' => 'SK.5420/MENLHK/2021',
                'status_aktif' => '1',
            ],
            [
                'nama_desa' => 'Desa Padang Tikar',
                'kabupaten_kota_id' => $kubuRaya?->id,
                'skema' => 'Hutan Desa (HD)',
                'nama_lembaga' => 'LPHD Padang Tikar',
                'nomor_sk' => 'SK.2214/MENLHK/2022',
                'status_aktif' => '1',
            ],
            [
                'nama_desa' => 'Desa Ensaid Panjang',
                'kabupaten_kota_id' => $sintang?->id,
                'skema' => 'Hutan Adat (HA)',
                'nama_lembaga' => 'Masyarakat Adat Dayak Desa',
                'nomor_sk' => 'SK.8845/MENLHK/2023',
                'status_aktif' => '1',
            ],
            [
                'nama_desa' => 'Desa Sungai Pelang',
                'kabupaten_kota_id' => $ketapang?->id,
                'skema' => 'Hutan Desa (HD)',
                'nama_lembaga' => 'LPHD Pelang Asri',
                'nomor_sk' => 'SK.1105/MENLHK/2020',
                'status_aktif' => '1',
            ],
            [
                'nama_desa' => 'Desa Batu Ampar',
                'kabupaten_kota_id' => $kubuRaya?->id,
                'skema' => 'Hutan Kemasyarakatan (HKm)',
                'nama_lembaga' => 'KTH Batu Ampar',
                'nomor_sk' => 'SK.3341/MENLHK/2024',
                'status_aktif' => '1',
            ],
        ];

        foreach ($rows as $row) {
            PerhutananSosial::firstOrCreate(
                ['nomor_sk' => $row['nomor_sk']],
                $row
            );
        }
    }
}
