@extends('layouts.minbird')

@section('title', 'Magic Link')

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
        <h3 class="fw-bold mt-1">Welcome back to Minbird.</h3>
    </div>

    <form method="POST" action="{{ route('magic.send') }}">
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
            <button class="btn btn-primary" type="submit">Send Magic Link</button>
        </div>
    </form>

    <p class="text-muted text-center">Or</p>

    <div class="d-grid mb-3">
<a href="{{ route('password.login') }}" class="btn btn-outline-secondary">Use Password</a>
    </div>

    <a href="{{ route('create.account') }}" class="resend-link text-decoration-underline">New to Minbird? Signup</a>
</div>
@endsection

