@extends('layouts.master')
@section('content')
<style>
    .dashboard-section {
        display: flex;
        flex-wrap: nowrap;
    }

    .dashboard-card {
        margin: 10px;
        flex: 0 0 calc(33.33% - 20px);
        display: flex;
        flex-direction: column;
    }

    .dashboard-content {
        flex: 1;
    }
</style>
<style>
    /* Add global styles here */
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    .page-content-wrapper-inner {
        padding: 20px;
    }

    .dashboard-section {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .dashboard-card {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 20px;
        flex: 1;
    }

    .dashboard-card h5 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .dashboard-card table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-card th,
    .dashboard-card td {
        padding: 12px;
        text-align: left;
    }

    .dashboard-card th {
        background-color: #f3f3f3;
        font-weight: 600;
    }

    .dashboard-card tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .dashboard-card tr:hover {
        background-color: #e0e0e0;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .modal {
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        max-width: 600px;
        margin: 100px auto;
        background-color: #fff;
        border-radius: 5px;
    }

    .modal-content {
        padding: 20px;
    }

    .modal-header {
        background-color: #343a40;
        color: #fff;
        padding: 15px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .modal-title {
        font-size: 1.2rem;
    }

    .close {
        color: #fff;
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .topic-name {
        background-color: #ffcc00;
        /* Ganti dengan warna yang diinginkan */
        padding: 2px 5px;
        /* Sesuaikan dengan ukuran yang sesuai */
        border-radius: 5px;
        /* Membuat sudut elemen lebih lembut */
        margin-top: 5px;
    }

    .consultation-method {
        background-color: #66cc99;
        /* Ganti dengan warna yang diinginkan */
        padding: 2px 5px;
        /* Sesuaikan dengan ukuran yang sesuai */
        border-radius: 5px;
        /* Membuat sudut elemen lebih lembut */
    }
</style>
@php
use App\Helpers\CarbonHelper;
@endphp
<div class="page-content-wrapper-inner">
    <div class="content-viewport">
        <div class="row">
            <div class="col-12 py-3">
                <h4>Dashboard</h4>
                <p class="text-gray">Welcome, {{ Auth::user()->name }}</p>
            </div>
        </div>
        <div class="dashboard-section">
            <div class="dashboard-card">
                <h5>Permintaan Konseling</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($permintaanKonseling->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permintaanKonseling->take(5) as $jadwal)
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
                                            <button class="badge badge-success btn-outline-success confirm-button">Acc</button>
                                            <!-- <button type="submit" class="btn btn-success">Acc</button> -->
                                        </form>

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
                                                        <div>
                                                            <button type="button" class="btn btn-outline-secondary" onclick="addTemplate('Mohon maaf, jadwal hari ini penuh.')">jadwal penuh.</button>
                                                            <button type="button" class="btn btn-outline-secondary" onclick="addTemplate('Mohon maaf, hari ini sedang ada acara pribadi.')">Acara Pribadi</button>
                                                            <button type="button" class="btn btn-outline-secondary" onclick="addTemplate('Mohon maaf, hari ini sedang ada tugas kampus.')">Tugas Kampus</button>
                                                        </div>
                                                        <button type="button" class="btn btn-outline-danger" onclick="clearTemplate()">Hapus Template</button>
                                                        <button type="button" class="btn btn-outline-secondary" onclick="addTemplate('Mungkin anda bisa berkonsultasi pada dd mm yyyy jam H:i')">Rekomendasi Waktu</button>
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
                        @if ($permintaanKonseling->count() > 5)
                        <a href="{{ route('lihat.semua.permintaan.dosen') }}" class="view-all-btn float-right">View All</a>
                        @endif

                        @else
                        <p class="ml-3 my-4">Belum ada permintaan konseling.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="dashboard-card">
                <h5>Sedang Berlangsung</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($sedangBerlangsung->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Mulai Kapan?</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sedangBerlangsung->take(5) as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                        <small class="text-gray topic-name" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                                        <small class="font-weight-medium consultation-method">{{ $jadwal->metode_konsultasi }}</small>
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
                        @if ($sedangBerlangsung->count() > 5)
                        <a href="{{ route('lihat.semua.berlangsung.dosen') }}" class="view-all-btn float-right">View All</a>
                        @endif
                        @else
                        <p class="text-center my-4">Belum ada konseling yang Berlangsung.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="dashboard-card">
                <h5>Selesai</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($selesai->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selesai->take(5) as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                        <small class="text-gray topic-name" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                                        <small class="font-weight-medium consultation-method">{{ $jadwal->metode_konsultasi }}</small>
                                    </td>

                                    <td class="text-danger font-weight-medium">
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
                                    </div>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($selesai->count() > 5)
                        <a href="{{ route('lihat.semua.selesai.dosen') }}" class="view-all-btn float-right">View All</a>
                        @endif
                        @else
                        <p class="text-center my-4">Belum ada konseling selesai.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-section">
            <div class="dashboard-card">
                <h5>Coming Soon</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($comingSoonJadwals->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kapan?</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comingSoonJadwals->take(5) as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                        <small class="text-gray topic-name" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                                        <small class="font-weight-medium consultation-method">{{ $jadwal->metode_konsultasi }}</small>
                                    </td>
                                    <td class="font-weight-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y H:i') }}
                                        @if ($comingSoonJadwals)
                                        @php
                                        $carbonJadwal = \Carbon\Carbon::parse($jadwal->tanggal);
                                        $diffInTime = $carbonJadwal->diff($jadwal->updated_at);
                                        $diffText = $diffInTime->format('%d hari %h jam %i menit');
                                        @endphp
                                        ({{ $diffInTime->format('%d hari %h jam %i menit') }})
                                        <!-- {{ CarbonHelper::customDiffForHumans($jadwal->updated_at, $jadwal->tanggal) }} -->
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($comingSoonJadwals->count() > 5)
                        <a href="{{ route('lihat.semua.comingson.dosen') }}" class="view-all-btn float-right">View All</a>
                        @endif
                        @else
                        <p class="text-center my-4">Belum ada rencana konseling.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="dashboard-card">
                <h5>Tolak</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($tolak->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kapan?</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tolak->take(5) as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                        <small class="text-gray topic-name" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                                        <small class="font-weight-medium consultation-method">{{ $jadwal->metode_konsultasi }}</small>
                                    </td>
                                    <td class="font-weight-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y, H:i') }}</td>
                                    <td class="font-weight-medium">{{ $jadwal->deskripsi }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($tolak->count() > 5)
                        <a href="{{ route('lihat.semua.tolak.dosen') }}" class="view-all-btn float-right">View All</a>
                        @endif
                        @else
                        <p class="text-center my-4">Tidak ada konseling yang ditolak.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="dashboard-card">
                <h5>Expired</h5>
                <div class="dashboard-content">
                    <div class="grid table-responsive">
                        @if($expired->isNotEmpty())
                        <table class="table table-stretched">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Rencana Konseling</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expired->take(5) as $jadwal)
                                <tr>
                                    <td>
                                        <p class="mb-n1 font-weight-medium">{{ $jadwal->mahasiswa->nama }}</p>
                                        <small class="text-gray topic-name" title="Topik yang akan dibahas adalah {{ $jadwal->topikkonseling->nama_topik }}">{{ $jadwal->topikkonseling->nama_topik }}</small>
                                        <small class="font-weight-medium consultation-method">{{ $jadwal->metode_konsultasi }}</small>
                                    </td>
                                    <td class="font-weight-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y, H:i') }}
                                    </td>
                                    <td class="font-weight-medium">
                                        <button class="badge badge-success btn-outline-success">Bicarakan</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($expired->count() > 5)
                        <a href="{{ route('lihat.semua.expired.dosen') }}" class="view-all-btn float-right">View All</a>
                        @endif
                        @else
                        <p class="text-center my-4">Tidak ada konseling yang ditolak.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $('.confirm-button').click(function(e) {
        var form = $(this).closest("form");
        e.preventDefault();

        Swal.fire({
            title: 'Acc nih bos?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Ya',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                form.submit();
                Swal.fire('Saved!', '', 'success');
            }
        });
    });
</script>
@endpush

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Cari elemen tombol "Selesai"
    var selesaiButton = document.querySelector('.badge-success');

    // Saat tombol "Selesai" diklik
    selesaiButton.addEventListener('click', function() {
        // Cek metode konsultasi
        if (metode_konsultasi === 'offline') {
            // Tampilkan elemen permasalahan dan solusi
            document.getElementById('permasalahan-solusi-group').style.display = 'block';
        }
    });
</script>

<script>
    // Cari elemen tombol "Selesai"
    var tolakButton = document.querySelector('.badge-danger');

    // Saat tombol "Selesai" diklik
    tolakButton.addEventListener('click', function() {
        var konfirmasi = confirm("Apakah Anda yakin ingin menolak?");

        // Jika pengguna menekan tombol "OK" dalam konfirmasi
        if (konfirmasi) {
            document.getElementById('tolak-konsul-group').style.display = 'block';
        }
    });
</script>

<script>
    setInterval(function() {
        $.get('/check-expired-jadwal', function(response) {
            console.log(response.message);
        });
    }, 300000); // 5 menit
</script>
<script>
    $(document).ready(function() {
        $('.lihat-selesai').on('click', function(e) {
            e.preventDefault();
            var jadwalId = $(this).data('jadwal-id');

            // Menggunakan AJAX untuk mengambil data Konseling
            $.ajax({
                url: "{{ route('get.konseling.detail') }}",
                method: "GET",
                data: {
                    jadwalId: jadwalId
                },
                success: function(data) {
                    // Menampilkan permasalahan dan solusi dalam modal
                    $('#topik-detail').text(data.topik_konseling.nama_topik);
                    $('#metode-detail').text(data.metode_konsultasi);
                    $('#permasalahan-detail').text(data.permasalahan);
                    $('#solusi-detail').text(data.solusi);

                    var chatUrl = "{{ route('chat', ':jadwal_id') }}".replace(':jadwal_id', jadwalId);

                    $('#lihatChatButton').attr('href', chatUrl);

                    if (data.metode_konsultasi === 'online') {
                        $('#lihatChatButton').removeClass('d-none');
                    } else {
                        $('#lihatChatButton').addClass('d-none');
                    }
                    $('#detailKonselingModal').modal('show');
                }
            });
        });
    });
</script>
<script>
    // Cari elemen tombol "Jadwal Penuh"
    var jadwalPenuhButton = document.querySelector('#jadwalPenuhButton');

    // Saat tombol "Jadwal Penuh" diklik
    jadwalPenuhButton.addEventListener('click', function() {
        // Mengisi input alasan dengan teks "Jadwal Penuh"
        var alasanInput = document.querySelector('#permasalahan');
        alasanInput.value = "Jadwal Penuh";
    });
</script>
<script>
    function addTemplate(templateText) {
        // Dapatkan nilai textarea
        var existingText = document.getElementById('permasalahan').value;

        // Gabungkan nilai yang ada dengan template, tambahkan newline jika textarea sudah terisi
        var newText = existingText ? existingText + '\n' + templateText : templateText;

        // Setel nilai textarea dengan teks baru
        document.getElementById('permasalahan').value = newText;
    }

    function clearTemplate() {
        // Setel nilai textarea menjadi kosong
        document.getElementById('permasalahan').value = '';
    }
</script>