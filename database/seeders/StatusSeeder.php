<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'status' => 'Service Telah diterima',
        ]);
        DB::table('statuses')->insert([
            'status' => 'Dalam Perbaikan',
        ]);
        DB::table('statuses')->insert([
            'status' => 'Penggantian Sparepart',
        ]);
        DB::table('statuses')->insert([
            'status' => 'Penambahan Sparepart',
        ]);
        DB::table('statuses')->insert([
            'status' => 'Pembayaran diterima',
        ]);
        DB::table('statuses')->insert([
            'status' => 'Perbaikan Selesai',
        ]);
        DB::table('statuses')->insert([
            'status' => 'Kendaraan Diterima/Diambil',
        ]);
    }
}
