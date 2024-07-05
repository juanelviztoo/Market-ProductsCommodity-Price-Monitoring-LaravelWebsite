@extends('layouts.app')

@section('content')
<div class="container mt-4 pad">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">{{ __('Profile') }}</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{ __('Update Profile Information') }}
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    {{ __('Update Password') }}
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    {{ __('Delete Account') }}
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        font-size: 1.25rem;
        font-weight: 500;
    }
    .card-body {
        padding: 2rem;
    }
    .card {
        border-radius: 0.5rem;
    }
    label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-control {
        display: block;
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1.5rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        font-size: 1rem;
    }
    .btn {
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        border-radius: 0.25rem;
    }
    .pad {
        padding-bottom: 100px;
    }
</style>
@endpush