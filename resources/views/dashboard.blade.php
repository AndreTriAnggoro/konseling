@extends('layouts.master')
@section('content')
<style>
    .dashboard-section {
        display: flex;
        flex-wrap: nowrap;
    }

    .dashboard-card {
        margin: 10px;
        flex: 0 0 calc(33.33% - 20px);
        display: flex;
        flex-direction: column;
    }

    .dashboard-content {
        flex: 1;
    }

    .body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    .page-content-wrapper-inner {
        padding: 20px;
    }

    .dashboard-section {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .dashboard-card {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 20px;
        flex: 1;
    }

    .dashboard-card h5 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .dashboard-card table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-card th,
    .dashboard-card td {
        padding: 12px;
        text-align: left;
    }

    .dashboard-card th {
        background-color: #f3f3f3;
        font-weight: 600;
    }

    .dashboard-card tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .dashboard-card tr:hover {
        background-color: #e0e0e0;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .modal {
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        max-width: 600px;
        margin: 100px auto;
        background-color: #fff;
        border-radius: 5px;
    }

    .modal-content {
        padding: 20px;
    }

    .modal-header {
        background-color: #343a40;
        color: #fff;
        padding: 15px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .modal-title {
        font-size: 1.2rem;
    }

    .close {
        color: #fff;
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .topic-name {
        background-color: #ffcc00;
        /* Ganti dengan warna yang diinginkan */
        padding: 2px 5px;
        /* Sesuaikan dengan ukuran yang sesuai */
        border-radius: 5px;
        /* Membuat sudut elemen lebih lembut */
        margin-top: 5px;
    }

    .consultation-method {
        background-color: #66cc99;
        /* Ganti dengan warna yang diinginkan */
        padding: 2px 5px;
        /* Sesuaikan dengan ukuran yang sesuai */
        border-radius: 5px;
        /* Membuat sudut elemen lebih lembut */
    }
</style>
<div class="page-content-wrapper-inner">
    <div class="content-viewport">
        <div class="row">
            <div class="col-12 py-5">
                <h4>Dashboard</h4>
                <p class="text-gray">Welcome, {{ Auth::user()->name }}</p>
            </div>
        </div>
        <div class="dashboard-section">
            <div class="dashboard-card">
                <h5>Sedang Berlangsung</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($sedangBerlangsung->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Mulai Kapan?</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sedangBerlangsung->take(5) as $jadwal)
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
                        @if ($sedangBerlangsung->count() > 5)
                        <a href="{{ route('lihat.semua.berlangsung.mhs') }}" class="view-all-btn float-right">View All</a>
                        @endif

                        @else
                        <p class="text-center my-4">Belum ada permintaan konseling.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="dashboard-card">
                <h5>Coming Soon</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($comingSoonJadwals->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kapan?</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comingSoonJadwals->take(5) as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                        <small class="text-gray">{{ $jadwal->topikkonseling->nama_topik }}</small>
                                        <small class="font-weight-medium">{{ $jadwal->metode_konsultasi }}</small>
                                    </td>
                                    <td class="font-weight-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y, H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($comingSoonJadwals->count() > 5)
                        <a href="{{ route('lihat.semua.riwayat.mhs') }}" class="view-all-btn float-right">View All</a>
                        @endif

                        @else
                        <p class="text-center my-4">Belum ada permintaan konseling.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-section">
            <div class="dashboard-card">
                <h5>Riwayat Konseling</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($selesaiKonseling->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selesaiKonseling->take(5) as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                        <small class="text-gray">{{ $jadwal->topikkonseling->nama_topik }}</small>
                                        <small class="font-weight-medium">{{ $jadwal->metode_konsultasi }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y, H:i') }}</td>
                                    <td class="text-danger font-weight-medium">
                                        <div class="badge badge-success">{{ $jadwal->status_verifikasi }}</div>
                                        @if($jadwal->status_verifikasi == 'dikirim')
                                        <form action="{{ route('batal-notifikasi', $jadwal->id_jadwal) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="badge badge-success btn-outline-success">Cancel</button>
                                            <!-- <button type="submit" class="btn btn-success">Acc</button> -->
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($selesaiKonseling->count() > 5)
                        <a href="{{ route('lihat.semua.riwayat.mhs') }}" class="view-all-btn float-right">View All</a>
                        @endif

                        @else
                        <p class="text-center my-4">Belum ada permintaan konseling.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    setInterval(function() {
        $.get('/check-expired-jadwal', function(response) {
            console.log(response.message);
        });
    }, 300000); // 5 menit
</script>