@extends('layouts.logged-in')

@section('title', 'Campaign list')

@section('content')

<div class="col main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Campaign</h4>
            <button class="btn theme-btn btn-sm">New Post</button>
        </div>

        <!-- Filters -->
        <div class="d-flex flex-wrap gap-2 mb-3 filters-bar">
            <div class="input-group" style="max-width: 250px;">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search">
            </div>
            <select class="form-select" style="max-width: 180px;">
                <option>Select Channel</option>
            </select>
            <select class="form-select" style="max-width: 180px;">
                <option>Select Brand</option>
            </select>
            <select class="form-select" style="max-width: 150px;">
                <option>Sort by Year</option>
            </select>
        </div>

        <!-- Posts Table -->
        <div class="table-responsive">
            @if(session('success'))
            <div class="success-message" role="alert">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="success-message" role="alert">{{ session('error') }}</div>
            @endif
            <table class="list-table table align-middle bg-white border rounded">
                <thead class="table-light">
                    <tr>
                        <th>Campaign Name</th>
                        <th>Brand Name</th>
                        <th>Duration</th>
                        <th>Post</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($list->count())
                    @foreach($list as $k=>$v)
                    <tr>
                        <td><a href="{{route('campaign.edit', $v->id)}}">{{$v->name}}</a></td>
                        <td>{{$v->brand->name}}</td>
                        <td>
                            {{date('m/d/Y', strtotime($v->start_date))}}
                            @if(!empty($v->end_date))
                            - {{date('m/d/Y', strtotime($v->end_date))}}
                            @endif
                        </td>
                        <td>0</td>
                        <td>
                            @if($v->status == 0)
                            <span class="badge br-20 status-rejected">Inactive</span>
                            @elseif($v->status == 1)
                            <span class="badge br-20 status-posted">Active</span>
                            @elseif($v->status == 2)
                            <span class="badge br-20 status-draft">Draft</span>
                            @elseif($v->status == 3)
                            <span class="badge br-20 status-error">Error</span>
                            @else
                            <span class="badge br-20 status-rejected">Rejected</span>
                            @endif
                        </td>
                        <td><a href="javascript:void(0)" class="view-campaign" data-attr-id="{{$v->id}}"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6">No Data Found.</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <!-- <span class="text-muted small">← Previous</span> -->
            <ul class="pagination mb-0">
                @for ($i = 1; $i <= $list->lastPage(); $i++)
                    <li class="page-item {{ $list->currentPage() == $i ? 'active' : '' }}"><a class="page-link" href="{{ $list->url($i) }}">1</a></li>
                    @endfor
            </ul>
            <!-- <span class="text-muted small">Next →</span> -->
        </div>
    </div>
</div>
@endsection