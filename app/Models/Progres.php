<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progres extends Model
{
    const UPDATED_AT = null;

    protected $table = 'progres';

    protected $fillable = [
        'id_aspirasi',
        'user_id',
        'keterangan_progres',
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'id_aspirasi', 'id_aspirasi');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}