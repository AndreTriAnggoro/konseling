@extends('layouts.master')
@section('content')
<div>
    <h2>Pembayaran Belum Diverifikasi</h2>

    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Jumlah Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaranLunas as $pembayaran)
            <tr>
                <td>{{ $pembayaran->nim }}</td>
                <td>{{ $pembayaran->jumlah_pembayaran }}</td>
                <td>{{ $pembayaran->status_pembayaran }}</td>
                <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                <td><a href="#" data-toggle="modal" data-target="#buktiPembayaranModal{{ $pembayaran->id_pembayaran }}">
                        Lihat Bukti
                    </a></td>
                <td>
                    <a href="{{ route('admin.verifikasi', $pembayaran->id_pembayaran) }}">Setujui</a>
                    |
                    <a href="{{ route('admin.verifikasi', ['id_pembayaran' => $pembayaran->id_pembayaran, 'status_pembayaran' => 'Belum Bayar']) }}">Tolak</a>
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
</div>
@endsection