@extends('layouts.minbird')

@section('title', 'Setup Payment')

@section('content')
<main class="flex-grow-1 d-flex align-items-center justify-content-center">

  {{-- Success Message --}}
  @if(session('success'))
  <div class="alert alert-success position-absolute alert-auto-hide" role="alert">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
  </div>
  @endif

  <div class="choose-payment-plans">
    <div class="plan-header text-center mb-4">
      <h2>Choose your plan</h2>
      <p>Try for free for 45 days — cancel anytime</p>
    </div>

    <div class="row justify-content-center">
      @forelse($plans as $plan)
      <div class="col-md-6">
        <div class="plan-card mb-4 p-4 border rounded shadow-sm text-center">
          <h3>{{ $plan->plan_name }}</h3>
          @if($plan->description)
            <p class="text-muted">{{ $plan->description }}</p>
          @endif

          <div class="plan-details mt-3">
            <div class="price mb-3">
              ${{ number_format($plan->cost, 2) }}
              @if($plan->plan_duration == 1)
                /month
              @elseif($plan->plan_duration == 12)
                /year
              @else
                /{{ $plan->plan_duration }} days
              @endif
            </div>

            <ul class="checklist text-start d-inline-block">
              <li><strong>{{ $plan->no_of_brands }}</strong> Brands allowed</li>
              <li><strong>{{ $plan->no_of_social_accounts }}</strong> Social accounts</li>
              <li>Grace period: {{ $plan->grace_duration }} days</li>
            </ul>

            <button class="trial-btn btn btn-primary w-100 mt-3">Start 45 Days Trial</button>

            <span class="note d-block text-muted mt-2">
              <img src="{{ asset('assets/img/icons/cancel.svg') }}" alt="cancel" width="16">
              $0.00 due today, cancel anytime
            </span>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-center text-muted">
        <p>No payment plans available yet.</p>
      </div>
      @endforelse
    </div>

    <div class="text-center mt-4">
      <button class="continue-btn btn btn-outline-primary px-5">Continue</button>
    </div>
  </div>
</main>
@endsection
