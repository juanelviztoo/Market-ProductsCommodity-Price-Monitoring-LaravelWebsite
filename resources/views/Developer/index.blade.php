@extends('layouts.app')

@section('content')
<div class="container developer-container">
    <h1 class="h1-developer">Profile Pengembang</h1>
    <div class="row">
        @foreach($profiles as $profile)
            <div class="col-md-2">
                <div class="card">
                    <img src="{{ asset('storage/foto_pengembang/' . $profile['foto']) }}" class="card-img-top" alt="{{ $profile['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $profile['name'] }}</h5>
                        <p class="card-text">
                            NIM: {{ $profile['nim'] }}<br>
                            Prodi: {{ $profile['prodi'] }}<br>
                            Universitas: {{ $profile['universitas'] }}<br>
                            Job Description: {{ $profile['description'] }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection