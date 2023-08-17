<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'last_name' => 'admin',
            'role' => 'admin',
            'phone' => '08',
            'address' => 'merauke',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);
        DB::table('users')->insert([
            'name' => 'pemilik',
            'last_name' => 'pemilik',
            'role' => 'pemilik',
            'phone' => '08',
            'address' => 'merauke',
            'email' => 'pemilik@gmail.com',
            'password' => Hash::make('pemilik'),
        ]);
        DB::table('users')->insert([
            'name' => 'pelanggan',
            'last_name' => 'pelanggan',
            'role' => 'pelanggan',
            'phone' => '08',
            'address' => 'merauke',
            'email' => 'pelanggan@gmail.com',
            'password' => Hash::make('pelanggan'),
        ]);
    }
}
