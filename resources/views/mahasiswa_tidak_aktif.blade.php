@extends('layouts.master')
@section('content')

<div class="content">
    <h2 class="mt-3 mb-4">Daftar Mahasiswa Sudah Tidak Aktif</h2>
    <a href="{{ route('mahasiswa') }}" class="btn btn-primary mb-5" id="buttonMahasiswa">Mahasiswa Aktif</a>

    <div class="form-outline mb-4" data-mdb-input-init>
        <input type="search" style=" background-color: #f2f2f2;" class="form-control" id="datatable-search-input" placeholder="Search Mahasiswa ...">
    </div>
    <div id="datatable">
    </div>

    @if (session('importError'))
    <div class="alert alert-danger mb-3">
        {{ session('importError') }}
    </div>
    @endif

    <table class="table" id="mahasiswaTidakAktifTable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">nim</th>
                <th scope="col">nama</th>
                <th scope="col">programstudi</th>
                <th scope="col">jenis kelamin</th>
                <th scope="col">alamat</th>
                <th scope="col">email</th>
                <th scope="col">no hp</th>
                @if (auth()->user()->can('edit-mahasiswa') || auth()->user()->can('hapus-mahasiswa'))
                <th scope="col">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswaInactive as $item)
            <tr @if ($item->trashed()) @endif>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->programstudi ? $item->programstudi->nama_prodi : 'Tidak ada prodi' }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->no_hp }}</td>
                @if (auth()->user()->can('edit-mahasiswa') || auth()->user()->can('hapus-mahasiswa'))
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="aksiDropdown" style="max-width: 4rem; max-height: 25px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- Three-dot icon -->
                            <i class="fas fa-ellipsis-v"> </i>
                        </button>

                        <div class="dropdown-menu" aria-labelledby="aksiDropdown">
                            <a href="{{ route('mahasiswa.restore', $item->nim) }}" class="dropdown-item">Aktifkan</a>
                        </div>
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // ... (your existing code)

        // Search functionality
        $('#datatable-search-input').keyup(function() {
            var searchQuery = $(this).val().toLowerCase();

            // Filter table rows based on search query
            $('#mahasiswaTidakAktifTable tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.includes(searchQuery));
            });
        });
    });
</script>
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
    });
</script>