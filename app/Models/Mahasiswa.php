<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primaryKey = "nim";
    protected $fillable = [
        'nim', 'id_programstudi', 'nama', 'alamat', 'jenis_kelamin', 'email', 'no_hp', 'created_at', 'updated_at',
    ];

    public function getTanggalLahirAttribute($value)
    {
        // Ubah format tanggal menjadi hari-bulan-tahun
        return date('d-m-Y', strtotime($value));
    }

    public function programstudi()
    {
        return $this->belongsTo(Programstudi::class, 'id_programstudi', 'id_programstudi');
    }
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'nim');
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'nim', 'nim');
    }
}
