@extends('layouts.minbird')

@section('title', 'Setup Account')

@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="account-setup" style="max-width: 600px;">

        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        <h4 class="mb-1">Setup your account</h4>
        <p class="mb-4">
            A magic link has been sent to <strong>{{ $user->email }}</strong>, check your inbox.
        </p>

        <form action="{{ route('setup.account.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Your email address</label>
                <input type="email" class="form-control" value="{{ $user->email }}" readonly>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><span>*</span>First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="e.g. John" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="e.g. Doe">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"><span>*</span>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                <input type="password" name="password_confirmation" class="form-control mt-2" placeholder="Confirm password" required>
            </div>

            <div class="mb-2">
                <label class="form-label"><span>*</span>Your Brand Name</label>
                <input type="text" name="brand_name" class="form-control" placeholder="e.g. Minbird">
            </div>

            <div class="mb-2">
                <label class="form-label"><span>*</span>Select your industry</label>
                <select name="industry_id" class="form-select" required>
                    <option selected disabled>Choose industry</option>
                    @foreach(\App\Models\Industry::where('status', '1')->get() as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label"><span>*</span>Your role in brand</label>
                <select name="brand_role_id" class="form-select" required>
                    <option selected disabled>Choose role</option>
                    @foreach(\App\Models\BrandRole::where('status', '1')->get() as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">About your brand</label>
                <textarea name="about_brand" class="form-control" placeholder="Describe your brand..."></textarea>
            </div>

            <button type="submit" class="btn theme-btn btn-primary w-100 mb-3">Continue</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100">Cancel</a>
        </form>
    </div>
</main>
@endsection
