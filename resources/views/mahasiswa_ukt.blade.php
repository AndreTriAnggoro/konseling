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
    <h2 class="mt-3 mb-4">Daftar Pembayaran UKT</h2>
    <form action="{{ route('ukt.mahasiswa') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="search">Cari NIM:</label>
            <div class="input-group">
                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NIM</th>
                <th scope="col">Jumlah Pembayaran</th>
                <th scope="col">Status Pembayaran</th>
                <th scope="col">Tanggal Pembayaran</th>
                <th scope="col">Bukti Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaranUktMahasiswa as $pembayaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pembayaran->nim }}</td>
                <td>{{ $pembayaran->jumlah_pembayaran }}</td>
                <td>{{ $pembayaran->status_pembayaran }}</td>
                <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                <td>
                    @if($pembayaran->status_pembayaran === 'Lunas')
                    <a href="#" data-toggle="modal" data-target="#buktiPembayaranModal{{ $pembayaran->id_pembayaran }}">
                        Lihat Bukti
                    </a>
                    @else
                    Belum Lunas
                    @endif
                </td>
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