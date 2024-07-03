@extends('layouts.app')

@section('content')
<div class="container container-form container-produk">
    <h1>Tambah Produk Komoditi</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('produk_komoditi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="komoditi_id" class="form-label">Komoditi</label>
            <select class="form-control" id="komoditi_id" name="komoditi_id" required>
                @foreach($komoditis as $komoditi)
                <option value="{{ $komoditi->id }}">{{ $komoditi->jenis_komoditi }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required autofocus>
        </div>
        <div class="mb-3">
            <label for="gambar_produk" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" id="gambar_produk" name="gambar_produk">
        </div>
        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <select name="satuan" class="form-control" id="satuan" required>
                <option value="/Kg">/Kg</option>
                <option value="/Liter">/Liter</option>
                <option value="/Buah">/Buah</option>
                <option value="/Ikat">/Ikat</option>
                <option value="/250Gr">/250Gr</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan</button>
    </form>

    <hr>

    <h1>Import Data Produk Komoditi</h1>
    <form action="{{ route('produk_komoditi.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="excel_file" class="form-label">Import File Excel</label>
            <input type="file" class="form-control" id="excel_file" name="excel_file" required>
        </div>
        <button type="submit" class="btn btn-success">Import Data</button>
    </form>
</div>
@endsection
