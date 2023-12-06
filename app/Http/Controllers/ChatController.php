<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Pembayaran;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Konseling;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class ChatController extends Controller
{
    use HasRoles;

    public function index($jadwal_id)
    {

        

        $messages = Chat::where('jadwal_id', $jadwal_id)->get();

        $jadwal = Jadwal::find($jadwal_id);

        if ($jadwal) {
            $nimPadaJadwal = $jadwal->nim;

            $riwayatKonselingSelesai = Jadwal::where('nim', $nimPadaJadwal)
                ->where('status_verifikasi', 'selesai')
                ->where('id_jadwal', '!=', $jadwal_id)
                ->get();
        } else {
            $riwayatKonselingSelesai = collect();
        }

        $nim = $jadwal->nim;

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $pembayaranUkt = Pembayaran::where('nim', $mahasiswa->nim)->get();
        return view('chat', ['messages' => $messages, 'jadwal_id' => $jadwal_id, 'riwayatKonselingSelesai' => $riwayatKonselingSelesai, 'jadwal' => $jadwal, 'pembayaranUkt' => $pembayaranUkt]);
    }

    public function bukachat($jadwal_id)
    {
        $messages = Chat::where('jadwal_id', $jadwal_id)->get();

        $jadwal = Jadwal::find($jadwal_id);

        if ($jadwal) {
            $nimPadaJadwal = $jadwal->nim;

            $riwayatKonselingSelesai = Jadwal::where('nim', $nimPadaJadwal)
                ->where('status_verifikasi', 'selesai')
                ->where('id_jadwal', '!=', $jadwal_id)
                ->get();
        } else {
            $riwayatKonselingSelesai = collect();
        }

        return view('chat2', ['messages' => $messages, 'jadwal_id' => $jadwal_id, 'riwayatKonselingSelesai' => $riwayatKonselingSelesai, 'jadwal' => $jadwal]);
    }

    public function getKonselingDetail(Request $request)
    {
        $jadwalId = $request->input('jadwalId');
        $konseling = Konseling::with('topikKonseling')->where('id_jadwal', $jadwalId)->first();
        return response()->json($konseling);
    }

    public function send(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('mahasiswa')) {
            $pelaku = 'mahasiswa';
        } elseif ($user->hasRole('dosenwali')) {
            $pelaku = 'dosenwali';
        } else {
        }

        $message = new Chat;
        $message->jadwal_id = $request->jadwal_id;
        $message->message = $request->message;
        $message->pelaku = $pelaku;
        $message->save();

        return redirect()->route('chat', ['jadwal_id' => $request->jadwal_id]);
    }

    public function getChat($jadwal_id)
    {
        $messages = Chat::where('jadwal_id', $jadwal_id)->get();

        return response()->json(['messages' => $messages]);
    }

    public function getStatusVerifikasi($jadwal_id)
    {
        $jadwal = Jadwal::find($jadwal_id);
        if ($jadwal) {
            return response()->json([
                'status_verifikasi' => $jadwal->status_verifikasi,
                'permasalahan' => $jadwal->konseling->permasalahan, // Pastikan permasalahan ada
                'solusi' => $jadwal->konseling->solusi // Pastikan solusi ada
            ]);
        } else {
            return response()->json(['error' => 'Jadwal not found'], 404);
        }
    }
}
