<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name'=>'lihat-mahasiswa']);
        Permission::create(['name'=>'tambah-mahasiswa']);
        Permission::create(['name'=>'edit-mahasiswa']);
        Permission::create(['name'=>'hapus-mahasiswa']);

        Permission::create(['name'=>'tambah-jadwal']);
        Permission::create(['name'=>'buat-jadwal']);
        
        Permission::create(['name'=>'acc-mahasiswa']);
        Permission::create(['name'=>'manage-mahasiswa']);

        Permission::create(['name'=>'manage-dosen']);
        Permission::create(['name'=>'tambah-dosen']);
        Permission::create(['name'=>'edit-dosen']);
        Permission::create(['name'=>'hapus-dosen']);

        Permission::create(['name'=>'kelola-ukt']);
        Permission::create(['name'=>'kelola-nilai']);

        Role::create(['name'=>'superadmin']);
        Role::create(['name'=>'mahasiswa']);
        Role::create(['name'=>'dosenwali']);
        Role::create(['name'=>'kaprodi']);
        Role::create(['name'=>'kajur']);
        Role::create(['name'=>'keuangan']);
        Role::create(['name'=>'BAAK']);

        $roleSuperadmin = Role::findByName('superadmin');
        $roleSuperadmin->givePermissionTo('lihat-mahasiswa');
        $roleSuperadmin->givePermissionTo('tambah-mahasiswa');
        $roleSuperadmin->givePermissionTo('edit-mahasiswa');
        $roleSuperadmin->givePermissionTo('hapus-mahasiswa');
        $roleSuperadmin->givePermissionTo('manage-mahasiswa');
        $roleSuperadmin->givePermissionTo('manage-dosen');
        $roleSuperadmin->givePermissionTo('tambah-dosen');
        $roleSuperadmin->givePermissionTo('edit-dosen');
        $roleSuperadmin->givePermissionTo('hapus-dosen');

        $roleDosenwali = Role::findByName('dosenwali');
        $roleDosenwali->givePermissionTo('lihat-mahasiswa');
        $roleDosenwali->givePermissionTo('tambah-mahasiswa');
        $roleDosenwali->givePermissionTo('edit-mahasiswa');
        $roleDosenwali->givePermissionTo('hapus-mahasiswa');
        $roleDosenwali->givePermissionTo('manage-mahasiswa');
        $roleDosenwali->givePermissionTo('acc-mahasiswa');
        $roleDosenwali->givePermissionTo('kelola-nilai');

        $roleKaprodi = Role::findByName('kaprodi');
        $roleKaprodi->givePermissionTo('lihat-mahasiswa');
        $roleKaprodi->givePermissionTo('tambah-mahasiswa');
        $roleKaprodi->givePermissionTo('edit-mahasiswa');
        $roleKaprodi->givePermissionTo('manage-mahasiswa');

        $roleKajur = Role::findByName('kajur');
        $roleKajur->givePermissionTo('lihat-mahasiswa');
        $roleKajur->givePermissionTo('manage-mahasiswa');

        $roleMahasiswa = Role::findByName('mahasiswa');
        $roleMahasiswa->givePermissionTo('tambah-jadwal');
        $roleMahasiswa->givePermissionTo('buat-jadwal');
        
        $roleMahasiswa = Role::findByName('keuangan');
        $roleMahasiswa->givePermissionTo('kelola-ukt');

        $roleMahasiswa = Role::findByName('BAAK');
        $roleMahasiswa->givePermissionTo('kelola-nilai');
    }
}
