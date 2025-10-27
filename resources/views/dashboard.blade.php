@extends('layouts.minbird')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <h2>Welcome, {{ Auth::user()->name ?? 'User' }} </h2>
    <p>You’ve successfully logged in to your dashboard.</p>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="btn btn-outline-danger mt-3">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
@endsection
