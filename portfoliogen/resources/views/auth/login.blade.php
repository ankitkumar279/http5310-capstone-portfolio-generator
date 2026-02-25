@extends('layouts.auth')

@section('title', 'Login - PortfolioGen')

@section('content')
@php
  $slides = [
    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1600&auto=format&fit=crop',
  ];
@endphp

<div class="pg-auth-wrap">
  <div class="pg-auth-shell">
    <div class="row g-0 align-items-stretch">
      <div class="col-lg-5 d-none d-lg-block">
        <div class="pg-auth-left" id="pgHeroLogin">

          @foreach($slides as $i => $url)
            <div class="pg-slide {{ $i === 0 ? 'is-active' : '' }}"
                 style="background-image: url('{{ $url }}');"></div>
          @endforeach

          <div class="pg-auth-left-content">

            <div class="pg-auth-left-top">
              <div class="pg-brand-mark">
                <img src="{{ asset('images/logo.png') }}" alt="PortfolioGen">
              </div>

              <a href="{{ route('home') }}" class="pg-pill">
                Back to website →
              </a>
            </div>

            <div class="pg-left-copy">
              <h2>Welcome back.</h2>
              <p>
                Log in to continue building and managing your AI-powered portfolio.
              </p>

              <div class="pg-dots" id="pgDotsLogin">
                <div class="pg-dot is-active"></div>
                <div class="pg-dot"></div>
                <div class="pg-dot"></div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="pg-auth-right">
          <div class="pg-auth-card">

            <h1 class="pg-auth-title">Log in</h1>

            <p class="pg-auth-sub">
              Don’t have an account?
              <a class="pg-auth-link" href="{{ route('register') }}">Create one</a>
            </p>

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <label class="pg-form-label" for="email">Email</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       class="form-control pg-input @error('email') is-invalid @enderror"
                       placeholder="you@example.com">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label class="pg-form-label" for="password">Password</label>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       class="form-control pg-input @error('password') is-invalid @enderror"
                       placeholder="Enter your password">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <label class="d-flex align-items-center gap-2" style="color: rgba(255,255,255,0.75); font-size: 14px;">
                  <input type="checkbox" name="remember">
                  Remember me
                </label>

                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="pg-auth-link">
                    Forgot password?
                  </a>
                @endif
              </div>

              <button type="submit" class="btn pg-btn-gradient w-100">
                Log in
              </button>

              <div class="pg-divider">Or continue with</div>

              <div class="row g-2">
                <div class="col-sm-6">
                 <button onclick="window.location='{{ url('/auth/google/redirect') }}'" 
        type="button" 
        class="pg-social-btn">
  Continue with Google
</button>
                </div>
                <div class="col-sm-6">
                  <button onclick="window.location='{{ url('/auth/github/redirect') }}'" 
        type="button" 
        class="pg-social-btn">
  Continue with GitHub
</button>
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- SLIDER SCRIPT --}}
<script>
(function () {
  const root = document.getElementById('pgHeroLogin');
  if (!root) return;

  const slides = Array.from(root.querySelectorAll('.pg-slide'));
  const dotsWrap = document.getElementById('pgDotsLogin');
  const dots = dotsWrap ? Array.from(dotsWrap.querySelectorAll('.pg-dot')) : [];

  let i = 0;

  function setActive(next) {
    slides[i].classList.remove('is-active');
    if (dots[i]) dots[i].classList.remove('is-active');

    i = next;

    slides[i].classList.add('is-active');
    if (dots[i]) dots[i].classList.add('is-active');
  }

  setInterval(() => {
    const next = (i + 1) % slides.length;
    setActive(next);
  }, 5000);
})();
</script>

@endsection