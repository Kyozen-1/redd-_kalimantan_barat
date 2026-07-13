<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdWilayahCakupan;

class MdWilayahCakupanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Hutan Desa (HD)'
        ];

        foreach ($datas as $data) {
            $mdWilayahCakupan = new MdWilayahCakupan;
            $mdWilayahCakupan->user_id = 1;
            $mdWilayahCakupan->nama = $data;
            $mdWilayahCakupan->save();
        }
    }
}
