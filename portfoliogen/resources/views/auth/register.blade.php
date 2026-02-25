@extends('layouts.auth')

@section('title', 'Register - PortfolioGen')

@section('content')
@php
  $slides = [
    'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1600&auto=format&fit=crop', // your snowy alley image
    'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1600&auto=format&fit=crop',
  ];
@endphp

<div class="pg-auth-wrap">
  <div class="pg-auth-shell">
    <div class="row g-0">
      <div class="col-lg-5 d-none d-lg-block">
        <div class="pg-auth-left" id="pgHero">
          @foreach($slides as $i => $url)
            <div class="pg-slide {{ $i === 0 ? 'is-active' : '' }}" style="background-image:url('{{ $url }}')"></div>
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
              <h2>Create a portfolio recruiters love.</h2>
              <p>
                Build a premium, AI-polished portfolio in minutes using PortfolioGen.
                Clean templates, strong branding, and export-ready results.
              </p>

              <div class="pg-dots" id="pgDots">
                <div class="pg-dot is-active"></div>
                <div class="pg-dot"></div>
                <div class="pg-dot"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- RIGHT: FORM --}}
      <div class="col-lg-7">
        <div class="pg-auth-right">
          <div class="pg-auth-card">

            <h1 class="pg-auth-title">Create an account</h1>
            <p class="pg-auth-sub">
              Already have an account?
              <a class="pg-auth-link" href="{{ route('login') }}">Log in</a>
            </p>

            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="mb-3">
                <label class="pg-form-label" for="name">Name</label>
                <input id="name" type="text"
                  class="form-control pg-input @error('name') is-invalid @enderror"
                  name="name" value="{{ old('name') }}" required autofocus
                  placeholder="Your full name">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- ✅ USERNAME (OPTIONAL) --}}
              <div class="mb-3">
                <label class="pg-form-label" for="username">Username (optional)</label>
                <input id="username" type="text"
                  class="form-control pg-input @error('username') is-invalid @enderror"
                  name="username" value="{{ old('username') }}"
                  placeholder="e.g. ankitdev">
                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror

                <div class="form-text" style="color: rgba(255,255,255,0.65);">
                  Leave blank and we’ll create one from your name.
                </div>
              </div>

              <div class="mb-3">
                <label class="pg-form-label" for="email">Email</label>
                <input id="email" type="email"
                  class="form-control pg-input @error('email') is-invalid @enderror"
                  name="email" value="{{ old('email') }}" required
                  placeholder="you@example.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="mb-3">
                <label class="pg-form-label" for="password">Password</label>
                <input id="password" type="password"
                  class="form-control pg-input @error('password') is-invalid @enderror"
                  name="password" required
                  placeholder="Enter your password">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="mb-3">
                <label class="pg-form-label" for="password-confirm">Confirm password</label>
                <input id="password-confirm" type="password"
                  class="form-control pg-input"
                  name="password_confirmation" required
                  placeholder="Repeat your password">
              </div>

              <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms" style="color: rgba(255,255,255,0.75);">
                  I agree to the <a class="pg-auth-link" href="#" onclick="return false;">Terms & Conditions</a>
                </label>
              </div>

              <button type="submit" class="btn pg-btn-gradient w-100">
                Create account
              </button>

              <div class="pg-divider">Or register with</div>

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

          <div class="d-lg-none text-center mt-3">
            <a href="{{ route('home') }}" class="pg-auth-link">← Back to website</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  (function () {
    const root = document.getElementById('pgHero');
    if (!root) return;

    const slides = Array.from(root.querySelectorAll('.pg-slide'));
    const dotsWrap = document.getElementById('pgDots');
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