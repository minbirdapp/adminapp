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

    <form id="createAccountForm" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Your email address</label>
   <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control @error('email') is-invalid @enderror" 
                placeholder="eg: your email address" 
             
            >            <small class="text-danger" id="emailError"></small>

                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

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

<script>
document.getElementById('createAccountForm').addEventListener('submit', function(e) {
    let valid = true;

    // Reset any previous error messages
    document.getElementById('emailError').textContent = '';

    // Get the email value
    const email = document.getElementById('email').value.trim();

    // Check if empty
    if (email === '') {
        document.getElementById('emailError').textContent = 'Email address is required.';
        valid = false;
    } 
    // Check for valid email format
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address.';
        valid = false;
    }

    // Stop form submission if invalid
    if (!valid) {
        e.preventDefault();
    }
});
</script>
@endsection


