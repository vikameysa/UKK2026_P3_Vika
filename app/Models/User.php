<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Petugas;
use App\Models\Aspirasi;
use App\Models\Progres;
use App\Models\HistoryStatus;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'user_id');
    }

    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'user_id');
    }

    public function progres()
    {
        return $this->hasMany(Progres::class, 'user_id');
    }

    public function historyStatus()
    {
        return $this->hasMany(HistoryStatus::class, 'diubah_oleh');
    }
}