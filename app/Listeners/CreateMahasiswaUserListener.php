<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\CreateMahasiswaUser;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateMahasiswaUserListener implements ShouldQueue
{
    public function handle(CreateMahasiswaUser $event)
    {
        $mahasiswa = $event->mahasiswa;

        $user = new User();
        $user->name = $mahasiswa->nama;
        $user->username = $mahasiswa->nim;
        $user->password = bcrypt('12345678');
        $user->save();
    }
}
