<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdSektorEmisi;

class MdSektorEmisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Energi',
            'IPPU',
            'Pertanian',
            'Folu',
            'Kebakaran Gambut',
            'Limbah'
        ];

        foreach ($datas as $data) {
            $mdSektorEmisi = new MdSektorEmisi;
            $mdSektorEmisi->user_id = 1;
            $mdSektorEmisi->nama = $data;
            $mdSektorEmisi->save();
        }
    }
}
