@extends('layouts.master')

@section('content')
<style>
    .konseling-history-item {
        background-color: #f0f0f0;
        border-radius: 7px;
        padding: 10px;
        margin-bottom: 10px;
        margin-left: -5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .metode-konsultasi {
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
    }

    .metode-konsultasi.online {
        background-color: #a2ffa2;
        /* Warna hijau muda jika online */
        color: #008000;
        /* Warna hijau tua untuk teks */
    }

    .metode-konsultasi.offline {
        background-color: #ffcccc;
        /* Warna merah muda jika offline */
        color: #ff0000;
        /* Warna merah tua untuk teks */
    }
</style>
<style>
    .message-time {
        font-size: 0.8em;
        text-align: right;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chat</div>
                <div class="card-body">
                    <ul class="list-unstyled" id="chat-list" style="max-height: 600px; overflow-y: auto;">
                        <!-- Pesan akan ditampilkan di sini -->
                    </ul>
                    <div class="input-group mb-3" id="pesan-konseling">
                        <textarea class="form-control" id="chat-message" rows="3" placeholder="Ketik pesan Anda..."></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="kirim-chat">Kirim</button>
                        </div>
                    </div>
                    <div id="akhir-konseling-text" style="cursor: pointer; color: black; text-align: center;">Ingin akhiri konseling? Klik disini</div>
                    <form action="{{ route('selesai-notifikasi', $jadwal->id_jadwal) }}" method="POST">
                        @csrf
                        <div id="akhir-konseling-form" style="display: none;">
                            <h6>Permasalahan</h6>
                            <textarea class="form-control mb-4  " name="permasalahan" rows="3" placeholder="Permasalahan"></textarea>
                            <h6>Solusi</h6>
                            <textarea class="form-control" name="solusi" rows="3" placeholder="Solusi"></textarea>
                        </div>
                        <div id="button-akhir-konseling" style="display: none;">
                            <button type="submit" class="btn btn-primary">Selesai</button>
                        </div>
                        <div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="card">
                        <div class="card-header">Data Mahasiswa {{ $jadwal->mahasiswa->nama }}</div>
                        <div class="card-body">
                            <!-- <ul> -->
                            <!-- <div style="background-color: #f0f0f0; border-radius: 7px; padding: 10px; margin-bottom: 10px;"> -->
                            <!-- <li>Nim: {{ $jadwal->mahasiswa->nim }}</li>
                                    <li>Nama: {{ $jadwal->mahasiswa->nama }}</li>
                                    <li>Alamat: {{ $jadwal->mahasiswa->alamat }}</li>
                                    <li>Jenis Kelamin: {{ $jadwal->mahasiswa->jenis_kelamin }}</li>
                                    <li>Email: {{ $jadwal->mahasiswa->email }}</li>
                                    <li>No Hp: {{ $jadwal->mahasiswa->no_hp }}</li> -->
                            <table>
                                <tr>
                                    <td>Nim</td>
                                    <td>: {{ $jadwal->mahasiswa->nim }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{ $jadwal->mahasiswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{ $jadwal->mahasiswa->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>JK</td>
                                    <td>: {{ $jadwal->mahasiswa->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ $jadwal->mahasiswa->email }}</td>
                                </tr>
                                <tr>
                                    <td>No Hp</td>
                                    <td>: {{ $jadwal->mahasiswa->no_hp }}</td>
                                </tr>
                            </table>
                            <!-- </div> -->
                            <!-- </ul> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Riwayat Konseling {{ $jadwal->mahasiswa->nama }}</div>
                        <div class="card-body">
                            <ul>
                                @foreach($riwayatKonselingSelesai as $riwayat)
                                <a href="#" class="lihat-detail" data-jadwal-id="{{ $riwayat->id_jadwal }}">
                                    <li style="list-style-type: circle; color: black;">
                                        {{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d M Y H:i') }}
                                    </li>
                                </a>
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
                                                <textarea class="form-control mb-4" id="permasalahan-detail" rows="3" placeholder="Permasalahan" readonly></textarea>
                                                <h6>Solusi</h6>
                                                <textarea class="form-control" id="solusi-detail" rows="3" placeholder="Solusi" readonly></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-primary d-none" id="lihatChatButton" href="#">Lihat Chat</a>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Pembayaran UKT {{ $jadwal->mahasiswa->nama }}</div>
                        <div class="card-body">
                            <ul>
                                @foreach($pembayaranUkt as $ukt)
                                <a href="#" class="lihat-detail" data-jadwal-id="{{ $ukt->id_jadwal }}">
                                    <li style="list-style-type: circle; color: black;">
                                        Status : {{ $ukt->status_pembayaran }}
                                    </li>
                                    <li style="list-style-type: circle; color: black;">
                                        Tanggal : {{ $ukt->tanggal_pembayaran }}
                                    </li>
                                    <li style="list-style-type: circle; color: black;">
                                        Jumlah : {{ $ukt->jumlah_pembayaran }}
                                    </li>
                                </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.lihat-detail').on('click', function(e) {
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

                    var chatUrl = "{{ route('chat-selesai', ':jadwal_id') }}".replace(':jadwal_id', jadwalId);

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
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('kirim-chat').addEventListener('click', function() {
            var message = document.getElementById('chat-message').value;
            sendMessage(message);
        });

        function getStatusVerifikasi() {
            $.ajax({
                url: "{{ route('get.status.verifikasi', ['jadwal_id' => $jadwal_id]) }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data.status_verifikasi === "Acc") {
                        $("#akhir-konseling-text").show();
                    } else if (data.status_verifikasi === "Selesai") {
                        $("#pesan-konseling").empty().append("<p style='text-align: center; margin: 0 auto; width: 50%;'>Konseling ini telah selesai.</p>");
                        $("#akhir-konseling-form").show();
                        $("textarea[name='permasalahan']").val(data.permasalahan);
                        $("textarea[name='solusi']").val(data.solusi);
                        $("#akhir-konseling-text").empty();
                        $("#button-akhir-konseling").empty();
                    }
                },
                complete: function() {
                    setTimeout(updateChat, 10000);
                }
            });
        }

        function sendMessage(message) {
            $.ajax({
                url: "{{ route('send.chat') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    jadwal_id: "{{ $jadwal_id }}",
                    message: message
                },
                success: function(response) {
                    // Setelah pesan terkirim, kosongkan inputan pesan chat
                    document.getElementById('chat-message').value = '';
                }
            });
        }

        function updateChat() {
            $.ajax({
                url: "{{ route('get.chat', ['jadwal_id' => $jadwal_id]) }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#chat-list").empty();

                    data.messages.forEach(function(message) {
                        var messageClass = (message.pelaku === 'mahasiswa') ? 'bg-primary text-white ml-2' : 'bg-light';
                        var justifyContent = (message.pelaku === 'mahasiswa') ? 'flex-start' : 'flex-end';

                        var createdAt = new Date(message.created_at);
                        var hours = createdAt.getHours().toString().padStart(2, '0');
                        var minutes = createdAt.getMinutes().toString().padStart(2, '0');
                        var formattedTime = `${hours}:${minutes}`;

                        var messageHtml = `
                        <li class="d-flex mb-2 message-container" style="justify-content: ${justifyContent};">
                            <div class="${messageClass} rounded p-2 message">
                                <strong>${message.pelaku}:</strong> ${message.message}
                                <div class="message-time">${formattedTime}</div>
                            </div>
                        </li>
                    `;
                        $("#chat-list").append(messageHtml);
                    });
                },
                complete: function() {
                    setTimeout(updateChat, 10000);
                }
            });
        }

        getStatusVerifikasi();
        updateChat();

        document.getElementById('akhir-konseling-text').addEventListener('click', toggleAkhirKonselingForm);
        document.getElementById('pesan-konseling').addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage();
        });

        function toggleAkhirKonselingForm() {
            const akhirKonselingForm = document.getElementById('akhir-konseling-form');
            const buttonAkhirKonseling = document.getElementById('button-akhir-konseling');
            if (akhirKonselingForm.style.display === 'none' && buttonAkhirKonseling.style.display === 'none') {
                akhirKonselingForm.style.display = 'block';
                buttonAkhirKonseling.style.display = 'block';
            } else {
                akhirKonselingForm.style.display = 'none';
                buttonAkhirKonseling.style.display = 'none';
            }
        }
    });
</script>