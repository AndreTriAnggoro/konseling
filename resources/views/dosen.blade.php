@extends('layouts.master')
@section('content')

<div class="content">
    <h2 class="mt-3 mb-4">Daftar Dosen</h2>
    @can('tambah-dosen')
    <a href="{{ route('dosen.create') }}" class="btn btn-primary mb-5">Tambah Dosen</a>
    @endcan
    <a href="#" class="btn btn-success mb-5" id="importButton">Import Excel</a>
    <a href="{{ route('dosen.inactive') }}" class="btn btn-primary mb-5" id="buttonDosen">Dosen Tidak Aktif</a>

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
                    <form action="{{ route('import.dosen') }}" method="post" enctype="multipart/form-data">
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


    <table class="table" id="dosenTable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">nip</th>
                <th scope="col">nama</th>
                <th scope="col">programstudi</th>
                <th scope="col">alamat</th>
                <th scope="col">email</th>
                <th scope="col">no hp</th>
                @if (auth()->user()->can('edit-dosen') || auth()->user()->can('hapus-dosen'))
                <th scope="col">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
            $offset = ($dosen->currentPage() - 1) * $dosen->perPage();
            @endphp
            @foreach ($dosen as $item)
            <tr>
                <td>{{ $offset + $loop->iteration }}</td>
                <td>{{ $item->nip_dosenwali }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->programstudi ? $item->programstudi->nama_prodi : 'Tidak ada prodi' }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->no_hp }}</td>
                @if (auth()->user()->can('edit-dosen') || auth()->user()->can('hapus-dosen'))
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="aksiDropdown" style="max-width: 4rem; max-height: 25px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- Three-dot icon -->
                            <i class="fas fa-ellipsis-v"> </i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="aksiDropdown">
                            @can('edit-dosen')
                            <a href="{{ route('dosen.edit', $item->nip_dosenwali) }}" class="dropdown-item">Edit</a>
                            @endcan

                            @can('hapus-dosen')
                            <form action="{{ route('dosen.destroy', $item->nip_dosenwali) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">Delete</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <!-- Previous Page Link -->
            @if ($dosen->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $dosen->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
            @endif

            <!-- Page Links -->
            @foreach ($dosen->getUrlRange(1, $dosen->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $dosen->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach

            <!-- Next Page Link -->
            @if ($dosen->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $dosen->nextPageUrl() }}" rel="next">Next</a>
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
            $('#dosenTable tbody tr').each(function() {
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