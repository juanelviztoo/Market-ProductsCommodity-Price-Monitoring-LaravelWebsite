@extends('layouts.app')

@section('content')
<div class="container container-form container-pasar">
    <h1>Edit Pasar</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pasar.update', $pasar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="provinsi" class="form-label">Provinsi</label>
            <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ $pasar->provinsi }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="kota" class="form-label">Kota</label>
            <input type="text" class="form-control" id="kota" name="kota" value="{{ $pasar->kota }}" required>
        </div>
        <div class="mb-3">
            <label for="kode_kota" class="form-label">Kode Kota</label>
            <input type="text" class="form-control" id="kode_kota" name="kode_kota" value="{{ $pasar->kode_kota }}" required>
        </div>
        <div class="mb-3">
            <label for="nama_pasar" class="form-label">Nama Pasar</label>
            <input type="text" class="form-control" id="nama_pasar" name="nama_pasar" value="{{ $pasar->nama_pasar }}" required>
        </div>
        <div class="mb-3">
            <label for="gambar_pasar" class="form-label">Gambar Pasar</label>
            <input type="file" class="form-control" id="gambar_pasar" name="gambar_pasar">
            <img src="{{ asset('storage/gambar_pasar/' . $pasar->gambar_pasar) }}" width="100" class="mt-3">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection