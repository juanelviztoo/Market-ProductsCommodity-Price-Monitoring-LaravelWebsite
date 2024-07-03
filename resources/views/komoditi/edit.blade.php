@extends('layouts.app')

@section('content')
<div class="container container-form container-komoditi">
    <h1>Edit Komoditi</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('komoditi.update', $komoditi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select class="form-control" id="kategori_id" name="kategori_id">
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $komoditi->kategori_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="jenis_komoditi" class="form-label">Jenis Komoditi</label>
            <input type="text" class="form-control" id="jenis_komoditi" name="jenis_komoditi" value="{{ $komoditi->jenis_komoditi }}" required>
        </div>
        <div class="mb-3">
            <label for="gambar_komoditi" class="form-label">Gambar Komoditi</label>
            <input type="file" class="form-control" id="gambar_komoditi" name="gambar_komoditi">
            <img src="{{ asset('storage/gambar_komoditi/' . $komoditi->gambar_komoditi) }}" width="100" class="mt-3">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection