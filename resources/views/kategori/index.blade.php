@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Kategori</h1>
    @if(Auth::user() && Auth::user()->usertype == 'admin')
    <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
    @endif
    <a href="{{ route('kategori.preview') }}" class="btn btn-success mb-3">Preview Data & Export Kategori to Excel</a>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <table class="table table-light table-striped table-bordered table-hover">
        <thead class="thead-primary" style="text-align: center;">
            <tr>
                <th>Nama Kategori</th>
                @if(Auth::user() && Auth::user()->usertype == 'admin')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $kategori)
                <tr>
                    <td class="align-middle">{{ $kategori->nama_kategori }}</td>
                    @if(Auth::user() && Auth::user()->usertype == 'admin')
                    <td class="text-center align-middle">
                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus kategori {{ $kategori->nama_kategori }}?')">Delete</button>
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
                {{ $kategoris->links('pagination::bootstrap-4') }}
            @endif
        </div>
        <div>
            @if($viewAll)
                <a href="{{ route('kategori.index') }}" class="btn btn-info ml-2 mb-3">Lihat Data Lebih Ringkas</a>
            @else
                <a href="{{ route('kategori.index', ['view_all' => true]) }}" class="btn btn-info ml-2">Lihat Semua Data</a>
            @endif
        </div>
    </div>
</div>
@endsection