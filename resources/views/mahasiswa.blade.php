@extends('layouts.master')
@section('content')

<div class="content">
    <div class="card card-info card-outline">
        <div class="card-body">
            @can('tambah-mahasiswa')
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>
            @endcan
            <a href="#" class="btn btn-success mb-3" id="importButton">Import Excel</a>

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
                @foreach ($mahasiswa as $item)
                <tr>
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

                        @can('hapus-mahasiswa')
                        <form action="{{ route('mahasiswa.destroy', $item->nim) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">Delete</button>
                        </form>
                        @endcan
                    </td>
                    @endif
                    <!--  -->
                </tr>
                @endforeach
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