<div class="panel-header d-flex justify-content-between align-items-center">
    <h4 class="fw-semibold mb-0">View Campaign - {{$campaign->name}}</h4>
    <button id="closeCampaignPanel"><i class="fa-solid fa-xmark"></i></button>
</div>
<div class="panel-body">
    <h6>Post Overview</h6>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="report-card">
                <div class="head">
                    <img src="{{asset('assets/img/icons/post-icon.svg') }}" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>0</strong></p>
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
                    <img src="{{asset('assets/img/icons/post-icon.svg') }}" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>0</strong></p>
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
                    <img src="{{asset('assets/img/icons/post-icon.svg') }}" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>0</strong></p>
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
                    <img src="{{asset('assets/img/icons/post-icon.svg') }}" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>0</strong></p>
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
                    <img src="{{asset('assets/img/icons/post-icon.svg') }}" alt="Total Post">
                    <h6>Total Post</h6>
                    <p>Total Post: <strong>0</strong></p>
                </div>
                <div class="foot">
                    <a href="#" class="small">View all</a>
                    <span class="small text-muted">2025</span>
                </div>
            </div>
        </div>
    </div>
    <div class="objective">
        <h6>Objective of your campaign</h6>
        <p>{{$campaign->objective}}</p>
    </div>
    <div class="note-label">
        <h6>Note for our AI Agents</h6>
        <p>{{$campaign->notes}}</p>
    </div>
    <div class="duration-brands-column">
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <div class="label">Durations</div>
                <div class="value"> {{date('m/d/Y', strtotime($campaign->start_date))}}
                    @if(!empty($campaign->end_date))
                    - {{date('m/d/Y', strtotime($campaign->end_date))}}
                    @endif</div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="label">Brands</div>
                <div class="value">{{$campaign->brand->name}}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="label">Status</div>
                @if($campaign->status == 0)
                <span class="badge br-20 status-rejected">Inactive</span>
                @elseif($campaign->status == 1)
                <span class="badge br-20 status-posted">Active</span>
                @elseif($campaign->status == 2)
                <span class="badge br-20 status-draft">Draft</span>
                @elseif($campaign->status == 3)
                <span class="badge br-20 status-error">Error</span>
                @else
                <span class="badge br-20 status-rejected">Rejected</span>
                @endif
            </div>
        </div>
    </div>
    <form>
        <div class="form-section p-0 mt-4">
            <h6>Tracking URL</h6>
            @if($campaign->trackingUrls->count())
            @foreach($campaign->trackingUrls as $val)
            <div class="input-group mb-2">
                <span class="input-group-text">{{$val->name}}</span>
                <input type="text" class="form-control" value="{{$val->url}}">
            </div>
            @endforeach
            @else
            <div class="input-group mb-2">No data Found.</div>
            @endif
        </div>
    </form>
</div>
<div class="d-flex justify-content-between panel-footer">
    <div>
        <a href="{{route('campaign.edit',$campaign->id )}}" class="btn btn-primary">Edit</a>
        <button type="button" id="cancelBtn" class="btn btn-secondary ms-2">Cancel</button>
    </div>
    <a href="{{route('campaign.delete',$campaign->id )}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-outline-danger">Delete</a>
</div>