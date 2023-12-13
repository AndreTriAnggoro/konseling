@extends('layouts.master')
@section('content')

<div class="content">
    <h2 class="mt-3 mb-4">Daftar Mahasiswa</h2>
    @can('tambah-mahasiswa')
    <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-5">Tambah Mahasiswa</a>
    @endcan
    <a href="#" class="btn btn-success mb-5" id="importButton">Import Excel</a>
    <a href="{{ route('mahasiswa.inactive') }}" class="btn btn-primary mb-5" id="buttonMahasiswa">Mahasiswa Tidak Aktif</a>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="excel_file" class="font-weight-bold">Pilih File Excel (.xlsx)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel_file" name="excel_file" accept=".xlsx" required>
                                <label class="custom-file-label" for="excel_file" id="fileLabel">Pilih file</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-excel"></i> Import</button>
                    </form>
                    <div id="selectedFileName"></div>
                </div>
            </div>
        </div>
    </div>

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

    <table class="table" id="mahasiswaTable">
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
            @php
            $offset = ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage();
            @endphp
            @foreach ($mahasiswa as $item)
            <tr @if ($item->trashed()) style="background-color: #ffcccc;" @endif>
                <td>{{ $offset + $loop->iteration }}</td>
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
                            @can('edit-mahasiswa')
                            <a class="dropdown-item" href="{{ route('mahasiswa.edit', $item->nim) }}">Edit</a>
                            @endcan

                            @can('hapus-mahasiswa')
                            <form action="{{ route('mahasiswa.destroy', $item->nim) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">Non Aktif</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </td>
                @endif
                <!--  -->
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <!-- Previous Page Link -->
            @if ($mahasiswa->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $mahasiswa->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
            @endif

            <!-- Page Links -->
            @foreach ($mahasiswa->getUrlRange(1, $mahasiswa->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $mahasiswa->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach

            <!-- Next Page Link -->
            @if ($mahasiswa->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $mahasiswa->nextPageUrl() }}" rel="next">Next</a>
            </li>
            @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
            @endif
        </ul>
    </nav>
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
            $('#mahasiswaTable tbody tr').each(function() {
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
<script>
    $(document).ready(function() {
        // Menangani klik pada tautan Mahasiswa Tidak Aktif
        $('#buttonMahasiswa').click(function() {
            // Memuat data mahasiswa tidak aktif menggunakan AJAX
            $.get("{{ route('mahasiswa.inactive') }}", function(data) {
                // Mengganti data tabel dengan data yang dimuat
                updateTable(data);
            });
        });
    });

    function updateTable(data) {
        // Menghapus data tabel yang ada sebelumnya
        $('#mahasiswaTable tbody').empty();

        // Memasukkan data baru ke dalam tabel
        data.forEach(function(item) {
            $('#mahasiswaTable tbody').append('<tr><td>' + item.nim + '</td><td>' + item.nama + '</td></tr>');
            // Tambahkan kolom lain sesuai kebutuhan
        });
    }
</script>