<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusanIds = DB::table('jurusan')->pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $jurusanId = $jurusanIds[array_rand($jurusanIds)];
            $id = DB::table('mahasiswa')->insertGetId([
                'nama' => 'Mahasiswa ' . $i,
                'nim' => 'NIM' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'jurusan_id' => $jurusanId,
                'tanggal_lahir' => now()->subYears(rand(18, 23))->subDays(rand(1, 365)),
                'secret_key' => base64_encode('NIM' . str_pad($i, 4, '0', STR_PAD_LEFT)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('kartu_mahasiswa')->insert([
                'mahasiswa_id' => $id,
                'nomor_kartu' => 'KM' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'tanggal_terbit' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
