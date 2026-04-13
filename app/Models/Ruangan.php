<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'ruangan';

    // Primary key custom
    protected $primaryKey = 'id_ruangan';
    public $incrementing = true;
    protected $keyType = 'int';

    // Mass assignment
    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
        'jenis_ruangan',
        'lokasi',
        'kapasitas',
        'kondisi',
        'deskripsi'
    ];

    // Timestamp aktif
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'id_ruangan', 'id_ruangan');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Baik' => 'success',
            'Rusak Ringan' => 'warning',
            'Rusak Berat' => 'danger',
            'Dalam Perbaikan' => 'info'
        ];

        return $badges[$this->kondisi] ?? 'secondary';
    }
}