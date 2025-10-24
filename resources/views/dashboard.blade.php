@extends('layouts.minbird')
@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    <p>You have successfully verified your account.</p>
</div>
@endsection

