@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Pasar</h1>
    @if(Auth::user() && Auth::user()->usertype == 'admin')
    <a href="{{ route('pasar.create') }}" class="btn btn-primary mb-3">Tambah Pasar</a>
    @endif
    <a href="{{ route('pasar.preview') }}" class="btn btn-success mb-3">Preview Data & Export Pasar to Excel</a>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <table class="table table-light table-striped table-bordered table-hover">
        <thead class="thead-primary" style="text-align: center;">
            <tr>
                <th>Provinsi</th>
                <th>Kota</th>
                <th>Kode Kota</th>
                <th>Nama Pasar</th>
                <th>Gambar Pasar</th>
                @if(Auth::user() && Auth::user()->usertype == 'admin')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($pasars as $pasar)
                <tr>
                    <td>{{ $pasar->provinsi }}</td>
                    <td>{{ $pasar->kota }}</td>
                    <td>{{ $pasar->kode_kota }}</td>
                    <td>{{ $pasar->nama_pasar }}</td>
                    <td><img src="{{ asset('storage/gambar_pasar/' . $pasar->gambar_pasar) }}" alt="{{ $pasar->nama_pasar }}" width="100"></td>
                    @if(Auth::user() && Auth::user()->usertype == 'admin')
                    <td>
                        <a href="{{ route('pasar.edit', $pasar->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pasar.destroy', $pasar->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus {{ $pasar->nama_pasar }}?')">Delete</button>
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
                {{ $pasars->links('pagination::bootstrap-4') }}
            @endif
        </div>
        <div>
            @if($viewAll)
                <a href="{{ route('pasar.index') }}" class="btn btn-info ml-2 mb-3">Lihat Data Lebih Ringkas</a>
            @else
                <a href="{{ route('pasar.index', ['view_all' => true]) }}" class="btn btn-info ml-2">Lihat Semua Data</a>
            @endif
        </div>
    </div>
</div>
@endsection