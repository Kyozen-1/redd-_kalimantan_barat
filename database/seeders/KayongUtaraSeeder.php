<?php

namespace Database\Seeders\Region;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KayongUtaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kabupaten Kayong Utara',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Kepulauan Karimata' => [
                'Betok Jaya',
                'Padang',
                'Pelapis',
            ],
            'Pulau Maya' => [
                'Dusun Besar',
                'Dusun Kecil',
                'Kemboja',
                'Satai Lestari',
                'Tanjungsatai',
            ],
            'Seponti' => [
                'Durian Sebatang',
                'Podorukun',
                'Seponti Jaya',
                'Sungai Sepeti',
                'Telaga Arum',
                'Wonorejo',
            ],
            'Simpang Hilir' => [
                'Batu Barat',
                'Lubuk Batu',
                'Matan Jaya',
                'Medan Jaya',
                'Nipah Kuning',
                'Padu Banjar',
                'Pemangkat',
                'Penjalaan',
                'Pulau Kumbang',
                'Rantau Panjang',
                'Sungai Mata-mata',
                'Teluk Melano',
            ],
            'Sukadana' => [
                'Sutera',
                'Pangkalan Buton',
                'Pampang Harapan',
                'Sejahtera',
                'Simpang Tiga',
                'Riam Berasap Jaya',
                'Gunung Sembilan',
                'Harapan Mulia',
                'Benawai Agung',
                'Sedahan Jaya',
            ],
            'Teluk Batang' => [
                'Alur Bandung',
                'Banyu Abang',
                'Mas Bangun',
                'Sungaipaduan',
                'Telukbatang',
                'Telukbatang Selatan',
                'Telukbatang Utara',
            ],
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
