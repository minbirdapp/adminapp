@extends('layouts.minbird')

@section('title', 'Confirm Payment')
@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">
  @if(session('success'))
  <div class="success-message position-absolute" role="alert">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
  </div>
  @endif
  
  <div class="choose-payment-plans">
    <div class="plan-header">
      <h2>Choose your plan</h2>
      <p>{{ $plan->plan_name }}</p>
    </div>
    <!-- Plan Card -->
    <div class="plan-card">
      <h3>Plan & Payment Confirmation</h3>
      <div class="plan-details">
      <div class="price" id="planPrice">${{ $plan->cost }} /month</div>
      <ul class="checklist">
        <li>Your Truncation ID : {{rand(1000000,9999999)}}</li>
        <li>Next Billing Cycle : {{date('M d')}}, 2026</li>
        <li>Auto Renewal Status - Yes</li>
      </ul>
      </div>
    </div>
    <a href="{{route('dashboard')}}" class="continue-btn">Continue</a>
  </div>
    
</main>
@endsection