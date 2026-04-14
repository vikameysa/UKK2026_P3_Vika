<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'mata_pelajaran',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}