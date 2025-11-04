@extends('layouts.minbird')

@section('title', 'Team Members')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('includes.sidebar')

        <div class="col main-content">
            @include('layouts.logged-in-header')

            <div class="box-637 position-relative">
                <h6 class="mb-3">Team Members</h6>
                <a href="{{ route('app.settings') }}" class="btn btn-outline-secondary btn-sm top-right-btn">
                    Back to App Settings
                </a>
  

                {{-- Invite Team Member --}}
                <div class="card invite-team shadow-sm">
                    <div class="card-header"><h4>Invite Team Member</h4></div>
                    <div class="card-body">
                        <form id="inviteTeamForm" method="POST" action="{{ route('team-members.store') }}" novalidate>
                            @csrf
                            <div class="row g-3 mb-3">

                                {{-- First Name --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><span class="text-danger">*</span> First Name</label>
                                    <input type="text" name="first_name" class="form-control" 
                                           value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="text-danger client-error"></small>
                                </div>

                                {{-- Last Name --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><span class="text-danger">*</span> Last Name</label>
                                    <input type="text" name="last_name" class="form-control" 
                                           value="{{ old('last_name') }}">
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
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
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
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
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
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="text-danger client-error"></small>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Send Invite</button>
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

    <div class="team-list">
        @forelse($teamMembers as $member)
            <div class="team-item">
                <div class="team-info">
                    <p>{{ $member->user->name }}
                        <small>
                            ({{ $member->user->role->name ?? 'No Role' }})
                        </small>
                    </p>
                    @if($member->status == 1)
                        <span class="badge badge-active">Active Member</span>
                    @else
                        <span class="badge badge-inactive">Inactive Member</span>
                    @endif
                  
                    {{ $member->user->email }}
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
                        <a class="editMember" href="{{ route('team-members.edit', $member->id) }}" 
                           >Edit</a>
                        <!-- <form method="POST" action="{{ route('team-members.destroy', $member->id) }}" 
                              class="d-inline deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger border-0 bg-transparent">Delete</button>
                        </form> -->
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
    </div>
</div>
<!-- View Team Member Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">View Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="viewMemberContent" class="text-center py-4">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.editMember').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.dataset.id;

            fetch(`/team-members/${id}/view`)
                .then(res => res.json())
                .then(data => {
                    // Fill the form fields
                    document.querySelector('[name="first_name"]').value = data.first_name;
                    document.querySelector('[name="last_name"]').value = data.last_name;
                    document.querySelector('[name="email"]').value = data.email;
                    document.querySelector('[name="role_id"]').value = data.role_id;
                    document.querySelector('[name="status"]').value = data.status;
                    document.getElementById('member_id').value = data.id;

                    // Change button text
                    document.querySelector('#inviteTeamForm button[type="submit"]').textContent = 'Update Member';
                })
                .catch(() => alert('Failed to load team member details.'));
        });
    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Toggle 3-dot quick menu
    document.querySelectorAll('.menu-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            document.querySelectorAll('.quick-menu').forEach(menu => {
                if (menu !== btn.nextElementSibling) menu.classList.remove('active');
            });
            btn.nextElementSibling.classList.toggle('active');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.quick-menu').forEach(menu => menu.classList.remove('active'));
    });

    // View Modal (AJAX load)
    document.querySelectorAll('.viewMember').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.dataset.id;
            const modalBody = document.getElementById('viewMemberContent');
            modalBody.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

            fetch(`/team-members/${id}/view`)
                .then(res => res.json())
                .then(data => {
                    modalBody.innerHTML = `
                        <div class="text-start">
                            <p><strong>Full Name:</strong> ${data.name}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Status:</strong> ${data.status}</p>
                            <p><strong>Role:</strong> ${data.role}</p>
                            <p><strong>Joined:</strong> ${data.created_at}</p>
                        </div>`;
                })
                .catch(() => modalBody.innerHTML = '<p class="text-danger">Failed to load member info.</p>');
        });
    });

    // Confirm delete
    document.querySelectorAll('.deleteForm').forEach(form => {
        form.addEventListener('submit', e => {
            if (!confirm('Are you sure you want to delete this team member?')) e.preventDefault();
        });
    });

});
</script>


<?php include(resource_path('js/pages/validations.php')); ?>

@endsection
