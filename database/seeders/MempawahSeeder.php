<?php

namespace Database\Seeders\Region;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MempawahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kabupaten Mempawah',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Anjongan' => [
                'Anjungan Dalam',
                'Anjungan Melancar',
                'Dema',
                'Kepayang',
                'Pak Bulu'
            ],
            'Mempawah Hilir' => [
                'Kuala Secapah',
                'Malikian',
                'Pasir',
                'Penibung',
                'Sengkubang',
                'Tanjung',
                'Tengah',
                'Terusan'
            ],
            'Mempawah Timur' => [
                'Antibar',
                'Parit Banjar',
                'Pasir Palembang',
                'Pasir Panjang',
                'Pasir Wan Salim',
                'Pulau Pedalaman',
                'Sejegi',
                'Sungai Bakau Kecil'
            ],
            'Sadaniang' => [
                'Amawang',
                'Ansiap',
                'Bum-bun',
                'Pentek',
                'Sekabuk',
                'Suak Barangan'
            ],
            'Segedong' => [
                'Parit Bugis',
                'Peniti Besar',
                'Peniti Dalam I',
                'Peniti Dalam II',
                'Sungai Burung',
                'Sungai Purun Besar'
            ],
            'Siantan' => [
                'Jungkat',
                'Peniti Luar',
                'Sungai Nipah',
                'Wajok Hilir',
                'Wajok Hulu'
            ],
            'Sungai Kunyit' => [
                'Bukit Batu',
                'Mendalok',
                'Semparong Parit Raden',
                'Semudun',
                'Sungai Bundung Laut',
                'Sungai Dungun',
                'Sungai Duri I',
                'Sungai Duri II',
                'Sungai Kunyit Dalam',
                'Sungai Kunyit Hulu',
                'Sungai Kunyit Laut',
                'Sungai Limau'
            ],
            'Sungai Pinyuh' => [
                'Galang',
                'Nusapati',
                'Peniraman',
                'Sungai Bakau Besar Darat',
                'Sungai Bakau Besar Laut',
                'Sungai Batang',
                'Sungai Pinyuh',
                'Sungai Purun Kecil',
                'Sungai Rasau'
            ],
            'Toho' => [
                'Benuang',
                'Kecurit',
                'Pak Laheng',
                'Pak Utan',
                'Sambora',
                'Sepang',
                'Terap',
                'Toho Ilir'
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
