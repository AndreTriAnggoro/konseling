<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = "id_pembayaran";
    protected $fillable = [
        'id_pembayaran',
        'nim',
        'jumlah_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
        'bukti_pembayaran',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
