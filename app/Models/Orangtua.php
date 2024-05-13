<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'email',
        'no_telepon',
        'hubungan',
    ];
    public function relasi()
    {
        return $this->hasOne(Relasi::class, 'id_orangtua');
    }
}
