@extends('layouts.master')
@section('content')

<div class="content">
    <div class="card card-info card-outline">
        <div class="card-body">
            <h1>Edit Dosenwali</h1>

            <form action="{{ route('dosen.update', $dosen->nip_dosenwali) }}" method="POST">
                @csrf
                @method('PUT') <!-- Method PUT digunakan untuk mengupdate data -->

                <div class="form-group">
                    <label for="nip_dosenwali">NIP:</label>
                    <input type="text" name="nip_dosenwali" id="nip_dosenwali" class="form-control" value="{{ $dosen->nip_dosenwali }}" required>
                    @if ($errors->has('nip_dosenwali'))
                        <div class="alert alert-danger">{{ $errors->first('nip_dosenwali') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $dosen->nama }}" required>
                    @if ($errors->has('nama'))
                        <div class="alert alert-danger">{{ $errors->first('nama') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="id_programstudi">Program Studi:</label>
                    <select name="id_programstudi" id="id_programstudi" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach ($programstudi as $ps)
                            <option value="{{ $ps->id_programstudi }}" {{ $dosen->id_programstudi == $ps->id_programstudi ? 'selected' : '' }}>
                                {{ $ps->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_programstudi'))
                        <div class="alert alert-danger">{{ $errors->first('id_programstudi') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" id="alamat" class="form-control" required>{{ $dosen->alamat }}</textarea>
                    @if ($errors->has('alamat'))
                        <div class="alert alert-danger">{{ $errors->first('alamat') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $dosen->email }}" required>
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $dosen->no_hp }}" required>
                    @if ($errors->has('no_hp'))
                        <div class="alert alert-danger">{{ $errors->first('no_hp') }}</div>
                    @endif
                </div>


                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

@endsection
