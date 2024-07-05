@extends('layouts.app')

@section('content')
<div class="container developer-container">
    <h1 class="h1-developer mb-4">Profile Pengembang Software</h1>
    <div class="row">
        @foreach($profiles as $profile)
            <div class="col-md-12 mb-3">
                <div class="card developer-card p-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/foto_pengembang/' . $profile['foto']) }}" class="rounded-circle profile-photo mr-3" alt="{{ $profile['name'] }}">
                        <div>
                            <h5 class="card-title">{{ $profile['name'] }}</h5>
                            <p class="card-text mb-1">
                                <strong>NIM:</strong> {{ $profile['nim'] }}
                            </p>
                            <p class="card-text mb-1">
                                <strong>Prodi:</strong> {{ $profile['prodi'] }}
                            </p>
                            <p class="card-text mb-1">
                                <strong>Universitas:</strong> {{ $profile['universitas'] }}
                            </p>
                            <p class="card-text mb-1">
                                <strong>Job Description:</strong> {{ $profile['description'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection