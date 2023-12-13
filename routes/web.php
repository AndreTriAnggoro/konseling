<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Models\Mahasiswa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('logout');
})->middleware(['auth', 'verified'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dosen', [DosenController::class, 'index'])->name('dosen')->middleware('permission:manage-dosen');
    Route::get('mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create')->middleware('permission:tambah-mahasiswa');
    Route::get('dosen/create', [DosenController::class, 'create'])->name('dosen.create')->middleware('permission:tambah-dosen');
    Route::post('mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store')->middleware('permission:tambah-mahasiswa');
    Route::post('dosen/store', [DosenController::class, 'store'])->name('dosen.store')->middleware('permission:tambah-dosen');
    Route::get('mahasiswa/{nim}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit')->middleware('permission:edit-mahasiswa');
    Route::get('dosen/{id}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::put('mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update')->middleware('permission:edit-mahasiswa');
    Route::put('dosen/{id}', [DosenController::class, 'update'])->name('dosen.update')->middleware('permission:edit-dosen');
    Route::delete('mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy')->middleware('permission:hapus-mahasiswa');
    Route::get('mahasiswa/{id}', [MahasiswaController::class, 'restore'])->name('mahasiswa.restore');
    Route::get('dosen/{id}', [DosenController::class, 'restore'])->name('dosen.restore');
    Route::delete('dosen/{id}', [DosenController::class, 'destroy'])->name('dosen.destroy');
    Route::get('/get-kelas', [MahasiswaController::class, 'getKelas'])->name('get-kelas');
    Route::get('/notifikasi-dosenwali', [JadwalController::class, 'notifdosen'])->name('notif.dosen');
    // Route::get('/buat-jadwal-konseling', [MahasiswaController::class, 'buatjadwal'])->name('buat.jadwal');

    Route::get('/dashboard', [JadwalController::class, 'tampilkanDashboard'])->name('dashboard');

    Route::get('mahasiswa/search', [MahasiswaController::class, 'search'])->name('mahasiswa.search');

    Route::get('/buat-jadwal-konseling', [JadwalController::class, 'index'])->name('buat.jadwal');
    Route::get('/jadwal-konseling-dosen', [JadwalController::class, 'jadwaldosen'])->name('jadwal.dosen');
    Route::get('/lihat-jadwal-konseling-dosen', [JadwalController::class, 'lihatjadwaldosen'])->name('lihat.jadwal.dosen');
    Route::post('/form-jadwal-konseling', [JadwalController::class, 'store'])->name('form.jadwal');
    Route::get('/notifikasi', [JadwalController::class, 'notifikasiDosen'])->name('notifikasi.dosen');
    // Route::post('/notifikasi', [JadwalController::class, 'notifikasiDosen'])->name('notifikasi.dosen');

    Route::post('/chat/send', [ChatController::class, 'send'])->name('send.chat');
    Route::get('/chat/{jadwal_id}', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat-selesai/{jadwal_id}', [ChatController::class, 'bukachat'])->name('chat-selesai');
    Route::get('/get/chat/{jadwal_id}', [ChatController::class, 'getChat'])->name('get.chat');
    Route::get('/get-status-verifikasi/{jadwal_id}', [ChatController::class, 'getStatusVerifikasi'])->name('get.status.verifikasi');
    Route::get('/get-konseling-detail', [ChatController::class, 'getKonselingDetail'])->name('get.konseling.detail');

    Route::post('/acc-notifikasi/{id}', [JadwalController::class, 'accNotifikasi'])->name('acc-notifikasi');
    Route::post('/batalkan-notifikasi/{id}', [JadwalController::class, 'batalkanJadwal'])->name('batal-notifikasi');
    Route::post('/tolak-notifikasi/{id}', [JadwalController::class, 'tolakNotifikasi'])->name('tolak-notifikasi');
    Route::post('/selesai-notifikasi/{id_jadwal}', [JadwalController::class, 'selesaiNotifikasi'])->name('selesai-notifikasi');
    Route::get('/check-expired-jadwal', [JadwalController::class, 'checkExpiredJadwal']);

    Route::post('/import-mahasiswa', [ImportController::class, 'import'])->name('import');
    Route::post('/import-nilai-mahasiswa', [ImportController::class, 'importNilai'])->name('importNilai');
    Route::post('/import-dosen', [ImportController::class, 'importdosen'])->name('import.dosen');

    // routes/web.php
    Route::get('get/konseling/selesai/detail', [JadwalController::class, 'getKonselingSelesaiDetail'])->name('get.konseling.selesai.detail');
    Route::get('/lihat-semua-riwayat-mahasiswa', [MahasiswaController::class, 'riwayatk'])->name('lihat.semua.riwayat.mhs');
    Route::get('/lihat-semua-selesai-dosen', [DosenController::class, 'selesaik'])->name('lihat.semua.selesai.dosen');
    Route::get('/lihat-semua-permintaan-dosen', [DosenController::class, 'permintaank'])->name('lihat.semua.permintaan.dosen');
    Route::get('/lihat-semua-berlangsung-dosen', [DosenController::class, 'berlangsungk'])->name('lihat.semua.berlangsung.dosen');
    Route::get('/lihat-semua-comingson-dosen', [DosenController::class, 'comingsonk'])->name('lihat.semua.comingson.dosen');
    Route::get('/lihat-semua-tolak-dosen', [DosenController::class, 'tolakk'])->name('lihat.semua.tolak.dosen');
    Route::get('/lihat-semua-expired-dosen', [DosenController::class, 'expiredk'])->name('lihat.semua.expired.dosen');
    Route::get('/lihat-semua-berlangsung-mhs', [MahasiswaController::class, 'berlangsungk'])->name('lihat.semua.berlangsung.mhs');

    Route::get('/coming-soon', [DosenController::class, 'comingSoon'])->name('coming-soon');
    Route::post('/upload-image', [ChatController::class, 'uploadImage'])->name('upload.image');

    Route::get('/nilai-mahasiswa', [MahasiswaController::class, 'nilai'])->name('nilai.mahasiswa')->middleware('permission:kelola-nilai');

    Route::get('/mahasiswa/upload/bukti/ukt', [MahasiswaController::class, 'uploadBukti'])->name('mahasiswa.upload.bukti.ukt');

    Route::post('/mahasiswa/upload', [MahasiswaController::class, 'upload'])->name('mahasiswa.upload');

    Route::get('/admin/dashboard', [MahasiswaController::class, 'showUnverifiedPayments'])->name('admin.dashboard');
    Route::get('/admin/lunas/{id_pembayaran}', [MahasiswaController::class, 'Lunas'])->name('admin.lunas');
    Route::get('/admin/tidakLunas/{id_pembayaran}', [MahasiswaController::class, 'tidakLunas'])->name('admin.tidakLunas');
    
    Route::get('/ukt/mahasiswa', [MahasiswaController::class, 'mahasiswaUkt'])->name('ukt.mahasiswa');

    Route::get('/ukt/belum/bayar', [MahasiswaController::class, 'uktbelumbayar'])->name('ukt.belum.bayar');
    Route::get('/ukt/diproses', [MahasiswaController::class, 'uktdiproses'])->name('ukt.diproses');
    Route::get('/ukt/lunas', [MahasiswaController::class, 'uktlunas'])->name('ukt.lunas');

    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa');
    Route::get('/mahasiswa/inactive', [MahasiswaController::class, 'inactive'])->name('mahasiswa.inactive');
    Route::get('/dosen/inactive', [DosenController::class, 'inactive'])->name('dosen.inactive');

    Route::patch('/update-status-pembayaran/{id}', [MahasiswaController::class, 'updateStatusPembayaran'])->name('update_status_pembayaran');
});


Route::get('/dashboard/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

require __DIR__ . '/auth.php';
