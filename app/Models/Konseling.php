<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $table = "konseling";
    protected $primaryKey = "id_konseling";
    protected $fillable = [
        'id_konseling', 'id_jadwal', 'nim', 'nip_dosenwali', 'id_topik', 'tanggal', 'permasalahan', 'solusi', 'metode_konsultasi'
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }
 
    public function topikKonseling()
    {
        return $this->belongsTo(TopikKonseling::class, 'id_topik');
    }
}
