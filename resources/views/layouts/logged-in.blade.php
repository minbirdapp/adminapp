<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Minbird | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dashboard-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/choices.min.css')}}">
</head>

<body>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <div class="container-fluid">
        <div class="row">
            @include('includes/sidebar')
            <!-- Main Content -->
            @yield('content')
            <!-- Footer -->
            @include('includes/footer')
        </div>
    </div>


    <!-- footer section end -->
    <!-- vendor js -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/choices.min.js') }}"></script>
    <!-- main js -->
    <script>
        var searchBrandUrl = "{{route('search.brand')}}";
        var viewCampaign = "{{route('campaign.view')}}";
        var baseUrl = "{{env('APP_URL')}}";
        console.log(baseUrl);
    </script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
<!-- View Team Member Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">View Team Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewMemberContent">

                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

            </div>
            <div class="modal-footer">
                <a href="" class="editTMember btn btn-edit">Edit</a>
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <a onclick="return confirm('Are you sure you want to delete this item?');"  href="" class="deleteTmember btn btn-delete">Delete</a>
            </div>
        </div>
    </div>
</div>
<!-- Invite team member Slide Panel -->
<div id="invitePanel" class="slide-panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <h4 class="fw-semibold mb-0">Invite Team Member</h4>
        <button id="closeInvitePanel"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="panel-body">
        <p class="panel-note">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ornare, nisl nec laoreet lacinia,
            velit lacus ultricies velit, vel iaculis eros tortor ac risus.
        </p>
        <form>
            <div class="row form-section">
                <div class="col-md-6">
                    <label class="form-label">Name of team member</label>
                    <input type="text" class="form-control" placeholder="Enter campaign name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role of team member</label>
                    <select class="form-select">
                        <option>Select Status</option>
                        <option>Active</option>
                        <option>Draft</option>
                    </select>
                </div>
            </div>
            <div class="form-section">
                <label class="form-label">Email Address</label>
                <input type="text" class="form-control" placeholder="Enter campaign name">
            </div>
        </form>
    </div>
    <div class="d-flex justify-content-between panel-footer">
        <div>
            <button type="submit" class="btn theme-btn btn-primary">Invite Member</button>
            <button type="button" id="cancelBtn" class="btn btn-secondary ms-2">Cancel</button>
        </div>
        <button type="button" class="btn btn-outline-danger">Delete</button>
    </div>
</div>
 <!-- Campaign Slide Panel -->
  <div id="campaignPanel" class="slide-panel">
    
  </div>
<!-- Overlay -->
<div id="overlay" class="fade-overlay"></div>

</html>