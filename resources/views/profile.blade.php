@extends('layouts.minbird')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('includes.sidebar')

        <!-- Main Content -->
        <div class="col main-content">
            @include('layouts.logged-in-header')

            <div class="box-637 position-relative">
                <h6 class="mb-3">My Profile</h6>
                @include('includes/app_settings')

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Update your profile</h4>
                    </div>
                    <div class="card-body">
                        <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="profile-container text-center mb-4">
                                <img src="{{ $profile->profile_image ? asset('storage/profile/' . $profile->profile_image) : asset('assets/img/dummy.png') }}" id="profileImage" class="profile-pic" alt="Profile Photo">
                                <label for="fileInput" class="upload-btn">Upload Profile Photo</label>
                                <input type="file" id="fileInput" name="profile_image" accept="image/*" class="d-none">
                                <small class="text-danger d-block mt-1" id="imageError"></small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><span class="text-danger">*</span>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $profile->first_name) }}">
                                    @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="text-danger client-error"></small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><span class="text-danger">*</span>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $profile->last_name) }}">
                                    @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="text-danger client-error"></small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email (Read Only)</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Role</label>
                                <select name="role" disabled class="form-select">
                                    @foreach($roles as $tz)
                                    <option value="{{ $tz->id }}" {{ auth()->user()->user_role_id == $tz->id ? 'selected' : '' }}>
                                        {{ $tz->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">About Yourself</label>
                                <textarea name="bio" class="form-control" rows="3">{{ old('bio', $profile->bio) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><span class="text-danger">*</span>Select Your Timezone</label>
                                <select name="timezone_id" class="form-select">
                                    <option value="">Select timezone</option>
                                    @foreach($timezones as $tz)
                                    <option value="{{ $tz->id }}" {{ $profile->timezone_id == $tz->id ? 'selected' : '' }}>
                                        {{ $tz->label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('timezone_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small class="text-danger client-error"></small>
                            </div>

                            <div class="mt-4">
                                <button class="btn theme-btn btn-sm" type="submit">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(resource_path('js/pages/validations.php')); ?>
@endsection