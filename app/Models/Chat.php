<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $fillable = ['id', 'jadwal_id', 'message', 'image', 'pelaku',];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id_jadwal');
    }
}
