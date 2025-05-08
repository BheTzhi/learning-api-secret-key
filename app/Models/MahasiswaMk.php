<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaMk extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa_mk';
    protected $fillable = ['mahasiswa_id', 'mk_id', 'semester'];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mk_id');
    }
}
