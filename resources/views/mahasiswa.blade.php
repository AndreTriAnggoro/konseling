@extends('layouts.master')
@section('content')

<div class="content">
    
        <div class="card-body">
            @can('tambah-mahasiswa')
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>
            @endcan
            <a href="#" class="btn btn-success mb-3" id="importButton">Import Excel</a>
            <a href="{{ route('mahasiswa.inactive') }}" class="btn btn-primary mb-3" id="buttonMahasiswa">Mahasiswa Tidak Aktif</a>

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

            @if (session('importError'))
            <div class="alert alert-danger mb-3">
                {{ session('importError') }}
            </div>
            @endif

            <table class="table" id="example">
                <thead>
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
                </thead>
                @foreach ($mahasiswa as $item)
                <tr @if ($item->trashed()) style="background-color: #ffcccc;" @endif>
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
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">Non Aktif</button>
                        </form>
                        @endcan
                    </td>
                    @endif
                    <!--  -->
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

        // Menangani perubahan pada input file
        $('#excel_file').change(function() {
            // Mendapatkan nama file yang dipilih
            var fileName = $(this).val().split('\\').pop();
            // Memperbarui label nama file di modal
            $('#fileLabel').text(fileName);
            // Menampilkan nama file di luar modal (opsional)
            $('#selectedFileName').text('File yang dipilih: ' + fileName);
        });

        // $('#searchButton').click(function() {
        //     var searchQuery = $('#search_query').val().toLowerCase();

        //     // Hapus pewarnaan sebelumnya
        //     $('table tbody tr').find('td').each(function() {
        //         var cellText = $(this).text().toLowerCase();
        //         if (cellText.includes(searchQuery)) {
        //             $(this).css('background-color', '#ffff99'); // Ganti dengan warna yang diinginkan
        //         } else {
        //             $(this).css('background-color', '');
        //         }
        //     });

        //     // Filter baris berdasarkan kata kunci
        //     $('table tbody tr').filter(function() {
        //         var rowText = $(this).text().toLowerCase();
        //         $(this).toggle(rowText.includes(searchQuery));
        //     });
        // });


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