@extends('layouts.app')

@section('content')
<div class="container">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportPreviewModalLabel">Preview Data Kategori</h5>
                <!-- <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-light" style="text-align: center;">
                        <tr>
                            <th>Nama Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $kategori)
                            <tr>
                                <td class="align-middle">{{ $kategori->nama_kategori }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{ route('kategori.export') }}" class="btn btn-success">Download Table</a>
                <a href="{{ route('kategori.index') }}" class="btn btn-danger">Close</a>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> -->
            </div>
        </div>
    </div>
</div>
@endsection