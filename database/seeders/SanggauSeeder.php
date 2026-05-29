<?php

namespace Database\Seeders\Region;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SanggauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kabupaten Sanggau',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Balai' => [
                'Bulu Bala',
                'Cowet',
                'Empirang Ujung',
                'Hilir',
                'Kebadu',
                'Mak Kawing',
                'Padi Kaye',
                'Semoncol',
                'Senyabang',
                'Tae',
                'Temiang Mali',
                'Temiang Taba'
            ],
            'Beduai' => [
                'Bereng Berkawat',
                'Kasro Mego',
                'Mawang Muda',
                'Sungai Ilai',
                'Thang Raya'
            ],
            'Bonti' => [
                'Bahta',
                'Bantai',
                'Bonti',
                'Empodis',
                'Kampuh',
                'Majel',
                'Sami',
                'Tunggul Boyok',
                'Upe'
            ],
            'Entikong' => [
                'Entikong',
                'Nekan',
                'Pala Pasang',
                'Semanget',
                'Suruh Tembawang'
            ],
            'Jangkang' => [
                'Balai Sebut',
                'Empiyang',
                'Jangkang Benua',
                'Ketori',
                'Pisang',
                'Sape',
                'Selampung',
                'Semirau',
                'Semombat',
                'Tanggung',
                'Terati'
            ],
            'Kapuas' => [
                'Belangin',
                'Beringin',
                'Botuh Lintang',
                'Bunut',
                'Entakai',
                'Ilir Kota',
                'Kambong',
                'Lape',
                'Lintang Kapuas',
                'Lintang Pelaman',
                'Mengkiang',
                'Nanga Biang',
                'Pana',
                'Penyeladi',
                'Penyelimau',
                'Penyelimau Jaya',
                'Rambin',
                'Semerangkai',
                'Sungai Alai',
                'Sungai Batu',
                'Sungai Mawang',
                'Sungai Muntik',
                'Sungai Sengkuang',
                'Tanjung Kapuas',
                'Tanjung Sekayam',
                'Tapang Dulang'
            ],
            'Kembayan' => [
                'Kelompu',
                'Kuala Dua',
                'Mobui',
                'Sebongkuh',
                'Sebuduh',
                'Sejuah',
                'Semayang',
                'Tanap',
                'Tanjung Bunga',
                'Tanjung Merpati',
                'Tunggal Bhakti'
            ],
            'Meliau' => [
                'Balai Tinggi',
                'Baru Lombak',
                'Bhakti Jaya',
                'Cupang',
                'Enggadai',
                'Harapan Makmur',
                'Kuala Buayan',
                'Kuala Rosan',
                'Kunyil',
                'Lalang',
                'Melawi Makmur',
                'Meliau Hilir',
                'Meliau Hulu',
                'Melobok',
                'Meranggau',
                'Mukti Jaya',
                'Pampang Dua',
                'Sungai Kembayau',
                'Sungai Mayam'
            ],
            'Mukok' => [
                'Engkode',
                'Inggis',
                'Kedukul',
                'Layak Omang',
                'Semanggis Raya',
                'Semuntai',
                'Serambai Jaya',
                'Sungai Mawang',
                'Tri Mulya'
            ],
            'Noyan' => [
                'Empoto',
                'Idas',
                'Noyan',
                'Semongan',
                'Sungai Dangin'
            ],
            'Parindu' => [
                'Dosan',
                'Embala',
                'Gunam',
                'Hibun',
                'Maju Karya',
                'Maringin Jaya',
                'Marita',
                'Palem Jaya',
                'Pandu Raya',
                'Pusat Damai',
                'Rahayu',
                'Sebara',
                'Suka Gerundi',
                'Suka Mulya'
            ],
            'Sekayam' => [
                'Balai Karangan',
                'Bungkang',
                'Engkahan',
                'Kenaman',
                'Lubuk Sabuk',
                'Melenggang',
                'Pengadang',
                'Raut Muara',
                'Sangai Tekam',
                'Sotok'
            ],
            'Tayan Hilir' => [
                'Balai Ingin',
                'Beginjan',
                'Cempedak',
                'Emberas',
                'Kawat',
                'Lalang',
                'Melugai',
                'Pedalaman',
                'Pulau Tayan Utara',
                'Sebemban',
                'Sejotang',
                'Subah',
                'Sungai Jaman',
                'Tanjung Bunut',
                'Tebang Benua'
            ],
            'Tayan Hulu' => [
                'Berakak',
                'Binjai',
                'Engkasan',
                'Janjang',
                'Kedakas',
                'Mandong',
                'Menyabo',
                'Pandan Sembuat',
                'Peruan Dalam',
                'Riyai',
                'Sosok'
            ],
            'Toba' => [
                'Bagan Asam',
                'Balai Belungai',
                'Belungai Dalam',
                'Kampung Baru',
                'Lumut',
                'Sansat',
                'Teraju'
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
