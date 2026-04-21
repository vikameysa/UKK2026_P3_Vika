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
        'jabatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function canCreateAspirasi(): bool
    {
        return in_array($this->jabatan, ['Guru', 'Wali Kelas']);
    }

    public function canManageAspirasi(): bool
    {
        return $this->jabatan == 'Wali Kelas';
    }

    public function canChangeStatus(): bool
    {
        return $this->jabatan == 'Wali Kelas';
    }

    public function canViewAllAspirasi(): bool
    {
        return in_array($this->jabatan, ['Kepala Sekolah', 'Wakil Kepala', 'Kepala Jurusan', 'Wali Kelas']);
    }

    public function canViewStatistik(): bool
    {
        return in_array($this->jabatan, ['Kepala Sekolah', 'Wakil Kepala', 'Kepala Jurusan']);
    }

    public function getKelasId()
    {
        if ($this->jabatan != 'Wali Kelas') return null;

        return \App\Models\Kelas::where('wali_kelas_id', $this->id)->value('id_kelas');
    }
}
