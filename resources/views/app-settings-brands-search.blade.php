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

<ul class="pagination justify-content-center">
    @for ($i = 1; $i <= $brands->lastPage(); $i++)
        <li class="page-item {{ $brands->currentPage() == $i ? 'active' : '' }}">
            <a class="page-link" href="{{ $brands->url($i) }}">{{ $i }}</a>
        </li>
        @endfor
</ul>
@else
<div class="team-item">
    <div class="member-info">
        No brand data found.
    </div>
    </div>
@endif