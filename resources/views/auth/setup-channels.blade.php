@extends('layouts.minbird')

@section('title', 'Setup Channels')

@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">

  {{-- Success Alert --}}
  @if(session('success'))
  <div class="alert alert-success position-absolute" role="alert">
    {{ session('success') }}
  </div>
  @endif

  <div class="channel-setup-box">
    <h4>Setup your social media accounts for your brand</h4>
    <p class="text-muted mb-4">Connect a channel to start scheduling posts</p>

    {{-- Brand Card --}}
    {{-- Show all brands dynamically --}}
    @if($brands->count() > 0)
    @foreach($brands as $brand)
    <div class="card mb-4">
      <p class="brand-name mb-0">{{ $brand->name }}</p>
      <div class="border-secondary-subtle rounded-bottom p-3 bg-white text-center">

        {{-- Example social icons (for now, static placeholders) --}}
        <ul class="selected-brand-list">
          <li>
            <i><img src="{{ asset('assets/img/icons/fb-small.svg') }}" alt="Facebook"></i>
            <span><img src="{{ asset('assets/img/icons/user-img.png') }}" alt="user"></span>
          </li>
          <li>
            <i><img src="{{ asset('assets/img/icons/linkedin-small.svg') }}" alt="linkedin"></i>
            <span><img src="{{ asset('assets/img/icons/user-img.png') }}" alt="user"></span>
          </li>
          <li>
            <i><img src="{{ asset('assets/img/icons/instagram-small.svg') }}" alt="instagram"></i>
            <span><img src="{{ asset('assets/img/icons/user-img.png') }}" alt="user"></span>
          </li>
          <li>
            <i><img src="{{ asset('assets/img/icons/tiktok-small.svg') }}" alt="tiktok"></i>
            <span><img src="{{ asset('assets/img/icons/user-img.png') }}" alt="user"></span>
          </li>
        </ul>

        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#connectModal">
          Connect a Channel
        </button>
      </div>
    </div>
    @endforeach
    @else
    {{-- No brands yet --}}
    <div class="text-center text-muted mb-4">
      <p>You haven’t added any brand yet. Click “Add New Brand” below to get started.</p>
    </div>
    @endif


    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="{{ route('dashboard') }}" class="btn theme-btn btn-primary px-4">Continue</a>
      <a href="#" class="skip-link">Skip for Now</a>
    </div>

    <hr>

    <p style="color: #3A3A3A;" class="fw-bold mt-3">You handle more accounts</p>
    <div class="d-flex gap-2 mb-3">
      <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
        Add New Brand
      </button>
      <button class="btn btn-outline-secondary">View Plan</button>
    </div>

    <p class="text-muted note-txt" style="max-width:600px;">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porta turpis eget odio blandit consequat quis quis mi.
    </p>
  </div>
</main>


{{-- ✅ Add Brand Modal --}}
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="addBrandForm" method="POST" action="{{ route('brands.store') }}" novalidate>
        @csrf
        <div class="modal-header">
          <h4 class="modal-title" id="addBrandLabel">Add New Brand</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- Brand Name --}}
          <div class="mb-3">
            <label for="brandName" class="form-label">
              <span class="text-danger">*</span> Name of your brand
            </label>
            <input type="text" class="form-control" id="brandName" name="name" placeholder="Enter brand name">
            <small class="text-danger" id="brandError"></small>
          </div>

          {{-- Select Industry --}}
          <div class="mb-3">
            <label for="industrySelect" class="form-label">
              <span class="text-danger">*</span> Select Industry
            </label>
            <select class="form-select" id="industrySelect" name="industry_id">
              <option value="">Choose industry</option>
              @foreach($industries as $industry)
              <option value="{{ $industry->id }}">{{ $industry->name }}</option>
              @endforeach
            </select>
            <small class="text-danger" id="industryError"></small>
          </div>

          {{-- Competitors --}}
          <div class="mb-3">
            <label for="competitorInfo" class="form-label">Share your competitors information</label>
            <textarea class="form-control" id="competitorInfo" name="competitor_info" rows="3"></textarea>
          </div>

          {{-- About Brand --}}
          <div class="mb-3">
            <label for="brandIntro" class="form-label">About your brand</label>
            <textarea class="form-control" id="brandIntro" name="intro" rows="2"></textarea>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <div>
            <button type="submit" class="btn theme-btn btn-save text-white">Save</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- ✅ Connect Channel Modal (unchanged, just Laravel assets) --}}
<div class="modal fade" id="connectModal" tabindex="-1" aria-labelledby="connectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="connectModalLabel">Connect a New Channel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="channel-grid">
          <div class="channel-card"><img src="{{ asset('assets/img/icons/facebook.svg') }}" alt="Facebook">
            <p class="mb-0 small">Page or Profile</p>
          </div>
          <div class="channel-card"><img src="{{ asset('assets/img/icons/linkedin.svg') }}" alt="LinkedIn">
            <p class="mb-0 small">Page or Profile</p>
          </div>
          <div class="channel-card" data-bs-toggle="modal" data-bs-target="#instagramModal">
            <img src="{{ asset('assets/img/icons/instagram.svg') }}" alt="Instagram">
            <p class="mb-0 small">Business, Creator, or Personal</p>
          </div>
          <div class="channel-card"><img src="{{ asset('assets/img/icons/x.svg') }}" alt="X (Twitter)">
            <p class="mb-0 small">Business, Creator, or Personal</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Instagram Modal (Fixed) -->
<div class="modal fade" id="instagramModal" tabindex="-1" aria-labelledby="instagramModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="instagramModalLabel">
          Which type of Instagram account would you like to connect?
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p>The account type you choose will determine the features available to you.</p>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="account-card">
              <h5>Personal Profile</h5>
              <p>Most used to share to family and friends</p>
              <ul class="checklist">
                <li>Notification-based publishing: Receive a mobile notification to post yourself</li>
                <li>Manual post publishing only</li>
              </ul>
              <button class="btn btn-primary theme-btn mt-3">Connect to Personal Account</button>
            </div>
          </div>

          <div class="col-md-6">
            <div class="account-card">
              <h5>Professional</h5>
              <p>Business or Creator Accounts</p>
              <ul class="checklist">
                <li>Automatic publishing</li>
                <li>Analytics & engagement (paid plans)</li>
              </ul>
              <button class="btn btn-primary theme-btn mt-3">Connect to Professional Account</button>
              <p class="mt-2" style="font-size: 0.9em;">
                If your account type isn't Professional yet, Instagram will prompt you to change it with a few simple steps.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include(resource_path('js/pages/validations.php')); ?>
@endsection