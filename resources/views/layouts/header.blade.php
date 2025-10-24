<nav class="navbar bg-white shadow-sm">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <a href="{{ url('/') }}">
        <img src="{{ asset('assets/img/LOGO.svg') }}" alt="logo" class="me-2">
      </a>
    </div>

    <div class="dropdown welcome-btn">
      <div class="user-icon">
        <img src="{{ asset('assets/img/icons/user-icon.svg') }}" alt="user" class="me-2">
      </div>
      <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Welcome {{ Auth::user()->name ?? 'Guest' }}
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        @auth
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item">Logout</button>
            </form>
          </li>
        @else
          <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
