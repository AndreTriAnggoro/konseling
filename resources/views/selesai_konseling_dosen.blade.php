@extends('layouts.master')
@section('content')
@php
use App\Helpers\CarbonHelper;
@endphp
<div class="dashboard-card">
    <h5>Selesai</h5>
    <div class="dashboard-content">
        <div class="grid table-responsive">
            <table class="table table-stretched">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Waktu Konseling</th>
                        <th>Lama Konseling</th>
                        <th>Permasalahan</th>
                        <th>Solusi</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($selesai as $jadwal)
                    <tr>
                        <td>
                            <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                            <small class="text-gray topic-name" title="Topik yang telah dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                            <small class="font-weight-medium consultation-method" title="Konseling ini dilakukan secara {{ $jadwal->metode_konsultasi }}" data-jadwal-id="{{ $jadwal->id_jadwal }}" onclick="checkConsultationMethod('{{ $jadwal->metode_konsultasi }}', this)">{{ $jadwal->metode_konsultasi }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y H:i') }}</td>
                        <td>
                            {{ CarbonHelper::customDiffForHumans($jadwal->updated_at, $jadwal->tanggal) }}
                        </td>
                            <?php
                            // Hitung waktu dalam detik menggunakan Carbon
                            $waktuDetik = \Carbon\Carbon::parse($jadwal->updated_at)->diffInSeconds($jadwal->tanggal);

                            // Tambahkan ke total waktu
                            $totalWaktu += $waktuDetik;

                            // Tingkatkan jumlah sesi konseling
                            $jumlahSesiKonseling++;
                            ?>
                        <td>{{ $jadwal->konseling->permasalahan }}</td>
                        <td>{{ $jadwal->konseling->solusi }}</td>
                        <!-- <td class="text-danger font-weight-medium">
                            <button class="badge badge-success btn-outline-success lihat-selesai" data-jadwal-id="{{ $jadwal->id_jadwal }}">Lihat</button>
                        </td>
                        <div class="modal fade" id="detailKonselingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Detail Konseling</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Topik</h6>
                                        <p id="topik-detail"></p>
                                        <h6>Metode Konsultasi</h6>
                                        <p id="metode-detail"></p>
                                        <h6>Permasalahan</h6>
                                        <textarea class="form-control mb-4" id="permasalahan-detail" name="permasalahan" rows="3" placeholder="Permasalahan" readonly></textarea>
                                        <h6>Solusi</h6>
                                        <textarea class="form-control" id="solusi-detail" name="solusi" rows="3" placeholder="Solusi" readonly></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-primary d-none" id="lihatChatButton" href="#">Lihat Chat</a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    @if ($selesai->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $selesai->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                    @endif

                    @foreach ($selesai->getUrlRange(1, $selesai->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $selesai->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}{{ strpos($url, '?') !== false ? '&' : '?' }}search_column={{ request('search_column') }}&search_query={{ request('search_query') }}">{{ $page }}</a>
                    </li>
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($selesai->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $selesai->appends(['search_column' => request('search_column'), 'search_query' => request('search_query')])->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <a class="page-link" href="{{ $selesai->appends(['search_column' => request('search_column'), 'search_query' => request('search_query')])->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    function checkConsultationMethod(method, element) {
        // Dapatkan jadwalId dari atribut data-jadwal-id
        var jadwalId = element.getAttribute('data-jadwal-id');

        // Cek jika metode konsultasi adalah online
        if (method.toLowerCase() === 'online') {
            // Redirect ke route chat dengan jadwal_id
            window.location.href = "{{ url('chat') }}/" + jadwalId;
        }
        // Jika metode konsultasi offline, tidak lakukan apa-apa
    }
</script>


@endsection