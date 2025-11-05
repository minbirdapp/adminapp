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
        var  searchBrandUrl = "{{route('search.brand')}}";
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
          <!-- <button type="button" class="btn btn-edit">Edit</button> -->
          <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
          <!-- <button type="button" class="btn btn-delete">Delete</button> -->
        </div>
        </div>
    </div>
</div>
<!-- Campaign Slide Panel -->
    <div id="campaignPanel" class="slide-panel">
        <div class="panel-header d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold mb-0">Create a New Campaign</h4>
            <button id="closeCampaignPanel"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="panel-body">
            <p class="panel-note">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ornare, nisl nec laoreet lacinia,
                velit lacus ultricies velit, vel iaculis eros tortor ac risus.
            </p>
            <input type="hidden" name="validFieldsresponse" id="validFieldsresponse" value="" />
            <form method="post" action="{{route('campaign.create')}}" id="documentForm" novalidate>
                @csrf
                <div class="form-section">
                    <label class="form-label">Name of your campaign</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter campaign name">
                    <div id="nameError" class="text-danger"></div>
                </div>
                <div class="row form-section">
                    <div class="col-md-6">
                        <label class="form-label">Select the brand associated to this campaign</label>
                        <select id="brand_id" name="brand_id" class="form-select">
                            <option value="">Select a brand</option>
                            @if(isset($brands))
                            @foreach($brands as $v)
                            <option value="{{$v->id}}"> {{$v->name}}</option>
                            @endforeach
                            @endif
                        </select>
                        <div id="brand_idError" class="text-danger"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status of your campaign</label>
                        <select id="status" name="status" class="form-select">
                            <option>Select Status</option>
                            <option value="1">Active</option>
                            <option value="2">Draft</option>
                        </select>
                        <div id="statusError" class="text-danger"></div>
                    </div>
                </div>
                <div class="form-section">
                    <label class="form-label">Objective of your campaign</label>
                    <textarea id="objective" name="objective" class="form-control" rows="2" placeholder="Write objective..."></textarea>
                    <div id="objectiveError" class="text-danger"></div>

                </div>

                <div class="form-section">
                    <label class="form-label">Note for our AI Agents</label>
                    <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="Add notes for AI agents..."></textarea>
                    <div id="notesError" class="text-danger"></div>
                </div>

                <div class="row form-section">
                    <div class="col-md-6">
                        <label class="form-label">Start Date</label>
                        <input id="start_date" name="start_date" type="date" class="form-control">
                        <div id="start_dateError" class="text-danger"></div>

                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End date of Campaign (optional)</label>
                        <input id="end_date" name="end_date" type="date" class="form-control">
                        <div id="end_dateError" class="text-danger"></div>
                    </div>
                </div>

                <div class="form-section">
                    <label class="form-label">Tracking URL</label>
                    <div class="row g-2 mb-2">
                        <div class="col-md-5"><input type="text" class="form-control trackerName" name="tracker[name][]" placeholder="Tracker Name"></div>
                        <div class="col-md-5"><input type="text" class="form-control trackerUrl" name="tracker[url][]" placeholder="URL of Tracker"></div>
                        <div class="col-md-2"><button type="button" id="addUrl" class="addurl-btn btn btn-outline-primary w-100">Add
                                URL</button></div>
                    </div>
                    <div class="trackingUrls">
                    </div>
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text">Shopping URL</span>
                        <input type="text" class="form-control" value="https://www.domainname.com/trackerid/845">
                        <button class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </div> -->
                </div>
                <button type="submit" id="submitCamp" class="btn btn-primary" style="display:none;">Save</button>

            </form>
        </div>
        <div class="d-flex justify-content-between panel-footer">
            <div>
                <button type="button" id="submitCampaign" class="btn btn-primary">Save</button>
                <button type="button" id="cancelBtn" class="btn btn-secondary ms-2">Cancel</button>
            </div>
            <!-- <button type="button" class="btn btn-outline-danger">Delete</button> -->
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
    <!-- Overlay -->
    <div id="overlay" class="fade-overlay"></div>
</html>