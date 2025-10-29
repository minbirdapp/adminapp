@extends('layouts.minbird')

@section('title', 'Setup Payment')

@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">

  {{-- Success Message --}}
  @if(session('success'))
  <div class="success-message position-absolute alert-auto-hide" role="alert">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
  </div>
  @endif

  <div class="choose-payment-plans">
    <div class="plan-header">
      <h2>Choose your plan</h2>
      <p>Try for free for 45 days - cancel anytime</p>
    </div>
    <?php
    $planId = 0;

    ?>
    @forelse($plans as $plan)
    <div class="plan-card">
      <?php $planId = $plan->id; ?>
      <h3>{{ $plan->plan_name }}</h3>
      <div class="plan-details">
        <div class="price" id="planPrice">${{ number_format($plan->cost, 2) }}
          @if($plan->plan_duration == 1)
          /month
          @elseif($plan->plan_duration == 12)
          /year
          @else
          /{{ $plan->plan_duration }} days
          @endif</div>
        <ul class="checklist">
          <li>5 connected social accounts</li>
          <li>Multiple accounts per platform</li>
          <li>Unlimited posts</li>
          <li>Scheduled posts</li>
          <li>Carousel posts</li>
          <li>Human support</li>
          <li><strong>{{ $plan->no_of_brands }}</strong> Brands allowed</li>
          <li><strong>{{ $plan->no_of_social_accounts }}</strong> Social accounts</li>
          <li>Grace period: {{ $plan->grace_duration }} days</li>
        </ul>
        <button class="trial-btn">Start 45 days Trial</button>
        <span class="note"><img src="assets/img/icons/cancel.svg" alt="info"> $0.00 due today, cancel anytime</span>
      </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted">
      <p>No payment plans available yet.</p>
    </div>
    @endforelse
    <a href="{{route('setup.confirm', $planId)}}" class="continue-btn">Continue</a>
  </div>
</main>
@endsection