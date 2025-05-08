<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswaList = DB::table('mahasiswa')->get();

        foreach ($mahasiswaList as $mhs) {
            $mataKuliah = DB::table('mata_kuliah')
                ->where('jurusan_id', $mhs->jurusan_id)
                ->inRandomOrder()
                ->take(rand(15, 40))
                ->get();

            $mahasiswaMkBatch = [];

            foreach ($mataKuliah as $mk) {
                $nilaiAngka = round(rand(50, 100) + rand(0, 99) / 100, 2);
                $nilaiHuruf = match (true) {
                    $nilaiAngka >= 85 => 'A',
                    $nilaiAngka >= 70 => 'B',
                    $nilaiAngka >= 55 => 'C',
                    $nilaiAngka >= 40 => 'D',
                    default => 'E',
                };

                $timestamp = now();

                // Tambahkan ke array
                $mahasiswaMkBatch[] = [
                    'mk_id' => $mk->id,
                    'mahasiswa_id' => $mhs->id,
                    'semester' => rand(1, 8),
                    'nilai_angka' => $nilaiAngka,
                    'nilai_huruf' => $nilaiHuruf,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            DB::table('mahasiswa_mk')->insert($mahasiswaMkBatch);
        }
    }
}
