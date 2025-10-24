<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

   @stack('styles')
</head>

<body>
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
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
   @stack('scripts')
</body>
</html>
