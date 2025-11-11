@extends('layouts.logged-in')

@section('title', 'Create Campaign')

@section('content')

<div class="col main-content">
    <!-- Header -->
    @include('layouts.logged-in-header')
    <div class="box-637 position-relative">
        <h5>&nbsp;</h5>
        @include('includes/app_settings')
        <div class="card mt-3">
            <div class="card-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Campaign Setup</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="form-section p-0">
                    <input type="hidden" name="validFieldsresponse" id="validFieldsresponse" value="" />

                    <form method="post" action="{{route('campaign.create')}}" id="documentForm" novalidate>@csrf
                        <!-- Basic Fields -->
                         <input type="hidden" name="id" value="{{$campaign ? $campaign->id: ''}}" />
                        <div class="mb-3">
                            <label class="form-label">Name of your campaign <span class="text-danger">*</span></label>
                            <input type="text" id="name" value="{{$campaign ? $campaign->name: ''}}" name="name" class="form-control" placeholder="Enter campaign name">
                            <div id="nameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Brand <span class="text-danger">*</span></label>
                            <select id="brand_id" name="brand_id" class="form-select">
                                <option value="">Select a brand</option>
                                @if(isset($brands))
                                @foreach($brands as $v)
                                <option {{ $campaign && $campaign->brand_id== $v->id ? 'selected' : '' }} value="{{$v->id}}"> {{$v->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <div id="brand_idError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status of your campaign <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select">
                                <option value="">Select Status</option>
                                <option {{ $campaign && $campaign->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                <option {{ $campaign && $campaign->status == 0 ? 'selected' : '' }} value="0">InActive</option>
                                <option {{ $campaign && $campaign->status == 2 ? 'selected' : '' }} value="2">Draft</option>
                            </select>
                            <div id="statusError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Objective of your campaign <span class="text-danger">*</span></label>
                            <textarea id="objective" name="objective" class="form-control" rows="2" placeholder="Write objective...">{{$campaign ? $campaign->objective: ''}}</textarea>
                            <div id="objectiveError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note for our AI Agents <span class="text-danger">*</span></label>
                            <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="Add notes for AI agents...">{{$campaign ? $campaign->notes: ''}}</textarea>
                            <div id="notesError" class="text-danger"></div>
                        </div>

                        <!-- Dates -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-calendar-week"></i></span>
                                    <input id="start_date" name="start_date" value="{{$campaign && $campaign->start_date ? date('d-m-Y',strtotime($campaign->start_date)): ''}}" type="date" class="form-control">
                                    <div id="start_dateError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End date of Campaign <small
                                        class="text-muted">(Optional)</small></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-calendar-week"></i></span>
                                    <input id="end_date" name="end_date" value="{{$campaign && $campaign->end_date ? date('d-m-Y',strtotime($campaign->end_date)): ''}}" type="date" class="form-control">
                                    <div id="end_dateError" class="text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Tracking URLs -->
                        <div class="border rounded p-3 mb-3">
                            <h6 class="mb-3">Tracking URL</h6>

                            <div class="mb-3">
                                <label class="form-label">Tracker Name</label>
                                <input type="text" class="form-control trackerName" name="" placeholder="Tracker Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tracker URL</label>
                                <input type="text" class="form-control trackerUrl" name="" placeholder="URL of Tracker">
                            </div>

                            <button type="button" id="addUrl" class="btn btn-outline-primary btn-xs mb-2">Add URL Tracker</button>

                            <!-- Tracker List -->
                            <div id="trackerList">
                                @if($campaign->trackingUrls->count())
                                @foreach($campaign->trackingUrls as $val)
                                <div class="tracker-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><strong>{{$val->name}}</strong> — {{$val->url}}</span>
                                        <div class="tracker-buttons"><button type="button" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></button> <button type="button" class="deleteTrackingUrl delete-btn"><i class="fa-solid fa-trash"></i></button> </div>
                                    </div>
                                    <div class="edit-form"><input type="text" class="form-control form-control-sm mb-2 currentInput" value="{{$val->url}}"> <input type="hidden" class="trackerName" name="tracker[name][]" value="{{$val->name}}"> <input type="hidden" name="tracker[url][]" class="form-control trackerUrl" value="{{$val->url}}">
                                        <div class="text-end"> <button type="button" class="btn btn-sm btn-primary save-btn">Save</button> <button type="button" class="btn btn-sm btn-outline-secondary cancel-btn">Cancel</button> </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                            </div>
                        </div>

                        <!-- Buttons -->
                        <div>
                            <button type="submit" id="submitCamp" class="btn btn-primary">{{$campaign ? 'Edit' :  'Add' }} Campaign</button>
                            <a href="{{route('campaign.list')}}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include(resource_path('js/pages/validations.php')); ?>
    @push('scripts')
    <script>
        let deleteTarget = null;
        jQuery(document).on('click', '.edit-btn', function() {
            const parent = jQuery(this).parent().parent().closest('.tracker-item');
            parent.find('.edit-form').show();
        });
        jQuery(document).on('click', '.cancel-btn', function() {
            const parent = jQuery(this).parent().parent().closest('.tracker-item');
            parent.find('.edit-form').hide();
        });
        jQuery(document).on('click', '.deleteTrackingUrl', function() {
            const parent = jQuery(this).parent().parent().closest('.tracker-item');
            parent.remove();
        });
        jQuery(document).on('click', '.save-btn', function() {
            const parent = jQuery(this).parent().parent().closest('.tracker-item');
            const name = parent.find('.trackerName').val();
            const url = parent.find('.currentInput').val();
            parent.find('span').html(`<strong>${name}</strong> — ${url}`);
            parent.find('.edit-form').hide();
        });

        // Delete Tracker
        if (document.getElementById('deleteModal')) {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteTarget = this.closest('.tracker-item');
                    deleteModal.show();
                });
            });
            document.getElementById('confirmDelete').addEventListener('click', () => {
                if (deleteTarget) deleteTarget.remove();
                deleteModal.hide();
            });
        }
    </script>
    @endpush
</div>
@endsection