<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relasi extends Model
{
    protected $fillable = [
        'id_user',
        'id_mahasiswa',
        'id_orangtua',
        'status_konfirmasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class, 'id_orangtua');
    }
}
