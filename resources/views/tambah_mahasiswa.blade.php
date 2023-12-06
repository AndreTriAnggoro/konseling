@extends('layouts.master')

@section('content')
<div class="content">
    <div class="card card-info card-outline">
        <div class="card-body">
            <h1 class="mb-3">Tambah Mahasiswa</h1>

            <form action="{{ route('mahasiswa.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6 mb-3">
                    <label for="nim">NIM:</label>
                    <input type="text" name="nim" id="nim" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="id_programstudi">Program Studi:</label>
                    <select name="id_programstudi" id="id_programstudi" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach($programstudi as $ps)
                            <option value="{{ $ps->id_programstudi }}">{{ $ps->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_hp">No. HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>


        </div>
    </div>
</div>
@endsection
