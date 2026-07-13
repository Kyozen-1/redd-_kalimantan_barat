<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdKawasanHutan;

class MdKawasanHutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Hutan Lindung',
            'Suaka Alam dan Pelestarian Alam',
            'Hutan Produksi Terbatas',
            'Hutan Produksi Tetap',
            'Hutan Produksi yang dapat Dikonversi',
            'Jumlah Luas Hutan dan Perairan'
        ];

        foreach ($datas as $data) {
            $mdKawasanHutan = new MdKawasanHutan;
            $mdKawasanHutan->user_id = 1;
            $mdKawasanHutan->nama = $data;
            $mdKawasanHutan->save();
        }
    }
}
