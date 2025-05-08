<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'jurusan_id',
        'tanggal_lahir',
        'secret_key'
    ];

    public function mahasiswaMk()
    {
        return $this->hasMany(MahasiswaMk::class, 'mahasiswa_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
