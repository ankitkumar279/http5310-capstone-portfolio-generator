<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $portfolio->full_name }} — Designer Portfolio</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/designerportfolio.css') }}">
</head>

<body>
  @php
    $username = request()->route('username')
      ?? ($portfolio->user->username ?? null)
      ?? (auth()->user()->username ?? auth()->user()->name ?? null);
  @endphp

  <div class="dp-blob dp-blob1"></div>
  <div class="dp-blob dp-blob2"></div>
  <div class="dp-blob dp-blob3"></div>

  <div class="dp-wrap">
    @if(auth()->check() && auth()->id() === $portfolio->user_id)
      <div class="dp-ownerbar-wrap">
        <div class="dp-ownerbar">

          <a class="dp-btn" href="{{ route('portfolio.step', [
            'username'  => $username,
            'portfolio' => $portfolio->id,
            'step'      => 6
          ]) }}">Edit</a>

          <a class="dp-btn dp-btn-primary" href="{{ route('portfolio.template.edit', [
            'username'  => $username,
            'portfolio' => $portfolio->id
          ]) }}">Change Template</a>

          <form method="POST" action="{{ route('portfolio.draft', [
            'username'  => $username,
            'portfolio' => $portfolio->id
          ]) }}">
            @csrf
            @method('PATCH')
            <button class="dp-btn" type="submit">Save as Draft</button>
          </form>

          <form method="POST" action="{{ route('portfolio.duplicate', [
            'username'  => $username,
            'portfolio' => $portfolio->id
          ]) }}">
            @csrf
            <button class="dp-btn" type="submit">Duplicate</button>
          </form>

          <form method="POST" action="{{ route('portfolio.destroy', [
            'username'  => $username,
            'portfolio' => $portfolio->id
          ]) }}"
                onsubmit="return confirm('Delete this portfolio? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button class="dp-btn dp-btn-danger" type="submit">Delete</button>
          </form>

        </div>
      </div>
    @endif

    {{-- TOP NAV --}}
    <div class="dp-topbar">
      <div class="dp-brand">
        <span class="dp-brandmark">✦</span>
        <span>{{ $portfolio->full_name }}</span>
      </div>

      <div class="dp-nav">
        <a href="#about">About</a>
        <a href="#work">Work</a>
        <a href="#skills">Skills</a>
        <a href="#projects">Projects</a>
      </div>
    </div>

    {{-- HERO --}}
    <section class="dp-hero dp-reveal">
      <div class="dp-hero-grid">

        <div>
          <div class="dp-kicker">
            <span class="dp-dot"></span>
            Hello! I’m {{ $portfolio->full_name }}
          </div>

          <div class="dp-title">
            {{ $portfolio->job_title ?? 'Designer' }} who
            <span class="dp-accent">judges by the cover</span>
          </div>

          <p class="dp-subtitle">
            {{ $portfolio->short_bio ?? 'I design experiences that feel fast, beautiful, and human.' }}
          </p>

          <div class="dp-meta">
            @if($portfolio->location)
              <div class="dp-pill">📍 {{ $portfolio->location }}</div>
            @endif
            <div class="dp-pill">✨ PortfolioGen — Designer</div>
          </div>

          <div class="dp-cta-row">
            @if($portfolio->linkedin_url)
              <a class="dp-btn dp-btn-primary" href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>
            @endif
            @if($portfolio->github_url)
              <a class="dp-btn" href="{{ $portfolio->github_url }}" target="_blank" rel="noopener">GitHub</a>
            @endif
            @if($portfolio->twitter_url)
              <a class="dp-btn" href="{{ $portfolio->twitter_url }}" target="_blank" rel="noopener">Twitter/X</a>
            @endif
          </div>
        </div>

        <div class="dp-hero-side">
          <div class="dp-orb" aria-hidden="true">
            <div class="dp-logo" title="Animated Logo">
              <svg viewBox="0 0 64 64" role="img" aria-label="Logo">
                <path class="dp-path" d="M18 20h28M32 20v24M22 44h20" />
              </svg>
            </div>
          </div>
        </div>

      </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="dp-section dp-reveal">
      <h2>About</h2>
      <div class="dp-muted">{{ $portfolio->short_bio ?? 'Tell your story here.' }}</div>
    </section>

    {{-- WORK --}}
    <section id="work" class="dp-section dp-reveal">
      <h2>Work Experience</h2>

      @if($portfolio->experiences->count() === 0)
        <div class="dp-muted">No experience added yet.</div>
      @else
        <div class="dp-grid2">
          @foreach($portfolio->experiences as $x)
            <div class="dp-card">
              <div class="dp-card-title">{{ $x->role }} — {{ $x->company_name }}</div>
              <div class="dp-card-meta">{{ $x->start_date ?? '-' }} → {{ $x->end_date ?? 'Present' }}</div>
              @if($x->description)
                <div class="dp-muted">{{ $x->description }}</div>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    </section>

    {{-- SKILLS --}}
    <section id="skills" class="dp-section dp-reveal">
      <h2>Skills</h2>

      @if($portfolio->skills->count() === 0)
        <div class="dp-muted">No skills added.</div>
      @else
        @foreach($portfolio->skills as $s)
          <div class="dp-skill">
            <div class="dp-skill-name">{{ $s->name }}</div>
            <div class="dp-skill-val">{{ $s->level }}%</div>
          </div>
          <div class="dp-bar" aria-hidden="true">
            <div style="width: {{ (int)$s->level }}%;"></div>
          </div>
        @endforeach
      @endif
    </section>

    {{-- PROJECTS --}}
    <section id="projects" class="dp-section dp-reveal">
      <h2>Projects</h2>

      @if($portfolio->projects->count() === 0)
        <div class="dp-muted">No projects added.</div>
      @else
        <div class="dp-grid2">
          @foreach($portfolio->projects as $p)
            @php
              $img = null;
              if (!empty($p->image_path)) {
                if (preg_match('/^https?:\/\//i', $p->image_path)) $img = $p->image_path;
                elseif (str_starts_with($p->image_path, 'storage/')) $img = asset($p->image_path);
                else $img = \Illuminate\Support\Facades\Storage::url($p->image_path);
              }
            @endphp

            <div class="dp-card">
              <div class="dp-card-title">{{ $p->title }}</div>
              <div class="dp-muted">{{ $p->description }}</div>

              @if($img)
                <img class="dp-proj-img" src="{{ $img }}" alt="{{ $p->title }} image" loading="lazy" decoding="async">
              @endif

              <div class="dp-chip-row">
                @if($p->live_url)
                  <a class="dp-chip dp-chip-primary" href="{{ $p->live_url }}" target="_blank" rel="noopener">Live</a>
                @endif
                @if($p->github_url)
                  <a class="dp-chip" href="{{ $p->github_url }}" target="_blank" rel="noopener">GitHub</a>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>

    {{-- EDUCATION --}}
    <section class="dp-section dp-reveal">
      <h2>Education</h2>

      @if($portfolio->educations->count() === 0)
        <div class="dp-muted">No education added.</div>
      @else
        <div class="dp-grid2">
          @foreach($portfolio->educations as $e)
            <div class="dp-card">
              <div class="dp-card-title">{{ $e->degree }}</div>
              <div class="dp-card-meta">{{ $e->institution_name }}</div>
              <div class="dp-muted">{{ $e->start_date }} → {{ $e->end_date ?? 'Present' }}</div>
            </div>
          @endforeach
        </div>
      @endif
    </section>

    {{-- PREMIUM FOOTER --}}
    <footer class="dp-footer dp-reveal">
      <div class="dp-footer-top">

        <div class="dp-footer-block">
          <div class="dp-footer-h">Don’t miss future updates.</div>
          <div class="dp-footer-muted">New projects, case studies & improvements — straight to your inbox.</div>

          <form class="dp-footer-form" onsubmit="return false;">
            <input class="dp-footer-input" type="email" placeholder="Email address" aria-label="Email address">
            <button class="dp-footer-submit" type="submit">Subscribe</button>
          </form>

          <div class="dp-footer-tiny">Unsubscribe anytime.</div>
        </div>

        <div class="dp-footer-block">
          <div class="dp-footer-h">Explore</div>
          <div class="dp-footer-links2">
            <a href="#about">About</a>
            <a href="#work">Work</a>
            <a href="#skills">Skills</a>
            <a href="#projects">Projects</a>
          </div>
        </div>

        <div class="dp-footer-block">
          <div class="dp-footer-h">Connect</div>
          <div class="dp-footer-muted">
            @if($portfolio->email)
              <div class="dp-footer-line">✉️ {{ $portfolio->email }}</div>
            @endif
            @if($portfolio->location)
              <div class="dp-footer-line">📍 {{ $portfolio->location }}</div>
            @endif
          </div>

          <div class="dp-footer-icons">
            @if($portfolio->github_url)
              <a class="dp-iconbtn" href="{{ $portfolio->github_url }}" target="_blank" rel="noopener" aria-label="GitHub">
                <svg viewBox="0 0 24 24" class="dp-ico"><path fill="currentColor" d="M12 .5C5.73.5.75 5.74.75 12.23c0 5.2 3.44 9.6 8.2 11.16.6.12.82-.27.82-.6v-2.2c-3.34.74-4.04-1.66-4.04-1.66-.55-1.43-1.35-1.8-1.35-1.8-1.1-.77.08-.75.08-.75 1.22.09 1.86 1.28 1.86 1.28 1.08 1.9 2.83 1.35 3.52 1.03.11-.8.42-1.35.76-1.66-2.67-.31-5.48-1.38-5.48-6.13 0-1.35.46-2.45 1.22-3.31-.12-.31-.53-1.57.12-3.27 0 0 1-.33 3.3 1.26.96-.27 1.98-.4 3-.4s2.05.14 3 .4c2.3-1.59 3.3-1.26 3.3-1.26.65 1.7.24 2.96.12 3.27.76.86 1.22 1.96 1.22 3.31 0 4.76-2.82 5.82-5.5 6.13.43.38.82 1.13.82 2.28v3.38c0 .33.22.73.83.6 4.76-1.56 8.2-5.96 8.2-11.16C23.25 5.74 18.27.5 12 .5Z"/></svg>
              </a>
            @endif

            @if($portfolio->linkedin_url)
              <a class="dp-iconbtn" href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24" class="dp-ico"><path fill="currentColor" d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29ZM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>
              </a>
            @endif

            @if($portfolio->twitter_url)
              <a class="dp-iconbtn" href="{{ $portfolio->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter/X">
                <svg viewBox="0 0 24 24" class="dp-ico"><path fill="currentColor" d="M18.9 2H22l-6.8 7.77L23 22h-6.8l-5.32-6.62L4.9 22H2l7.35-8.4L1 2h6.9l4.82 6.02L18.9 2Zm-1.2 18h1.7L6.8 4H5L17.7 20Z"/></svg>
              </a>
            @endif
          </div>
        </div>

      </div>

      <div class="dp-footer-bottom">
        <div class="dp-footer-name">{{ $portfolio->full_name }}</div>
        <div class="dp-footer-sub">Built with PortfolioGen • © {{ date('Y') }}</div>
      </div>
    </footer>

  </div>

  <script>
    (function(){
      const els = Array.from(document.querySelectorAll('.dp-reveal'));
      const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('in'); });
      }, { threshold: 0.12 });
      els.forEach(el => io.observe(el));
    })();
  </script>
</body>
</html>