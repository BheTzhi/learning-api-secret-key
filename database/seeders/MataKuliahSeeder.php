<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusan = DB::table('jurusan')->get();
        foreach ($jurusan as $j) {
            for ($i = 1; $i <= 40; $i++) {
                DB::table('mata_kuliah')->insert([
                    'nama_mk' => "MK {$j->nama_jurusan} $i",
                    'kode_mk' => strtoupper(substr($j->nama_jurusan, 0, 3)) . $i,
                    'sks' => rand(2, 4),
                    'jurusan_id' => $j->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
