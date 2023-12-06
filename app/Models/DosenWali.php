<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenWali extends Model
{
    use HasFactory;

    protected $table = "dosenwali";
    protected $primaryKey = "nip_dosenwali";
    protected $fillable = [
        'nip_dosenwali', 'id_programstudi', 'nama', 'email', 'no_hp', 'alamat'
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'nip_dosenwali');
    }
    public function programstudi() {
        return $this->belongsTo(Programstudi::class, 'id_programstudi', 'id_programstudi');
    }

}
