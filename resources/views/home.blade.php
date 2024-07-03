@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron text-center">
        <h1>- Welcome to Market Monitor -</h1>
        <h5>Venture Out and Find Your Needs in Determining The Commodity Prices of each Product and its Market.<br>
        We've Provided some Updates of The Commodity Product Prices for The Markets we Maintain,<br>
        Hope You Find Them Handy. Happy to Assist!</h5>
    </div>
    @foreach($kategoris as $kategori)
        <h2 class="h2-home">{{ $kategori->nama_kategori }}</h2>
        <div class="row">
            @foreach($kategori->komoditi as $komoditi)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('storage/gambar_komoditi/' . $komoditi->gambar_komoditi) }}" class="card-img-top" alt="{{ $komoditi->jenis_komoditi }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $komoditi->jenis_komoditi }}</h5>
                            <p class="card-text">Recent Price Averages: 
                                Rp{{ number_format($komoditi->latestAveragePrice ?? 0, 2, ',', '.') }} {{ $komoditi->satuan }}
                            </p>
                            <p>
                                @if($komoditi->latestAveragePrice !== null)
                                    <span class="{{ $komoditi->statusClass }}">
                                        <i class="{{ $komoditi->statusIcon }}"></i> {{ $komoditi->status }}
                                    </span>
                                    <span class="{{ $komoditi->statusClass }}">
                                        <i class="{{ $komoditi->statusIcon }}"></i> Rp {{ number_format($komoditi->priceDiff, 0, ',', '.') }} ({{ $komoditi->percentageChange }}%)
                                    </span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection