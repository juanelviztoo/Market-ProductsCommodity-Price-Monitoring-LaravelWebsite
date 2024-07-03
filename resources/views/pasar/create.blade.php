@extends('layouts.app')

@section('content')
<div class="container container-form container-pasar">
    <h1>Tambah Pasar</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pasar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="provinsi" class="form-label">Provinsi</label>
            <input type="text" class="form-control" id="provinsi" name="provinsi" required autofocus>
        </div>
        <div class="mb-3">
            <label for="kota" class="form-label">Kota</label>
            <input type="text" class="form-control" id="kota" name="kota" required>
        </div>
        <div class="mb-3">
            <label for="kode_kota" class="form-label">Kode Kota</label>
            <input type="text" class="form-control" id="kode_kota" name="kode_kota" required>
        </div>
        <div class="mb-3">
            <label for="nama_pasar" class="form-label">Nama Pasar</label>
            <input type="text" class="form-control" id="nama_pasar" name="nama_pasar" required>
        </div>
        <div class="mb-3">
            <label for="gambar_pasar" class="form-label">Gambar Pasar</label>
            <input type="file" class="form-control" id="gambar_pasar" name="gambar_pasar" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan</button>
    </form>

    <hr>

    <h1>Import Data Pasar</h1>
    <form action="{{ route('pasar.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-success">Import Data</button>
    </form>
</div>
@endsection