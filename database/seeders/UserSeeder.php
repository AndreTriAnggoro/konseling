<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name'=>'admin',
            'username'=>'idadmin',
            'password'=>bcrypt('12345678')
        ]);
        $superadmin->assignRole('superadmin');

        $keuangan = User::create([
            'name'=>'keuangan',
            'username'=>'keuangan',
            'password'=>bcrypt('12345678')
        ]);
        $keuangan->assignRole('keuangan');

        $baak = User::create([
            'name'=>'baak',
            'username'=>'baak',
            'password'=>bcrypt('12345678')
        ]);
        $baak->assignRole('BAAK');

        $dosenwali = User::create([
            'name'=>'laurasari',
            'username'=>'9274371987',
            'password'=>bcrypt('12345678')
        ]);
        $dosenwali->assignRole('dosenwali');

        $kaprodi = User::create([
            'name'=>'vikasari',
            'username'=>'7272371785',
            'password'=>bcrypt('12345678')
        ]);
        $kaprodi->assignRole('kaprodi');

        $kajur = User::create([
            'name'=>'dwinovi',
            'username'=>'9274312818',
            'password'=>bcrypt('12345678')
        ]);
        $kajur->assignRole('kajur');

        $mahasiswa = User::create([
            'name'=>'andre',
            'username'=>'210202002',
            'password'=>bcrypt('12345678')
        ]);
        $mahasiswa->assignRole('mahasiswa');
    }
}
