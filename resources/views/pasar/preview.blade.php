@extends('layouts.app')

@section('content')
<div class="container container-preview-pasar">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportPreviewModalLabel">Preview Data Pasar</h5>
                <!-- <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light" style="text-align: center;">
                        <tr>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Kode Kota</th>
                            <th>Nama Pasar</th>
                            <th>Gambar Pasar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pasars as $pasar)
                            <tr>
                                <td class="align-middle">{{ $pasar->provinsi }}</td>
                                <td class="align-middle">{{ $pasar->kota }}</td>
                                <td class="align-middle">{{ $pasar->kode_kota }}</td>
                                <td class="align-middle">{{ $pasar->nama_pasar }}</td>
                                <td class="text-center align-middle"><img src="{{ asset('storage/gambar_pasar/' . $pasar->gambar_pasar) }}" alt="{{ $pasar->nama_pasar }}" width="100"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('pasar.export') }}" class="btn btn-success">Download Table</a>
                <a href="{{ route('pasar.index') }}" class="btn btn-danger">Close</a>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> -->
            </div>
        </div>
    </div>
</div>
@endsection
