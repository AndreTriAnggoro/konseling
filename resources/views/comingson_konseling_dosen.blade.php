@extends('layouts.master')
@section('content')
<div class="dashboard-card">
    <h5>Coming Soon</h5>
    <div class="dashboard-content">
        <form method="GET" action="{{ route('coming-soon') }}">
            <label for="filter">Filter:</label>
            <select name="filter" id="filter">
                <option value="terdekat">Terdekat</option>
                <!-- Tambahkan pilihan filter lainnya jika diperlukan -->
            </select>
            <button type="submit">Terapkan Filter</button>

        </form>
        <a href="{{ route('lihat.semua.comingson.dosen') }}" class="btn btn-danger">Hapus Filter</a>
        <div class="grid table-responsive">
            <table class="table table-stretched">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kapan?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comingSoonJadwals as $jadwal)
                    <tr>
                        <td>
                            <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                            <small class="text-gray topic-name" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                            <small class="font-weight-medium consultation-method">{{ $jadwal->metode_konsultasi }}</small>
                        </td>
                        <td class="font-weight-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y, H:i') }}
                            @if ($comingSoonJadwals)
                            ({{ \Carbon\Carbon::parse($jadwal->tanggal)->diffForHumans(['parts' => 2]) }})
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection