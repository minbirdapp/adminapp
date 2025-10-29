@extends('layouts.minbird')

@section('title', 'Login / Magic Link')

@section('content')
<div class="box p-4" style="max-width: 500px; width: 100%; margin: auto;">
    {{--  Flash Messages --}}
    @if(session('success'))
        <div class="success-message alert-auto-hide" role="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-auto-hide" role="alert">{{ session('error') }}</div>
    @endif

    <div class="mb-3">
        <small class="text-muted">Work in all dimensions</small>
        <h3 class="fw-bold mt-1">Welcome back to Minbird.</h3>
    </div>

    {{--  Shared Email Field --}}
    <div class="mb-3">
        <label class="form-label">Your email address</label>
        <input type="email" id="emailInput" class="form-control" placeholder="e.g. your email address">
        <small class="text-danger" id="emailError"></small>
    </div>

    {{-- Magic Link Form --}}
    <form id="magicForm" method="POST" action="{{ route('magic.send') }}" novalidate>
        @csrf
        <input type="hidden" name="email" id="magicEmail">

        <div class="mb-3">
            <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_SITE_KEY') }}"></div>
             <small class="text-danger" id="captchaError"></small>
        </div>

        <div class="d-grid mb-3">
            <button class="btn btn-primary" type="submit">Send Magic Link</button>
        </div>
    </form>

    {{-- Password Login Form (hidden by default) --}}
    <form id="passwordForm" method="POST" action="{{ route('password.login') }}" style="display:none;" novalidate> 
        @csrf
        <input type="hidden" name="email" id="passwordEmail">

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input 
                type="password" 
                name="password" 
                id="passwordInput" 
                class="form-control" 
                placeholder="Enter your password">
            <small class="text-danger" id="passwordError"></small>
        </div>
          

        <div class="d-grid mb-3">
            <button class="btn btn-primary" type="submit">Login</button>
        </div>
    </form>

    <p class="text-muted text-center" id="orText">Or</p>

    {{--  Toggle Button --}}
    <div class="d-grid">
        <a href="#" id="toggleLoginType" class="btn btn-outline-secondary">Use Password</a>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('create.account') }}" class="resend-link text-decoration-underline">New to Minbird? Signup</a>
    </div>
</div>

<?php include(resource_path('js/pages/validations.php')); ?>
@endsection
