@extends('layouts.logged-in')

@section('title', 'App Settings')

@section('content')

<!-- Main Content -->
<div class="col main-content">
    <!-- Header -->
    @include('layouts.logged-in-header')
    <div class="app-settings">
        <h5 class="mb-4">Quick App Settings</h5>

        <div class="row g-4">

            <div class="col-md-4 col-sm-6">
                <div class="setting-card active">
                    <span class="setting-icon"><img src="assets/img/icons/share.svg" alt="share"></span>
                    <h6 class="text-primary">Connect your Channel</h6>
                    <p>Most things start with a Campaign board in Min Bird.</p>
                    <a href="{{route('app.settingschannel')}}" class="btn btn-outline-dark btn-sm">View Channels</a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="setting-card">
                    <span class="setting-icon"><img src="assets/img/icons/team.svg" alt="team"></span>
                    <h6 class="text-primary">Invite your team</h6>
                    <p>Build, ship, and manage with coworkers.</p>
                    <a  href="{{ route('app.settings.teams') }}" class="btn btn-outline-dark btn-sm">Invite Team Member</a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="setting-card">
                    <span class="setting-icon"><img src="assets/img/icons/brand.svg" alt="brand"></span>
                    <h6 class="text-primary">Brands</h6>
                    <p>Most things start with a Campaign board in Min Bird.</p>
                    <button class="btn btn-outline-dark btn-sm">View Brand</button>
                </div>
            </div>
            <!-- My Profile -->
            <div class="col-md-4 col-sm-6">
                <div class="setting-card ">
                    <span class="setting-icon">
                        <img src="{{ asset('assets/img/icons/myProfile.svg') }}" alt="profile" width="48">
                    </span>
                    <h6 class="text-primary">My Profile</h6>
                    <p>Update your personal and account details.</p>
                    <a href="{{ route('profile') }}" class="btn btn-outline-dark btn-sm">View Profile</a>
                </div>
            </div>

            <!-- Change Password -->
            <div class="col-md-4 col-sm-6">
                <div class="setting-card ">
                    <span class="setting-icon">
                        <img src="{{ asset('assets/img/icons/password.svg') }}" alt="password" width="48">
                    </span>
                    <h6 class="text-primary">Change Password</h6>
                    <p>Change your account password securely.</p>
                    <a href="{{ route('password.change') }}" class="btn btn-outline-dark btn-sm">Change Password</a>
                </div>
            </div>

            <!-- Billing -->
            <div class="col-md-4 col-sm-6">
                <div class="setting-card">
                    <span class="setting-icon">
                        <img src="{{ asset('assets/img/icons/billing.svg') }}" alt="billing" width="48">
                    </span>
                    <h6 class="text-primary">Billing</h6>
                    <p>Manage your payment methods and invoices.</p>
                    <a href="#" class="btn btn-outline-dark btn-sm ">Open Billing</a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="setting-card">
                    <span class="setting-icon"><img src="assets/img/icons/campaign.svg" alt="campaign"></span>
                    <h6 class="text-primary">CRM</h6>
                    <p>Most things start with a Campaign board in Min Bird.</p>
                    <button class="btn btn-outline-dark btn-sm">Start Campaign</button>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="setting-card">
                    <span class="setting-icon"><img src="assets/img/icons/campaign.svg" alt="campaign"></span>
                    <h6 class="text-primary">Whatsapp / Message</h6>
                    <p>Build, ship, and manage with coworkers.</p>
                    <button class="btn btn-outline-dark btn-sm">Invite Team Member</button>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="setting-card">
                    <span class="setting-icon"><img src="assets/img/icons/campaign.svg" alt="campaign"></span>
                    <h6 class="text-primary">Connect to Calendar</h6>
                    <p>Most things start with a Campaign board in Min Bird.</p>
                    <button class="btn btn-outline-dark btn-sm">Invite Team Member</button>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="setting-card">
                    <span class="setting-icon"><img src="assets/img/icons/campaign.svg" alt="campaign"></span>
                    <h6 class="text-primary">Services</h6>
                    <p>Most things start with a Campaign board in Min Bird.</p>
                    <button class="btn btn-outline-dark btn-sm">Start Campaign</button>
                </div>
            </div>

        </div>


    </div>
</div>
@endsection