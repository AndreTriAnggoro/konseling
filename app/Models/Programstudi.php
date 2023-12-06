<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programstudi extends Model
{
    use HasFactory;

    protected $table = "programstudi";
    protected $fillable = [
        'id_programstudi', 'id_jurusan', 'nama_prodi', 'nama_kaprodi', 'nip_kaprodi', 'no_hp',
    ];

    public function mahasiswa() {
        return $this->hasMany(Mahasiswa::class, 'id_programstudi', 'id_programstudi');
    }
}
