<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $portfolio->full_name }} — Developer Portfolio</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/portfolio-dev.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body class="dev-body" id="top">

  @php
    // ✅ Get the username from the current route (works with your show route: /{username}/p/{portfolio})
    $username = request()->route('username') ?? (auth()->user()->username ?? auth()->user()->name ?? null);
  @endphp

  {{-- Owner actions --}}
  @if(auth()->check() && auth()->id() === $portfolio->user_id)
    <div class="container py-3 d-flex justify-content-end gap-2 flex-wrap">
      {{-- ✅ FIXED: pass username + portfolio + step --}}
      <a href="{{ route('portfolio.step', [
        'username'  => $username,
        'portfolio' => $portfolio->id,
        'step'      => 6
      ]) }}" class="btn btn-outline-light">Edit</a>

      {{-- ✅ If this route also lives under /{username}/..., pass username too.
           If your route does NOT include username, you can revert to route('portfolio.template.edit', $portfolio->id) --}}
      <a href="{{ route('portfolio.template.edit', [
        'username'  => $username,
        'portfolio' => $portfolio->id
      ]) }}" class="btn btn-outline-primary">
        Change Template
      </a>

      <form method="POST" action="{{ route('portfolio.draft', [
        'username'  => $username,
        'portfolio' => $portfolio->id
      ]) }}">
        @csrf
        @method('PATCH')
        <button class="btn btn-secondary">Save as Draft</button>
      </form>

      <form method="POST" action="{{ route('portfolio.duplicate', [
        'username'  => $username,
        'portfolio' => $portfolio->id
      ]) }}">
        @csrf
        <button class="btn btn-outline-success">Duplicate</button>
      </form>

      <form method="POST" action="{{ route('portfolio.destroy', [
        'username'  => $username,
        'portfolio' => $portfolio->id
      ]) }}"
            onsubmit="return confirm('Delete this portfolio? This cannot be undone.');">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger">Delete</button>
      </form>
    </div>
  @endif

  {{-- NAV --}}
  <header class="dev-nav-wrap">
    <div class="container">
      <nav class="dev-nav">
        <a class="dev-brand" href="#top">
          <span class="dev-brand-dot"></span>
          <span class="dev-brand-text">
            {{ \Illuminate\Support\Str::of($portfolio->full_name)->explode(' ')->first() ?? $portfolio->full_name }}
          </span>
        </a>

        <div class="dev-nav-links d-none d-md-flex">
          <a href="#skills" class="dev-link">Skills</a>
          <a href="#projects" class="dev-link">Projects</a>
          <a href="#experience" class="dev-link">Experience</a>
          <a href="#connect" class="dev-link">Connect</a>
        </div>

        <div class="dev-nav-actions">
          @if($portfolio->github_url)
            <a class="dev-icon-btn" href="{{ $portfolio->github_url }}" target="_blank" aria-label="GitHub">
              @include('portfolio.partials.icons', ['name' => 'github'])
            </a>
          @endif

          @if($portfolio->linkedin_url)
            <a class="dev-icon-btn" href="{{ $portfolio->linkedin_url }}" target="_blank" aria-label="LinkedIn">
              @include('portfolio.partials.icons', ['name' => 'linkedin'])
            </a>
          @endif

          <a class="dev-btn dev-btn-primary" href="#connect">Hire me</a>
        </div>
      </nav>
    </div>
  </header>

  {{-- HERO --}}
  <main class="dev-hero">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="dev-pill">
            <span class="dev-pulse"></span>
            <span>Developer Portfolio</span>
          </div>

          <h1 class="dev-h1">
            Hey, I am <span class="dev-accent">{{ \Illuminate\Support\Str::of($portfolio->full_name)->explode(' ')->last() }}</span><br>
            <span class="dev-title">{{ $portfolio->job_title }}</span>
          </h1>

          <p class="dev-sub">{{ $portfolio->short_bio }}</p>

          <div class="d-flex gap-2 flex-wrap">
            <a class="dev-btn dev-btn-primary" href="#connect">Hire me</a>
            <a class="dev-btn dev-btn-ghost" href="#projects">See Projects</a>
          </div>

          <div class="dev-mini-grid">
            <div class="dev-mini-card">
              <div class="dev-mini-k">Location</div>
              <div class="dev-mini-v">{{ $portfolio->location }}</div>
            </div>
            <div class="dev-mini-card">
              <div class="dev-mini-k">Focus</div>
              <div class="dev-mini-v">Real-Time • Scrollytelling • AR/VR</div>
            </div>
            <div class="dev-mini-card">
              <div class="dev-mini-k">Stack</div>
              <div class="dev-mini-v">React • Node • Laravel</div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="dev-hero-card">
            <div class="dev-hero-badge">JS</div>

            <div class="dev-quote">
              <div class="dev-quote-mark">“</div>
              <div class="dev-quote-text">
                I design interfaces that feel premium, then engineer them to stay fast at scale.
              </div>
              <div class="dev-quote-author">
                <span class="dev-dot"></span>
                <span>{{ $portfolio->full_name }}</span>
              </div>
            </div>

            <div class="dev-avatar">
              <div class="dev-avatar-ring"></div>
              <div class="dev-avatar-core">
                <div class="dev-avatar-initials">
                  {{ strtoupper(substr($portfolio->full_name, 0, 1)) }}
                </div>
              </div>
            </div>

            <div class="dev-float dev-float-1" title="HTML">@include('portfolio.partials.icons', ['name'=>'html'])</div>
            <div class="dev-float dev-float-2" title="CSS">@include('portfolio.partials.icons', ['name'=>'css'])</div>
            <div class="dev-float dev-float-3" title="JS">@include('portfolio.partials.icons', ['name'=>'js'])</div>
            <div class="dev-float dev-float-4" title="Figma">@include('portfolio.partials.icons', ['name'=>'figma'])</div>
          </div>
        </div>
      </div>
    </div>
  </main>

  {{-- SKILLS --}}
  <section id="skills" class="dev-section">
    <div class="container">
      <div class="dev-section-head">
        <h2 class="dev-h2">Skills</h2>
        <p class="dev-muted">Polished UI, clean architecture, and performance-first engineering.</p>
      </div>

      <div class="row g-4 align-items-stretch">
        <div class="col-lg-7">
          <div class="dev-card">
            <div class="dev-card-title">
              <span class="dev-card-title-icon">@include('portfolio.partials.icons', ['name'=>'chart'])</span>
              <span>Core Skills</span>
            </div>

            @foreach($portfolio->skills as $s)
              <div class="dev-skill">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="dev-skill-name">{{ $s->name }}</div>
                  <div class="dev-skill-val">{{ $s->level }}%</div>
                </div>
                <div class="dev-bar">
                  <div class="dev-bar-fill" style="width: {{ (int)$s->level }}%"></div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="dev-card mt-4">
            <div class="dev-card-title">
              <span class="dev-card-title-icon">@include('portfolio.partials.icons', ['name'=>'cap'])</span>
              <span>Education</span>
            </div>

            @foreach($portfolio->educations as $e)
              <div class="dev-edu">
                <div class="dev-edu-top">
                  <div class="dev-edu-degree">{{ $e->degree }}</div>
                  <div class="dev-edu-date">{{ $e->start_date }} → {{ $e->end_date ?? 'Present' }}</div>
                </div>
                <div class="dev-edu-inst">{{ $e->institution_name }}</div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-lg-5">
          <div class="dev-card">
            <div class="dev-card-title">
              <span class="dev-card-title-icon">@include('portfolio.partials.icons', ['name'=>'spark'])</span>
              <span>Motion & Interaction</span>
            </div>

            <div class="dev-feature-grid">
              <div class="dev-feature">
                <div class="dev-feature-ic">@include('portfolio.partials.icons', ['name'=>'layers'])</div>
                <div class="dev-feature-t">Motion Graphics</div>
                <div class="dev-feature-s">Micro-interactions & transitions that feel alive</div>
              </div>

              <div class="dev-feature">
                <div class="dev-feature-ic">@include('portfolio.partials.icons', ['name'=>'eye'])</div>
                <div class="dev-feature-t">Scroll Reveal</div>
                <div class="dev-feature-s">Narrative layout, progressive disclosure</div>
              </div>

              <div class="dev-feature">
                <div class="dev-feature-ic">@include('portfolio.partials.icons', ['name'=>'cpu'])</div>
                <div class="dev-feature-t">Performance</div>
                <div class="dev-feature-s">Fast LCP/INP, reduced layout shift</div>
              </div>

              <div class="dev-feature">
                <div class="dev-feature-ic">@include('portfolio.partials.icons', ['name'=>'cube'])</div>
                <div class="dev-feature-t">AR/VR UX</div>
                <div class="dev-feature-s">3D-first thinking for immersive apps</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- PROJECTS --}}
  <section id="projects" class="dev-section">
    <div class="container">
      <div class="dev-section-head">
        <h2 class="dev-h2">Projects</h2>
        <p class="dev-muted">Hover a project card to preview, then open Live / GitHub.</p>
      </div>

      <div class="row g-4">
        @foreach($portfolio->projects as $p)
          @php
            $img = null;

            if (!empty($p->image_path)) {
              if (preg_match('/^https?:\/\//i', $p->image_path)) {
                $img = $p->image_path;
              }
              elseif (str_starts_with($p->image_path, 'storage/')) {
                $img = asset($p->image_path);
              }
              else {
                $img = \Illuminate\Support\Facades\Storage::url($p->image_path);
              }
            }
          @endphp

          <div class="col-md-6">
            <article class="dev-project-card">
              <div class="dev-project-media">
                @if($img)
                  <div class="dev-project-thumb dev-project-thumb-img">
                    <img src="{{ $img }}" alt="{{ $p->title }}" loading="lazy" decoding="async">
                    <div class="dev-project-chip">Preview</div>
                  </div>
                @else
                  <div class="dev-project-thumb">
                    <div class="dev-project-chip">Preview</div>
                    <div class="dev-project-code">
                      <div class="line w70"></div>
                      <div class="line w50"></div>
                      <div class="line w85"></div>
                      <div class="line w60"></div>
                    </div>
                  </div>
                @endif

                <div class="dev-project-overlay">
                  <div class="dev-project-overlay-inner">
                    <div class="dev-project-title">{{ $p->title }}</div>
                    <div class="dev-project-desc">{{ $p->description }}</div>

                    <div class="dev-project-actions">
                      @if($p->live_url)
                        <a class="dev-btn dev-btn-primary dev-btn-sm" href="{{ $p->live_url }}" target="_blank">Live</a>
                      @endif
                      @if($p->github_url)
                        <a class="dev-btn dev-btn-ghost dev-btn-sm" href="{{ $p->github_url }}" target="_blank">GitHub</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              <div class="dev-project-meta">
                <div>
                  <div class="dev-project-meta-title">{{ $p->title }}</div>
                  <div class="dev-project-meta-sub">{{ $p->description }}</div>
                </div>
                <div class="dev-project-badges">
                  <span class="dev-badge">Dev</span>
                  <span class="dev-badge dev-badge-soft">UI</span>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- EXPERIENCE --}}
  <section id="experience" class="dev-section">
    <div class="container">
      <div class="dev-section-head">
        <h2 class="dev-h2">Experience</h2>
        <p class="dev-muted">What I shipped, improved, and scaled.</p>
      </div>

      <div class="dev-timeline">
        <div class="dev-timeline-rail"></div>

        @foreach($portfolio->experiences as $x)
          <div class="dev-timeline-item">
            <div class="dev-timeline-dot"></div>
            <div class="dev-card dev-card-x">
              <div class="dev-x-role">{{ $x->role }}</div>
              <div class="dev-x-co">{{ $x->company_name }}</div>
              @if($x->description)
                <div class="dev-x-desc">{{ $x->description }}</div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- CONNECT + FOOTER --}}
  <section id="connect" class="dev-section dev-section-last">
    <div class="container">
      <div class="dev-card dev-contact">
        <div class="row g-4 align-items-center">
          <div class="col-lg-7">
            <h2 class="dev-h2 mb-2">Let’s build something clean & fast.</h2>
            <p class="dev-muted mb-0">Connect with me via GitHub/LinkedIn.</p>
          </div>
          <div class="col-lg-5">
            <div class="d-flex gap-2 flex-wrap justify-content-lg-end">
              @if($portfolio->github_url)
                <a class="dev-btn dev-btn-ghost" href="{{ $portfolio->github_url }}" target="_blank">
                  @include('portfolio.partials.icons', ['name' => 'github']) GitHub
                </a>
              @endif
              @if($portfolio->linkedin_url)
                <a class="dev-btn dev-btn-ghost" href="{{ $portfolio->linkedin_url }}" target="_blank">
                  @include('portfolio.partials.icons', ['name' => 'linkedin']) LinkedIn
                </a>
              @endif
              <a class="dev-btn dev-btn-primary" href="#top">Back to top</a>
            </div>
          </div>
        </div>
      </div>

      <footer class="dev-footer">
        <div class="dev-footer-left">© {{ date('Y') }} {{ $portfolio->full_name }}</div>
        <div class="dev-footer-right">Theme: Dev Motion / AR-VR / Scrollytelling</div>
      </footer>
    </div>
  </section>

  <script>
    // Smooth scroll only
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href');
        if (!id || id.length < 2) return;
        const el = document.querySelector(id);
        if (!el) return;
        e.preventDefault();
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  </script>
</body>
</html>