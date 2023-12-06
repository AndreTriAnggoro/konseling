<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikKonseling extends Model
{
    // use HasFactory;

    protected $table = "topikkonseling";
    protected $primaryKey = "id_topik";
    protected $fillable = [
        'id_topik', 'nama_topik',
    ];

    
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_topik');
    }
}
