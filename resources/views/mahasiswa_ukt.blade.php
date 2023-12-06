@extends('layouts.master')
@section('content')
<!-- resources/views/admin/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran UKT</title>
</head>

<body>
    <h2>Pembayaran UKT</h2>
    <form action="{{ route('mahasiswa.ukt') }}" method="GET">
        <label for="search">Cari aja :</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}">
        <button type="submit">Cari</button>
    </form>

    <table>
        <thead>
            <tr>
                <!-- <th>ID Pembayaran</th> -->
                <th>NIM</th>
                <th>Jumlah Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <!-- <th>Aksi</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaranUktMahasiswa as $pembayaran)
            <tr>
                <td>{{ $pembayaran->nim }}</td>
                <td>{{ $pembayaran->jumlah_pembayaran }}</td>
                <td>{{ $pembayaran->status_pembayaran }}</td>
                <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                <td><a href="#" data-toggle="modal" data-target="#buktiPembayaranModal{{ $pembayaran->id_pembayaran }}">
                        Lihat Bukti
                    </a></td>
            </tr>

            <div class="modal fade" id="buktiPembayaranModal{{ $pembayaran->id_pembayaran }}" tabindex="-1" role="dialog" aria-labelledby="buktiPembayaranModalLabel{{ $pembayaran->id_pembayaran }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="buktiPembayaranModalLabel{{ $pembayaran->id_pembayaran }}">Bukti Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('uploads/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</body>

</html>

@endsection