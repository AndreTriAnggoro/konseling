@extends('layouts.master')
@section('content')

<div class="content">
    <div class="card card-info card-outline">
        <div class="card-body">
            <a href="{{ route('mahasiswa') }}" class="btn btn-primary mb-3" id="buttonMahasiswa">Mahasiswa Aktif</a>

            <div class="row mb-3">
                <div class="col-md-8">
                    <input type="text" name="search_query" class="form-control" id="search_query" placeholder="Cari data" aria-label="Cari data">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" id="searchButton">Cari</button>
                </div>
            </div>

            @if (session('importError'))
            <div class="alert alert-danger mb-3">
                {{ session('importError') }}
            </div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th>nim</th>
                    <th>nama</th>
                    <th>programstudi</th>
                    <th>jenis kelamin</th>
                    <th>alamat</th>
                    <th>email</th>
                    <th>no hp</th>
                    @if (auth()->user()->can('edit-mahasiswa') || auth()->user()->can('hapus-mahasiswa'))
                    <th>Aksi</th>
                    @endif
                </tr>
                @foreach ($mahasiswaInactive as $item)
                <tr @if ($item->trashed()) @endif>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->programstudi ? $item->programstudi->nama_prodi : 'Tidak ada prodi' }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->no_hp }}</td>
                    @if (auth()->user()->can('edit-mahasiswa') || auth()->user()->can('hapus-mahasiswa'))
                    <td>
                        @can('edit-mahasiswa')
                        <a href="{{ route('mahasiswa.edit', $item->nim) }}" class="btn btn-warning">Edit</a>
                        @endcan

                        <a href="{{ route('mahasiswa.restore', $item->nim) }}" class="btn btn-warning">Aktifkan</a>

                    </td>
                    @endif
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Menangani klik pada tautan Import Excel
        $('#importButton').click(function() {
            // Menampilkan modal Import Excel
            $('#importModal').modal('show');
        });

        // Menangani perubahan pada input file
        $('#excel_file').change(function() {
            // Mendapatkan nama file yang dipilih
            var fileName = $(this).val().split('\\').pop();
            // Memperbarui label nama file di modal
            $('#fileLabel').text(fileName);
            // Menampilkan nama file di luar modal (opsional)
            $('#selectedFileName').text('File yang dipilih: ' + fileName);
        });

        $('#searchButton').click(function() {
            var searchQuery = $('#search_query').val().toLowerCase();

            // Hapus pewarnaan sebelumnya
            $('table tbody tr').find('td').each(function() {
                var cellText = $(this).text().toLowerCase();
                if (cellText.includes(searchQuery)) {
                    $(this).css('background-color', '#ffff99'); // Ganti dengan warna yang diinginkan
                } else {
                    $(this).css('background-color', '');
                }
            });

            // Filter baris berdasarkan kata kunci
            $('table tbody tr').filter(function() {
                var rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.includes(searchQuery));
            });
        });
    });
</script>