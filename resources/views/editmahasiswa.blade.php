<style>
    .container {
        max-width: 600px;
        /* Sesuaikan lebar container sesuai kebutuhan */
        margin: 0 auto;
    }

    .content {
        /* background-color: #fff; */
        /* Warna latar belakang */
        padding: 20px;
        border-radius: 8px;
        /* Sudut elemen yang membulat */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Efek bayangan */
    }

    h1 {
        font-size: 28px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    p {
        color: #666;
        font-size: 16px;
        line-height: 1.5;
    }
</style>
@extends('layouts.master')
@section('content')

<div class="content">
    <h1 class="mb-2 mt-3">Ubah Data Mahasiswa</h1>
    <p class="mb-4 ml-1" style="color: #666;">Lengkapi formulir di bawah ini untuk mengubah data mahasiswa ke dalam sistem. Pastikan untuk memeriksa kembali setiap data yang diubah sebelum menyimpan.</p>
    <div class="card card-info card-outline">
        <div class="card-body">

            <form action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" method="POST" class="row g-3 needs-validation" novalidate>
                @csrf
                @method('PUT') <!-- Method PUT digunakan untuk mengupdate data -->

                <div class="form-group col-md-6">
                    <label for="nim">NIM:</label>
                    <input type="text" name="nim" id="nim" class="form-control" value="{{ $mahasiswa->nim }}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $mahasiswa->nama }}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
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
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki" {{ $mahasiswa->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $mahasiswa->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $mahasiswa->email }}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="no_hp">No. HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $mahasiswa->no_hp }}" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $mahasiswa->alamat }}</textarea>
                    <div class="valid-feedback">
                        Looks good!
                    </div>

                </div>
                <div class="form-group col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary mx-auto d-block">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    });
</script>