@extends('layouts.app')

@section('content')
<div class="container container-form container-riwayat">
    <h1>Tambah Riwayat Harga Komoditi</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('riwayat_harga_komoditi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="pasar_id" class="form-label">Pasar</label>
            <select class="form-control" id="pasar_id" name="pasar_id" required>
                @foreach($pasars as $pasar)
                    <option value="{{ $pasar->id }}">{{ $pasar->nama_pasar }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="komoditi_id" class="form-label">Komoditi</label>
            <select class="form-control" id="komoditi_id" name="komoditi_id" required>
                @foreach($komoditis as $komoditi)
                    <option value="{{ $komoditi->id }}">{{ $komoditi->jenis_komoditi }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="produk_komoditi_id" class="form-label">Produk Komoditi</label>
            <select class="form-control" id="produk_komoditi_id" name="produk_komoditi_id">
                @foreach($produkKomoditis as $produk)
                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_update" class="form-label">Tanggal Update</label>
            <input type="date" class="form-control" id="tanggal_update" name="tanggal_update" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" required autofocus>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="Harga Naik">Harga Naik</option>
                <option value="Harga Tetap">Harga Tetap</option>
                <option value="Harga Turun">Harga Turun</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan</button>
    </form>

    <hr>

    <h1>Import Data Riwayat Harga Komoditi</h1>
    <form action="{{ route('riwayat_harga_komoditi.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="excel_file" class="form-label">Pilih File Excel</label>
            <input type="file" class="form-control" id="excel_file" name="excel_file" required>
        </div>
        <button type="submit" class="btn btn-success">Import Data</button>
    </form>

</div>
@endsection