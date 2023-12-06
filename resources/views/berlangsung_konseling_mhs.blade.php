@extends('layouts.master')
@section('content')

<div class="dashboard-card">
    <h5>Sedang Berlangsung</h5>
    <div class="dashboard-content">
        <div class="grid table-responsive">
            <table class="table table-stretched">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Mulai Kapan?</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sedangBerlangsung as $jadwal)
                    <tr>
                        <td>
                            <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                            <small class="text-gray">{{ $jadwal->topikkonseling->nama_topik }}</small>
                            <small class="font-weight-medium">{{ $jadwal->metode_konsultasi }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('H:i') }}</td>
                        <td class="text-danger font-weight-medium">
                            <form action="{{ route('chat', ['jadwal_id' => $jadwal->id_jadwal]) }}" method="GET" class="d-inline">
                                @csrf
                                <button class="badge badge-success btn-outline-success">Lihat</button>
                                <form action="{{ route('selesai-notifikasi', $jadwal->id_jadwal) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="badge badge-success btn-outline-success">Selesai</button>
                                </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection