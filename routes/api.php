<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('verify.mahasiswa')->get('/mahasiswa/khs', [MahasiswaController::class, 'index']);

Route::get('/mahasiswa', [MahasiswaController::class, 'getAllMahasiswa']);
Route::get('/jurusan', [MahasiswaController::class, 'getAllJurusan']);
Route::get('/matakuliah', [MahasiswaController::class, 'getAllMataKuliah']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'getAllMahasiswaById']);
Route::get('/jurusan/{id}', [MahasiswaController::class, 'getAllJurusanById']);
Route::get('/matakuliah/{id}', [MahasiswaController::class, 'getAllMataKuliahById']);
