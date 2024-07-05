@extends('layouts.app')

@section('content')
<div class="container">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportPreviewModalLabel">Preview Data Produk Komoditi</h5>
                <!-- <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light" style="text-align: center;">
                    <tr>
                        <th>Jenis Komoditi</th>
                        <th>Nama Produk</th>
                        <th>Gambar Produk</th>
                        <th>Satuan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td class="align-middle">{{ $produk->komoditi->jenis_komoditi }}</td>
                        <td class="align-middle">{{ $produk->nama_produk }}</td>
                        <td class="text-center align-middle">
                            @if($produk->gambar_produk)
                            <img src="{{ asset('storage/gambar_produk/'.$produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" width="100">
                            @endif
                        </td>
                        <td class="align-middle">{{ $produk->satuan }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('produk_komoditi.export') }}" class="btn btn-success">Download Table</a>
                <a href="{{ route('produk_komoditi.index') }}" class="btn btn-danger">Close</a>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> -->
            </div>
        </div>
    </div>
</div>
@endsection