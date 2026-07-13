<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdEmisi;

class MdEmisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Gas Rumah Kaca'
        ];

        foreach ($datas as $data) {
            $mdEmisi = new MdEmisi;
            $mdEmisi->user_id = 1;
            $mdEmisi->nama = $data;
            $mdEmisi->save();
        }
    }
}
