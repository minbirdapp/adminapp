@extends('layouts.minbird')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="profile">
        <img src="{{ asset('assets/img/user.png') }}" alt="User Profile" />
      </div>

      <nav class="nav flex-column w-100">
        <a class="nav-link active" href="#">
          Dashboard
        </a>
        <a class="nav-link" href="#">Campaigns</a>
        <a class="nav-link" href="#">Ideas</a>
        <a class="nav-link" href="#">Post</a>
        <a class="nav-link" href="#">Schedules</a>
        <a class="nav-link" href="#">Reports</a>
        <a class="nav-link" href="#">Log Books</a>
        <a class="nav-link" href="#">Bird AI</a>
        <a class="nav-link" href="#">Settings</a>
        <a class="nav-link" href="#">Log Out</a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="col main-content">
      <!-- Header -->
      <div class="header text-center mt-3">
        <p class="text-secondary mb-1">🌤️ {{ now()->format('l, M j H:i') }}</p>
        <h4>Good morning, {{ auth()->user()->name ?? 'User' }}</h4>
      </div>

      <!-- Idea Box -->
      <div class="mb-4 mt-4">
        <label class="form-label fw-semibold">Ask Bird for Idea</label>
        <textarea class="form-control mb-2" rows="2" placeholder="Ask Bird for new creative ideas..."></textarea>
        <small class="text-muted">Plane AI can make mistakes, please double-check responses</small>
        <div class="d-flex justify-content-end">
          <button class="btn btn-primary theme-btn btn-sm">Generate Idea</button>
        </div>
      </div>

      <!-- Quickstart Guide -->
      <div class="mb-5">
        <h6 class="fw-semibold mb-3">Your Quickstart Guide</h6>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="quickstart-card">
              <h6>Create a Campaign</h6>
              <p class="text-muted small">Most things start with a Campaign board in Min Bird.</p>
              <button id="startCampaignBtn" class="btn btn-outline-primary btn-sm">Start Campaign</button>
            </div>
          </div>
          <div class="col-md-4">
            <div class="quickstart-card">
              <h6>Invite your Team</h6>
              <p class="text-muted small">Build, ship, and manage with coworkers.</p>
              <button id="inviteTeamBtn" class="btn btn-outline-primary btn-sm">Invite Team Member</button>
            </div>
          </div>
          <div class="col-md-4">
            <div class="quickstart-card">
              <h6>Schedule a Post</h6>
              <p class="text-muted small">Most things start with a Campaign board in Min Bird.</p>
              <button class="btn btn-outline-primary btn-sm">Start New Post</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Report -->
      <h6 class="fw-semibold mb-3">Quick Report</h6>
      <div class="row g-3">
        @for($i=0; $i<8; $i++)
        <div class="col-md-3 col-sm-6">
          <div class="report-card">
            <div class="head">
              <img src="{{ asset('assets/img/icons/post-icon.svg') }}" alt="Total Post">
              <h6>Total Post</h6>
              <p>Total Post: <strong>123</strong></p>
            </div>
            <div class="foot">
              <a href="#" class="small">View all</a>
              <span class="small text-muted">{{ date('Y') }}</span>
            </div>
          </div>
        </div>
        @endfor
      </div>

      <!-- Chart -->
      <div class="chart-box mt-5">
        <h6 class="fw-semibold mb-3">Quick Report</h6>
        <canvas id="reportChart" height="100"></canvas>
        <div class="text-end">
          <a href="#" class="small">View all</a> | <span class="small text-muted">{{ date('Y') }}</span>
        </div>
      </div>

      <!-- Footer -->
      <footer class="mt-5 text-center text-muted small">
        ©{{ date('Y') }} MinBird — 
        <a href="#" class="text-decoration-none text-muted">Terms</a> |
        <a href="#" class="text-decoration-none text-muted">Privacy</a> |
        <a href="#" class="text-decoration-none text-muted">Cookie preferences</a> |
        <a href="#" class="text-decoration-none text-muted">Do not sell or share my personal information</a>
      </footer>
    </div>
  </div>
</div>

<!-- Campaign Panel -->
<div id="campaignPanel" class="slide-panel">
  <div class="panel-header d-flex justify-content-between align-items-center">
    <h4 class="fw-semibold mb-0">Create a New Campaign</h4>
    <button id="closeCampaignPanel"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="panel-body">
    <form>
      <div class="form-section">
        <label class="form-label">Name of your campaign</label>
        <input type="text" class="form-control" placeholder="Enter campaign name">
      </div>

      <div class="row form-section">
        <div class="col-md-6">
          <label class="form-label">Select brand</label>
          <select class="form-select">
            <option>Select a brand</option>
            <option>Brand A</option>
            <option>Brand B</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select class="form-select">
            <option>Select Status</option>
            <option>Active</option>
            <option>Draft</option>
          </select>
        </div>
      </div>
    </form>
  </div>
  <div class="d-flex justify-content-between panel-footer">
    <div>
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="button" id="cancelBtn" class="btn btn-secondary ms-2">Cancel</button>
    </div>
    <button type="button" class="btn btn-outline-danger">Delete</button>
  </div>
</div>

<!-- Overlay -->
<div id="overlay" class="fade-overlay"></div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
  // Chart.js
  const ctx = document.getElementById('reportChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
      datasets: [
        {
          label: 'Posts',
          data: [12, 19, 3, 5, 2, 3, 9],
          borderColor: 'rgba(111, 66, 193, 1)',
          tension: 0.3,
          fill: true,
          backgroundColor: 'rgba(111, 66, 193, 0.1)',
        },
        {
          label: 'Accounts',
          data: [4, 15, 6, 8, 10, 7, 11],
          borderColor: 'rgba(0, 123, 255, 1)',
          tension: 0.3,
          fill: true,
          backgroundColor: 'rgba(0, 123, 255, 0.1)',
        }
      ],
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } },
    },
  });

  // Panels logic
  const overlay = document.getElementById("overlay");
  const campaignPanel = document.getElementById("campaignPanel");
  const startCampaignBtn = document.getElementById("startCampaignBtn");
  const closeCampaignBtn = document.getElementById("closeCampaignPanel");

  function openPanel(panel) {
    panel.classList.add("active");
    overlay.classList.add("active");
    document.body.style.overflow = "hidden";
  }

  function closePanel(panel) {
    panel.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = "";
  }

  startCampaignBtn.addEventListener("click", () => openPanel(campaignPanel));
  closeCampaignBtn.addEventListener("click", () => closePanel(campaignPanel));
  overlay.addEventListener("click", () => closePanel(campaignPanel));
</script>
@endpush
