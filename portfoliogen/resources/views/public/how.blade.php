@extends('layouts.app')

@section('content')
@push('styles')
  <link rel="stylesheet" href="{{ asset('css/how.css') }}">
@endpush

<div class="pg-how">
  <div class="container py-4">

    <!-- HERO -->
    <section class="pg-how-hero">
      <div class="pg-how-kicker">
        <span class="dot"></span>
        <span>How it works • 4 simple steps</span>
      </div>

      <h1 class="pg-how-title">
        Build a portfolio that looks <span class="grad">professional</span> — fast
      </h1>

      <p class="pg-how-sub">
        Choose a template, enter your details, and publish a clean, shareable portfolio.
        Optional AI can polish your wording so your projects read stronger—without changing your meaning.
      </p>
    </section>

    <hr class="pg-divider">

    @php
      $steps = [
        [
          'n' => '01',
          't' => 'Choose Your Template',
          'd' => 'Browse professionally designed templates and pick the style that matches your goal—minimal, developer-focused, or creative.',
          'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1400&auto=format&fit=crop'
        ],
        [
          'n' => '02',
          't' => 'Fill Your Details',
          'd' => 'Add your education, skills, projects, and experience in a guided flow. No design work required—just enter your information.',
          'img' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1400&auto=format&fit=crop'
        ],
        [
          'n' => '03',
          't' => 'AI-Powered Enhancement (Optional)',
          'd' => 'Improve clarity and impact with better summaries and stronger project bullets. Keep it authentic—your voice, just cleaner.',
          'img' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1400&auto=format&fit=crop'
        ],
        [
          'n' => '04',
          't' => 'Publish & Share',
          'd' => 'Generate your portfolio and share the link with recruiters, classmates, and clients. Update anytime and keep it fresh.',
          'img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=1400&auto=format&fit=crop'
        ],
      ];
    @endphp

    <!-- STEPS (alternating layout) -->
    <section class="pb-2">
      @foreach($steps as $i => $s)
        <div class="row g-3 align-items-stretch mb-3">
          @php($flip = $i % 2 === 1)

          <div class="col-lg-6 {{ $flip ? 'order-lg-2' : '' }}">
            <div class="pg-glass pg-step h-100">
              <div class="pg-step-num">{{ $s['n'] }}</div>
              <h5>{{ $s['t'] }}</h5>
              <p>{{ $s['d'] }}</p>
            </div>
          </div>

          <div class="col-lg-6 {{ $flip ? 'order-lg-1' : '' }}">
            <div class="pg-glass pg-step-media h-100">
              <img src="{{ $s['img'] }}" alt="{{ $s['t'] }}" loading="lazy">
            </div>
          </div>
        </div>
      @endforeach
    </section>

    <hr class="pg-divider">

    <!-- WHY CHOOSE -->
    <section>
      <h3 class="text-center fw-black" style="font-weight:900;">Why Choose PortfolioGen?</h3>
      <p class="text-center" style="color:rgba(255,255,255,0.72);max-width:70ch;margin:0.5rem auto 1.4rem;">
        Simple workflow, modern templates, and optional AI—built to help students and developers present work clearly.
      </p>

      <div class="row g-3">
        <div class="col-6 col-md-3">
          <div class="pg-glass pg-mini h-100">
            <div class="icon">⚡</div>
            <div class="t">Save Time</div>
            <div class="d">Create a portfolio in minutes, not days.</div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="pg-glass pg-mini h-100">
            <div class="icon">🧩</div>
            <div class="t">No Coding</div>
            <div class="d">Just fill the form and publish.</div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="pg-glass pg-mini h-100">
            <div class="icon">✨</div>
            <div class="t">AI-Powered</div>
            <div class="d">Optional improvements for stronger writing.</div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="pg-glass pg-mini h-100">
            <div class="icon">🔄</div>
            <div class="t">Always Updated</div>
            <div class="d">Edit anytime—your link stays the same.</div>
          </div>
        </div>
      </div>
    </section>

    <hr class="pg-divider">

    <!-- CTA -->
    <section class="pb-4">
      <div class="pg-cta d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
          <h4>Ready to build your portfolio?</h4>
          <p>Start free, choose a template, and publish a link you can share today.</p>
        </div>

       <div class="d-flex gap-2">
  @auth
    <a class="btn btn-light"
       href="{{ route('dashboard', ['username' => auth()->user()->username]) }}">
       Go to Dashboard
    </a>
  @else
    <a class="btn btn-light" href="{{ route('register') }}">
      Start for Free
    </a>
  @endauth

  <a class="btn btn-outline-light" href="{{ route('templates') }}">
    View Templates
  </a>
</div>
      </div>
    </section>

   
  </div>
</div>
@endsection