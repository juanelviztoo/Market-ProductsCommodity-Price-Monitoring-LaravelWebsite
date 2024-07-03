@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Produk Komoditi</h1>
    <a href="{{ route('produk_komoditi.create') }}" class="btn btn-primary mb-3">Tambah Produk Komoditi</a>
    <a href="{{ route('produk_komoditi.preview') }}" class="btn btn-success mb-3">Preview Data & Export Produk Komoditi to Excel</a>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <table class="table table-light table-striped table-bordered table-hover">
        <thead class="thead-primary" style="text-align: center;">
            <tr>
                <th>Jenis Komoditi</th>
                <th>Nama Produk</th>
                <th>Gambar Produk</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $produk)
            <tr>
                <td>{{ $produk->komoditi->jenis_komoditi }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>
                    @if($produk->gambar_produk)
                    <img src="{{ asset('storage/gambar_produk/'.$produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" width="100">
                    @endif
                </td>
                <td>{{ $produk->satuan }}</td>
                <td>
                    <a href="{{ route('produk_komoditi.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('produk_komoditi.destroy', $produk->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus produk {{ $produk->nama_produk }}?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
