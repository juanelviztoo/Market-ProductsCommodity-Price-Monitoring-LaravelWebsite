@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Produk Komoditi</h1>
    @if(Auth::user() && Auth::user()->usertype == 'admin')
    <a href="{{ route('produk_komoditi.create') }}" class="btn btn-primary mb-3">Tambah Produk Komoditi</a>
    @endif
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
                @if(Auth::user() && Auth::user()->usertype == 'admin')
                <th>Aksi</th>
                @endif
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
                @if(Auth::user() && Auth::user()->usertype == 'admin')
                <td>
                    <a href="{{ route('produk_komoditi.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('produk_komoditi.destroy', $produk->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus produk {{ $produk->nama_produk }}?')">Delete</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        <div>
            @if(!$viewAll)
                {{ $produks->links('pagination::bootstrap-4') }}
            @endif
        </div>
        <div>
            @if($viewAll)
                <a href="{{ route('produk_komoditi.index') }}" class="btn btn-info ml-2 mb-3">Lihat Data Lebih Ringkas</a>
            @else
                <a href="{{ route('produk_komoditi.index', ['view_all' => true]) }}" class="btn btn-info ml-2">Lihat Semua Data</a>
            @endif
        </div>
    </div>
</div>
@endsection
