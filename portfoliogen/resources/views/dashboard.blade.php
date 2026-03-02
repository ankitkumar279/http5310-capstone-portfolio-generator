@extends('layouts.dashboard')

@section('content')
@php
  $u = auth()->user()->username;
@endphp

<div class="pg-dash">
  <div class="pg-shell">
    <aside class="pg-side">
      <div class="pg-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PortfolioGen">
      </div>

      <nav class="pg-nav">
        <a class="active" href="{{ route('dashboard', ['username' => $u]) }}">Dashboard</a>
        <a href="{{ route('portfolio.create', ['username' => $u]) }}">Create Portfolio</a>
        <a href="{{ route('templates') }}">Templates</a>
        <a href="{{ route('how') }}">How it works</a>
      </nav>

      <div class="pg-side-bottom">
        <span>{{ auth()->user()->email }}</span>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="pg-mini-btn" type="submit">Logout</button>
        </form>
      </div>
    </aside>

    <main class="pg-main">
      <div class="pg-topbar">
        <h1 class="pg-hello">
          Hello {{ auth()->user()->name }} 👋
          <small>Your PortfolioGen dashboard overview</small>
        </h1>

        <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:flex-end;">
          <a class="pg-btn" href="{{ route('dashboard.published', ['username' => $u]) }}">
            Manage Published
          </a>

          <a class="pg-btn" href="{{ route('portfolio.create', ['username' => $u]) }}">
            + Create New Portfolio
          </a>
        </div>
      </div>

      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <section class="pg-stats">
        <div class="pg-card pulse">
          <div class="k">Total Portfolios</div>
          <div class="v">{{ $total }}</div>
        </div>

        <div class="pg-card">
          <div class="k">Published</div>
          <div class="v">{{ $published }}</div>
        </div>

        <div class="pg-card">
          <div class="k">Draft</div>
          <div class="v">{{ $draft }}</div>
        </div>
      </section>

      <section class="pg-card pg-table-card">
        <div class="pg-card-head">
          <div>
            <h5>Recent Portfolios</h5>
            <div class="sub">Quick access to your latest work</div>
          </div>
          <a class="pg-mini-btn" href="{{ route('portfolio.create', ['username' => $u]) }}">Create</a>
        </div>

        @if($recent->count() === 0)
          <p style="color: var(--pg-muted); margin:0;">No portfolios yet. Create your first one.</p>
        @else
          <div class="table-responsive">
            <table class="pg-table">
              <thead>
                <tr>
                  <th>Template</th>
                  <th>Status</th>
                  <th>Last Updated</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recent as $p)
                  <tr>
                    <td style="font-weight:900;">
                      {{ ucfirst($p->template_key) }}
                    </td>

                    <td>
                      <span class="pg-badge {{ $p->status === 'draft' ? 'draft' : 'published' }}">
                        {{ ucfirst($p->status) }}
                      </span>
                    </td>

                    <td style="color: var(--pg-muted);">
                      {{ $p->updated_at->format('Y-m-d') }}
                    </td>

                    <td class="text-end">
                      <div class="pg-actions">

                        <a class="pg-act primary"
                           href="{{ route('portfolio.step', ['username' => $u, 'portfolio' => $p->id, 'step' => $p->current_step]) }}">
                          Edit
                        </a>

                        <a class="pg-act"
                           href="{{ route('portfolio.owner.view', ['username' => $u, 'portfolio' => $p->id]) }}">
                          Preview
                        </a>

                        <a class="pg-act"
                           href="{{ route('portfolio.template.edit', ['username' => $u, 'portfolio' => $p->id]) }}">
                          Template
                        </a>

                        <form class="pg-inline" method="POST"
                              action="{{ route('portfolio.duplicate', ['username' => $u, 'portfolio' => $p->id]) }}">
                          @csrf
                          <button class="pg-act" type="submit">Duplicate</button>
                        </form>

                        <form class="pg-inline" method="POST"
                              action="{{ route('portfolio.destroy', ['username' => $u, 'portfolio' => $p->id]) }}"
                              onsubmit="return confirm('Delete this portfolio? This cannot be undone.');">
                          @csrf
                          @method('DELETE')
                          <button class="pg-act danger" type="submit">Delete</button>
                        </form>

                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </section>

    </main>
  </div>
</div>
@endsection