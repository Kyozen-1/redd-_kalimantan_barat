<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdSectionLandingPage;

class MdSectionLandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Inisiatif Unggulan',
            'Hero',
            'Mekanisme',
            'Footer'
        ];

        foreach ($datas as $data) {
            $mdSectionLandingPage = new MdSectionLandingPage;
            $mdSectionLandingPage->user_id = 1;
            $mdSectionLandingPage->nama = $data;
            $mdSectionLandingPage->save();
        }
    }
}
