@extends('layouts.minbird')

@section('title', 'Activation Code')

@section('content')
<div class="magic-box" style="max-width: 500px; margin: auto;">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <p class="mb-4">
        <strong>A magic link has been sent to your email, check your inbox.</strong>
    </p>

    <form method="POST" action="{{ route('activate.code') }}">
        @csrf
        <div class="mb-3">
            <label for="activationCode" class="form-label">Activation Code</label>
            <input type="text" id="activationCode" name="activation_code" class="form-control @error('activation_code') is-invalid @enderror" placeholder="Enter your activation code" required>
            @error('activation_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Continue</button>
    </form>

    <div class="mt-3 text-center">
        <a href="{{ route('magic.link') }}" class="resend-link text-decoration-underline">Resend Activation Code</a>
    </div>
</div>
@endsection
