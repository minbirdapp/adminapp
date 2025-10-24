@extends('layouts.minbird')

@section('title', 'Create Account')

@section('content')
<div class="box p-4" style="max-width: 500px; width: 100%; margin: auto;">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-3">
        <small class="text-muted">Work in all dimensions</small>
        <h3 class="fw-bold mt-1">Create your Minbird account.</h3>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Your email address</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="eg: your email address" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
        </div>

        <div class="d-grid mb-3">
            <button class="btn btn-primary" type="submit">Continue</button>
        </div>
    </form>

    <p class="text-muted text-center">
        By creating an account, you agree to our 
        <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
    </p>

    <div class="d-grid">
        <a href="{{ route('magic.link') }}" class="btn btn-outline-secondary">Already have an account? Sign in</a>
    </div>
</div>
@endsection


