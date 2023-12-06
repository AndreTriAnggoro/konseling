<!-- resources/views/riwayat-konseling-all.blade.php -->

@extends('layouts.master')
@section('content')

<style>
    /* Gaya tambahan Anda untuk halaman "View All" bisa diletakkan di sini */
</style>

<div class="page-content-wrapper-inner">
    <div class="content-viewport">
        <div class="row">
            <div class="col-12 py-5">
                <h4>Riwayat Konseling (Semua)</h4>
            </div>
        </div>
        <div class="dashboard-section">
            <div class="dashboard-card">
                <div class="dashboard-content">
                    <div class="grid table-responsive" style="overflow-x: hidden;">
                        <form action="{{ route('lihat.semua.riwayat.mhs') }}" method="GET">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <select class="form-control" name="search_column">
                                        <option value="metode_konsultasi" {{ request('search_column') == 'metode_konsultasi' ? 'selected' : '' }}>Metode</option>
                                        <option value="waktu" {{ request('search_column') == 'waktu' ? 'selected' : '' }}>Waktu</option>
                                        <option value="nama_topik" {{ request('search_column') == 'nama_topik' ? 'selected' : '' }}>Topik</option>
                                        <!-- Tambahkan opsi untuk kolom lainnya sesuai kebutuhan -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="search_query" class="form-control" placeholder="Cari berdasarkan" aria-label="Cari berdasarkan" value="{{ request('search_query') }}">
                                </div>
                            </div>
                        </form>
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                    <th>Pembahasan</th>
                                    <th>metode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalKonseling as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y, H:i') }}</td>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->topikkonseling->nama_topik }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->metode_konsultasi }}</p>
                                    </td>
                                    <td class="text-danger font-weight-medium">
                                        <div class="badge badge-success">{{ $jadwal->status_verifikasi }}</div>
                                        @if($jadwal->status_verifikasi == 'dikirim')
                                        <form action="{{ route('batal-notifikasi', $jadwal->id_jadwal) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="badge badge-success btn-outline-success">Batal</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                @if ($jadwalKonseling->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $jadwalKonseling->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                                @endif

                                @foreach ($jadwalKonseling->getUrlRange(1, $jadwalKonseling->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $jadwalKonseling->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}{{ strpos($url, '?') !== false ? '&' : '?' }}search_column={{ request('search_column') }}&search_query={{ request('search_query') }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($jadwalKonseling->hasMorePages())
                                <li class="page-item">
                                <a class="page-link" href="{{ $jadwalKonseling->appends(['search_column' => request('search_column'), 'search_query' => request('search_query')])->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                                @else
                                <li class="page-item disabled">
                                <a class="page-link" href="{{ $jadwalKonseling->appends(['search_column' => request('search_column'), 'search_query' => request('search_query')])->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection