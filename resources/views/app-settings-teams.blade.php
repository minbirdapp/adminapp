@extends('layouts.logged-in')

@section('title', 'Team Members')

@section('content')
<div class="col main-content">
    @include('layouts.logged-in-header')

    <div class="box-637 position-relative">
        <h6 class="mb-3">Team Members</h6>
        <a href="{{ route('app.settings') }}" class="btn btn-outline-secondary btn-sm top-right-btn">
            Back to App Settings
        </a>


        {{-- Invite Team Member --}}
        <div class="card invite-team shadow-sm">
            <div class="card-header">
                <h4>Invite Team Member</h4>
            </div>
            <div class="card-body">
                <form id="inviteTeamForm" method="POST" action="{{ $selectedMember ?  route('team-members.update', $selectedMember->id) : route('team-members.store') }}" novalidate>
                    @csrf
                    <div class="row g-3 mb-3">

                        {{-- First Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><span class="text-danger">*</span> First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                value="{{ $selectedMember ? $selectedMember->user->profile->first_name : old('first_name') }}">
                            @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger client-error"></small>
                        </div>

                        {{-- Last Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><span class="text-danger">*</span> Last Name</label>
                            <input type="text" name="last_name" class="form-control"
                                value="{{ $selectedMember ? $selectedMember->user->profile->last_name :old('last_name') }}">
                            @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger client-error"></small>
                        </div>

                        {{-- Role --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><span class="text-danger">*</span> Role</label>
                            <select name="role_id" class="form-select">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}
                                    {{ $selectedMember && $selectedMember->user->user_role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger client-error"></small>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><span class="text-danger">*</span> Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $selectedMember ? $selectedMember->user->email : old('email') }}">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger client-error"></small>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><span class="text-danger">*</span> Status</label>
                            <select name="status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="1" {{ $selectedMember && $selectedMember->status == 1 ? 'selected' : '' }} {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $selectedMember && $selectedMember->status == 0 ? 'selected' : '' }} {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger client-error"></small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $selectedMember ? 'Update' : 'Send Invite' }}</button>
                </form>
            </div>
        </div>
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
        {{-- List of Team Members --}}
        <div class="list-team-section mt-5">
            <h6 class="mb-3">List of Team Members</h6>
            <div class="search-box mb-3 position-relative">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="teamSearch" class="form-control" placeholder="Search team members...">
            </div>

            <div class="team-list">
                @forelse($teamMembers as $member)
                <div class="team-item">
                    <div class="team-info">
                        <p>{{ $member->invitedUser->name ?? 'N/A' }}
                            <small>
                                ({{ $member->invitedUser->role->name ?? 'No Role' }})
                            </small>
                        </p>
                        @if($member->status == 1)
                        <span class="badge badge-active">Active Member</span>
                        @else
                        <span class="badge badge-inactive">Inactive Member</span>
                        @endif
                        <br>
                        {{ $member->invitedUser->email ?? '' }}
                    </div>

                    {{-- 3-dot menu --}}
                    <div class="position-relative">
                        <button class="btn-more menu-btn">⋯</button>
                        <div class="quick-menu">
                            <h6>Quick Menu</h6>
                            <a href="#" class="viewMember"
                                data-id="{{ $member->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#viewModal">View</a>
                            <a class="" href="{{ route('team-members.edit', $member->id) }}">
                                Edit
                            </a>
                            <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{ route('team-members.delete', $member->id) }}">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">No team members found.</p>
                @endforelse
            </div>

        </div>

    </div>
</div>


<?php include(resource_path('js/pages/validations.php')); ?>

@endsection