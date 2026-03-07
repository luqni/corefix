<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate([
            'email' => 'admin@corefix.id',
        ], [
            'name' => 'Admin Corefix',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::updateOrCreate([
            'email' => 'superadmin@corefix.id',
        ], [
            'name' => 'Super Admin',
            'role' => 'super_admin',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::updateOrCreate([
            'email' => 'teknisi@corefix.id',
        ], [
            'name' => 'Teknisi Corefix',
            'role' => 'teknisi',
            'password' => bcrypt('password'),
        ]);
    }
}
