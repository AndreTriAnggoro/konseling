@extends('layouts.master')

@section('content')

<ul class="navbar-nav" style="display: flex; flex-direction: row;">
    <li class="nav-item" style="margin-right: 10px;">
        <a class="nav-link" href="{{ route('jadwal.dosen') }}">Jadwal Dosen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('buat.jadwal') }}">Buat Jadwal</a>
    </li>
</ul>

@if (session('success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill"/>
        </svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="content">
    <div class="card card-info card-outline">
        <div class="card-body">
            <h1>Form Konseling</h1>

            <form action="{{ route('form.jadwal') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="topik_konseling">Topik Konseling:</label>
                    <select name="topik_konseling" id="topik_konseling" class="form-control">
                        <option value="">Pilih Topik Konseling</option>
                        @foreach ($topikkonseling as $topik)
                            <option value="{{ $topik->nama_topik }}">{{ $topik->nama_topik }}</option>
                        @endforeach
                    </select>
                    @error('topik_konseling')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="metode">Metode:</label>
                    <select name="metode" id="metode" class="form-control" required>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dosen_wali">Dosen Wali:</label>
                    <select name="dosen_wali" id="dosen_wali" class="form-control" required>
                        <option value="">Pilih Dosen Wali</option>
                        @foreach ($dosenwali as $dosen)
                            <option value="{{ $dosen->nama }}">{{ $dosen->nama }}</option>
                        @endforeach
                    </select>
                </div>
 
                <div class="form-group">
                    <label for="tanggal">Tanggal:</label>
                    <input type="datetime-local" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection