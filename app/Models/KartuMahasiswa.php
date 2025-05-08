<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartuMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'kartu_mahasiswa';

    protected $fillable = ['mahasiswa_id', 'nomor_kartu', 'tanggal_terbit'];
}
