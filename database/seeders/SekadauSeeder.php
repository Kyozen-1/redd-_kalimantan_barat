<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekadauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kabupaten Sekadau',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Belitang' => [
                'Belitang Dua',
                'Belitang Satu',
                'Maboh Permai',
                'Menua Prama',
                'Nanga Ansar',
                'Padak',
                'Setuntung'
            ],
            'Belitang Hilir' => [
                'Empajak',
                'Entabuk',
                'Kumpang Bis',
                'Melanjan Raya',
                'Menawai Tekam',
                'Merbang',
                'Semadu',
                'Sepantak',
                'Sungai Ayak Dua',
                'Sungai Ayak Satu',
                'Tapang Pulau'
            ],
            'Belitang Hulu' => [
                'Balai Sepuak',
                'Batuk Mulau',
                'Bukit Rambat',
                'Ijuk',
                'Kumpang Ilong',
                'Mengaret',
                'Pakit Mulau',
                'Sebetung',
                'Seburuk Satu',
                'Sungai Antu Hulu',
                'Sungai Tapah',
                'Tabuk Hulu',
                'Terduk Dampak'
            ],
            'Nanga Mahap' => [
                'Batu Pahat',
                'Cenayan',
                'Karang Betung',
                'Landau Apin',
                'Landau Kumpai',
                'Lembah Beringin',
                'Nanga Mahap',
                'Nanga Suri',
                'Sebabas',
                'Tamang',
                'Teluk Kebau',
                'Tembaga',
                'Tembesuk'
            ],
            'Nanga Taman' => [
                'Engkulun Hulu',
                'Lubuk Tajau',
                'Meragun',
                'Nanga Engkulun',
                'Nanga Kiungkang',
                'Nanga Koman',
                'Nanga Mentukak',
                'Nanga Mongko',
                'Nanga Taman',
                'Pantok',
                'Rirang Jati',
                'Semerawai',
                'Senangak',
                'Sungai Lawak',
                'Tapang Tingang'
            ],
            'Sekadau Hilir' => [
                'Beringkai Raya',
                'Bokak Sebumbun',
                'Engkersik',
                'Ensalang',
                'Gonis Tekam',
                'Landau Kodah',
                'Merapi',
                'Mungguk',
                'Peniti',
                'Seberang Kapuas',
                'Selalong',
                'Semabi',
                'Sempulau Indah',
                'Seraras',
                'Sungai Kunyit',
                'Sungai Ringin',
                'Tanjung',
                'Tapang Semadak',
                'Tigur Jaya',
                'Timpuk'
            ],
            'Sekadau Hulu' => [
                'Boti',
                'Cupang Gading',
                'Mondi',
                'Nanga Biaban',
                'Nanga Menterap',
                'Nanga Pembubuh',
                'Perongkan',
                'Rawak Hilir',
                'Rawak Hulu',
                'Sekonau',
                'Setawar',
                'Sungai Sambang',
                'Sunsong',
                'Tapang Perodah',
                'Tinting Boyok'
            ]
        ];

        foreach ($data as $districtName => $villages) {

            $district = District::create([
                'regency_id' => $regency->id,
                'name' => $districtName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($villages as $villageName) {
                Village::create([
                    'district_id' => $district->id,
                    'name' => $villageName,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
