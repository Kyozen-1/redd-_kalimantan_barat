<?php

namespace Database\Seeders\Region;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KubuRayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $regency = Regency::create([
            'name' => 'Kabupaten Kubu Raya',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $data = [
            'Batu Ampar' => [
                'Ambarawa',
                'Batu Ampar',
                'Medan Mas',
                'Muara Tiga',
                'Nipah Panjang',
                'Padang Tikar Dua',
                'Padang Tikar Satu',
                'Sumber Agung',
                'Sungai Besar',
                'Sungai Jawi',
                'Sungai Kerawang',
                'Tanjung Beringin',
                'Tanjung Harapan',
                'Tasik Malaya',
                'Teluk Nibung',
            ],
            'Kuala Mandor B' => [
                'Kuala Mandor A',
                'Kuala Mandor B',
                'Kubu Padi',
                'Padi Jaya',
                'Retok',
                'Sungai Enau',
            ],
            'Kubu' => [
                'Air Putih',
                'Ambawang',
                'Dabong',
                'Jangkang Dua',
                'Jangkang Satu',
                'Kampung Baru',
                'Kubu',
                'Mengkalang',
                'Mengkalang Jambu',
                'Olak-Olak Kubu',
                'Pelita Jaya',
                'Pinang Dalam',
                'Pinang Luar',
                'Sepakat Baru',
                'Seruat Dua',
                'Seruat Tiga',
                'Sungai Bemban',
                'Sungai Selamat',
                'Sungai Terus',
                'Teluk Nangka',
            ],
            'Rasau Jaya' => [
                'Bintang Mas',
                'Pematang Tujuh',
                'Rasau Jaya Dua',
                'Rasau Jaya Satu',
                'Rasau Jaya Tiga',
                'Rasau Jaya Umum',
            ],
            'Sungai Ambawang' => [
                'Ampera Raya',
                'Bengkarek',
                'Durian',
                'Jawa Tengah',
                'Korek',
                'Lingga',
                'Mega Timur',
                'Pancaroba',
                'Pasak',
                'Pasak Piang',
                'Puguk',
                'Simpang Kanan',
                'Sungai Ambawang Kuala',
                'Sungai Malaya',
                'Teluk Bakung',
            ],
            'Sungai Kakap' => [
                'Jeruju Besar',
                'Kalimas',
                'Pal Sembilan',
                'Parit Keladi',
                'Punggur Kapuas',
                'Pungur Besar',
                'Pungur Kecil',
                'Rengas Kapuas',
                'Sepuk Laut',
                'Sungai Belidak',
                'Sungai Itik',
                'Sungai Kakap',
                'Sungai Kupah',
                'Sungai Rengas',
                'Tanjung Saleh',
            ],
            'Sungai Raya' => [
                'Arang Limbung',
                'Gunung Tamang',
                'Kalibandung',
                'Kapur',
                'Kuala Dua',
                'Limbung',
                'Madu Sari',
                'Mekar Baru',
                'Mekar Sari',
                'Muara Baru',
                'Parit Baru',
                'Permata Jaya',
                'Pulau Jambu',
                'Pulau Limbung',
                'Sukulanting',
                'Sungai Ambangah',
                'Sungai Asam',
                'Sungai Bulan',
                'Sungai Raya',
                'Sungai Raya Dalam',
                'Tebang Kacang',
                'Teluk Kapuas',
            ],
            'Teluk Pakedai' => [
                'Arus Deras',
                'Kuala Karang',
                'Madura',
                'Pasir Putih',
                'Selat Remis',
                'Seruat Satu',
                'Sungai Deras',
                'Sungai Nibung',
                'Sungai Nipah',
                'Tanjung Bunga',
                'Teluk Gelam',
                'Teluk Pakedai Dua',
                'Teluk Pakedai Hulu',
                'Teluk Pakedai Satu',
            ],
            'Terentang' => [
                'Betuah',
                'Permata',
                'Radak Baru',
                'Sungai Dungun',
                'Sungai Radak Dua',
                'Sungai Radak Satu',
                'Teluk Bayur',
                'Teluk Empening',
                'Terentang Hilir',
                'Terentang Hulu',
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
