@extends('layouts.logged-in')

@section('title', 'Create Post - Step 1')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('includes.sidebar')

        <div class="col main-content">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="box-637 position-relative">
                <h4 class="mb-3">Create a New Post</h4>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary btn-sm top-right-btn">Back to Posts</a>

                <div class="card shadow-sm">
                    <div class="card-header">
                        <small>Step 1</small>
                        <h4>Create a Social Media Post</h4>
                    </div>

                    <div class="card-body">
@if(isset($post) && $post->id)
<form method="POST" action="{{ route('posts.update.step1', $post->id) }}" id="step1Form">
@else
<form method="POST" action="{{ route('posts.store.step1') }}" id="step1Form">
@endif
    @csrf

    <!-- Post Title -->
    <div class="mb-3">
        <label class="form-label"><span class="text-danger">*</span> Post Title</label>
<input type="text" name="title" id="title" class="form-control"
       value="{{ old('title', $post->title ?? '') }}">
               <small class="text-danger" id="titleError"></small>
    </div>

    <!-- Select Campaign -->
    <div class="mb-3">
        <label class="form-label"><span class="text-danger">*</span> Select Campaign</label>
        <select name="campaign_id" id="campaignSelect" class="form-select">
            <option value="">Select Campaign</option>
            @foreach($campaigns ?? [] as $campaign)
    <option value="{{ $campaign->id }}"
    {{ old('campaign_id', $post->campaign_id ?? '') == $campaign->id ? 'selected' : '' }}>
    {{ $campaign->name }}
</option>


            @endforeach
        </select>
        <small class="text-danger" id="campaignError"></small>
    </div>

    <!-- Media Post Type -->
    <div class="mb-3">
        <label class="form-label"><span class="text-danger">*</span> Media Post Type</label>
        <select name="content_type" id="contentType" class="form-select">
            <option value="">Select Type</option>
<option value="text" {{ old('content_type', $post->content_type ?? '') == 'text' ? 'selected' : '' }}>Text</option>
<option value="media" {{ old('content_type', $post->content_type ?? '') == 'media' ? 'selected' : '' }}>Media</option>
        </select>
        <small class="text-danger" id="contentTypeError"></small>
    </div>

    <!-- Social Media Channel -->
    <div class="mb-3">
        <label class="form-label"><span class="text-danger">*</span> Select Social Media Channel</label>
        @if($profiles->isEmpty())
            <p class="text-muted">No connected social media channels found.</p>
        @else
            @foreach($profiles as $profile)
            <div class="profile-option">
<input id="profile_{{ $profile->id }}" type="radio" name="profile_id" value="{{ $profile->id }}"
       {{ old('profile_id', $post->profile_id ?? '') == $profile->id ? 'checked' : '' }}>
                <label for="profile_{{ $profile->id }}">
                    <img src="{{ asset('assets/img/icons/profile-small-icon.png') }}" alt="Profile">
                    {{ ucfirst($profile->account_type) }}
                </label>
            </div>
            @endforeach
        @endif
        <small class="text-danger" id="profileError"></small>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn theme-btn btn-sm">Continue to Step 2</button>
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

