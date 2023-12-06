@extends('layouts.master')
@section('content')

<div class="content">
    <div class="card card-info card-outline">
        <div class="card-body">
            <h1>Edit Mahasiswa</h1>

            <form action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT') <!-- Method PUT digunakan untuk mengupdate data -->

                <div class="form-group col-md-6">
                    <label for="nim">NIM:</label>
                        <div class="input-group-prepend d-none" id="nim-prepend">
                            <span class="input-group-text">{{ $mahasiswa->nim }}</span>
                        </div>
                    <input type="text" name="nim" id="nim" class="form-control" value="{{ $mahasiswa->nim }}" required>
                    @if ($errors->has('nim'))
                    <div class="alert alert-danger">{{ $errors->first('nim') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $mahasiswa->nama }}" required>
                    @if ($errors->has('nama'))
                    <div class="alert alert-danger">{{ $errors->first('nama') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="id_programstudi">Program Studi:</label>
                    <select name="id_programstudi" id="id_programstudi" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach ($programstudi as $ps)
                        <option value="{{ $ps->id_programstudi }}" {{ $mahasiswa->id_programstudi == $ps->id_programstudi ? 'selected' : '' }}>
                            {{ $ps->nama_prodi }}
                        </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_programstudi'))
                    <div class="alert alert-danger">{{ $errors->first('id_programstudi') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki" {{ $mahasiswa->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $mahasiswa->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @if ($errors->has('jenis_kelamin'))
                    <div class="alert alert-danger">{{ $errors->first('jenis_kelamin') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $mahasiswa->tanggal_lahir }}" required>
                    @if ($errors->has('tanggal_lahir'))
                    <div class="alert alert-danger">{{ $errors->first('tanggal_lahir') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $mahasiswa->email }}" required>
                    @if ($errors->has('email'))
                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="no_hp">No. HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $mahasiswa->no_hp }}" required>
                    @if ($errors->has('no_hp'))
                    <div class="alert alert-danger">{{ $errors->first('no_hp') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $mahasiswa->alamat }}</textarea>
                    @if ($errors->has('alamat'))
                    <div class="alert alert-danger">{{ $errors->first('alamat') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Simpan nilai NIM awal saat halaman dimuat
        var originalNimValue = $('#nim').val();

        // Saat pengguna mengetik di input nim
        $('#nim').on('input', function() {
            // Periksa apakah nilai sebelum perubahan berbeda dengan nilai setelah perubahan
            var currentNimValue = $(this).val();
            if (originalNimValue !== currentNimValue) {
                // Jika berbeda, tampilkan prepend
                $('#nim-prepend').removeClass('d-none');
            } else {
                // Jika tidak, sembunyikan prepend
                $('#nim-prepend').addClass('d-none');
            }
        });
    });
</script>

@endsection