<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PontianakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kota Pontianak',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Pontianak Barat' => [
                'Pallima',
                'Sungaibeliung',
                'Sungaijawi Dalam',
                'Sungaijawi Luar'
            ],
            'Pontianak Kota' => [
                'Daratsekip',
                'Mariana',
                'Sungaibangkong',
                'Sungaijawi',
                'Tengah'
            ],
            'Pontianak Selatan' => [
                'Akcaya',
                'Benuamelayu Darat',
                'Benuamelayu Laut',
                'Kotabaru',
                'Parittokaya'
            ],
            'Pontianak Tenggara' => [
                'Bangka Belitung Darat',
                'Bangka Belitung Laut',
                'Bansir Darat',
                'Bansir Laut'
            ],
            'Pontianak Timur' => [
                'Banjar Serasan',
                'Dalambugis',
                'Paritmayor',
                'Saigon',
                'Tambelansampit',
                'Tanjunghilir',
                'Tanjunghulu'
            ],
            'Pontianak Utara' => [
                'Batulayang',
                'Siantan Hilir',
                'Siantan Hulu',
                'Siantan Tengah'
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
