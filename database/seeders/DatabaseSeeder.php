<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BengkayangSeeder::class,
            KapuasHuluSeeder::class,
            KetapangSeeder::class,
            KubuRayaSeeder::class,
            LandakSeeder::class,
            MelawiSeeder::class,
            MempawahSeeder::class,
            PontianakSeeder::class,
            SambasSeeder::class,
            SanggauSeeder::class,
            SekadauSeeder::class,
            SingkawangSeeder::class,
            SintangSeeder::class,
            UserSeeder::class,
            KayongUtaraSeeder::class
        ]);
        // // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
