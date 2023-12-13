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
    <h1 class="mb-2 mt-3">Tambah Dosen</h1>
    <p class="mb-4 ml-1" style="color: #666;">Lengkapi formulir di bawah ini untuk menambahkan data dosen baru ke dalam sistem. Pastikan untuk memeriksa kembali setiap detail sebelum menyimpan.</p>
    <div class="card card-info card-outline">
        <div class="card-body">

            <form action="{{ route('dosen.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                @csrf
                <div class="col-md-6 mb-3">
                    <label for="nip_dosenwali">NIP:</label>
                    <input type="text" name="nip_dosenwali" id="nip_dosenwali" class="form-control" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="id_programstudi">Program Studi:</label>
                    <select name="id_programstudi" id="id_programstudi" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach($programstudi as $ps)
                        <option value="{{ $ps->id_programstudi }}">{{ $ps->nama_prodi }}</option>
                        @endforeach
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" rows="3" id="alamat" class="form-control" required></textarea>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="no_hp">No. HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group col-md-12 mt-5">
                    <button type="submit" class="btn btn-primary px-5 mx-auto d-block">Simpan</button>
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