@extends('layouts.minbird')


@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">

  <div class="channel-setup-box">
    <h4>Setup your social media accounts for your brand</h4>
    <p class="text-muted mb-4">Connect a channel to start scheduling posts</p>

    <!-- Card -->
    <div class="card mb-4">
      <p class="brand-name mb-0">{{ $profile->brand_name ?? 'Brand name not set' }}</p>
      <div class="border-secondary-subtle rounded-bottom p-3 bg-white text-center">
        <p class="mb-3 text-muted">
          Currently you don't have any social media account configured to your brand
        </p>
        <button class="btn btn-outline-secondary btn-sm compact-btn" data-bs-toggle="modal"
          data-bs-target="#connectModal">Connect a Channel</button>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="{{ route('dashboard') }}" class="btn theme-btn btn-primary custom-blue-btn">Continue</a>
      <a href="{{ route('dashboard') }}" class="skip-link">Skip for Now</a>
    </div>

    <hr>

    <p style="color: #3A3A3A;" class="fw-bold mt-3">You handle more accounts</p>
    <div class="d-flex gap-2 mb-3">
      <button class="btn btn-outline-secondary compact-btn" data-bs-toggle="modal"
        data-bs-target="#addBrandModal">Add New Brand</button>
      <button class="btn btn-outline-secondary compact-btn">View Plan</button>
    </div>
    <p class="text-muted note-txt" style="max-width:600px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      Pellentesque porta turpis eget odio blandit consequat quis quis mi.</p>
  </div>
  
</main>


  <!-- Modal -->
  <div class="modal fade" id="connectModal" tabindex="-1" aria-labelledby="connectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="connectModalLabel">Connect a New Channel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="channel-grid">

            <div class="channel-card">
              <img src="assets/img/icons/facebook.svg" alt="Facebook">
              <p class="mb-0 small">Page or Profile</p>
            </div>

            <div class="channel-card">
              <img src="assets/img/icons/youtube.svg" alt="YouTube">
              <p class="mb-0 small">Channel</p>
              <span class="coming-soon">Coming Soon</span>
            </div>

            <div class="channel-card">
              <img src="assets/img/icons/linkedin.svg" alt="LinkedIn">
              <p class="mb-0 small">Page or Profile</p>
            </div>

            <div class="channel-card" data-bs-toggle="modal" data-bs-target="#instagramModal">
              <img src="assets/img/icons/instagram.svg" alt="Instagram">
              <p class="mb-0 small">Business, Creator, or Personal</p>
            </div>

            <div class="channel-card">
              <img src="assets/img/icons/whatsapp.svg" alt="WhatsApp">
              <p class="mb-0 small">Business, Creator, or Personal</p>
              <span class="coming-soon">Coming Soon</span>
            </div>

            <div class="channel-card">
              <img src="assets/img/icons/pinterest.svg" alt="Pinterest">
              <p class="mb-0 small">Business, Creator, or Personal</p>
              <span class="coming-soon">Coming Soon</span>
            </div>

            <div class="channel-card">
              <img src="assets/img/icons/tik_tok.svg" alt="TikTok">
              <p class="mb-0 small">Business, Creator, or Personal</p>
              <span class="coming-soon">Coming Soon</span>
            </div>

            <div class="channel-card">
              <img src="assets/img/icons/x.svg" alt="X (Twitter)">
              <p class="mb-0 small">Business, Creator, or Personal</p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- INSTAGRAM Modal -->
  <div class="modal fade" id="instagramModal" tabindex="-1" aria-labelledby="instagramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="instagramModalLabel">Which type of Instagram account would you like to connect?
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <p>The account type you choose will determine the features available to you.</p>

          <div class="row g-3">
            <!-- Personal Profile -->
            <div class="col-md-6">
              <div class="account-card">
                <h5>Personal Profile</h5>
                <p>Most used to share to family and friends</p>
                <ul class="checklist">
                  <li>Notification-based publishing: Receive a mobile notification to post yourself</li>
                  <li>Notification-based publishing: Receive a mobile notification to post yourself</li>
                </ul>
                <button class="btn btn-primary theme-btn mt-3">Connect to Personal Account</button>
              </div>
            </div>

            <!-- Professional -->
            <div class="col-md-6">
              <div class="account-card">
                <h5>Professional</h5>
                <p>Business or Creator Accounts</p>
                <ul class="checklist">
                  <li>Notification-based publishing: Receive a mobile notification to post yourself</li>
                  <li>Automatic publishing: Schedule and we'll publish for you</li>
                  <li>Analytics & engagement (paid plans)</li>
                </ul>
                <button class="btn btn-primary theme-btn mt-3">Connect to Professional Account</button>
                <p class="mt-2" style="font-size: 0.9em;">
                  If your account type isn't Professional yet, Instagram will prompt you to change it with a few simple
                  steps.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="addBrandLabel">Add New Brand</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="addBrandForm">
          @csrf

          <!-- Brand Name -->
          <div class="mb-3">
            <label for="brandName" class="form-label">
              <span class="text-danger">*</span> Brand Name
            </label>
            <input type="text" class="form-control" id="brandName" name="name" required>
          </div>

          <!-- Select Industry -->
          <div class="mb-3">
            <label for="industrySelect" class="form-label">
              <span class="text-danger">*</span> Select Industry
            </label>
            <select class="form-select" id="industrySelect" name="industry_id" required>
              <option value="">-- Select Industry --</option>
              @foreach ($industries as $industry)
                <option value="{{ $industry->id }}">{{ $industry->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Competitors -->
          <div class="mb-3">
            <label for="competitorInfo" class="form-label">Competitor Info</label>
            <textarea class="form-control" id="competitorInfo" name="competitor_info" rows="3"></textarea>
          </div>
        </form>
      </div>

      <div class="modal-footer justify-content-between">
        <div>
          <button type="button" id="saveBrandBtn" class="btn theme-btn btn-save text-white custom-blue-btn">
            Save
          </button>
          <button type="button" class="btn btn-outline-secondary custom-blue-btn" data-bs-dismiss="modal">
            Cancel
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const saveBrandBtn = document.getElementById('saveBrandBtn');
  const addBrandForm = document.getElementById('addBrandForm');

  saveBrandBtn.addEventListener('click', function () {
    const formData = new FormData(addBrandForm);

    fetch("{{ route('brands.store') }}", {
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}",
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Hide the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBrandModal'));
        modal.hide();

        // Add new card dynamically
        const cardHTML = `
          <div class="card mb-4">
            <p class="brand-name mb-0">${data.brand.name}</p>
            <div class="border-secondary-subtle rounded-bottom p-3 bg-white text-center">
              <p class="mb-3 text-muted">
                Currently you don't have any social media account configured to your brand
              </p>
              <button class="btn btn-outline-secondary btn-sm compact-btn" data-bs-toggle="modal"
                data-bs-target="#connectModal">Connect a Channel</button>
            </div>
          </div>
        `;
        document.querySelector('.channel-setup-box').insertAdjacentHTML('afterbegin', cardHTML);

        // Reset form
        addBrandForm.reset();
      } else {
        alert('Error: ' + (data.message ?? 'Could not save brand.'));
      }
    })
    .catch(err => console.error(err));
  });
});
</script>



  <!-- Close parent modal when Instagram modal opens -->
  <script>
    const instagramModal = document.getElementById('instagramModal');
    instagramModal.addEventListener('show.bs.modal', () => {
      const connectModal = bootstrap.Modal.getInstance(document.getElementById('connectModal'));
      connectModal.hide();
    });
  </script>
@endsection

