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
                        <th>Topik</th>
                        <th>Metode</th>
                        <th>Mulai Kapan?</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sedangBerlangsung as $jadwal)
                    <tr>
                        <td>
                            <p>{{ $jadwal->mahasiswa->nama }}</p>
                        </td>
                        <td>
                            <p>{{ $jadwal->topikkonseling->nama_topik }}</p>
                        </td>
                        <td>
                            <p>{{ $jadwal->metode_konsultasi }}</p>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('H:i') }}</td>
                        <td class="text-danger font-weight-medium">
                            @if($jadwal->metode_konsultasi === 'online')
                            <form action="{{ route('chat', ['jadwal_id' => $jadwal->id_jadwal]) }}" method="GET" class="d-inline">
                                @csrf
                                <button class="badge badge-success btn-outline-success">Lihat</button>
                            </form>
                            @else
                            <button class="badge badge-success btn-outline-success" data-toggle="modal" data-target="#selesaiModal-{{ $jadwal->id_jadwal }}">Selesai</button>
                            @endif

                        </td>
                    </tr>
                    <div class="modal fade" id="selesaiModal-{{ $jadwal->id_jadwal }}" tabindex="-1" role="dialog" aria-labelledby="selesaiModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('selesai-notifikasi', $jadwal->id_jadwal) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="selesaiModalLabel">Selesaikan Konseling</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group" id="permasalahan-solusi-group">
                                            <label for="permasalahan">Permasalahan</label>
                                            <textarea class="form-control" name="permasalahan" id="permasalahan" rows="3"></textarea>
                                        </div>
                                        <div class="form-group" id="permasalahan-solusi-group">
                                            <label for="solusi">Solusi</label>
                                            <textarea class="form-control" name="solusi" id="solusi" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Selesai</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection