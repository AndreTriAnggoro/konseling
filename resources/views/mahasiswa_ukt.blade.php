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

    <div class="form-outline mb-4" data-mdb-input-init>
        <input type="search" style=" background-color: #f2f2f2;" class="form-control" id="datatable-search-input" placeholder="Search Mahasiswa ...">
    </div>
    <div id="datatable">
    </div>

    <table class="table" id="uktTable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NIM</th>
                <th scope="col">Status Pembayaran</th>
                <th scope="col">Jumlah Pembayaran</th>
                <th scope="col">Tanggal Pembayaran</th>
                <th scope="col">Bukti Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @php
            $offset = ($pembayaranUktMahasiswa->currentPage() - 1) * $pembayaranUktMahasiswa->perPage();
            @endphp
            @foreach($pembayaranUktMahasiswa as $pembayaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pembayaran->nim }}</td>
                <td>
                    @if($pembayaran->status_pembayaran === 'KIP')
                    {{ $pembayaran->status_pembayaran }}
                    @else
                    <form action="{{ route('update_status_pembayaran', $pembayaran->id_pembayaran) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status_pembayaran" class="form-control" onchange="this.form.submit()">
                            <option value="{{ $pembayaran->status_pembayaran }}" selected>{{ $pembayaran->status_pembayaran }}</option>
                            <option value="Lunas" {{ $pembayaran->status_pembayaran === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="KIP" {{ $pembayaran->status_pembayaran === 'KIP' ? 'selected' : '' }}>KIP</option>
                            <!-- Tambahkan opsi dropdown sesuai kebutuhan -->
                        </select>
                    </form>
                    @endif
                </td>
                <td>
                    @if($pembayaran->status_pembayaran === 'KIP')
                    {{ 'KIP' }}
                    @else
                    {{ $pembayaran->jumlah_pembayaran }}
                    @endif
                </td>
                <!-- Tambahkan ini ke dalam kolom status_pembayaran -->

                <td>
                    @if($pembayaran->status_pembayaran === 'KIP')
                    {{ 'KIP' }}
                    @else
                    {{ $pembayaran->tanggal_pembayaran }}
                    @endif
                </td>
                <td>
                    @if($pembayaran->status_pembayaran === 'KIP')
                    {{ 'KIP' }}
                    @else
                    @if($pembayaran->status_pembayaran === 'Lunas')
                    <a href="#" data-toggle="modal" data-target="#buktiPembayaranModal{{ $pembayaran->id_pembayaran }}">
                        Lihat Bukti
                    </a>
                    @else
                    Belum Lunas
                    @endif
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
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <!-- Previous Page Link -->
            @if ($pembayaranUktMahasiswa->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $pembayaranUktMahasiswa->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
            @endif

            <!-- Page Links -->
            @foreach ($pembayaranUktMahasiswa->getUrlRange(1, $pembayaranUktMahasiswa->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $pembayaranUktMahasiswa->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach

            <!-- Next Page Link -->
            @if ($pembayaranUktMahasiswa->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $pembayaranUktMahasiswa->nextPageUrl() }}" rel="next">Next</a>
            </li>
            @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
            @endif
        </ul>
    </nav>
</body>

</html>

@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // ... (your existing code)

        // Search functionality
        $('#datatable-search-input').keyup(function() {
            var searchQuery = $(this).val().toLowerCase();

            // Filter table rows based on search query
            $('#uktTable tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.includes(searchQuery));
            });
        });
    });
</script>