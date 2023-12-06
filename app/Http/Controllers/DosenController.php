<?php

namespace App\Http\Controllers;

use App\Models\DosenWali;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Programstudi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = DosenWali::with('programstudi')->get();
        return view('dosen', compact('dosen'));
    }

    public function selesaik()
    {
        $user = Auth::user();
        $selesai = Jadwal::with(['mahasiswa', 'topikkonseling', 'konseling'])
            ->where('status_verifikasi', 'Selesai')
            ->where('nip_dosenwali', $user->username)
            ->paginate(3);

        return view('selesai_konseling_dosen', compact('selesai'));
    }

    public function berlangsungk()
    {
        $now = now();
        $sedangBerlangsung = Jadwal::with(['mahasiswa', 'topikkonseling'])
            ->where('status_verifikasi', 'Acc')
            ->where('nip_dosenwali', Auth::user()->username)
            ->get()
            ->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return $tanggalJadwal->year === $now->year &&
                    $tanggalJadwal->month === $now->month &&
                    $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute < $now->minute || $tanggalJadwal->hour < $now->hour) &&
                    $jadwal->nip_dosenwali == Auth::user()->username;
            });

        return view('berlangsung_konseling_dosen', compact('sedangBerlangsung'));
    }

    public function permintaank()
    {
        $user = Auth::user();
        $permintaanKonseling = Jadwal::with(['mahasiswa', 'topikkonseling'])
            ->where('status_verifikasi', 'dikirim')
            ->where('nip_dosenwali', $user->username)
            ->get();
        return view('permintaan_konseling_dosen', compact('permintaanKonseling'));
    }

    public function comingsonk()
    {
        $now = now();
        $comingSoonJadwals = Jadwal::with(['mahasiswa', 'topikkonseling'])
            ->where('status_verifikasi', 'Acc')
            ->where('nip_dosenwali', Auth::user()->username)
            ->get()
            ->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return ($tanggalJadwal->year === $now->year && $tanggalJadwal->month === $now->month && $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute > $now->minute || $tanggalJadwal->hour > $now->hour) ||
                    ($tanggalJadwal->year === $now->year && $tanggalJadwal->month === $now->month && $tanggalJadwal->day > $now->day));
            });

        return view('comingson_konseling_dosen', compact('comingSoonJadwals'));
    }

    public function comingSoon(Request $request)
    {
        // Mendapatkan nilai filter dari permintaan
        $filter = $request->input('filter', 'terdekat');

        // Mengambil jadwals dengan filter yang sesuai
        $comingSoonJadwals = Jadwal::where('tanggal', '>', Carbon::now())
            ->where('status_verifikasi', 'Acc');

        if ($filter == 'terdekat') {
            // Mengurutkan berdasarkan selisih waktu terdekat
            $comingSoonJadwals = $comingSoonJadwals->orderBy('tanggal');
        }

        // Menyertakan get() untuk mengeksekusi permintaan dan mendapatkan hasil
        $comingSoonJadwals = $comingSoonJadwals->get();

        // Menampilkan hasil dalam view
        return view('comingson_konseling_dosen', compact('comingSoonJadwals'));
    }

    public function tolakk()
    {
        $tolak = Jadwal::where('status_verifikasi', 'Tolak')->paginate(5);

        return view('tolak_konseling_dosen', compact('tolak'));
    }

    public function expiredk()
    {
        $expired = Jadwal::where('status_verifikasi', 'Expired')->paginate(5);

        return view('expired_konseling_dosen', compact('expired'));
    }

    public function create()
    {
        $programstudi = Programstudi::all();
        return view('tambah_dosen', compact('programstudi'));
    }

    public function edit($nip_dosenwali)
    {
        $dosen = DosenWali::find($nip_dosenwali);
        $programstudi = ProgramStudi::all();

        return view('editdosenwali', compact('dosen', 'programstudi'));
    }

    public function destroy($nip_dosenwali)
    {
        // Cari mahasiswa berdasarkan ID
        $dosen = DosenWali::find($nip_dosenwali);

        // Hapus mahasiswa jika ditemukan
        if ($dosen) {
            $dosen->delete();
            // Redirect ke halaman daftar mahasiswa atau halaman lain yang sesuai
            return redirect()->route('dosen');
        } else {
            // Tampilkan pesan error jika mahasiswa tidak ditemukan
            abort(404, 'Dosen not found.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip_dosenwali' => 'required|unique:dosenwali,nip_dosenwali',
            'nama' => 'required',
            'id_programstudi' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
        ]);


        // Simpan data mahasiswa ke database
        $dosen = new DosenWali();
        $dosen->nip_dosenwali = $request->input('nip_dosenwali');
        $dosen->nama = $request->input('nama');
        $dosen->id_programstudi = $request->input('id_programstudi');
        $dosen->alamat = $request->input('alamat');
        $dosen->email = $request->input('email');
        $dosen->no_hp = $request->input('no_hp');
        // Simpan data ke database
        $dosen->save();

        $user = new User();
        $user->name = $request->input('nama');
        $user->username = $request->input('nip_dosenwali');
        $user->password = bcrypt('12345678');
        $user->save();

        $user->assignRole('dosenwali');

        // event(new CreateMahasiswaUser($mahasiswa));

        return redirect()->route('dosen')->with('success', 'Data mahasiswa berhasil disimpan.');
    }
    public function update(Request $request, $nip_dosenwali)
    {
        $request->validate([
            'nip_dosenwali' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'id_programstudi' => 'required',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        $dosen = DosenWali::findOrFail($nip_dosenwali);

        $dosen->nip_dosenwali = $request->input('nip_dosenwali');
        $dosen->nama = $request->input('nama');
        $dosen->id_programstudi = $request->input('id_programstudi');
        $dosen->alamat = $request->input('alamat');
        $dosen->email = $request->input('email');
        $dosen->no_hp = $request->input('no_hp');

        $dosen->save();

        // $user = User::findOrFail($nip_dosenwali);

        // $user->name = $request->input('nama');
        // $user->username = $request->input('nip_dosenwali');
        // $user->password = bcrypt('12345678');
        // $user->save();

        return redirect()->route('dosen');
    }
}
