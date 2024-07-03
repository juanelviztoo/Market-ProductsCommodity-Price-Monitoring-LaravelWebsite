@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Riwayat Harga Komoditi</h1>
    <a href="{{ route('riwayat_harga_komoditi.create') }}" class="btn btn-primary mb-3">Tambah Riwayat Harga Komoditi</a>
    <a href="{{ route('riwayat_harga_komoditi.peview') }}" class="btn btn-success mb-3">Preview Data & Export Riwayat Harga Komoditi to Excel</a>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger fade show" role="alert">{{ session('error') }}</div>
    @endif

    <table class="table table-light table-striped table-bordered table-hover">
        <thead class="thead-primary" style="text-align: center;">
            <tr>
                <th>Pasar</th>
                <th>Jenis Komoditi</th>
                <th>Produk Komoditi</th>
                <th>Tanggal Update</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayats as $riwayat)
                <tr>
                    <td>{{ $riwayat->pasar->nama_pasar }}</td>
                    <td>{{ $riwayat->komoditi->jenis_komoditi }}</td>
                    <td>{{ optional($riwayat->produkKomoditi)->nama_produk ?? 'N/A' }}</td>
                    <td>{{ $riwayat->tanggal_update }}</td>
                    <td>Rp{{ number_format($riwayat->harga, 2, ',', '.') }} {{ optional($riwayat->produkKomoditi)->satuan ?? '' }}</td>
                    <td>
                        @if($riwayat->status == 'Harga Naik')
                            <i class="fas fa-circle text-danger"></i> Harga Naik
                        @elseif($riwayat->status == 'Harga Tetap')
                            <i class="fas fa-circle text-warning"></i> Harga Tetap
                        @else
                            <i class="fas fa-circle text-success"></i> Harga Turun
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('riwayat_harga_komoditi.edit', $riwayat->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('riwayat_harga_komoditi.destroy', $riwayat->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus Riwayat Harga {{ $riwayat->produkKomoditi->nama_produk }} di {{ $riwayat->pasar->nama_pasar }}?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        <div>
            @if(!$viewAll)
                {{ $riwayats->links('pagination::bootstrap-4') }}
            @endif
        </div>
        <div>
            @if($viewAll)
                <a href="{{ route('riwayat_harga_komoditi.index') }}" class="btn btn-info ml-2 mb-3">Lihat Data Lebih Ringkas</a>
            @else
                <a href="{{ route('riwayat_harga_komoditi.index', ['view_all' => true]) }}" class="btn btn-info ml-2">Lihat Semua Data</a>
            @endif
        </div>
    </div>
</div>
@endsection