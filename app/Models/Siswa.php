<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'user_id', 'nis', 'nama', 'kelas', 'jurusan',
        'jenis_kelamin', 'tanggal_lahir', 'alamat', 'no_hp', 'foto'
    ];
}