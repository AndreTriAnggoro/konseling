<?php

namespace App\Http\Controllers;

use App\Models\DosenWali;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\Konseling;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\TopikKonseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class JadwalController extends Controller
{

    public function index()
    {
        $jadwal = Jadwal::all();
        $topikkonseling = TopikKonseling::all();
        $dosenwali = DosenWali::all();
        return view('buat_jadwal', compact('jadwal', 'topikkonseling', 'dosenwali'));
    }

    public function checkExpiredJadwal()
    {
        $expiredJadwals = Jadwal::where('status_verifikasi', 'dikirim')
            ->where('tanggal', '<', now()->toDateTimeString())
            ->get();

        foreach ($expiredJadwals as $jadwal) {
            $jadwal->status_verifikasi = 'Expired';
            $jadwal->save();
        }

        return response()->json(['message' => 'Proses pembaruan status jadwal expired telah selesai.']);
    }

    public function accNotifikasi($id_jadwal)
    {
        $notifikasi = Jadwal::findOrFail($id_jadwal);
        $notifikasi->status_verifikasi = 'Acc';
        $notifikasi->save();

        return redirect()->back();
    }

    public function batalkanJadwal($id_jadwal)
    {
        $notifikasi = Jadwal::findOrFail($id_jadwal);
        $notifikasi->status_verifikasi = 'Dibatalkan';
        $notifikasi->save();

        return redirect()->back();
    }

    public function selesaiNotifikasi($id_jadwal)
    {
        $notifikasi = Jadwal::findOrFail($id_jadwal);

        $permasalahan = request('permasalahan');
        $solusi = request('solusi');

        $inputData = [
            'id_jadwal' => $notifikasi->id_jadwal,
            'nim' => $notifikasi->nim,
            'nip_dosenwali' => $notifikasi->nip_dosenwali,
            'id_topik' => $notifikasi->id_topik,
            'tanggal' => $notifikasi->tanggal,
            'metode_konsultasi' => $notifikasi->metode_konsultasi,
            'permasalahan' => $permasalahan,
            'solusi' => $solusi,
        ];

        Konseling::create($inputData);

        $notifikasi->status_verifikasi = 'Selesai';
        $notifikasi->save();

        return redirect()->back();
    }

    public function tolakNotifikasi($id_jadwal)
    {
        $this->validate(request(), [
            'permasalahan' => 'required',
        ]);

        $notifikasi = Jadwal::findOrFail($id_jadwal);

        $notifikasi->deskripsi = request('permasalahan');
        $notifikasi->status_verifikasi = 'Tolak';
        $notifikasi->save();

        return redirect()->back();
    }

    public function jadwaldosen()
    {
        $jadwal = Jadwal::all();
        $dosenwali = DosenWali::all();
        $jadwalDosen = [];
        return view('jadwaldosen', compact('jadwal', 'dosenwali', 'jadwalDosen'));
    }

    public function lihatjadwaldosen(Request $request)
    {
        $validatedData = $request->validate([
            'dosen' => 'required',
            'tanggal' => 'date',
        ]);

        $selectedDosenId = $validatedData['dosen'];
        $selectedTanggal = $request->input('tanggal');

        // Query untuk mencari jadwal berdasarkan id dosen
        $query = Jadwal::where('nip_dosenwali', $selectedDosenId);

        // Jika tanggal telah diinputkan, tambahkan filter berdasarkan tanggal
        if (!empty($selectedTanggal)) {
            // Konversi tanggal ke format "Y-m-d"
            $selectedTanggalYMD = date('Y-m-d', strtotime($selectedTanggal));
            $query->whereDate('tanggal', $selectedTanggalYMD);
        }

        // Tambahkan filter untuk status_verifikasi 'Acc'
        $query->whereIn('status_verifikasi', ['Acc', 'dikirim']);

        // Ambil data semua dosen
        $dosenwali = DosenWali::all();

        // Ambil data jadwal sesuai dengan query yang sudah dibuat
        $jadwalDosen = $query->get();

        session(['dosen' => $request->input('dosen')]);
        session(['tanggal' => $request->input('tanggal')]);

        return view('jadwaldosen', compact('jadwalDosen', 'dosenwali'));
    }



    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'topik_konseling' => 'required',
            'metode' => 'required',
            'dosen_wali' => 'required',
            'tanggal' => 'required',
        ]);

        $waktuSekarang = now();

        $tanggalWaktu = Carbon::parse($validatedData['tanggal']);

        if ($tanggalWaktu <= $waktuSekarang) {
            // Tanggal dan waktu kurang dari atau sama dengan waktu sekarang
            return redirect()->back()->with('error', 'Tanggal dan waktu harus lebih dari waktu sekarang.');
        }


        $nim = auth()->user()->username;

        $dosenwali = DosenWali::where('nama', $validatedData['dosen_wali'])->first();
        $dosenId = DosenWali::where('nama', $validatedData['dosen_wali'])->value('nip_dosenwali');
        $topikKonseling = TopikKonseling::where('nama_topik', $validatedData['topik_konseling'])->first();
        // $tanggalWaktu = Carbon::parse($request->input('tanggal'));

        $existingJadwal = Jadwal::where('tanggal', $tanggalWaktu)
            ->where('status_verifikasi', 'Acc')
            ->first();

        if ($existingJadwal) {
            // Jadwal sudah ada, berikan pesan error
            return redirect()->back()->with('error', 'Maaf, pada tanggal dan jam tersebut sudah ada jadwal yang disetujui.');
        }

        $tolakanTerakhir = Jadwal::where('nim', $nim)
            ->where('nip_dosenwali', $dosenId)
            ->where('status_verifikasi', 'Tolak')
            ->where('updated_at', '>=', now()->subMinutes(5))
            ->exists();

        if ($tolakanTerakhir) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan membuat jadwal ke dosen ini dalam 5 menit setelah penolakan terakhir.');
        }

        // Simpan data ke dalam tabel jadwal (gunakan model yang sesuai)
        $jadwal = new Jadwal();
        $jadwal->nim = $nim;
        $jadwal->id_topik = $topikKonseling->id_topik;
        $jadwal->metode_konsultasi = $validatedData['metode'];
        $jadwal->nip_dosenwali = $dosenwali->nip_dosenwali;
        $jadwal->tanggal = $tanggalWaktu;
        $jadwal->save();

        session()->flash('success', 'Pembuatan jadwal berhasil!');
        // Redirect atau lakukan tindakan sesuai dengan kebutuhan Anda
        return redirect()->back();
    }

    public function tampilkanDashboard()
    {
        $user = Auth::user();

        if ($user->hasRole('mahasiswa')) {
            $selesaiKonseling = Jadwal::with(['mahasiswa', 'topikkonseling'])
                ->where('status_verifikasi', 'Selesai')
                ->where('nim', $user->username)
                ->get();


            $AccKonseling = Jadwal::with(['mahasiswa', 'topikkonseling'])
                ->where('status_verifikasi', 'Acc')
                ->where('nim', $user->username)
                ->get();

            $now = now();
            $comingSoonJadwals = $AccKonseling->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return ($tanggalJadwal->year === $now->year && $tanggalJadwal->month === $now->month && $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute > $now->minute || $tanggalJadwal->hour > $now->hour) ||
                    ($tanggalJadwal->year === $now->year && $tanggalJadwal->month === $now->month && $tanggalJadwal->day > $now->day)) &&
                    $jadwal->nim == Auth::user()->username;;
            });

            $sedangBerlangsung = $AccKonseling->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return $tanggalJadwal->year === $now->year &&
                    $tanggalJadwal->month === $now->month &&
                    $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute < $now->minute || $tanggalJadwal->hour < $now->hour) &&
                    $jadwal->nim == Auth::user()->username;
            });

            return view('dashboard', compact('selesaiKonseling', 'comingSoonJadwals', 'sedangBerlangsung'));
        } elseif ($user->hasRole('dosenwali')) {
            $statusDitampilkan = ['dikirim', 'Acc', 'Tolak', 'Selesai', 'Dibatalkan', 'Expired'];
            $jadwalKonseling = Jadwal::with(['mahasiswa', 'topikkonseling'])
                ->whereIn('status_verifikasi', $statusDitampilkan)
                ->where('nip_dosenwali', $user->username)
                ->get();

            $permintaanKonseling = $jadwalKonseling->where('status_verifikasi', 'dikirim');
            $selesai = $jadwalKonseling->where('status_verifikasi', 'Selesai');
            $tolak = $jadwalKonseling->where('status_verifikasi', 'Tolak');
            $expired = $jadwalKonseling->where('status_verifikasi', 'Expired');

            $now = now();
            $AccKonseling = $jadwalKonseling->where('status_verifikasi', 'Acc');

            $sedangBerlangsung = $AccKonseling->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return $tanggalJadwal->year === $now->year &&
                    $tanggalJadwal->month === $now->month &&
                    $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute < $now->minute || $tanggalJadwal->hour < $now->hour) &&
                    $jadwal->nip_dosenwali == Auth::user()->username;
            });

            $comingSoonJadwals = $AccKonseling->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return ($tanggalJadwal->year === $now->year && $tanggalJadwal->month === $now->month && $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute > $now->minute || $tanggalJadwal->hour > $now->hour) ||
                    ($tanggalJadwal->year === $now->year && $tanggalJadwal->month === $now->month && $tanggalJadwal->day > $now->day)) &&
                    $jadwal->nip_dosenwali == Auth::user()->username;;
            });

            return view('dashboard_dosen', compact('permintaanKonseling', 'AccKonseling', 'selesai', 'tolak', 'sedangBerlangsung', 'comingSoonJadwals', 'expired'));
        } elseif ($user->hasRole('kaprodi')) {
            return view('dashboard_kaprodi');
        } elseif ($user->hasRole('superadmin')) {


            // Ambil data pembayaran yang belum diverifikasi
            $pembayaranBelumDiverifikasi = Pembayaran::where('status_pembayaran', 'Dalam Proses')->get();

            return view('dashboard_admin', ['pembayaranBelumDiverifikasi' => $pembayaranBelumDiverifikasi]);
        } elseif ($user->hasRole('keuangan')) {

            $belumBayar = Pembayaran::where('status_pembayaran', 'Belum Bayar')->get();
            $dalamProses = Pembayaran::where('status_pembayaran', 'Dalam Proses')->get();
            $Lunas = Pembayaran::where('status_pembayaran', 'Lunas')->get();

            $jumlahBelumBayar = $belumBayar->count();
            $jumlahDalamProses = $dalamProses->count();
            $jumlahLunas = $Lunas->count();

            $pembayaranBelumDiverifikasi = Pembayaran::where('status_pembayaran', 'Dalam Proses')->get();

            return view('dashboard_keuangan', compact('belumBayar', 'dalamProses', 'Lunas', 'jumlahBelumBayar', 'jumlahDalamProses', 'jumlahLunas', 'pembayaranBelumDiverifikasi'));
        } elseif ($user->hasRole('BAAK')) {

            $now = now();
            $jadwalKonseling = Jadwal::with(['mahasiswa', 'topikkonseling'])
                ->where('status_verifikasi', 'Acc')
                ->get();

            $sedangBerlangsung = $jadwalKonseling->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return $tanggalJadwal->year === $now->year &&
                    $tanggalJadwal->month === $now->month &&
                    $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute < $now->minute || $tanggalJadwal->hour < $now->hour);
            });

            $jumlahMahasiswa = Mahasiswa::count();
            $jumlahDosen = DosenWali::count();
            $jumlahSelesaiKonseling = Konseling::count();

            $Konseling = Konseling::all(); // Gantilah dengan model dan metode sesuai dengan aplikasi Anda

            // Inisialisasi total waktu dan jumlah sesi konseling
            $totalDurasi = 0;
            $jumlahSesiKonseling = 0;

            foreach ($Konseling as $jadwal) {
                // Hitung durasi sesi konseling menggunakan Carbon
                $durasiSesi = Carbon::parse($jadwal->updated_at)->diffInSeconds($jadwal->tanggal);

                // Tambahkan ke total durasi
                $totalDurasi += $durasiSesi;

                // Tingkatkan jumlah sesi konseling
                $jumlahSesiKonseling++;
            }

            // Hitung rata-rata durasi konseling dalam detik
            $rataRataDurasi = $jumlahSesiKonseling > 0 ? ($totalDurasi / $jumlahSesiKonseling) : 0;

            // Konversi rata-rata waktu ke format yang sesuai (misalnya, jam:menit:detik)
            $rataRataDurasiFormat = sprintf(
                '%s%s',
                $rataRataDurasi >= 3600 ? sprintf('%02d jam ', ($rataRataDurasi / 3600)) : '',
                $rataRataDurasi >= 60 ? sprintf('%02d menit ', ($rataRataDurasi % 3600 / 60)) : '',
            );

            return view('dashboard_baak', compact('jumlahMahasiswa', 'jumlahDosen', 'jumlahSelesaiKonseling', 'sedangBerlangsung', 'rataRataDurasiFormat'));
        } elseif ($user->hasRole('kajur')) {
            return view('dashboard_kajur');
        }
    }
}
