@extends('layouts.logged-in')

@section('title', 'App Settings')

@section('content')



    <!-- Main Content -->
    <div class="col main-content">

      <!-- Logged-in Header -->
      @include('layouts.logged-in-header')

      {{-- Success Alert --}}
      @if(session('success'))
      <div class="alert alert-success position-absolute alert-auto-hide " role="alert">

        {{ session('success') }}
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-danger position-absolute alert-auto-hide " role="alert">
        {{ session('error') }}
      </div>
      @endif

      <div class="w-75 position-relative m-auto">
        <h6 class="mb-3">My Profile</h6>
        <a href="{{ route('app.settings') }}" class="btn btn-outline-secondary btn-sm top-right-btn">
          Back to App Settings
        </a>

        {{-- Brand Cards --}}
        @if($brands->count() > 0)
        @foreach($brands as $brand)
        <div class="card mb-4">
          <p class="brand-name mb-0">{{ $brand->name }}</p>
          <div class="border-secondary-subtle rounded-bottom p-3 bg-white text-center">

            {{-- Connected Social Media --}}
            @if($brand->social_medias->count())
            <ul class="selected-brand-list">
              @foreach($brand->social_medias as $account)
              <li>
                @php
                $icon = match($account->account_type) {
                'facebook' => 'fb-small.svg',
                'linkedin' => 'linkedin-small.svg',
                'instagram',
                'instagram_personal',
                'instagram_professional' => 'instagram-small.svg',
                'tiktok' => 'tik_tok.svg',
                default => 'x-small.svg',
                };

                @endphp
                <i><img src="{{ asset('assets/img/icons/' . $icon) }}" alt="{{ $account->account_type }}"></i>
                <span><img src="{{ asset('assets/img/icons/user-img.png') }}" alt="user"></span>
              </li>
              @endforeach
            </ul>
            @else
            <p class="mb-3 text-muted">
              Currently you don't have any social media account configured to your brand
            </p>
            @endif

            <button data-brand-id="{{ $brand->id }}"
              class="btn btn-outline-secondary btn-sm openChannelList">
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

{{-- 🔹 Step 2: Dynamic Channel Modal (works for all platforms) --}}
<div class="modal fade" id="connectChannelModal" tabindex="-1" aria-labelledby="connectChannelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <span id="modalTitle">Connect Channel</span>
        </h4>
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

         }
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
                <button class="btn btn-primary theme-btn mt-3 connectAccount" data-type="${channel}">Connect to Personal Account</button>
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
                <button class="btn btn-primary theme-btn mt-3 connectAccount" data-type="${channel}">Connect to Professional Account</button>
              </div>
            </div>
          </div>`;
        // if (channel === "instagram") {
          
        // } else {
        //   html = `
        //   <div class="text-center">
        //     <img src="/assets/img/icons/${channel}.svg" width="60" class="mb-3" alt="${name}">
        //     <p>Connect your ${name} account to manage posts and analytics.</p>
        //     <button class="btn btn-primary theme-btn connectAccount" data-type="${channel}">
        //       Connect ${name}
        //     </button>
        //   </div>`;
        // }

        modalBody.innerHTML = html;
        connectChannelModal.show();

        // Handle connect button clicks (AJAX optional)
        // Handle connect button clicks (AJAX optional)
        modalBody.querySelectorAll(".connectAccount").forEach(btn => {
          btn.addEventListener("click", function() {
            const accountType = this.dataset.type;
            if (!selectedBrandId) return alert("No brand selected!");

            //  Send data using fetch but expect redirect response
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
                //  Redirect handled by Laravel — just reload page
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
<?php include(resource_path('js/pages/validations.php')); ?>

@endpush