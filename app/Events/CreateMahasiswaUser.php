<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateMahasiswaUser
{
    use Dispatchable, SerializesModels;

    public $mahasiswa;

    public function __construct($mahasiswa)
    {
        $this->mahasiswa = $mahasiswa;
    }
}
