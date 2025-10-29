<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>@yield('title', 'Minbird')</title>
   <!-- Vendor CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/fontawesome/fontawesome.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/choices.min.css') }}">
   <!-- Main CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/dashboard-style.css') }}">
   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   <!-- Your code -->
   @stack('styles')
</head>
<body>
   <script>
      var siteKey = "{{env('CAPTCHA_SITE_KEY') }}";
      var secretKey = "{{env('CAPTCHA_SECRET_KEY') }}";
      if(document.getElementById('register-btn')) {
      document.getElementById('register-btn').addEventListener('click', function(e) {
         e.preventDefault();
         grecaptcha.enterprise.ready(async () => {
            const token = await grecaptcha.enterprise.execute(siteKey, {
               action: 'register'
            });
            document.getElementById('g-recaptcha-response').value = token;
            document.getElementById('register-form').submit();
         });
      });}
   </script>
   <div class="wrapper d-flex flex-column min-vh-100">
      {{-- Header --}}
      @include('layouts.header')
      {{-- Main Page Content --}}
      <main class="flex-grow-1 d-flex align-items-center justify-content-center">
         @yield('content')
      </main>
      {{-- Footer --}}
      @include('layouts.footer')
   </div>
   <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/choices.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
   @stack('scripts')
</body>
</html>