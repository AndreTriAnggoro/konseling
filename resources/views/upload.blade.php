@extends('layouts.master')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran</title>
</head>
<body>
    <h2>Upload Bukti Pembayaran</h2>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('mahasiswa.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="file">Pilih File Bukti Pembayaran:</label>
        <input type="file" name="file" required>
        
        <label for="jumlah_pembayaran">Jumlah Pembayaran:</label>
        <input type="number" name="jumlah_pembayaran" required>
        
        <label for="tanggal_pembayaran">Tanggal Pembayaran:</label>
        <input type="date" name="tanggal_pembayaran" required>

        <input type="submit" value="Upload">
    </form>
</body>
</html>
@endsection
