@extends('layouts.master')

@section('content')

<ul class="navbar-nav" style="display: flex; flex-direction: row;">
    <li class="nav-item" style="margin-right: 10px;">
        <a class="nav-link" href="{{ route('jadwal.dosen') }}">Jadwal Dosen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('buat.jadwal') }}">Buat Jadwal</a>
    </li>
</ul>

<form action="{{ route('lihat.jadwal.dosen') }}" method="GET" class="row g-3">
    @csrf
    <div class="form-group col-md-6">
        <label for="dosen">Pilih Dosen:</label>
        <select name="dosen" id="dosen" class="form-control">
            <option value="">Pilih Dosen</option>
            @foreach ($dosenwali as $dosen)
                <option value="{{ $dosen->nip_dosenwali }}" @if(session('dosen') == $dosen->nip_dosenwali) selected @endif>
                    {{ $dosen->nama }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="tanggal">Pilih Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ session('tanggal') }}">
    </div>
    <button type="submit" class="btn btn-primary">Tampilkan Jadwal Dosen</button>
</form>

@if (count($jadwalDosen) > 0)
    <h2>Jadwal Dosen</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Dosen</th>
                <th>Tanggal</th>
                <th>Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalDosen as $jadwal)
                <tr>
                    <td>{{ $jadwal->dosenWali->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d, H:i') }}</td>
                    <td>{{ $jadwal->status_verifikasi }}</td>
                    <td>
                        @if ($jadwal->nim == auth()->user()->username)
                            Jadwal Saya
                        @else
                            
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Tidak ada jadwal dosen yang tersedia untuk dosen yang dipilih.</p>
@endif
@endsection
