@extends('layouts.logged-in')
@section('title', 'Dashboard')
@section('content')
<div class="col main-content">
    <!-- Header -->
       @include('layouts.logged-in-header')

    <!-- Idea Box -->
    <div class="mb-4">
        <label class="form-label fw-semibold">Ask Bird for Idea</label>
        <textarea class="form-control mb-2" rows="2" placeholder="Ask Bird for new creative ideas..."></textarea>
        <small class="text-muted">Plane AI can make mistakes, please double-check responses</small>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary theme-btn btn-sm">Generate Idea</button>
        </div>

    </div>

    <!-- Quickstart Guide -->
    <div class="mb-5">
        @if(session('success'))
            <div class="success-message mb-3 alert-auto-hide" role="alert">{{ session('success') }}</div>
        @endif
        <h6 class="fw-semibold mb-3">Your Quickstart Guide</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="quickstart-card">
                    <h6>Create a Campaign</h6>
                    <p class="text-muted small">Most things start with a Campaign board in Min Bird.</p>
                    <a id="startCampaignBtn" href="{{route('campaign.create')}}" class="btn btn-outline-primary btn-sm">Start Campaign</a>
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
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="assets/img/icons/post-icon.svg" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>123</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="chart-box mt-5">
        <h6 class="fw-semibold mb-3">Quick Report</h6>
        <canvas id="reportChart" height="100"></canvas>
        <div class="text-end">
            <a href="#" class="small">View all</a> | <span class="small text-muted">2025</span>
        </div>
    </div>
</div>

@endsection