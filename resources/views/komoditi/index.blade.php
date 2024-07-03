@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Komoditi</h1>
    @if(Auth::user() && Auth::user()->usertype == 'admin')
    <a href="{{ route('komoditi.create') }}" class="btn btn-primary mb-3">Tambah Komoditi</a>
    @endif
    <a href="{{ route('komoditi.preview') }}" class="btn btn-success mb-3">Preview Data & Export Komoditi to Excel</a>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <table class="table table-light table-striped table-bordered table-hover">
        <thead class="thead-primary" style="text-align: center;">
            <tr>
                <th>Nama Kategori</th>
                <th>Jenis Komoditi</th>
                <th>Gambar Komoditi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($komoditis as $komoditi)
                <tr>
                    <td>{{ $komoditi->kategori->nama_kategori }}</td>
                    <td>{{ $komoditi->jenis_komoditi }}</td>
                    <td><img src="{{ asset('storage/gambar_komoditi/' . $komoditi->gambar_komoditi) }}" alt="{{ $komoditi->jenis_komoditi }}" width="100"></td>
                    @if(Auth::user() && Auth::user()->usertype == 'admin')
                    <td>
                        <a href="{{ route('komoditi.edit', $komoditi->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('komoditi.destroy', $komoditi->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus komoditi {{ $komoditi->jenis_komoditi }}?')">Delete</button>
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection