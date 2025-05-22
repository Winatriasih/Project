<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMahasiswa extends Model
{
    protected $table = 'data_mahasiswa';

    protected $fillable = [
        'nim', 'foto', 'nama', 'prodi', 'angkatan'
    ];
}

