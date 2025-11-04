@extends('layouts.logged-in')

@section('title', 'Change Password')

@section('content')

<div class="col main-content">
    <!-- Header -->
    @include('layouts.logged-in-header')
    @if(session('success'))
    <div class="alert alert-success position-absolute alert-auto-hide" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="box-637 position-relative">
        <h6 class="mb-3">Brands</h6>
        @include('includes/app_settings')
        <!-- Card -->
        <div class="card invite-team shadow-sm">
            <div class="card-header">
                <h4>{{$selectedBrand ? 'Edit' : 'Add New'}} Brand</h4>
            </div>
            <div class="card-body">
                <form id="addBrandForm" method="POST" action="{{ route('brands.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="app-settings-brands" value="1" />
                    <input type="hidden" name="record_id" value="{{$selectedBrand ? $selectedBrand->id : ''}}" />
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><span class="text-danger">*</span>Name of the Brand</label>
                            <input type="text" class="form-control" value="{{$selectedBrand ? $selectedBrand->name : ''}}" id="brandName" name="name" placeholder="Enter brand name">
                            <small class="text-danger" id="brandError"></small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><span class="text-danger">*</span>Select Industry</label>
                            <select class="form-select" id="industrySelect" name="industry_id">

                                <option value="">Choose industry</option>
                                @foreach($industries as $industry)
                                @if($selectedBrand && $selectedBrand->industry_id == $industry->id)
                                <option selected value="{{ $industry->id }}">{{ $industry->name }}</option>
                                @else
                                <option value="{{ $industry->id }}">{{ $industry->name }}</option>

                                @endif
                                @endforeach
                            </select>
                            <small class="text-danger" id="industryError"></small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Describe your brand</label>
                            <textarea class="form-control" id="brandIntro" name="intro" rows="2">{{$selectedBrand ? $selectedBrand->intro : ''}} </textarea>

                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Share your competitors information</label>
                            <textarea class="form-control" id="competitorInfo" name="competitor_info" rows="3">{{$selectedBrand ? $selectedBrand->competitor_info : ''}}</textarea>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{$selectedBrand ? 'Edit' : 'Add New'}} Brand</button>
                </form>
            </div>
        </div>
        <!-- List Section -->
        <div class="list-team-section">
            <h6 class="mb-3">List of Brands</h6>
            <div class="search-box mb-3 position-relative">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="form-control searchBrandData" placeholder="Search">
            </div>

            <div class="team-list" id="searchBrandData">
                @if($brands->count())
                @foreach($brands as $v)
                <div class="team-item">
                    <div class="member-info">
                        <p>{{$v->name}}</p><br>
                        {{$v->social_medias->count()}} Social Media Channel
                    </div>
                    <div class="position-relative">
                        <button class="btn-more menu-btn">...</button>
                        <div class="quick-menu">
                            <h6>Quick Menu</h6>
                            <a href="{{route('app.settings.edit.brands', $v->id)}}">Edit</a>
                            <!-- <a data-bs-toggle="modal" data-bs-target="#viewModal" href="#">View</a> -->
                            <a href="{{route('app.settings.delete.brands', $v->id)}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        </div>
                    </div>
                    <!-- <button class="btn-more">...</button> -->
                </div>
                @endforeach


                @endif

                <ul class="pagination justify-content-center">
                    @for ($i = 1; $i <= $brands->lastPage(); $i++)
                        <li class="page-item {{ $brands->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $brands->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor
                </ul>


            </div>

        </div>
    </div>
    <?php include(resource_path('js/pages/validations.php')); ?>

    <script>
        document.querySelectorAll(".menu-btn").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.stopPropagation();

                // Close all other menus first
                document.querySelectorAll(".quick-menu").forEach(menu => {
                    if (menu !== this.nextElementSibling) menu.classList.remove("active");
                });

                // Toggle this menu
                const menu = this.nextElementSibling;
                menu.classList.toggle("active");
            });
        });

        // Close menu if click outside
        document.addEventListener("click", () => {
            document.querySelectorAll(".quick-menu").forEach(menu => menu.classList.remove("active"));
        });
    </script>
</div>
@endsection