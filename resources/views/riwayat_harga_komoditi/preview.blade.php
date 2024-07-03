@extends('layouts.app')

@section('content')
<div class="container">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportPreviewModalLabel">Preview Data Riwayat Harga Komoditi</h5>
                <!-- <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light" style="text-align: center;">
                        <tr>
                            <th>Pasar</th>
                            <th>Jenis Komoditi</th>
                            <th>Produk Komoditi</th>
                            <th>Tanggal Update</th>
                            <th>Harga</th>
                            <th>Status</th>
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
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('riwayat_harga_komoditi.export') }}" class="btn btn-success">Download Table</a>
                <a href="{{ route('riwayat_harga_komoditi.index') }}" class="btn btn-danger">Close</a>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> -->
            </div>
        </div>
    </div>
</div>
@endsection