@extends('layouts.master')
@section('content')

<div class="content">
    <div class="card card-info card-outline">
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
                    <th>semester 1</th>
                    <th>semester 2</th>
                    <th>semester 3</th>
                    <th>semester 4</th>
                    <th>semester 5</th>
                    <th>semester 6</th>
                    <th>semester 7</th>
                    <th>semester 8</th>
                    <th>ipk</th>
                </tr>
                @foreach ($nilai as $item)
                <tr>
                    <td>{{ $item->nim }}</td>
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