@extends('layouts.master')
@section('content')
<!-- resources/views/admin/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<style>
    .dashboard-card {
        border: 1px solid #ddd;
        /* Tambahkan garis tepi untuk memberikan efek kartu */
        border-radius: 8px;
        /* Tambahkan radius sudut untuk menampilkan kartu yang lebih baik */
        padding: 15px;
        margin: 10px;
        /* Berikan margin antara kartu-kartu */
    }

    .dashboard-section {
        display: flex;
        /* Tata letak flex untuk kartu-kartu berjejer */
    }
</style>

<body>
    <div class="dashboard-section">
        <a href="">
            <div class="dashboard-card">
                <h5>Jumlah Mahasiswa</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        <p class="text-center my-4">{{ $jumlahMahasiswa }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="">
            <div class="dashboard-card">
                <h5>Jumlah Dosen</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        <p class="text-center my-4">{{ $jumlahDosen }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="dashboard-section">
        <a href="">
            <div class="dashboard-card">
                <h5>Jumlah Sesi Konseling Selesai</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        <p class="text-center my-4">{{ $jumlahSelesaiKonseling }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="">
            <div class="dashboard-card">
                <h5>Jumlah Dosen</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        <p class="text-center my-4">{{ $rataRataDurasiFormat }}</p>
                    </div>
                </div>
            </div>
        </a>
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
                                <th>Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sedangBerlangsung->take(5) as $jadwal)
                            <tr>
                                <td>
                                    <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                </td>
                                <td>
                                    <p class="mb-n1 font-weight-medium">{{ $jadwal->dosenWali->nama }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($sedangBerlangsung->count() > 5)
                    <a href="{{ route('lihat.semua.berlangsung.dosen') }}" class="view-all-btn float-right">View All</a>
                    @endif
                    @else
                    <p class="text-center my-4">Belum ada konseling yang Berlangsung.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>

@endsection