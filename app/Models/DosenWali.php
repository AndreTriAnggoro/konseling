<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenWali extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "dosenwali";
    protected $primaryKey = "nip_dosenwali";
    protected $fillable = [
        'nip_dosenwali', 'id_programstudi', 'nama', 'email', 'no_hp', 'alamat'
    ];

    public function getStatus()
    {
        if ($this->trashed()) {
            return 'Dosen sudah dihapus (soft delete)';
        } else {
            return 'Dosen masih aktif';
        }
    }

    public function getTanggalLahirAttribute($value)
    {
        // Ubah format tanggal menjadi hari-bulan-tahun
        return date('d-m-Y', strtotime($value));
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'nip_dosenwali');
    }
    public function programstudi() {
        return $this->belongsTo(Programstudi::class, 'id_programstudi', 'id_programstudi');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'nip_dosenwali', 'username');
    }

}
