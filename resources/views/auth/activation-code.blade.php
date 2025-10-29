@extends('layouts.minbird')

@section('title', 'Activation Code')

@section('content')
<div class="magic-box" style="max-width: 500px; margin: auto;">
    @if(session('success'))
        <div class="success-message alert-auto-hide" role="alert"><span></span>{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-danger alert-auto-hide" role="alert">{{ session('error') }}</div>
    @endif

    {{-- ✅ Show this only if email exists --}}
    @if(isset($email))
        <p id="magic-message" class="mb-4">
            <strong>
                A magic link has been sent to {{ $email }}. Please check your inbox.
            </strong>
        </p>
    @endif

    <form method="POST" action="{{ route('activate.code') }}" novalidate>
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
        <a href="{{ route('resend.code', ['email' => $email ?? request()->get('email')]) }}" class="resend-link text-decoration-underline">
            Resend Activation Code
        </a>
    </div>
</div>



<?php include(resource_path('js/pages/validations.php')); ?>
@endsection
