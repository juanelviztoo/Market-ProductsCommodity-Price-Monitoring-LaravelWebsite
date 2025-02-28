@extends('layouts.app')

@section('content')
<div class="container">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportPreviewModalLabel">Preview Data Komoditi</h5>
                <!-- <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light" style="text-align: center;">
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Jenis Komoditi</th>
                            <th>Gambar Komoditi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($komoditis as $komoditi)
                        <tr>
                            <td class="align-middle">{{ $komoditi->kategori->nama_kategori }}</td>
                            <td class="align-middle">{{ $komoditi->jenis_komoditi }}</td>
                            <td class="text-center align-middle"><img src="{{ asset('storage/gambar_komoditi/' . $komoditi->gambar_komoditi) }}" alt="{{ $komoditi->jenis_komoditi }}" width="100"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('komoditi.export') }}" class="btn btn-success">Download Table</a>
                <a href="{{ route('komoditi.index') }}" class="btn btn-danger">Close</a>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> -->
            </div>
        </div>
    </div>
</div>
@endsection