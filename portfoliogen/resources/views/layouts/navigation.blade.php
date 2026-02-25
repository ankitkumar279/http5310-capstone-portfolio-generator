@php
  $isDarkPage = request()->routeIs('home') 
                || request()->routeIs('how') 
                || request()->routeIs('templates');
@endphp

<nav class="navbar navbar-expand-lg navbar-dark pg-nav {{ $isDarkPage ? 'pg-nav-solid' : '' }}">
  <div class="container">

    <a class="navbar-brand pg-logo" href="{{ route('home') }}">
      <img src="{{ asset('images/logo.png') }}" alt="PortfolioGen">
    </a>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNav"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse" id="mainNav">

      <ul class="navbar-nav mx-auto gap-lg-1 align-items-lg-center">

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
             href="{{ route('home') }}">
            Home
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('how') ? 'active' : '' }}"
             href="{{ route('how') }}">
            How it works
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('templates') ? 'active' : '' }}"
             href="{{ route('templates') }}">
            Templates
          </a>
        </li>

        @auth
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ route('dashboard', ['username' => auth()->user()->username]) }}">
              Dashboard
            </a>
          </li>
        @endauth

      </ul>

      <div class="d-flex align-items-center gap-2">

        @guest
          <a class="pg-btn-sm pg-btn-ghost btn" href="{{ route('login') }}">
            Login
          </a>

          <a class="pg-btn-sm pg-btn-primary btn" href="{{ route('register') }}">
            Get Started
          </a>
        @endguest

        @auth
          <div class="dropdown">
            <button class="btn pg-btn-sm pg-user dropdown-toggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
              {{ auth()->user()->name }}
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item"
                   href="{{ route('dashboard', ['username' => auth()->user()->username]) }}">
                  Dashboard
                </a>
              </li>

              <li><hr class="dropdown-divider"></li>

              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        @endauth

      </div>

    </div>
  </div>
</nav>