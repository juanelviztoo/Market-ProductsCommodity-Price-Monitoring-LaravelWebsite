@extends('layouts.app')

@section('content')
<div class="container container-form container-kategori">
    <h1>Tambah Kategori</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan</button>
    </form>

    <hr>

    <h1>Import Data Kategori</h1>
    <form action="{{ route('kategori.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-success">Import Data</button>
    </form>
    </div>
@endsection