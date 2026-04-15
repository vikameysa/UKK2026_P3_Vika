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
        'jabatan', // pastikan kolom ini ada di tabel
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Guru & Wali Kelas bisa buat aspirasi
    public function canCreateAspirasi(): bool
    {
        return in_array($this->jabatan, ['Guru', 'Wali Kelas']);
    }

    // Wali Kelas bisa kelola (feedback, progres) aspirasi
    public function canManageAspirasi(): bool
    {
        return $this->jabatan == 'Wali Kelas';
    }

    // Wali Kelas bisa ubah status aspirasi
    public function canChangeStatus(): bool
    {
        return $this->jabatan == 'Wali Kelas';
    }

    // Kepala Sekolah, Wakil, Kepala Jurusan bisa lihat semua aspirasi
    public function canViewAllAspirasi(): bool
    {
        return in_array($this->jabatan, ['Kepala Sekolah', 'Wakil Kepala', 'Kepala Jurusan', 'Wali Kelas']);
    }

    // Kepala Sekolah, Wakil, Kepala Jurusan bisa lihat statistik
    public function canViewStatistik(): bool
    {
        return in_array($this->jabatan, ['Kepala Sekolah', 'Wakil Kepala', 'Kepala Jurusan']);
    }

    // Ambil id_kelas yang diampu Wali Kelas
    public function getKelasId()
    {
        if ($this->jabatan != 'Wali Kelas') return null;

        return \App\Models\Kelas::where('wali_kelas_id', $this->id)->value('id_kelas');
    }
}