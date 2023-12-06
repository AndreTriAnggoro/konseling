<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    protected $primaryKey = 'nim';
    protected $fillable = [
        'nim',
        'semester1',
        'semester2',
        'semester3',
        'semester4',
        'semester5',
        'semester6',
        'semester7',
        'semester8',
        'ipk',
    ];

    
}
