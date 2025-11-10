@extends('layouts.logged-in')

@section('title', 'Create Post - Step 2')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('includes.sidebar')

        <div class="col main-content">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="box-637 position-relative">
                <h5>Create a New Post</h5>
                <a href="{{ route('posts.create.step1') }}" class="btn btn-outline-secondary btn-sm top-right-btn">Back to Step 1</a>

                <div class="card mt-3">
                    <div class="card-header position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><small>Step 2</small>
                                <h4>Create a Social Media Post</h4>
                            </span>

                            <button type="button" class="btn btn-outline-secondary btn-sm top-right-btn">Preview Post</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.store.step2', $post->id) }}" enctype="multipart/form-data" id="step2Form">
                            @csrf
                            <input type="hidden" name="post_type_id" id="post_type_id" value="{{ $post->post_type_id ?? $postTypes->first()->id }}">

                            <!-- Post Type Tabs -->
                            <label class="form-section-title mb-2">Select Post Type</label>
                            <ul class="nav nav-tabs mb-3" id="postTypeTabs" role="tablist">
                                @foreach($postTypes as $type)
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ strtolower($type->name) }}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#{{ strtolower($type->name) }}"
                                        type="button"
                                        role="tab">
                                        {{ ucfirst($type->name) }}
                                    </button>
                                </li>
                                @endforeach
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="postTypeTabsContent">
                                @foreach($postTypes as $type)
                                <div
                                    class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ strtolower($type->name) }}"
                                    role="tabpanel"
                                    aria-labelledby="{{ strtolower($type->name) }}-tab">

                                    @if(strtolower($type->name) === 'feed')
                                    <div class="mb-3">
                                        <label class="form-section-title"><span class="text-danger">*</span> Post Content for Twitter</label>
                                        <textarea name="twitter_content" class="form-control" rows="2" placeholder="Enter text for Twitter">{{ old('twitter_content') }}</textarea>
                                         <small class="text-danger" id="twitterError"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-section-title"><span class="text-danger">*</span> Post Content for Instagram</label>
                                        <textarea name="instagram_content" class="form-control" rows="2" placeholder="Enter text for Instagram">{{ old('instagram_content') }}</textarea>
                                                        <small class="text-danger" id="instagramError"></small>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-section-title"><span class="text-danger">*</span> Post Content for Facebook</label>
                                        <textarea name="facebook_content" class="form-control" rows="2" placeholder="Enter text for Facebook">{{ old('facebook_content') }}</textarea>
                                                        <small class="text-danger" id="facebookError"></small>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-section-title"><span class="text-danger">*</span> Post Content for LinkedIn</label>
                                        <textarea name="linkedin_content" class="form-control" rows="2" placeholder="Enter text for LinkedIn">{{ old('linkedin_content') }}</textarea>
                                        <small class="text-danger" id="linkedinError"></small>
                                    </div>

                                    @elseif(strtolower($type->name) === 'reel')
                                    <div class="mb-3">
                                        <label class="form-section-title"><span class="text-danger">*</span> Reel Caption</label>
                                        <textarea name="reel_caption" class="form-control" rows="3" placeholder="Enter caption for Reel">{{ old('reel_caption') }}</textarea>
                                        <small class="text-danger" id="reelError"></small>
                                    </div>

                                    @elseif(strtolower($type->name) === 'story')
                                    <div class="mb-3">
                                        <label class="form-section-title"><span class="text-danger">*</span> Story Description</label>
                                        <textarea name="story_description" class="form-control" rows="3" placeholder="Enter story content">{{ old('story_description') }}</textarea>
                                        <small class="text-danger" id="storyError"></small>
                                    </div>

                                    @elseif(strtolower($type->name) === 'shorts')
                                    <div class="mb-3">
                                        <label class="form-section-title"><span class="text-danger">*</span> Shorts Title</label>
                                        <input type="text" name="shorts_title" class="form-control" placeholder="Enter short title" value="{{ old('shorts_title') }}">
                                        <small class="text-danger" id="shortsError"></small>
                                    </div>
                                    @endif

                                </div>
                                @endforeach
                            </div>


                            <!-- Schedule Section -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-section-title"><span class="text-danger">*</span> Schedule your post</label>
                                    <input type="date" name="schedule_date" class="form-control" value="{{ old('schedule_date') }}">
                                    <small class="text-danger" id="scheduleDateError"></small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-section-title"><span class="text-danger">*</span> Schedule your time</label>
                                    <input type="time" name="schedule_time" class="form-control" value="{{ old('schedule_time') }}">
                                    <small class="text-danger" id="scheduleTimeError"></small>
                                </div>
                            </div>

                            <!-- Upload -->
                            <div class="mb-3">
                                <label class="form-section-title">Media</label>
                                <div class="upload-box text-center border p-4 rounded">
                                    <p>📤 JPG, PNG, or WebM less than 10MB<br>
                                        Drag & drop here or
                                        <label class="text-primary" style="cursor:pointer;">Browse
                                            <input type="file" name="media[]" multiple class="d-none">
                                        </label>
                                    </p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-section-title"><span class="text-danger">*</span>Status of the Post</label>
                                <select name="status" class="form-select">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                <small class="text-danger" id="statusError"></small>
                            </div>

                            <!-- Approver -->
                            <div class="mb-3 approver-box">
                                <small class="mb-2 d-block">Do you need approval for this Post?</small>
                                <label class="form-section-title"><span class="text-danger">*</span>Select Approver or Manager name</label>
                                <select name="approver_id" class="form-select">
                                    <option value="">Select Approver</option>
                                    @foreach($approvers ?? [] as $user)
                                    <option value="{{ $user->id }}" {{ old('approver_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                                 <small class="text-danger" id="approverError"></small>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn theme-btn">Publish Post</button>
                                    <button type="submit" name="status" value="draft" class="btn theme-btn">Save as Draft</button>
                                </div>
                                <a href="{{ route('posts.create.step1') }}" class="btn btn-light border">Back to Step 1</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const postTypeInput = document.getElementById("post_type_id");
    const postTypes = @json($postTypes);

    //  update hidden post type id on tab switch
    document.querySelectorAll('#postTypeTabs button[data-bs-toggle="tab"]').forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            const tabId = event.target.id.replace('-tab', '');
            postTypes.forEach(type => {
                if (type.name.toLowerCase() === tabId.toLowerCase()) {
                    postTypeInput.value = type.id;
                }
            });
        });
    });

    //  VALIDATION
    const step2Form = document.getElementById('step2Form');
    if (!step2Form) return;

    step2Form.addEventListener('submit', function(e) {
        let valid = true;

        // Clear previous errors
        step2Form.querySelectorAll('small.text-danger').forEach(el => el.textContent = '');

        const activeTab = document.querySelector('#postTypeTabs .nav-link.active');
        const activeType = activeTab ? activeTab.textContent.trim().toLowerCase() : '';
        const scheduleDate = document.querySelector("[name='schedule_date']");
        const scheduleTime = document.querySelector("[name='schedule_time']");
        const statusSelect = document.querySelector("[name='status']");
        const approverSelect = document.querySelector("[name='approver_id']");

        //  validate active tab content
        if (activeType === 'feed') {
            ['twitter','instagram','facebook','linkedin'].forEach(platform => {
                const field = document.querySelector(`[name='${platform}_content']`);
                const err = document.getElementById(`${platform}Error`);
                if (field && !field.value.trim()) {
                    err.textContent = `Please enter ${platform} content.`;
                    valid = false;
                }
            });
        }

        if (activeType === 'reel') {
            const reel = document.querySelector("[name='reel_caption']");
            const err = document.getElementById('reelError');
            if (reel && !reel.value.trim()) {
                err.textContent = 'Reel caption is required.';
                valid = false;
            }
        }

        if (activeType === 'story') {
            const story = document.querySelector("[name='story_description']");
            const err = document.getElementById('storyError');
            if (story && !story.value.trim()) {
                err.textContent = 'Story description is required.';
                valid = false;
            }
        }

        if (activeType === 'shorts') {
            const shorts = document.querySelector("[name='shorts_title']");
            const err = document.getElementById('shortsError');
            if (shorts && !shorts.value.trim()) {
                err.textContent = 'Shorts title is required.';
                valid = false;
            }
        }

        // other required fields
        if (!scheduleDate.value.trim()) {
            document.getElementById('scheduleDateError').textContent = 'Please select a schedule date.';
            valid = false;
        }

        if (!scheduleTime.value.trim()) {
            document.getElementById('scheduleTimeError').textContent = 'Please select a schedule time.';
            valid = false;
        }

        if (!statusSelect.value) {
            document.getElementById('statusError').textContent = 'Please select a status.';
            valid = false;
        }

        // if (!approverSelect.value) {
        //     document.getElementById('approverError').textContent = 'Please select an approver.';
        //     valid = false;
        // }

        // stop form submission if invalid
        if (!valid) {
            e.preventDefault();
            e.stopImmediatePropagation(); // ensures Laravel doesn’t catch submit
        }
    });
});
</script>
@endpush


