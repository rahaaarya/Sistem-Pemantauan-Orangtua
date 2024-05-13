<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';
    protected $fillable = ['image', 'nidn', 'nama', 'email', 'no_telepon'];


    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_dosen_wali');
    }
}
