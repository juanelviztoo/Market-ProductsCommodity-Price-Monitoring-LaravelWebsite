@extends('layouts.app')

@section('content1')
<div>
    <style>
        .form-group.d-flex {
            align-items: flex-end; /* Align to the bottom */
            gap: 10px; /* Space between elements */
        }
        .form-group.d-flex .form-control {
            width: auto; /* Allow auto width */
            max-width: 400px; /* Set a larger max width */
        }
        .search-bar-container {
            position: relative;
            width: 300px; /* Adjust the width of the search bar container */
        }
        .search-bar-container input {
            padding-left: 30px; /* Space for the icon */
        }
        .search-bar-container .search-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #999;
        }
        .bold-label {
            font-weight: bold; /* Make label bold */
        }
    </style>

    <header style="background-image: url('storage/background/HD-background3.jpg');">
        <div class="parallax-content">
            <h1>Welcome to Market Monitor</h1>
            <h5>Venture Out and Find Your Needs in Determining The Commodity Prices of each Product and its Market.<br>
            We've Provided some Updates of The Commodity Product Prices for The Markets we Maintain,<br>
            Hope You Find Them Handy. Happy to Assist!</h5>
        </div>
    </header>
</div>
<div class="after-parallax">
    <div class="container">
        <h2 class="main-title">Perkembangan Harga Rata-Rata Komoditi Nasional</h2>
        <div class="card kategori-card shadow radius">
            <div class="card-body">
                <div class="form-group d-flex">
                    <div>
                        <label for="kategori-select">Jenis Data Kategori</label>
                        <select id="kategori-select" class="form-control radius mt-2" style="width: 300px;">
                            <option value="semua">Semua</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-bar-container">
                        <input type="text" id="search-bar" class="form-control radius" placeholder="Cari Komoditi">
                        <i class="search-icon fas fa-search"></i>
                    </div>
                </div>
                @foreach($kategoris as $kategori)
                    <div class="kategori-section" data-kategori-id="{{ $kategori->id }}">
                        <h2 class="card-title-kategori">{{ $kategori->nama_kategori }}</h2>
                        <div class="row">
                            @foreach($kategori->komoditi as $komoditi)
                                <div class="col-md-4 mb-4">
                                    <div class="card card-komoditi radius">
                                        <div class="card-front">
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
                                        <div class="card-back">
                                            {!! $komoditi->chart !!}
                                            {!! $komoditi->chartScript !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="main-title">Perkembangan Harga Produk Komoditi Nasional</h2>
            <div class="empty-card card shadow radius">
                <div class="card-body">
                    <div class="form-group">
                        <label for="empty-select">Jenis Data Panel Kosong</label>
                        <select id="empty-select" class="form-control radius">
                            <option value="semua">Semua</option>
                            <!-- Tambahkan opsi sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="row">
                        <!-- Tambahkan card-card seperti yang ada di kategori komoditi -->
                        <!-- Contoh card kosong -->
                        <div class="col-md-4 mb-4">
                            <div class="card card-komoditi radius">
                                <div class="card-body">
                                    <h5 class="card-title">Judul Kosong</h5>
                                    <p class="card-text">Isi kosong untuk card.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Tambahkan card-card lainnya sesuai kebutuhan -->
                    </div>
                </div>
            </div>
    </div>
</div>

<script>
    document.querySelectorAll('.card-komoditi').forEach(card => {
        card.addEventListener('click', function() {
            card.classList.toggle('flipped');
        });
    });

    document.getElementById('kategori-select').addEventListener('change', function() {
        filterKomoditi();
    });

    document.getElementById('search-bar').addEventListener('input', function() {
        filterKomoditi();
    });

    function filterKomoditi() {
        var selectedKategori = document.getElementById('kategori-select').value.toLowerCase();
        var searchQuery = document.getElementById('search-bar').value.toLowerCase();
        var kategoriSections = document.querySelectorAll('.kategori-section');

        kategoriSections.forEach(function(section) {
            var komoditiCards = section.querySelectorAll('.card-komoditi');
            var showSection = false;

            komoditiCards.forEach(function(card) {
                var komoditiName = card.querySelector('.card-title').innerText.toLowerCase();
                var isMatch = komoditiName.includes(searchQuery);
                var isKategoriMatch = selectedKategori === 'semua' || section.getAttribute('data-kategori-id') === selectedKategori;

                if (isMatch && isKategoriMatch) {
                    card.style.display = 'block';
                    showSection = true;
                } else {
                    card.style.display = 'none';
                }
            });

            section.style.display = showSection ? 'block' : 'none';
        });
    }

    // Trigger the change event to display all categories initially
    document.getElementById('kategori-select').dispatchEvent(new Event('change'));
</script>
@endsection