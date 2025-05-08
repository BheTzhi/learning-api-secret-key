<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusan = ['Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Manajemen', 'Akuntansi'];

        foreach ($jurusan as $j) {
            DB::table('jurusan')->insert([
                'nama_jurusan' => $j,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
