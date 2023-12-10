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
        <a href="{{ route('ukt.belum.bayar') }}">
            <div class="dashboard-card">
                <h5>Belum Bayar</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($belumBayar->isNotEmpty())

                        <p class="text-center my-4">{{ $jumlahBelumBayar }}</p>

                        @else
                        <p class="text-center my-4">Tidak ada mahasiswa yang belum bayar.</p>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('ukt.diproses') }}">
            <div class="dashboard-card">
                <h5>Dalam Proses</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($dalamProses->isNotEmpty())

                        <p class="text-center my-4">{{ $jumlahDalamProses }}</p>

                        @else
                        <p class="text-center my-4">Belum ada pembayaran diproses.</p>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('ukt.lunas') }}">
            <div class="dashboard-card">
                <h5>Lunas</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($Lunas->isNotEmpty())

                        <p class="text-center my-4">{{ $jumlahLunas }}</p>

                        @else
                        <p class="text-center my-4">Belum ada UKT Lunas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="dashboard-section">
    </div>

</body>

</html>

@endsection