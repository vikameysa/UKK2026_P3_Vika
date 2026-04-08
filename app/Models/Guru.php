<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $fillable = [
        'user_id', 'nip', 'nama', 'mata_pelajaran',
        'jenis_kelamin', 'tanggal_lahir', 'alamat', 'no_hp', 'foto'
    ];
}