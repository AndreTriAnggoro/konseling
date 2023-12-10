<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Programstudi;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Nilai;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function uktlunas()
    {
        $pembayaranLunas = Pembayaran::where('status_pembayaran', 'Lunas')->get();
        return view('uktLunas', compact('pembayaranLunas'));
    }
    public function tes()
    {
        return view('app/tes');
    }
    public function uktdiproses()
    {
        $pembayaranDiproses = Pembayaran::where('status_pembayaran', 'Dalam Proses')->get();
        return view('uktDiproses', compact('pembayaranDiproses'));
    }
    public function uktbelumbayar()
    {
        $pembayaranBelumDiverifikasi = Pembayaran::where('status_pembayaran', 'Belum Bayar')->get();
        return view('uktBelumVerif', compact('pembayaranBelumDiverifikasi'));
    }
    public function index()
    {
        $mahasiswa = Mahasiswa::with('programstudi')->paginate(15);
        return view('mahasiswa', compact('mahasiswa'));
    }

    public function inactive()
    {
        $mahasiswaInactive = Mahasiswa::onlyTrashed()->with('programstudi')->get();
        return view('mahasiswa_tidak_aktif', compact('mahasiswaInactive'));
    }

    public function verifikasi($id_pembayaran)
    {
        $notifikasi = Pembayaran::findOrFail($id_pembayaran);
        $notifikasi->status_pembayaran = 'Lunas';
        $notifikasi->save();

        return redirect()->back();
    }

    public function berlangsungk()
    {
        $now = now();
        $sedangBerlangsung = Jadwal::with(['mahasiswa', 'topikkonseling'])
            ->where('status_verifikasi', 'Acc')
            ->where('nim', Auth::user()->username)
            ->get()
            ->filter(function ($jadwal) use ($now) {
                $tanggalJadwal = Carbon::parse($jadwal->tanggal);

                return $tanggalJadwal->year === $now->year &&
                    $tanggalJadwal->month === $now->month &&
                    $tanggalJadwal->day === $now->day &&
                    ($tanggalJadwal->hour === $now->hour && $tanggalJadwal->minute < $now->minute || $tanggalJadwal->hour < $now->hour) &&
                    $jadwal->nim == Auth::user()->username;
            });

        return view('berlangsung_konseling_mhs', compact('sedangBerlangsung'));
    }

    public function riwayatk(Request $request)
    {
        // ... kode lainnya untuk mendapatkan data jadwalKonseling ...

        $user = Auth::user();
        $statusDitampilkan = ['Selesai'];

        $searchColumn = $request->input('search_column', 'nama'); // Kolom pencarian default

        // Menggunakan when method untuk menangani pencarian
        $jadwalKonseling = Jadwal::with(['mahasiswa', 'topikkonseling'])
            ->whereIn('status_verifikasi', $statusDitampilkan)
            ->when($request->filled('search_query'), function ($query) use ($request, $searchColumn) {
                switch ($searchColumn) {
                    case 'metode_konsultasi':
                        $query->where('metode_konsultasi', 'LIKE', "%{$request->input('search_query')}%");
                        break;
                    case 'waktu':
                        $query->where('tanggal', 'LIKE', "%{$request->input('search_query')}%");
                        break;
                    case 'nama_topik':
                        $query->whereHas('topikkonseling', function ($subQuery) use ($request) {
                            $subQuery->where('nama_topik', 'LIKE', "%{$request->input('search_query')}%");
                        });
                        break;
                        // Tambahkan case untuk kolom lainnya sesuai kebutuhan
                }
            })
            ->where('nim', $user->username)
            ->paginate(3);

        return view('riwayat_konseling_mhs', compact('jadwalKonseling'));
    }

    //daterangepicker


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programstudi = Programstudi::all();
        return view('tambah_mahasiswa', compact('programstudi'));
    }

    public function nilai()
    {
        $nilai = Nilai::paginate(15);
        return view('nilai_mahasiswa', compact('nilai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim melalui formulir
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'nama' => 'required',
            'id_programstudi' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email',
            'no_hp' => 'required',
        ]);


        // Simpan data mahasiswa ke database
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim = $request->input('nim');
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->id_programstudi = $request->input('id_programstudi');
        $mahasiswa->alamat = $request->input('alamat');
        $mahasiswa->jenis_kelamin = $request->input('jenis_kelamin');
        $mahasiswa->email = $request->input('email');
        $mahasiswa->no_hp = $request->input('no_hp');
        // Simpan data ke database
        $mahasiswa->save();

        $user = new User();
        $user->name = $request->input('nama');
        $user->username = $request->input('nim');
        $user->password = bcrypt('12345678');
        $user->save();

        $user->assignRole('mahasiswa');

        $pembayaran = new Pembayaran();
        $pembayaran->nim = $request->input('nim');
        $pembayaran->save();

        // event(new CreateMahasiswaUser($mahasiswa));

        return redirect()->route('mahasiswa')->with('success', 'Data mahasiswa berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::find($id_mahasiswa);
        $programstudi = ProgramStudi::all();

        return view('editmahasiswa', compact('mahasiswa', 'programstudi'));
    }

    public function update(Request $request, $nim)
    {
        $request->validate([
            'nim' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'id_programstudi' => 'required',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', // Menggunakan validasi 'in' untuk memastikan nilai jenis kelamin adalah 'L' atau 'P'
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($nim);

        $mahasiswa->nim = $request->input('nim');
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->id_programstudi = $request->input('id_programstudi');
        $mahasiswa->alamat = $request->input('alamat');
        $mahasiswa->jenis_kelamin = $request->input('jenis_kelamin');
        $mahasiswa->email = $request->input('email');
        $mahasiswa->no_hp = $request->input('no_hp');

        $mahasiswa->save();

        $user = User::where('username', $nim)->first();
        $user->name = $request->input('nama');
        $user->save();

        // Kembali ke halaman "mahasiswa.blade.php" dengan data mahasiswa yang telah diperbarui
        $mahasiswa = Mahasiswa::all();

        return view('mahasiswa', compact('mahasiswa'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nim)
    {
        // Cari mahasiswa berdasarkan nim
        $mahasiswa = Mahasiswa::with('user')->find($nim);

        // Hapus mahasiswa dan pengguna jika ditemukan
        if ($mahasiswa) {
            // Hapus pengguna terkait
            if ($mahasiswa->user) {
                User::where('username', $mahasiswa->user->username)->delete();
            }

            // Hapus mahasiswa
            $mahasiswa->delete();

            // Redirect ke halaman daftar mahasiswa atau halaman lain yang sesuai
            return redirect()->route('mahasiswa');
        } else {
            // Tampilkan pesan error jika mahasiswa tidak ditemukan
            abort(404, 'Mahasiswa not found.');
        }
    }
    public function restore($nim)
    {
        // Lakukan proses restore mahasiswa berdasarkan nim
        Mahasiswa::withTrashed()->where('nim', $nim)->restore();

        // Dapatkan data mahasiswa yang sudah di-restore
        $mahasiswaRestored = Mahasiswa::find($nim);

        // Jika mahasiswa ditemukan, lakukan proses pengembalian data user
        if ($mahasiswaRestored) {
            // Dapatkan atau buat user baru berdasarkan username (nim)
            $user = User::firstOrNew(['username' => $mahasiswaRestored->nim]);

            // Isi kolom name dengan data nama dari tabel mahasiswa
            $user->name = $mahasiswaRestored->nama;

            // Isi kolom password dengan password default (Anda bisa menggunakan Hash::make('12345678') jika menggunakan Laravel Hashing)
            $user->password = bcrypt('12345678');
            // Tambahkan proses pengembalian data user sesuai kebutuhan
            // ...

            // Simpan perubahan pada data user
            $user->save();
            $user->assignRole('mahasiswa');
        }

        // Redirect kembali ke halaman mahasiswa tidak aktif
        $mahasiswaInactive = Mahasiswa::onlyTrashed()->with('programstudi')->get();
        return view('mahasiswa_tidak_aktif', compact('mahasiswaInactive'));
    }

    public function __construct()
    {
        $this->middleware('permission:lihat-mahasiswa')->only('index');
        $this->middleware('permission:tambah-mahasiswa')->only('create', 'store');
        $this->middleware('permission:edit-mahasiswa')->only('edit', 'update');
        $this->middleware('permission:hapus-mahasiswa')->only('destroy');
    }

    public function showUploadForm()
    {
        return view('upload');
    }

    public function mahasiswaUkt(Request $request)
    {
        $query = Pembayaran::query();

        if ($request->has('search')) {
            $searchTerm = '%' . $request->input('search') . '%';

            $query->where('nim', 'LIKE', $searchTerm)
                ->orWhere('jumlah_pembayaran', 'LIKE', $searchTerm)
                ->orWhere('status_pembayaran', 'LIKE', $searchTerm)
                ->orWhere('tanggal_pembayaran', 'LIKE', $searchTerm);
        }

        $pembayaranUktMahasiswa = $query->get();

        return view('mahasiswa_ukt', compact('pembayaranUktMahasiswa'));
    }

    public function upload(Request $request)
    {
        // Validasi file dan data lainnya
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,png|max:2048',
            'jumlah_pembayaran' => 'required|numeric',
            'tanggal_pembayaran' => 'required|date',
            // Tambahkan validasi lain sesuai kebutuhan Anda
        ]);

        // Simpan file bukti pembayaran
        $file = $request->file('file');
        $fileNama = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileNama);

        // Ambil NIM dari username pengguna yang sedang login
        $nim = Auth::user()->username;

        // Simpan data ke dalam tabel pembayaran
        Pembayaran::create([
            'nim' => $nim,
            'jumlah_pembayaran' => $request->input('jumlah_pembayaran'),
            'status_pembayaran' => 'Dalam Proses', // Status default saat pengunggahan
            'tanggal_pembayaran' => $request->input('tanggal_pembayaran'),
            'bukti_pembayaran' => $fileNama,
        ]);

        return redirect()->route('mahasiswa.upload.form')->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function accNotifikasi($id_jadwal)
    {
        $notifikasi = Jadwal::findOrFail($id_jadwal);
        $notifikasi->status_verifikasi = 'Acc';
        $notifikasi->save();

        return redirect()->back();
    }
}
