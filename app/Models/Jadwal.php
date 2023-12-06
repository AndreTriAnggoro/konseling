<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    //use HasFactory;

    protected $table = "jadwalkonseling";
    protected $primaryKey = "id_jadwal";
    protected $fillable = [
        'id_jadwal', 'nim', 'nip_dosenwali', 'id_topik', 'tanggal', 'status_verifikasi', 'metode_konsultasi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    public function topikKonseling()
    {
        return $this->belongsTo(TopikKonseling::class, 'id_topik');
    }

    public function dosenWali()
    {
        return $this->belongsTo(DosenWali::class, 'nip_dosenwali');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'jadwal_id', 'id_jadwal');
    }

    public function konseling()
    {
        return $this->belongsTo(Konseling::class, 'id_jadwal', 'id_jadwal');
    }

}
