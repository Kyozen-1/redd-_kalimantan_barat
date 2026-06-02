<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'superadmin', 'email' => 'superadmin@email.com', 'status_aktif' => '1', 'role' => 'superadmin', 'password' => 12345678]);
    }
}
