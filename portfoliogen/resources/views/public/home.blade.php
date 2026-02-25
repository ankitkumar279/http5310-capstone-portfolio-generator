@extends('layouts.app')

@section('content')
@push('styles')
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

<div class="pg-landing">
  <!-- Ambient Background Motion -->
  <div class="pg-ambient" aria-hidden="true">
    <div class="pg-blob one"></div>
    <div class="pg-blob two"></div>
    <div class="pg-blob three"></div>
  </div>

  <div class="container py-4 pg-wrap">
    <!-- HERO -->
    <section class="pg-hero">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6">
          <div class="pg-kicker">
            <span class="dot"></span>
            <span>PortfolioGen • Build a portfolio that gets interviews</span>
          </div>

          <h1 class="pg-title">
            Create your professional portfolio in <span class="grad">minutes</span>
          </h1>

          <p class="pg-sub">
            Pick a template, enter your details, and publish a clean, recruiter-friendly portfolio.
            Optional AI helps you polish your bio and project descriptions so your work stands out.
          </p>

          <div class="d-flex flex-wrap gap-2 mt-3">
            @auth
              <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="btn pg-btn pg-btn-primary">
  Start Building
</a>
            @else
              <a href="{{ route('register') }}" class="btn pg-btn pg-btn-primary">
                Start Building
              </a>
            @endauth

            <a href="{{ route('how') }}" class="btn pg-btn pg-btn-ghost">
              How It Works
            </a>
          </div>

          <div class="d-flex flex-wrap gap-2 mt-4">
            <span class="pg-badge">No coding</span>
            <span class="pg-badge">Mobile-friendly</span>
            <span class="pg-badge">ATS-ready sections</span>
            <span class="pg-badge">Fast publishing</span>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="pg-card p-3 p-md-4">
            <div class="pg-card-inner position-relative">
              <div class="pg-media position-relative">
                <img
                  src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1400&auto=format&fit=crop"
                  alt="Portfolio preview"
                  loading="lazy"
                />
                <div class="pg-media-overlay"></div>
              </div>
              <div class="mt-3 d-flex flex-wrap gap-2">
                <span class="pg-badge">Templates</span>
                <span class="pg-badge">Sections</span>
                <span class="pg-badge">Publish</span>
                <span class="pg-badge">Share link</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <hr class="pg-divider">

    <!-- WHY CHOOSE -->
    <section>
      <h3 class="pg-section-title">Why Choose PortfolioGen?</h3>
      <p class="pg-section-sub">
        A simple workflow, modern templates, and optional AI support—built to help students and developers present their work professionally.
      </p>

      <div class="row g-3">
        <div class="col-md-4">
          <div class="pg-card pg-feature h-100">
            <div class="pg-card-inner">
              <div class="pg-icon">
                <!-- icon -->
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M4 7h16M4 12h10M4 17h16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </div>
              <h5>Easy Form-Based Creation</h5>
              <p>
                Add your bio, skills, education, and projects with a guided flow—then generate a clean portfolio automatically.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="pg-card pg-feature h-100">
            <div class="pg-card-inner">
              <div class="pg-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M12 2l2.2 6.3H21l-5 3.7 1.9 6.3L12 15.8 6.1 18.3 8 12 3 8.3h6.8L12 2z"
                        stroke="white" stroke-width="2" stroke-linejoin="round"/>
                </svg>
              </div>
              <h5>AI-Powered Content (Optional)</h5>
              <p>
                Improve clarity and impact: stronger project bullets, better summaries, and polished descriptions—without changing your meaning.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="pg-card pg-feature h-100">
            <div class="pg-card-inner">
              <div class="pg-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M4 5h16v14H4V5z" stroke="white" stroke-width="2"/>
                  <path d="M8 9h8M8 13h6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </div>
              <h5>Professional Templates</h5>
              <p>
                Pick a style that matches your goal—minimal, developer-focused, or creative—optimized for readability and sharing.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <hr class="pg-divider">

    <!-- TEMPLATES -->
    <section>
      <h4 class="pg-section-title">Choose Your Template</h4>
      <p class="pg-section-sub">
        Start with a professionally designed layout and customize it with your information.
      </p>

      @php
        $cards = [
          [
            'key'   => 'minimal',
            'title' => 'Modern Minimalist',
            'tag'   => 'Clean & simple',
            'img'   => 'https://image2url.com/r2/default/images/1772032929069-e9d0cdd0-092a-4bc2-aa37-ce1a5398b33e.png'
          ],
          [
            'key'   => 'developer',
            'title' => 'Developer',
            'tag'   => 'Projects-first',
            'img'   => 'https://image2url.com/r2/default/images/1772032735055-d72484da-b149-4f76-9160-58793dd0b654.png'
          ],
          [
            'key'   => 'designer',
            'title' => 'Creative Designer',
            'tag'   => 'Visual impact',
            'img'   => 'https://image2url.com/r2/default/images/1772032798941-8320fd3a-8cee-45d9-9d18-912293a09d27.png'
          ],
        ];
      @endphp

      <div class="row g-3">
        @foreach($cards as $c)
          <div class="col-md-4">
            <div class="pg-card pg-template h-100">
              <div class="pg-card-inner">
                <div class="pg-thumb">
                  <img src="{{ $c['img'] }}" alt="{{ $c['title'] }}" loading="lazy">
                  <div class="pg-shine"></div>
                </div>

                <div class="pg-template-body">
                  <div>
                    <div class="pg-template-title">{{ $c['title'] }}</div>
                    <div class="mt-1">
                      <span class="pg-badge">{{ $c['tag'] }}</span>
                    </div>
                  </div>

                  <a href="{{ route('templates') }}" class="btn pg-btn pg-btn-primary" style="padding:.65rem .9rem;border-radius:14px;">
                    Preview
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>
  </div>
</div>
@endsection