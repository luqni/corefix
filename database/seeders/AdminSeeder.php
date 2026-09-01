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
        \App\Models\User::firstOrCreate([
            'email' => 'admin@corefix.id',
        ], [
            'name' => 'Admin Corefix',
            'role' => 'admin',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        \App\Models\User::firstOrCreate([
            'email' => 'superadmin@corefix.id',
        ], [
            'name' => 'Super Admin',
            'role' => 'super_admin',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        \App\Models\User::firstOrCreate([
            'email' => 'teknisi@corefix.id',
        ], [
            'name' => 'Teknisi Corefix',
            'role' => 'teknisi',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);
    }
}
