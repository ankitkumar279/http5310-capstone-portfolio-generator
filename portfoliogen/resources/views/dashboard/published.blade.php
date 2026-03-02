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
        <a href="{{ route('dashboard', ['username' => $u]) }}">Dashboard</a>
        <a href="{{ route('portfolio.create', ['username' => $u]) }}">Create Portfolio</a>
        <a href="{{ route('templates') }}">Templates</a>
        <a href="{{ route('how') }}">How it works</a>
        <a class="active" href="{{ route('dashboard.published', ['username' => $u]) }}">Published</a>
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
    Published Portfolios
    <small>Open / Copy / Unpublish / Delete</small>
  </h1>

  <div class="pg-topbar-actions">
    <a class="pg-btn pg-btn-ghost" href="{{ route('dashboard', ['username' => $u]) }}">
      ← Back
    </a>
  </div>
</div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if($publishedList->count() === 0)
        <div class="pg-card" style="padding:18px;">
          <div style="font-weight:900;">No published portfolios yet.</div>
          <div style="opacity:.75; margin-top:6px;">
            Publish a portfolio and it will show here with shareable link.
          </div>
        </div>
      @else
        <section class="pg-card pg-table-card">
          <div class="pg-card-head">
            <div>
              <h5>All Published Links</h5>
              <div class="sub">Manage your public portfolios</div>
            </div>
          </div>

          <div class="pg-table-wrap">
            <table class="pg-table">
              <thead>
                <tr>
                  <th>Template</th>
                  <th>Published At</th>
                  <th>Public Link</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>

              <tbody>
                @foreach($publishedList as $p)
                  @php
                    $publicUrl = route('portfolio.public.view', [
                      'username' => $u,
                      'public_id' => $p->public_id
                    ]);
                  @endphp

                  <tr>
                    <td style="font-weight:900;">{{ ucfirst($p->template_key) }}</td>

                    <td style="opacity:.75;">
                      {{ optional($p->published_at)->format('Y-m-d H:i') }}
                    </td>

                    <td style="max-width:520px;">
                      <a href="{{ $publicUrl }}" target="_blank" rel="noopener" style="word-break:break-all;">
                        {{ $publicUrl }}
                      </a>
                    </td>

                    <td class="text-end">
                      <div class="pg-actions">

                        <button type="button" class="pg-act"
                          onclick="navigator.clipboard.writeText(@js($publicUrl)).then(()=>alert('Copied!')).catch(()=>alert('Copy failed'));">
                          Copy
                        </button>

                        <a class="pg-act primary" href="{{ $publicUrl }}" target="_blank" rel="noopener">
                          Open
                        </a>

                        <a class="pg-act"
                           href="{{ route('portfolio.owner.view', ['username' => $u, 'portfolio' => $p->id]) }}">
                          Owner Preview
                        </a>

                        <form class="pg-inline" method="POST"
                              action="{{ route('portfolio.unpublish', ['username' => $u, 'portfolio' => $p->id]) }}"
                              onsubmit="return confirm('Unpublish this portfolio? It will stop being public.');">
                          @csrf
                          @method('PATCH')
                          <button class="pg-act" type="submit">Unpublish</button>
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
        </section>
      @endif

    </main>
  </div>
</div>
@endsection