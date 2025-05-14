<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::with(['mahasiswaMk.mataKuliah', 'jurusan'])
            ->where('nim', $request->get('nim'))
            ->first();


        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $semester = $request->get('semester');
        $khs = $this->getKHS($mahasiswa, $semester);
        $ipk = $this->hitungIPK($mahasiswa, $semester);
        $predikat = $this->getPredikat($ipk);

        return response()->json([
            'nama' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'jurusan' => $mahasiswa->jurusan ? $mahasiswa->jurusan->nama_jurusan : null,
            'khs' => $khs,
            'ipk' => number_format($ipk, 2),
            'predikat' => $predikat,
        ]);
    }

    private function getKHS($mahasiswa, $semester)
    {

        $mahasiswaMk = $semester
            ? $mahasiswa->mahasiswaMk->where('semester', $semester)
            : $mahasiswa->mahasiswaMk;


        if ($semester && $mahasiswaMk->isEmpty()) {
            return response()->json(['message' => "Anda belum/tidak mengikuti semester $semester"], 404);
        }


        return $mahasiswaMk->groupBy('semester')->map(function ($semesterData, $semester) {
            return [
                'semester' => $semester,
                'nilai' => $semesterData->map(function ($mkm) {
                    return [
                        'nama_mk' => $mkm->mataKuliah->nama_mk,
                        'sks' => $mkm->mataKuliah->sks,
                        'nilai_angka' => $mkm->nilai_angka,
                        'nilai_huruf' => $mkm->nilai_huruf,
                    ];
                })
            ];
        })->values()->all();
    }

    private function hitungIPK($mahasiswa, $semester)
    {

        $mahasiswaMk = $semester
            ? $mahasiswa->mahasiswaMk->where('semester', $semester)
            : $mahasiswa->mahasiswaMk;

        $totalSks = $totalNilai = 0;

        foreach ($mahasiswaMk as $mkm) {
            $totalSks += $mkm->mataKuliah->sks;
            $totalNilai += $this->nilaiToAngka($mkm->nilai_huruf) * $mkm->mataKuliah->sks;
        }

        return $totalSks > 0 ? $totalNilai / $totalSks : 0;
    }

    private function nilaiToAngka($nilaiHuruf)
    {
        $nilai = [
            'A' => 4.0,
            'A-' => 3.7,
            'B+' => 3.3,
            'B' => 3.0,
            'B-' => 2.7,
            'C+' => 2.3,
            'C' => 2.0,
            'C-' => 1.7,
            'D' => 1.0,
            'E' => 0.0
        ];

        return $nilai[$nilaiHuruf] ?? 0.0;
    }

    private function getPredikat($ipk)
    {
        if ($ipk >= 3.50) return 'Cumlaude';
        if ($ipk >= 3.00) return 'Baik';
        if ($ipk >= 2.00) return 'Cukup';
        return 'Tidak Lulus';
    }

    public function getAllMahasiswa()
    {
        // $mahasiswa = Mahasiswa::all();
        $mahasiswa = Mahasiswa::all()->makeHidden(['secret_key']);

        return response()->json([
            'request_at' => time(),
            'data' => $mahasiswa
        ]);
    }

    public function getAllJurusan()
    {

        $jurusan = Jurusan::all();

        return response()->json([
            'request_at' => time(),
            'data' => $jurusan
        ]);
    }

    public function getAllMataKuliah()
    {

        $matakuliah = MataKuliah::all();

        return response()->json([
            'request_at' => time(),
            'data' => $matakuliah
        ]);
    }

    public function getAllMahasiswaById($id)
    {
        // $mahasiswa = Mahasiswa::where('id', $id)->first();
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        $mahasiswa?->makeHidden(['secret_key']);

        return response()->json([
            'request_at' => time(),
            'data' => $mahasiswa
        ]);
    }

    public function getAllJurusanById($id)
    {

        $jurusan = Jurusan::where('id', $id)->first();

        return response()->json([
            'request_at' => time(),
            'data' => $jurusan
        ]);
    }

    public function getAllMataKuliahById($id)
    {

        $matakuliah = MataKuliah::where('id', $id)->first();

        return response()->json([
            'request_at' => time(),
            'data' => $matakuliah
        ]);
    }
}
