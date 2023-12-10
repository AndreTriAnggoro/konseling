@extends('layouts.master')
@section('content')

<div class="content">
    
        <div class="card-body">
            @can('tambah-dosen')
            <a href="{{ route('dosen.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>
            @endcan
            <a href="#" class="btn btn-success mb-3" id="importButton">Import Excel</a>

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

            @if (session('importError'))
            <div class="alert alert-danger mb-3">
                {{ session('importError') }}
            </div>
            @endif


            <table class="table table-bordered">
                <tr>
                    <th>nip</th>
                    <th>nama</th>
                    <th>programstudi</th>
                    <th>alamat</th>
                    <th>email</th>
                    <th>no hp</th>
                    @if (auth()->user()->can('edit-dosen') || auth()->user()->can('hapus-dosen'))
                    <th>Aksi</th>
                    @endif
                </tr>
                @foreach ($dosen as $item)
                <tr>
                    <td>{{ $item->nip_dosenwali }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->programstudi ? $item->programstudi->nama_prodi : 'Tidak ada prodi' }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->no_hp }}</td>
                    @if (auth()->user()->can('edit-dosen') || auth()->user()->can('hapus-dosen'))
                    <td>
                        @can('edit-dosen')
                        <a href="{{ route('dosen.edit', $item->nip_dosenwali) }}" class="btn btn-warning">Edit</a>
                        @endcan

                        @can('hapus-dosen')
                        <form action="{{ route('dosen.destroy', $item->nip_dosenwali) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">Delete</button>
                        </form>
                        @endcan
                    </td>
                    @endif
                </tr>
                @endforeach
            </table>
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