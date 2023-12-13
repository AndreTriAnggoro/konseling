@extends('layouts.master')
@section('content')

<div class="content">
    <!-- <div class="card card-info card-outline"> -->
    <div class="card-body">
        <!-- @can('tambah-mahasiswa')
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>
            @endcan -->
        <a href="#" class="btn btn-success mb-3" id="importNilaiButton">Import Excel</a>

        <!-- Modal Import Excel -->
        <div class="modal fade" id="importModalNilai" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('importNilai') }}" method="post" enctype="multipart/form-data">
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

        <div class="form-outline mb-4" data-mdb-input-init>
            <input type="search" style=" background-color: #f2f2f2;" class="form-control" id="datatable-search-input" placeholder="Search Mahasiswa ...">
        </div>
        <div id="datatable">
        </div>

        <table class="table" id="nilaiTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Semester 1</th>
                    <th scope="col">Semester 2</th>
                    <th scope="col">Semester 3</th>
                    <th scope="col">Semester 4</th>
                    <th scope="col">Semester 5</th>
                    <th scope="col">Semester 6</th>
                    <th scope="col">Semester 7</th>
                    <th scope="col">Semester 8</th>
                    <th scope="col">IPK</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nilai as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->semester1 }}</td>
                    <td>{{ $item->semester2 }}</td>
                    <td>{{ $item->semester3 }}</td>
                    <td>{{ $item->semester4 }}</td>
                    <td>{{ $item->semester5 }}</td>
                    <td>{{ $item->semester6 }}</td>
                    <td>{{ $item->semester7 }}</td>
                    <td>{{ $item->semester8 }}</td>
                    <td>{{ $item->ipk }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Menangani klik pada tautan Import Excel
        $('#importNilaiButton').click(function() {
            // Menampilkan modal Import Excel
            $('#importModalNilai').modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // ... (your existing code)

        // Search functionality
        $('#datatable-search-input').keyup(function() {
            var searchQuery = $(this).val().toLowerCase();

            // Filter table rows based on search query
            $('#nilaiTable tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.includes(searchQuery));
            });
        });
    });
</script>