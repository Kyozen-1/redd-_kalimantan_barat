<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdPenyebabDeforestasi;

class MdPenyebabDeforestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Karhutla'
        ];

        foreach ($datas as $data) {
            $mdPenyebabDeforestasi = new MdPenyebabDeforestasi;
            $mdPenyebabDeforestasi->user_id = 1;
            $mdPenyebabDeforestasi->nama = $data;
            $mdPenyebabDeforestasi->save();
        }
    }
}
