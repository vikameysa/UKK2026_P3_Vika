<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryStatus extends Model
{
    protected $table = 'history_status';

    protected $fillable = [
        'id_aspirasi',
        'status_lama',
        'status_baru',
        'diubah_oleh'
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'id_aspirasi');
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }
}