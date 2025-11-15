@extends('layouts.logged-in')

@section('title', 'All Posts')

@section('content')
<div class="col main-content">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">List of Posts</h4>
      <a href="{{ route('posts.create.step1') }}" class="btn theme-btn btn-sm"> New Post</a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('posts.index') }}" id="filterForm" class="d-flex flex-wrap gap-2 mb-3 align-items-center">

      <!-- Search -->
      <div class="input-group" style="max-width: 250px;">
        <span class="input-group-text bg-white border-end-0">
          <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          class="form-control border-start-0"
          placeholder="Search..."
          onkeyup="delaySubmit()" />
      </div>

      <!-- Channel -->
      <select name="channel_id" class="form-select" style="max-width: 180px;" onchange="this.form.submit()">
        <option value="">Select Channel</option>
        @foreach($channels as $ch)
        <option value="{{ $ch->id }}" {{ request('channel_id') == $ch->id ? 'selected' : '' }}>
          {{ ucfirst($ch->account_type) }}
        </option>
        @endforeach
      </select>

      <!-- Brand -->
      <select name="brand_id" class="form-select" style="max-width: 180px;" onchange="this.form.submit()">
        <option value="">Select Brand</option>
        @foreach($brands as $brand)
        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
          {{ $brand->name }}
        </option>
        @endforeach
      </select>

      <!-- Year -->
      <select name="year" class="form-select" style="max-width: 150px;" onchange="this.form.submit()">
        <option value="">Sort by Year</option>
        @for($i = now()->year; $i >= 2020; $i--)
        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
          {{ $i }}
        </option>
        @endfor
      </select>
    </form>
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
              <!-- <a href="#"><i class="fa-solid fa-eye"></i></a> -->
              <a href="{{ route('posts.edit.step1', $post->id) }}" class="me-2">
                <i class="fa-solid fa-pencil text-warning"></i>
              </a>

              <!-- Delete -->

              <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Are you sure you want to delete this post?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="border:none; background:none; padding:0;">
                  <i class="fa-solid fa-trash text-danger"></i>
                </button>
              </form>


            </td>
            <!-- Edit -->




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
    <?php include(resource_path('js/pages/validations.php')); ?>
@endsection
@push('scripts')
<script>
  let typingTimer;

  function delaySubmit() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
      document.getElementById('filterForm').submit();
    }, 600); // delay typing 600ms before submit
  }
</script>

@endpush