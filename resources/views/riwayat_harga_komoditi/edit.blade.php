@extends('layouts.app')

@section('content')
<div class="container container-form container-riwayat">
    <h1>Edit Riwayat Harga Komoditi</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('riwayat_harga_komoditi.update', $riwayatHargaKomoditi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="pasar_id" class="form-label">Pasar</label>
            <select class="form-control" id="pasar_id" name="pasar_id" required>
                @foreach($pasars as $pasar)
                    <option value="{{ $pasar->id }}" {{ $riwayatHargaKomoditi->pasar_id == $pasar->id ? 'selected' : '' }}>{{ $pasar->nama_pasar }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="komoditi_id" class="form-label">Komoditi</label>
            <select class="form-control" id="komoditi_id" name="komoditi_id">
                @foreach($komoditis as $komoditi)
                    <option value="{{ $komoditi->id }}" {{ $riwayatHargaKomoditi->komoditi_id == $komoditi->id ? 'selected' : '' }}>{{ $komoditi->jenis_komoditi }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="produk_komoditi_id" class="form-label">Produk Komoditi</label>
            <select class="form-control" id="produk_komoditi_id" name="produk_komoditi_id">
                @foreach($produkKomoditis as $produk)
                    <option value="{{ $produk->id }}" {{ $riwayatHargaKomoditi->produk_komoditi_id == $produk->id ? 'selected' : '' }}>{{ $produk->nama_produk }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_update" class="form-label">Tanggal Update</label>
            <input type="date" class="form-control" id="tanggal_update" name="tanggal_update" value="{{ $riwayatHargaKomoditi->tanggal_update }}" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $riwayatHargaKomoditi->harga }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="Harga Naik" {{ $riwayatHargaKomoditi->status == 'Harga Naik' ? 'selected' : '' }}>Harga Naik</option>
                <option value="Harga Tetap" {{ $riwayatHargaKomoditi->status == 'Harga Tetap' ? 'selected' : '' }}>Harga Tetap</option>
                <option value="Harga Turun" {{ $riwayatHargaKomoditi->status == 'Harga Turun' ? 'selected' : '' }}>Harga Turun</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection