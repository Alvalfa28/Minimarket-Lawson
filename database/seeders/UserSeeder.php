<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'     => 'Admin Sistem',
                'email'    => 'admin@lawson.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Manajer Toko',
                'email'    => 'manajer@lawson.com',
                'password' => Hash::make('password'),
                'role'     => 'manajer',
            ],
            [
                'name'     => 'Staf Gudang',
                'email'    => 'gudang@lawson.com',
                'password' => Hash::make('password'),
                'role'     => 'gudang',
            ],
            [
                'name'     => 'Kasir Lawson',
                'email'    => 'kasir@lawson.com',
                'password' => Hash::make('password'),
                'role'     => 'kasir',
            ],
        ]);
    }
}