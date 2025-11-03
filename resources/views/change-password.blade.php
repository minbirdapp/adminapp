@extends('layouts.logged-in')

@section('title', 'Change Password')

@section('content')

<div class="col main-content">
    <!-- Header -->
    @include('layouts.logged-in-header')

    <div class="box-637 position-relative">
        <h6 class="mb-3">Change Password</h6>
        @include('includes/app_settings')

        <div class="card shadow-sm">
            <div class="card-header">
                <h4>Update Your Password</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="success-message mb-3 alert-auto-hide" role="alert">{{ session('success') }}</div>
                @endif

                <form id="changePasswordForm" method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span> Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control">
                        <small id="currentPasswordError" class="text-danger">
                            @error('current_password') {{ $message }} @enderror
                        </small>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span> New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control">
                        <small id="newPasswordError" class="text-danger">
                            @error('new_password') {{ $message }} @enderror
                        </small>

                        <!-- Password Requirement List -->
                        <ul id="passwordRules" class="list-unstyled mt-2">
                            <li id="rule-length" class="rule-item text-danger">Minimum 8 characters</li>
                            <li id="rule-letter" class="rule-item text-danger">At least one letter</li>
                            <li id="rule-number" class="rule-item text-danger">At least one number</li>
                            <li id="rule-special" class="rule-item text-danger">At least one special character</li>
                        </ul>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span> Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
                        <small id="confirmPasswordError" class="text-danger">
                            @error('new_password_confirmation') {{ $message }} @enderror
                        </small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn theme-btn btn-sm">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include(resource_path('js/pages/validations.php')); ?>
</div>
@endsection