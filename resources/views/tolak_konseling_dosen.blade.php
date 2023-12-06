@extends('layouts.master')
@section('content')
<div class="dashboard-card">
    <h5>Tolak</h5>
    <div class="dashboard-content">
        <div class="grid table-responsive">
            <table class="table table-stretched">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Rencana Konseling</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tolak as $jadwal)
                    <tr>
                        <td>
                            <p class="mb-n1 font-weight-medium custom-tooltip" title="Nama mahasiswa yang berencana konseling {{ $jadwal->mahasiswa->nama }}">{{ $jadwal->mahasiswa->nama }}</p>
                            <small class="text-gray topic-name" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                            <small class="font-weight-medium consultation-method" title="{{ $jadwal->mahasiswa->nama }} ingin berkonseling secara {{ $jadwal->metode_konsultasi }}">{{ $jadwal->metode_konsultasi }}</small>
                        </td>
                        <td class="font-weight-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y, H:i') }}</td>
                        <td class="font-weight-medium">Ditolak pada {{ \Carbon\Carbon::parse($jadwal->created_at)->format('d F Y') }} Jam {{ \Carbon\Carbon::parse($jadwal->created_at)->format('H:i') }} dikarenakan {{ $jadwal->deskripsi }}</td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    @if ($tolak->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $tolak->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                    @endif

                    @foreach ($tolak->getUrlRange(1, $tolak->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $tolak->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}{{ strpos($url, '?') !== false ? '&' : '?' }}search_column={{ request('search_column') }}&search_query={{ request('search_query') }}">{{ $page }}</a>
                    </li>
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($tolak->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $tolak->appends(['search_column' => request('search_column'), 'search_query' => request('search_query')])->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <a class="page-link" href="{{ $tolak->appends(['search_column' => request('search_column'), 'search_query' => request('search_query')])->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection