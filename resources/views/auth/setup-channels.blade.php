@extends('layouts.minbird')

@section('title', 'Setup Channels')

@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">

  <div class="channel-setup-box">
    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert alert-success position-absolute alert-auto-hide" role="alert">
      {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger position-absolute alert-auto-hide" role="alert">
      {{ session('error') }}
    </div>
    @endif

    <h4>Setup your social media accounts for your brand</h4>
    <p class="text-muted mb-4">Connect a channel to start scheduling posts</p>

    {{-- Brand Card --}}
    @if($brands->count() > 0)
    @foreach($brands as $brand)
    <div class="card mb-4">
      <p class="brand-name mb-0">{{ $brand->name }}</p>
      <div class="border-secondary-subtle rounded-bottom p-3 bg-white text-center">

        @if($brand->social_medias->count())
        <ul class="selected-brand-list">
          @foreach($brand->social_medias as $vv)
          <li>
            @php
            $icon = match($vv->account_type) {
              'facebook' => 'fb-small.svg',
              'linkedin' => 'linkedin-small.svg',
              'instagram' => 'instagram-small.svg',
              'tiktok' => 'tiktok-small.svg',
              default => 'x.svg'
            };
            @endphp
            <i><img src="{{ asset('assets/img/icons/' . $icon) }}" alt="{{ $vv->account_type }}"></i>
            <span><img src="{{ asset('assets/img/icons/user-img.png') }}" alt="user"></span>
          </li>
          @endforeach
        </ul>
        @else
        <p class="mb-3 text-muted">
          Currently you don't have any social media account configured to your brand
        </p>
        @endif

        <button data-brand-id="{{ $brand->id }}" class="btn btn-outline-secondary btn-sm openChannelList">
          Connect a Channel
        </button>
      </div>
    </div>
    @endforeach
    @else
    <div class="text-center text-muted mb-4">
      <p>You haven’t added any brand yet. Click “Add New Brand” below to get started.</p>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="{{ route('setup.payment') }}" class="btn theme-btn btn-primary px-4">Continue</a>
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

{{-- 🔹 Step 1: Channel Selection Modal --}}
<div class="modal fade" id="channelListModal" tabindex="-1" aria-labelledby="channelListModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Connect a New Channel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="channel-grid text-center">
          @foreach(['facebook', 'linkedin', 'instagram', 'tiktok', 'x'] as $channel)
          <div class="channel-card selectChannel" data-channel="{{ $channel }}" data-name="{{ ucfirst($channel) }}">
            <img src="{{ asset('assets/img/icons/' . $channel . '.svg') }}" alt="{{ ucfirst($channel) }}">
            <p class="mb-0 small">{{ ucfirst($channel) }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

{{-- 🔹 Step 2: Dynamic Connect Channel Modal --}}
<div class="modal fade" id="connectChannelModal" tabindex="-1" aria-labelledby="connectChannelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="modalTitle">Connect Channel</span></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBodyContent">
        {{-- Loaded dynamically --}}
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    let selectedBrandId = null;
    const channelListModal = new bootstrap.Modal(document.getElementById("channelListModal"));
    const connectChannelModal = new bootstrap.Modal(document.getElementById("connectChannelModal"));
    const modalTitle = document.getElementById("modalTitle");
    const modalBody = document.getElementById("modalBodyContent");

    // When user clicks "Connect a Channel" on brand card
    document.querySelectorAll(".openChannelList").forEach(button => {
      button.addEventListener("click", function() {
        selectedBrandId = this.getAttribute("data-brand-id");
        channelListModal.show();
      });
    });

    // When a channel is selected from the grid
    document.querySelectorAll(".selectChannel").forEach(card => {
      card.addEventListener("click", function() {
        const channel = this.dataset.channel;
        const name = this.dataset.name;
        channelListModal.hide();

        modalTitle.textContent = `Connect your ${name} account`;
        let html = "";

        if (channel === "instagram") {
          html = `
            <p>The account type you choose will determine the features available to you.</p>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="account-card">
                  <h5>Personal Profile</h5>
                  <p>Most used to share to family and friends</p>
                  <ul class="checklist">
                    <li>Notification-based publishing</li>
                    <li>Manual post publishing only</li>
                  </ul>
                  <button class="btn btn-primary theme-btn mt-3 connectAccount" data-type="instagram_personal">Connect to Personal Account</button>
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
                  <button class="btn btn-primary theme-btn mt-3 connectAccount" data-type="instagram_professional">Connect to Professional Account</button>
                </div>
              </div>
            </div>`;
        } else {
          html = `
            <div class="text-center">
              <img src="/assets/img/icons/${channel}.svg" width="60" class="mb-3" alt="${name}">
              <p>Connect your ${name} account to manage posts and analytics.</p>
              <button class="btn btn-primary theme-btn connectAccount" data-type="${channel}">Connect ${name}</button>
            </div>`;
        }

        modalBody.innerHTML = html;
        connectChannelModal.show();

        // Handle connect button clicks
        modalBody.querySelectorAll(".connectAccount").forEach(btn => {
          btn.addEventListener("click", function() {
            const accountType = this.dataset.type;
            if (!selectedBrandId) return alert("No brand selected!");

            fetch("{{ route('add.social.account') }}", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                  brand_id: selectedBrandId,
                  account_type: accountType
                })
              })
              .then(res => {
                connectChannelModal.hide();
                window.location.reload();
              })
              .catch(err => console.error(err));
          });
        });
      });
    });
  });
</script>
@endpush
