<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SambasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kabupaten Sambas',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Galing' => [
                'Galing',
                'Ratu Sepudak',
                'Sagu',
                'Sijang',
                'Sungai Palah',
                'Teluk Pandan',
                'Tempapan Hulu',
                'Tempapan Kuala',
                'Tri Gadu',
                'Tri Kembang'
            ],
            'Jawai' => [
                'Bakau',
                'Dungun Laut',
                'Lambau',
                'Mutus Darussalam',
                'Parit Setia',
                'Pelimpaan',
                'Sarang Burung Danau',
                'Sarang Burung Kolam',
                'Sarang Burung Kuala',
                'Sarang Burung Usrat',
                'Sentebang',
                'Sungai Nilam',
                'Sungai Nyirih'
            ],
            'Jawai Selatan' => [
                'Jawai Laut',
                'Jelu Air',
                'Matang Terap',
                'Sabaran',
                'Sari Laba A',
                'Sari Laba B',
                'Semperiuk A',
                'Semperiuk B',
                'Suah Api'
            ],
            'Paloh' => [
                'Kalimantan',
                'Malek',
                'Matang Danau',
                'Mentibar',
                'Nibung',
                'Sebubus',
                'Tanah Hitam',
                'Temajuk'
            ],
            'Pemangkat' => [
                'Gugah Sejahtera',
                'Harapan',
                'Jelutung',
                'Lonam',
                'Pemangkat Kota',
                'Penjajap',
                'Perapakan',
                'Sebatuan'
            ],
            'Sajad' => [
                'Beringin',
                'Jirak',
                'Mekar Jaya',
                'Tengguli'
            ],
            'Sajingan Besar' => [
                'Kaliau\'',
                'Santaban',
                'Sebunga',
                'Senatab',
                'Sungai Bening'
            ],
            'Salatiga' => [
                'Parit Baru',
                'Salatiga',
                'Serumpun',
                'Serunai',
                'Sungai Toman'
            ],
            'Sambas' => [
                'Dalam Kaum',
                'Durian',
                'Gapura',
                'Jagur',
                'Kartiasa',
                'Lorong',
                'Lubuk Dagang',
                'Lumbang',
                'Pasar Melayu',
                'Pendawan',
                'Saing Rambi',
                'Sebayan',
                'Semangau',
                'Sumber Harapan',
                'Sungai Rambah',
                'Tanjung Bugis',
                'Tanjung Mekar',
                'Tumuk Manggis'
            ],
            'Sebawi' => [
                'Rantau Panjang',
                'Sebangun',
                'Sebawi',
                'Sempalai Sebedang',
                'Sepuk Tanjung',
                'Tebing Batu',
                'Tempatan'
            ],
            'Sejangkung' => [
                'Parit Raja',
                'Penakalan',
                'Perigi Landu',
                'Perigi Limus',
                'Piantus',
                'Sekuduk',
                'Semangga',
                'Sendoyan',
                'Senujuh',
                'Sepantai',
                'Setalik',
                'Sulung'
            ],
            'Selakau' => [
                'Bentunai',
                'Gayung Bersambut',
                'Kuala',
                'Pangkalan Bemban',
                'Parit Baru',
                'Parit Kongsi',
                'Semelagi Besar',
                'Sungai Daun',
                'Sungai Nyirih',
                'Sungai Rusa',
                'Twi Mentibar'
            ],
            'Selakau Timur' => [
                'Buduk Sempadang',
                'Gelik',
                'Selakau Tua',
                'Seranggam'
            ],
            'Semparuk' => [
                'Seburing',
                'Semparuk',
                'Sepadu',
                'Sepinggan',
                'Singa Raya'
            ],
            'Subah' => [
                'Arga Pura',
                'Balai Gemuruh',
                'Bukit Mulya',
                'Karaban Jaya',
                'Madak',
                'Mensade',
                'Mukti Raharja',
                'Sabung',
                'Sapak Hulu Trans',
                'Sempurna',
                'Sungai Deden',
                'Sungai Sapa\'',
                'Tebuah Elok'
            ],
            'Tangaran' => [
                'Arung Medang',
                'Arung Parak',
                'Merabuan',
                'Merpati',
                'Pancur',
                'Semata',
                'Simpang Empat',
                'Tangaran'
            ],
            'Tebas' => [
                'Batu Makjage',
                'Bekut',
                'Bukit Sigoler',
                'Dungun Perapakan',
                'Makrampai',
                'Maktangguk',
                'Maribas',
                'Matang Labong',
                'Mekar Sekuntum',
                'Mensere',
                'Pangkalan Kongsi',
                'Pusaka',
                'Seberkat',
                'Segarau Parit',
                'Segedong',
                'Sejiram',
                'Sempalai',
                'Seret Ayon',
                'Serindang',
                'Serumpun Buluh',
                'Sungai Kelambu',
                'Tebas Kuala',
                'Tebas Sungai'
            ],
            'Tekarang' => [
                'Cepala',
                'Matang Segarau',
                'Merubung',
                'Rambayan',
                'Sari Makmur',
                'Sempadian',
                'Tekarang'
            ],
            'Teluk Keramat' => [
                'Berlimang',
                'Kuala Pangkalan Keramat',
                'Kubangga',
                'Lela',
                'Matang Segantar',
                'Mekar Sekuntum',
                'Mulia',
                'Pedada',
                'Pipit Teja',
                'Puringan',
                'Sabing',
                'Samustida',
                'Sayang Sedayu',
                'Sebagu',
                'Sekura',
                'Sengawang',
                'Sepadu',
                'Sungai Baru',
                'Sungai Kumpai',
                'Sungai Serabek',
                'Tambatan',
                'Tanjung Kerucut',
                'Teluk Kaseh',
                'Teluk Kumbang',
                'Tri Mandayan'
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
