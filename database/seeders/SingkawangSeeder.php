<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SingkawangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kota Singkawang',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Singkawang Barat' => [
                'Kuala',
                'Melayu',
                'Pasiran',
                'Tengah'
            ],
            'Singkawang Selatan' => [
                'Pangmilang',
                'Sagatani',
                'Sedau',
                'Sijangkung'
            ],
            'Singkawang Tengah' => [
                'Bukit Batu',
                'Condong',
                'Jawa',
                'Roban',
                'Sekip Lama',
                'Sungai Wie'
            ],
            'Singkawang Timur' => [
                'Bagak Sahwa',
                'Maya Sopa',
                'Nyarumkop',
                'Pajintan',
                'Sanggau Kulor'
            ],
            'Singkawang Utara' => [
                'Naram',
                'Semelagi Kecil',
                'Setapuk Besar',
                'Setapuk Kecil',
                'Sungai Bulan',
                'Sungai Garam Hilir',
                'Sungai Rasau'
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
