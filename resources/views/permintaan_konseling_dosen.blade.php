@extends('layouts.master')
@section('content')

<div class="dashboard-card">
    <h5>Permintaan Konseling</h5>
    <div class="dashboard-content">
        <div class="grid table-responsive">
            <table class="table table-stretched">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permintaanKonseling as $jadwal)
                    <tr>
                        <td>
                            <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                            <small class="text-gray" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                            <small class="font-weight-medium">{{ $jadwal->metode_konsultasi }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y, H:i') }}</td>
                        <td class="text-danger font-weight-medium">
                            <!-- Anda perlu menambahkan data perubahan (change) dari jadwal -->
                            <form action="{{ route('acc-notifikasi', $jadwal->id_jadwal) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="badge badge-success btn-outline-success">Acc</button>
                                <!-- <button type="submit" class="btn btn-success">Acc</button> -->
                            </form>
                            @csrf
                            <button class="badge badge-danger btn-outline-danger" data-toggle="modal" data-target="#tolakModal-{{ $jadwal->id_jadwal }}">Tolak</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="tolakModal-{{ $jadwal->id_jadwal }}" tabindex="-1" role="dialog" aria-labelledby="tolakModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('tolak-notifikasi', $jadwal->id_jadwal) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tolakModalLabel">Berikan alasan anda</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group" id="tolak-konsul-group">
                                            <label for="permasalahan">Alasan</label>
                                            <textarea class="form-control" name="permasalahan" id="permasalahan" rows="3"></textarea>
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