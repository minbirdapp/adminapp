@extends('layouts.logged-in')

@section('title', 'All Posts')

@section('content')
<div class="col main-content">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">List of Posts</h4>
      <a href="{{ route('posts.create.step1') }}" class="btn theme-btn btn-sm">+ New Post</a>
    </div>

    <!-- Filters -->
    <div class="d-flex flex-wrap gap-2 mb-3">
      <div class="input-group" style="max-width: 250px;">
        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
        <input type="text" class="form-control border-start-0" placeholder="Search...">
      </div>

      <select class="form-select" style="max-width: 180px;">
        <option value="">Select Channel</option>
        @foreach($channels as $ch)
          <option value="{{ $ch->id }}">{{ ucfirst($ch->account_type) }}</option>
        @endforeach
      </select>

      <select class="form-select" style="max-width: 180px;">
        <option value="">Select Brand</option>
        @foreach($brands as $brand)
          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
      </select>

      <select class="form-select" style="max-width: 150px;">
        <option>Sort by Year</option>
        @for($i = now()->year; $i >= 2020; $i--)
          <option value="{{ $i }}">{{ $i }}</option>
        @endfor
      </select>
    </div>

    <!-- Posts Table -->
    <div class="table-responsive">
      <table class="list-table table align-middle bg-white border rounded">
        <thead class="table-light">
          <tr>
            <th>Post Name</th>
            <th>Date of Posting</th>
            <th>Type</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($posts as $post)
            <tr>
              <td>
                @if($post->profile && $post->profile->account_type)
                  <i class="fa-brands fa-{{ strtolower($post->profile->account_type) }}"></i>
                @endif
                {{ $post->title }}
              </td>
              <td>
                @if($post->schedule_date && $post->schedule_time)
                  {{ \Carbon\Carbon::parse($post->schedule_date . ' ' . $post->schedule_time)->format('M d Y h:i A') }}
                @else
                  —
                @endif
              </td>
              <td>
                {{ $post->postType->name ?? 'N/A' }}
                <span class="badge bg-light text-dark ms-2">{{ ucfirst($post->content_type) }}</span>
              </td>
              <td>
                @php
                  $statusClass = match($post->status) {
                    'posted' => 'status-posted',
                    'scheduled' => 'status-scheduled',
                    'processing' => 'status-processing',
                    'draft' => 'status-draft',
                    'rejected' => 'status-rejected',
                    default => 'status-draft'
                  };
                @endphp
                <span class="badge br-20 {{ $statusClass }}">{{ ucfirst($post->status ?? 'Draft') }}</span>
              </td>
              <td>
                <a href="#"><i class="fa-solid fa-eye"></i></a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">No posts found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <span class="text-muted small">← Previous</span>
      {{ $posts->links('pagination::bootstrap-5') }}
      <span class="text-muted small">Next →</span>
    </div>
  </div>
</div>
@endsection
