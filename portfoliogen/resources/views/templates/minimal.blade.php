<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $portfolio->full_name }} — Portfolio</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/portfolio-minimal.css') }}">
</head>

<body class="pi-body">

  @php
    $username = request()->route('username')
      ?? ($portfolio->user->username ?? null)
      ?? (auth()->user()->username ?? auth()->user()->name ?? null);
  @endphp

  @if(auth()->check() && auth()->id() === $portfolio->user_id)
    <div class="pi-owner-wrap">
      <div class="pi-ownerbar">
        <a href="{{ route('portfolio.step', [
            'username'  => $username,
            'portfolio' => $portfolio->id,
            'step'      => 6
        ]) }}" class="pi-btn pi-btn-ghost">
          <span class="pi-ico">@includeIf('portfolio.partials.icons.pencil')</span>
          Edit
        </a>

        <a href="{{ route('portfolio.template.edit', [
            'username'  => $username,
            'portfolio' => $portfolio->id
        ]) }}" class="pi-btn pi-btn-primary">
          <span class="pi-ico">@includeIf('portfolio.partials.icons.layers')</span>
          Change Template
        </a>

        <form method="POST" action="{{ route('portfolio.draft', [
            'username'  => $username,
            'portfolio' => $portfolio->id
        ]) }}">
          @csrf
          @method('PATCH')
          <button class="pi-btn pi-btn-ghost" type="submit">
            <span class="pi-ico">@includeIf('portfolio.partials.icons.save')</span>
            Save as Draft
          </button>
        </form>

        <form method="POST" action="{{ route('portfolio.duplicate', [
            'username'  => $username,
            'portfolio' => $portfolio->id
        ]) }}">
          @csrf
          <button class="pi-btn pi-btn-ghost" type="submit">
            <span class="pi-ico">@includeIf('portfolio.partials.icons.copy')</span>
            Duplicate
          </button>
        </form>

        <form method="POST" action="{{ route('portfolio.destroy', [
            'username'  => $username,
            'portfolio' => $portfolio->id
        ]) }}"
              onsubmit="return confirm('Delete this portfolio? This cannot be undone.');">
          @csrf
          @method('DELETE')
          <button class="pi-btn pi-btn-danger" type="submit">
            <span class="pi-ico">@includeIf('portfolio.partials.icons.trash')</span>
            Delete
          </button>
        </form>
      </div>
    </div>
  @endif

  <header class="pi-top">
    <div class="pi-container">
      <div class="pi-top-inner">

        <a class="pi-brand" href="#top" aria-label="Home">
          <span class="pi-brand-badge" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2l9 6-9 14L3 8l9-6z"/></svg>
          </span>
          <span class="pi-brand-text">
            <span class="pi-brand-name">{{ $portfolio->full_name }}</span>
            <span class="pi-brand-sub">{{ $portfolio->job_title ?? 'Portfolio' }}</span>
          </span>
        </a>

        <nav class="pi-nav" aria-label="Primary navigation">
          <a href="#about">
            <span class="pi-nav-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 12a4 4 0 1 0-4-4a4 4 0 0 0 4 4Zm0 2c-4.42 0-8 2-8 4.5V21h16v-2.5C20 16 16.42 14 12 14Z"/></svg>
            </span>
            About
          </a>

          <a href="#skills">
            <span class="pi-nav-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path fill="currentColor" d="M3 17l6-6 4 4 7-7 1.5 1.5-8.5 8.5-4-4-5 5L3 17Z"/></svg>
            </span>
            Skills
          </a>

          <a href="#work">
            <span class="pi-nav-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path fill="currentColor" d="M10 4h4a2 2 0 0 1 2 2v2h4a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h4V6a2 2 0 0 1 2-2Zm0 4h4V6h-4v2Z"/></svg>
            </span>
            Experience
          </a>

          <a href="#projects">
            <span class="pi-nav-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path fill="currentColor" d="M4 5h7v7H4V5Zm9 0h7v4h-7V5ZM4 14h7v5H4v-5Zm9-3h7v8h-7v-8Z"/></svg>
            </span>
            Projects
          </a>

          <a href="#education" class="pi-hide-sm">
            <span class="pi-nav-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 3l10 6-10 6L2 9l10-6Zm0 13l6.5-3.9V17L12 21l-6.5-4v-4.9L12 16Z"/></svg>
            </span>
            Education
          </a>
        </nav>

      </div>
    </div>
  </header>

  <main id="top" class="pi-container pi-main">

    <section class="pi-hero">
      <div class="pi-hero-grid">

        <div class="pi-hero-left">
          <div class="pi-chipline">
            <span class="pi-chip">Open to work</span>
            <span class="pi-chip">Remote / Hybrid</span>
            <span class="pi-chip">Fast learner</span>
          </div>

          <h1 class="pi-h1">
            Building products with <span class="pi-accent">clarity</span>, speed,
            and strong UI.
          </h1>

          <p class="pi-lead">
            {{ $portfolio->short_bio ?? 'Minimal. Modern. Agency-grade layout with motion and depth.' }}
          </p>

          <div class="pi-cta">
            @if($portfolio->linkedin_url)
              <a class="pi-btn pi-btn-primary pi-btn-lg" href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener">
                <span class="pi-ico">
                  <svg viewBox="0 0 24 24"><path fill="currentColor" d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29ZM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>
                </span>
                LinkedIn
              </a>
            @endif

            @if($portfolio->github_url)
              <a class="pi-btn pi-btn-ghost pi-btn-lg" href="{{ $portfolio->github_url }}" target="_blank" rel="noopener">
                <span class="pi-ico">
                  <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 .5C5.73.5.75 5.74.75 12.23c0 5.2 3.44 9.6 8.2 11.16.6.12.82-.27.82-.6v-2.2c-3.34.74-4.04-1.66-4.04-1.66-.55-1.43-1.35-1.8-1.35-1.8-1.1-.77.08-.75.08-.75 1.22.09 1.86 1.28 1.86 1.28 1.08 1.9 2.83 1.35 3.52 1.03.11-.8.42-1.35.76-1.66-2.67-.31-5.48-1.38-5.48-6.13 0-1.35.46-2.45 1.22-3.31-.12-.31-.53-1.57.12-3.27 0 0 1-.33 3.3 1.26.96-.27 1.98-.4 3-.4s2.05.14 3 .4c2.3-1.59 3.3-1.26 3.3-1.26.65 1.7.24 2.96.12 3.27.76.86 1.22 1.96 1.22 3.31 0 4.76-2.82 5.82-5.5 6.13.43.38.82 1.13.82 2.28v3.38c0 .33.22.73.83.6 4.76-1.56 8.2-5.96 8.2-11.16C23.25 5.74 18.27.5 12 .5Z"/></svg>
                </span>
                GitHub
              </a>
            @endif
          </div>

          <div class="pi-metrics">
            <div class="pi-metric">
              <div class="pi-metric-k">Projects</div>
              <div class="pi-metric-v">{{ $portfolio->projects->count() }}</div>
            </div>
            <div class="pi-metric">
              <div class="pi-metric-k">Skills</div>
              <div class="pi-metric-v">{{ $portfolio->skills->count() }}</div>
            </div>
            <div class="pi-metric">
              <div class="pi-metric-k">Experience</div>
              <div class="pi-metric-v">{{ $portfolio->experiences->count() }}</div>
            </div>
          </div>
        </div>

        {{-- ✅ FIXED HERO RIGHT (your divs were broken) --}}
        <div class="pi-hero-right" aria-hidden="true">
          <div class="pi-iso">
            <div class="pi-iso-plane">
              <div class="pi-iso-tile t1"></div>
              <div class="pi-iso-tile t2"></div>
              <div class="pi-iso-tile t3"></div>
              <div class="pi-iso-tile t4"></div>
              <div class="pi-iso-tile t5"></div>
              <div class="pi-iso-tile t6"></div>
            </div>
          </div>

          <div class="pi-profile pi-profile-name-only">
            <div class="pi-big-name">{{ $portfolio->full_name }}</div>
            <div class="pi-big-role">{{ $portfolio->job_title ?? 'Professional' }}</div>
          </div>
        </div>

      </div>
    </section>

    <section id="about" class="pi-section">
      <div class="pi-head">
        <h2 class="pi-h2">About</h2>
        <div class="pi-headline">A short intro</div>
      </div>
      <div class="pi-surface">
        <p class="pi-p">{{ $portfolio->short_bio ?? 'Tell your story here.' }}</p>
      </div>
    </section>

    <section id="skills" class="pi-section">
      <div class="pi-head">
        <h2 class="pi-h2">Skills</h2>
        <div class="pi-headline">Tools & strengths</div>
      </div>

      @if($portfolio->skills->count() === 0)
        <div class="pi-empty">No skills added yet.</div>
      @else
        <div class="pi-grid2">
          @foreach($portfolio->skills as $s)
            <div class="pi-skill">
              <div class="pi-skill-top">
                <div class="pi-skill-name">{{ $s->name }}</div>
                <div class="pi-skill-val">{{ (int)$s->level }}%</div>
              </div>
              <div class="pi-bar">
                <div class="pi-bar-fill" style="width: {{ (int)$s->level }}%;"></div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>

    <section id="work" class="pi-section">
      <div class="pi-head">
        <h2 class="pi-h2">Experience</h2>
        <div class="pi-headline">Timeline</div>
      </div>

      @if($portfolio->experiences->count() === 0)
        <div class="pi-empty">No experience added yet.</div>
      @else
        <div class="pi-grid2">
          @foreach($portfolio->experiences as $x)
            <article class="pi-card">
              <div class="pi-card-top">
                <div class="pi-card-title">{{ $x->role }}</div>
                <div class="pi-card-sub">{{ $x->company_name }}</div>
              </div>
              <div class="pi-card-meta">{{ $x->start_date ?? '-' }} → {{ $x->end_date ?? 'Present' }}</div>
              @if($x->description)
                <p class="pi-p pi-muted">{{ $x->description }}</p>
              @endif
            </article>
          @endforeach
        </div>
      @endif
    </section>

    <section id="projects" class="pi-section">
      <div class="pi-head">
        <h2 class="pi-h2">Projects</h2>
        <div class="pi-headline">Selected work</div>
      </div>

      @if($portfolio->projects->count() === 0)
        <div class="pi-empty">No projects added yet.</div>
      @else
        <div class="pi-grid2 pi-projects-grid">
          @foreach($portfolio->projects as $p)
            @php
              $img = null;
              if (!empty($p->image_path)) {
                if (preg_match('/^https?:\/\//i', $p->image_path)) $img = $p->image_path;
                elseif (str_starts_with($p->image_path, 'storage/')) $img = asset($p->image_path);
                else $img = \Illuminate\Support\Facades\Storage::url($p->image_path);
              }
            @endphp

            <article class="pi-card pi-project">
              <div class="pi-project-top">
                <div class="pi-project-title">{{ $p->title }}</div>
                @if($p->tech_stack)
                  <div class="pi-project-tech">{{ $p->tech_stack }}</div>
                @endif
              </div>

              <div class="pi-project-body">
                <p class="pi-project-desc">{{ $p->description }}</p>

                @if($img)
                  <div class="pi-project-media">
                    <img class="pi-img" src="{{ $img }}" alt="{{ $p->title }} image" loading="lazy" decoding="async">
                  </div>
                @endif
              </div>

              <div class="pi-links pi-project-links">
                @if($p->live_url)
                  <a class="pi-link pi-link-primary" href="{{ $p->live_url }}" target="_blank" rel="noopener">Live</a>
                @endif
                @if($p->github_url)
                  <a class="pi-link" href="{{ $p->github_url }}" target="_blank" rel="noopener">GitHub</a>
                @endif
              </div>
            </article>
          @endforeach
        </div>
      @endif
    </section>

    <section id="education" class="pi-section">
      <div class="pi-head">
        <h2 class="pi-h2">Education</h2>
        <div class="pi-headline">Background</div>
      </div>

      @if($portfolio->educations->count() === 0)
        <div class="pi-empty">No education added yet.</div>
      @else
        <div class="pi-grid2">
          @foreach($portfolio->educations as $e)
            <article class="pi-card">
              <div class="pi-card-title">{{ $e->degree }}</div>
              <div class="pi-card-meta">{{ $e->institution_name }}</div>
              <p class="pi-p pi-muted">{{ $e->start_date }} → {{ $e->end_date ?? 'Present' }}</p>
            </article>
          @endforeach
        </div>
      @endif
    </section>

    <footer class="pi-footer">
      <div class="pi-footer-top">
        <div class="pi-footer-brand">
          <span class="pi-brand-badge" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2l9 6-9 14L3 8l9-6z"/></svg>
          </span>
          <div>
            <div class="pi-footer-name">{{ $portfolio->full_name }}</div>
            <div class="pi-footer-sub">{{ $portfolio->job_title ?? 'Portfolio' }}</div>
          </div>
        </div>

        <div class="pi-footer-stats">
          <div class="pi-stat">
            <div class="pi-stat-v">{{ $portfolio->projects->count() }}</div>
            <div class="pi-stat-k">Projects</div>
          </div>
          <div class="pi-stat">
            <div class="pi-stat-v">{{ $portfolio->skills->count() }}</div>
            <div class="pi-stat-k">Skills</div>
          </div>
          <div class="pi-stat">
            <div class="pi-stat-v">{{ $portfolio->experiences->count() }}</div>
            <div class="pi-stat-k">Roles</div>
          </div>
        </div>
      </div>

      <div class="pi-footer-grid">
        <div class="pi-footer-col">
          <div class="pi-footer-h">Pages</div>
          <div class="pi-footer-links">
            <a href="#about">About</a>
            <a href="#skills">Skills</a>
            <a href="#work">Experience</a>
            <a href="#projects">Projects</a>
            <a href="#education">Education</a>
          </div>
        </div>

        <div class="pi-footer-col">
          <div class="pi-footer-h">Connect</div>
          <div class="pi-footer-muted">
            @if($portfolio->email)
              <div>✉️ {{ $portfolio->email }}</div>
            @endif
            @if($portfolio->location)
              <div>📍 {{ $portfolio->location }}</div>
            @endif
          </div>

          <div class="pi-footer-social">
            @if($portfolio->github_url)
              <a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener">GitHub</a>
            @endif
            @if($portfolio->linkedin_url)
              <a href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>
            @endif
            @if($portfolio->twitter_url)
              <a href="{{ $portfolio->twitter_url }}" target="_blank" rel="noopener">Twitter/X</a>
            @endif
          </div>
        </div>

        <div class="pi-footer-col">
          <div class="pi-footer-h">Newsletter</div>
          <div class="pi-footer-muted">Get occasional updates about my newest work.</div>
          <form class="pi-news" onsubmit="return false;">
            <input class="pi-news-input" type="email" placeholder="Email address" aria-label="Email address">
            <button class="pi-news-btn" type="submit">Subscribe</button>
          </form>
          <div class="pi-footer-tiny">Unsubscribe anytime.</div>
        </div>
      </div>

      <div class="pi-footer-bottom">
        <div>© {{ date('Y') }} {{ $portfolio->full_name }} • Built with PortfolioGen</div>
      </div>
    </footer>

  </main>
</body>
</html>