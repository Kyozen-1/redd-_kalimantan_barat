<?php

namespace Database\Seeders\Region;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kabupaten Landak',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Air Besar' => [
                'Bentiang Madomang',
                'Dange Aji',
                'Engkadik Pade',
                'Engkangin',
                'Jambu Tembawang',
                'Merayuh',
                'Nyari',
                'Parek',
                'Sekendal',
                'Sempantung Lawek',
                'Semuntik',
                'Sepangah',
                'Serimbu',
                'Temoyok',
                'Tengon',
                'Tenguwe'
            ],
            'Banyuke Hulu' => [
                'Gamang',
                'Kampet',
                'Padang Pio',
                'Ringo Lojok',
                'Semade',
                'Tembawang Bale',
                'Untang'
            ],
            'Jelimpo' => [
                'Angan Tembawang',
                'Balai Peluntan',
                'Dara Itam I',
                'Jelimpo',
                'Kayu Ara',
                'Kersik Belantian',
                'Mandor Kiru',
                'Nyi\'in',
                'Papung',
                'Pawis Hilir',
                'Sekais',
                'Temahar',
                'Tubang Raeng'
            ],
            'Kuala Behe' => [
                'Angkanyar',
                'Bengawan Ampar',
                'Kedama',
                'Kuala Behe',
                'Nyayum',
                'Paku Raya',
                'Permiit',
                'Sehe Lusur',
                'Sejowet',
                'Semedang',
                'Tanjung Balai'
            ],
            'Mandor' => [
                'Bebatung',
                'Kayu Ara',
                'Kayu Tanam',
                'Keramas',
                'Kerohok',
                'Mandor',
                'Manggang',
                'Mengkunyit',
                'Ngarak',
                'Pongok',
                'Salatiga',
                'Sebadu',
                'Sekilap',
                'Selutung',
                'Semenok',
                'Simpang Kasturi',
                'Sumsum'
            ],
            'Mempawah Hulu' => [
                'Ansolok',
                'Babatn',
                'Bilayuk',
                'Caokng',
                'Garu',
                'Karangan',
                'Mentonyek',
                'Pahokng',
                'Parigi',
                'Sabaka',
                'Sailo',
                'Sala\'as',
                'Salumang',
                'Sampuro',
                'Sungai Laki',
                'Tiang Tanjung',
                'Tunang'
            ],
            'Menjalin' => [
                'Bengkawe',
                'Lamoanak',
                'Menjalin',
                'Nangka',
                'Raba',
                'Re\'es',
                'Sepahat',
                'Tempoak'
            ],
            'Menyuke' => [
                'Angkaras',
                'Anik Dingir',
                'Ansang',
                'Bagak',
                'Berinang Mayun',
                'Darit',
                'Kayu Ara',
                'Ladangan',
                'Lintah Betung',
                'Mamek',
                'Ongkol Padang',
                'Sidan',
                'Songga',
                'Sungai Lubang',
                'Ta\'as',
                'Tolok'
            ],
            'Meranti' => [
                'Ampadi',
                'Kelampai Setolo',
                'Meranti',
                'Moro Betung',
                'Selange',
                'Tahu'
            ],
            'Ngabang' => [
                'Amang',
                'Ambarang',
                'Amboyo Inti',
                'Amboyo Selatan',
                'Amboyo Utara',
                'Antan Rayan',
                'Engkadu',
                'Hilir Kantor',
                'Hilir Tengah',
                'Mu\'un',
                'Mungguk',
                'Pak Mayam',
                'Penyaho Dangku',
                'Raja',
                'Rasan',
                'Sebirang',
                'Sungai Keli',
                'Tebedak',
                'Temiang Sawi'
            ],
            'Sebangki' => [
                'Agak',
                'Kumpang Tengah',
                'Rantau Panjang',
                'Sebangki',
                'Sungai Segak'
            ],
            'Sengah Temila' => [
                'Andeng',
                'Aur Sampuk',
                'Banying',
                'Gombang',
                'Keranji Mancal',
                'Keranji Paidang',
                'Pahauman',
                'Paloan',
                'Rabak',
                'Saham',
                'Sebatih',
                'Senakin',
                'Sidas',
                'Tonang'
            ],
            'Sompak' => [
                'Amawakng',
                'Galar',
                'Lingkonong',
                'Pakumbang',
                'Pauh',
                'Sompak',
                'Tapakng'
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
