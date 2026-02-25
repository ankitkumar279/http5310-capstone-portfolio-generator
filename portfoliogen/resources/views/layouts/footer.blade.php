@php
  $isDarkPage =
      request()->routeIs('home') ||
      request()->routeIs('how') ||
      request()->routeIs('templates');
@endphp

<footer class="pg-footer {{ $isDarkPage ? 'pg-footer-dark' : 'pg-footer-light' }}">
  <div class="container py-4">

    <div class="row g-4 align-items-start">
      <!-- Brand -->
      <div class="col-12 col-md-3">
        <div class="fw-bold mb-1">{{ config('app.name', 'PortfolioGen') }}</div>
        <div class="{{ $isDarkPage ? 'text-white-50' : 'text-muted' }} small">
          Create professional portfolios in minutes with AI-powered content generation.
        </div>
      </div>

      <!-- Product -->
      <div class="col-6 col-md-3">
        <div class="fw-bold mb-2">Product</div>
        <div class="d-grid gap-1 small">
          <a class="pg-footer-link" href="{{ route('templates') }}">Templates</a>
          <a class="pg-footer-link" href="{{ route('how') }}">How it Work</a>
          <a class="pg-footer-link" href="#">Pricing</a>
        </div>
      </div>

      <!-- Company -->
      <div class="col-6 col-md-3">
        <div class="fw-bold mb-2">Company</div>
        <div class="d-grid gap-1 small">
          <a class="pg-footer-link" href="#">Contact</a>
          <a class="pg-footer-link" href="#">About</a>
          <a class="pg-footer-link" href="#">GitHub</a>
        </div>
      </div>

      <!-- Connect -->
      <div class="col-12 col-md-3">
        <div class="fw-bold mb-2">Connect</div>
        <div class="d-flex gap-2 align-items-center">
          <!-- GitHub -->
          <a class="pg-footer-icon" href="#" aria-label="GitHub">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path fill="currentColor" d="M12 .5C5.73.5.75 5.62.75 12c0 5.1 3.29 9.42 7.86 10.95.57.11.78-.25.78-.55v-2.02c-3.2.71-3.87-1.4-3.87-1.4-.52-1.35-1.27-1.71-1.27-1.71-1.04-.72.08-.71.08-.71 1.15.08 1.75 1.2 1.75 1.2 1.02 1.78 2.68 1.27 3.33.97.1-.75.4-1.27.72-1.56-2.55-.3-5.23-1.3-5.23-5.77 0-1.27.44-2.31 1.17-3.12-.12-.3-.51-1.5.11-3.12 0 0 .95-.31 3.12 1.19.91-.26 1.88-.39 2.85-.39.97 0 1.95.13 2.85.39 2.17-1.5 3.12-1.19 3.12-1.19.62 1.62.23 2.82.11 3.12.73.81 1.17 1.85 1.17 3.12 0 4.48-2.69 5.47-5.26 5.76.41.37.78 1.1.78 2.22v3.29c0 .3.21.66.79.55 4.56-1.53 7.85-5.85 7.85-10.95C23.25 5.62 18.27.5 12 .5Z"/>
            </svg>
          </a>

          <!-- LinkedIn -->
          <a class="pg-footer-icon" href="#" aria-label="LinkedIn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path fill="currentColor" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H7.351V9h3.414v1.561h.046c.476-.9 1.637-1.852 3.37-1.852 3.603 0 4.268 2.372 4.268 5.457v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.119 20.452H3.556V9h3.563v11.452z"/>
            </svg>
          </a>

          <!-- X -->
          <a class="pg-footer-icon" href="#" aria-label="X">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path fill="currentColor" d="M18.9 2H22l-6.77 7.74L23.2 22h-6.5l-5.1-6.56L5.5 22H2.4l7.3-8.35L1 2h6.6l4.6 6.02L18.9 2Zm-1.1 18h1.7L6.7 3.9H4.9L17.8 20Z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <hr class="pg-footer-sep my-3">

    <div class="text-center fw-semibold pg-footer-copy">
      © {{ date('Y') }} {{ config('app.name','PortfolioGen') }}. All rights reserved.
    </div>

  </div>
</footer>