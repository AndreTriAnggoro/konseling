@extends('layouts.master')

@section('content')
<div class="content">
    <div class="card card-info card-outline">
        <div class="card-body">
            <h1>Tambah Dosen</h1>

            <form action="{{ route('dosen.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nip_dosenwali">NIP:</label>
                    <input type="text" name="nip_dosenwali" id="nip_dosenwali" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="id_programstudi">Program Studi:</label>
                    <select name="id_programstudi" id="id_programstudi" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach($programstudi as $ps)
                            <option value="{{ $ps->id_programstudi }}">{{ $ps->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>


        </div>
    </div>
</div>
@endsection
