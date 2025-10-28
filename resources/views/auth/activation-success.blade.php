@extends('layouts.minbird')

@section('title', 'You’re All Set')

@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="magic-box text-center">

        @if(session('success'))
            <div class="alert alert-success alert-auto-hide" role="alert">{{ session('success') }}</div>
        @endif

        <!-- Success Message -->
        <div class="success-message">
            <span>🎉</span> You’re all set
        </div>

        <!-- Main Text -->
        <p class="mb-4">
            <strong>Let’s take you over to MinBird so you can start setting up your social channels and scheduling posts.</strong>
        </p>

        <!-- Continue Button -->
<a href="{{ route('setup.account') }}" class="btn btn-primary w-100">Continue</a>
    </div>
</main>
@endsection
