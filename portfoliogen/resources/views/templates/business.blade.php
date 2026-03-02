<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $portfolio->full_name }} — Business Portfolio</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/portfolio-business.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body class="biz-body" id="top">
  @php
    $username = request()->route('username')
      ?? ($portfolio->user->username ?? null)
      ?? (auth()->user()->username ?? auth()->user()->name ?? null);
  @endphp

  {{-- Published link bar (only if published or session has it) --}}
  @php
    $publicUrl = null;
    if (!empty($portfolio->public_id)) {
      $publicUrl = route('portfolio.public.view', [
        'username'  => $username,
        'public_id' => $portfolio->public_id
      ]);
    }
  @endphp

  @if(auth()->check() && auth()->id() === $portfolio->user_id && (session('public_url') || $portfolio->isPublished()))
    <div class="container pt-2">
      <div class="pg-pubbar">
        <div class="pg-pubbar-left">
          <div class="pg-pubbar-title">  Published Link — Management options are visible only to the owner</div>
          <a id="pgPublicLink" class="pg-pubbar-link"
             href="{{ session('public_url') ?? $publicUrl }}"
             target="_blank" rel="noopener">
            {{ session('public_url') ?? $publicUrl }}
          </a>
        </div>

        <div class="pg-pubbar-actions">
          <button type="button" class="pg-pubbar-btn" onclick="pgCopyPublicLink()">
            Copy
          </button>

          <a class="pg-pubbar-btn pg-pubbar-btn-primary"
             href="{{ session('public_url') ?? $publicUrl }}"
             target="_blank" rel="noopener">
            Open
          </a>
        </div>
      </div>
    </div>
  @endif

  @if(auth()->check() && auth()->id() === $portfolio->user_id)
    <div class="container py-3 d-flex justify-content-end gap-2 flex-wrap">

      <a href="{{ route('portfolio.step', [
          'username'  => $username,
          'portfolio' => $portfolio->id,
          'step'      => 6
      ]) }}" class="btn btn-outline-dark">Edit</a>

      <a href="{{ route('portfolio.template.edit', [
          'username'  => $username,
          'portfolio' => $portfolio->id
      ]) }}" class="btn btn-outline-primary">Change Template</a>

      {{-- Publish button (only when NOT published) --}}
      @if(!$portfolio->isPublished())
        <form method="POST" action="{{ route('portfolio.publish', [
            'username'  => $username,
            'portfolio' => $portfolio->id
        ]) }}">
          @csrf
          @method('PATCH')
          <button class="btn btn-primary">Publish</button>
        </form>
      @endif

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

  <header class="biz-header">
    <div class="container">
      <div class="biz-topbar">
        <a class="biz-brand" href="#top">
          <span class="biz-mark"></span>
          <span class="biz-name">{{ $portfolio->full_name }}</span>
        </a>

        <nav class="biz-nav d-none d-md-flex">
          <a href="#profile">Profile</a>
          <a href="#skills">Skills</a>
          <a href="#education">Education</a>
          @if($portfolio->experiences->count() > 0)<a href="#experience">Experience</a>@endif
          @if($portfolio->projects->count() > 0)<a href="#projects">Projects</a>@endif
          <a href="#contact">Contact</a>
        </nav>

        <a class="biz-cta" href="#projects">Portfolio</a>
      </div>
    </div>
  </header>

  <section class="biz-hero">
    <div class="container">
      <div class="biz-hero-card">
        <div class="row g-4 align-items-center">
          <div class="col-lg-8">
            <div class="biz-kicker">Business Portfolio</div>
            <h1 class="biz-h1">{{ $portfolio->full_name }}</h1>
            <div class="biz-subhead">
              <span class="biz-role">{{ $portfolio->job_title }}</span>
              <span class="biz-dot">•</span>
              <span class="biz-loc">{{ $portfolio->location }}</span>
            </div>

            <p class="biz-bio" id="profile">{{ $portfolio->short_bio }}</p>

            <div class="biz-actions">
              <a class="biz-btn biz-btn-primary" href="#contact">Get in touch</a>
              @if($portfolio->linkedin_url)
                <a class="biz-btn biz-btn-ghost" href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>
              @endif
              @if($portfolio->github_url)
                <a class="biz-btn biz-btn-ghost" href="{{ $portfolio->github_url }}" target="_blank" rel="noopener">GitHub</a>
              @endif
              @if($portfolio->twitter_url)
                <a class="biz-btn biz-btn-ghost" href="{{ $portfolio->twitter_url }}" target="_blank" rel="noopener">Twitter/X</a>
              @endif
            </div>
          </div>

          <div class="col-lg-4">
            <div class="biz-metrics">
              <div class="biz-metric">
                <div class="biz-metric-k">Primary Focus</div>
                <div class="biz-metric-v">Strategy • Execution • Delivery</div>
              </div>
              <div class="biz-metric">
                <div class="biz-metric-k">Availability</div>
                <div class="biz-metric-v">Open to opportunities</div>
              </div>
              <div class="biz-metric">
                <div class="biz-metric-k">Location</div>
                <div class="biz-metric-v">{{ $portfolio->location }}</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  {{-- MAIN GRID --}}
  <section class="biz-section">
    <div class="container">
      <div class="row g-4">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-5">

          {{-- CONTACT --}}
          <div class="biz-panel" id="contact">
            <div class="biz-panel-head">
              <h3 class="biz-h3">Contact</h3>
              <div class="biz-mini">Professional links</div>
            </div>

            <div class="biz-links">
              @if($portfolio->linkedin_url)
                <a class="biz-link" href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener">
                  <span>LinkedIn</span><span class="biz-arrow">→</span>
                </a>
              @endif
              @if($portfolio->github_url)
                <a class="biz-link" href="{{ $portfolio->github_url }}" target="_blank" rel="noopener">
                  <span>GitHub</span><span class="biz-arrow">→</span>
                </a>
              @endif
              @if($portfolio->twitter_url)
                <a class="biz-link" href="{{ $portfolio->twitter_url }}" target="_blank" rel="noopener">
                  <span>Twitter/X</span><span class="biz-arrow">→</span>
                </a>
              @endif

              @if(!$portfolio->linkedin_url && !$portfolio->github_url && !$portfolio->twitter_url)
                <div class="biz-empty">No links added yet.</div>
              @endif
            </div>
          </div>

          {{-- SKILLS --}}
          <div class="biz-panel mt-4" id="skills">
            <div class="biz-panel-head">
              <h3 class="biz-h3">Skills</h3>
              <div class="biz-mini">Capability overview</div>
            </div>

            @foreach($portfolio->skills as $s)
              <div class="biz-skill">
                <div class="biz-skill-top">
                  <div class="biz-skill-name">{{ $s->name }}</div>
                  <div class="biz-skill-val">{{ $s->level }}%</div>
                </div>
                <div class="biz-skill-bar">
                  <div class="biz-skill-fill" style="width: {{ (int)$s->level }}%"></div>
                </div>
              </div>
            @endforeach
          </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-7">

          {{-- EDUCATION --}}
          <div class="biz-panel" id="education">
            <div class="biz-panel-head">
              <h3 class="biz-h3">Education</h3>
              <div class="biz-mini">Academic background</div>
            </div>

            <div class="biz-list">
              @foreach($portfolio->educations as $e)
                <div class="biz-item">
                  <div class="biz-item-top">
                    <div class="biz-item-title">{{ $e->degree }}</div>
                    <div class="biz-item-date">{{ $e->start_date }} → {{ $e->end_date ?? 'Present' }}</div>
                  </div>
                  <div class="biz-item-sub">{{ $e->institution_name }}</div>
                </div>
              @endforeach
            </div>
          </div>

          {{-- EXPERIENCE --}}
          @if($portfolio->experiences->count() > 0)
            <div class="biz-panel mt-4" id="experience">
              <div class="biz-panel-head">
                <h3 class="biz-h3">Experience</h3>
                <div class="biz-mini">Roles & responsibilities</div>
              </div>

              <div class="biz-list">
                @foreach($portfolio->experiences as $x)
                  <div class="biz-item">
                    <div class="biz-item-top">
                      <div class="biz-item-title">{{ $x->role }}</div>
                      <div class="biz-item-tag">{{ $x->company_name }}</div>
                    </div>
                    @if($x->description)
                      <div class="biz-item-desc">{{ $x->description }}</div>
                    @endif
                  </div>
                @endforeach
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </section>

 {{-- PROJECTS (FULL WIDTH) --}}
@if($portfolio->projects->count() > 0)
  <section class="biz-section biz-projects-section" id="projects">
    <div class="container">
      <div class="biz-panel biz-panel-wide">
        <div class="biz-panel-head">
          <h3 class="biz-h3">Projects</h3>
          <div class="biz-mini">Selected work & outcomes</div>
        </div>

        <div class="biz-projects-grid">
   @foreach($portfolio->projects as $p)
 @php
  $img = null;

  if (!empty($p->image_path)) {
    // external URL stays as-is
    if (preg_match('/^https?:\/\//i', $p->image_path)) {
      $img = $p->image_path;
    } else {
      // ✅ relative URL = same origin always
      $img = '/storage/' . ltrim($p->image_path, '/');
    }
  }
@endphp
            <article class="biz-project-card">
              <div class="biz-project-media">
                @if($img)
                  <img src="{{ $img }}" alt="{{ $p->title }}" loading="lazy" decoding="async">
                @else
                  <div class="biz-project-placeholder">
                    <div class="biz-ph-line w80"></div>
                    <div class="biz-ph-line w60"></div>
                    <div class="biz-ph-line w90"></div>
                  </div>
                @endif
              </div>

              <div class="biz-project-body">
                <div class="biz-project-title">{{ $p->title }}</div>

                {{-- Short first, full on hover (CSS handles clamp/expand) --}}
                <div class="biz-project-desc biz-clamp">
                  {{ $p->description }}
                </div>

                {{-- Clean links (optional) --}}
                @if($p->live_url || $p->github_url)
                  <div class="biz-project-links">
                    @if($p->live_url)
                      <a class="biz-project-link" href="{{ $p->live_url }}" target="_blank" rel="noopener">
                        🔗 Live
                      </a>
                    @endif

                    @if($p->github_url)
                      <a class="biz-project-link" href="{{ $p->github_url }}" target="_blank" rel="noopener">
                        💻 GitHub
                      </a>
                    @endif
                  </div>
                @endif

                {{-- Buttons (keep) --}}
                <div class="biz-project-actions">
                  @if($p->live_url)
                    <a class="biz-pill biz-pill-primary" href="{{ $p->live_url }}" target="_blank" rel="noopener">Live</a>
                  @endif
                  @if($p->github_url)
                    <a class="biz-pill biz-pill-ghost" href="{{ $p->github_url }}" target="_blank" rel="noopener">GitHub</a>
                  @endif
                </div>
              </div>
            </article>
          @endforeach
        </div>

      </div>
    </div>
  </section>
@endif

  <footer class="biz-footer-pro">
    <div class="container">
      <div class="biz-footer-grid">
        <div class="biz-footer-brand">
          <div class="biz-footer-name">{{ $portfolio->full_name }}</div>
          <div class="biz-footer-sub">{{ $portfolio->job_title }} • {{ $portfolio->location }}</div>
          <div class="biz-footer-note">Business Theme • Clean • Professional</div>
        </div>

        <div class="biz-footer-links">
          <div class="biz-footer-h">Quick links</div>
          <a href="#profile">Profile</a>
          <a href="#skills">Skills</a>
          <a href="#education">Education</a>
          @if($portfolio->experiences->count() > 0)<a href="#experience">Experience</a>@endif
          @if($portfolio->projects->count() > 0)<a href="#projects">Projects</a>@endif
          <a href="#contact">Contact</a>
        </div>

        <div class="biz-footer-links">
          <div class="biz-footer-h">Social</div>
          @if($portfolio->linkedin_url)<a href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>@endif
          @if($portfolio->github_url)<a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener">GitHub</a>@endif
          @if($portfolio->twitter_url)<a href="{{ $portfolio->twitter_url }}" target="_blank" rel="noopener">Twitter/X</a>@endif
          @if(!$portfolio->linkedin_url && !$portfolio->github_url && !$portfolio->twitter_url)
            <div class="biz-footer-muted">No social links added.</div>
          @endif
        </div>
      </div>

      <div class="biz-footer-bottom">
        <div>© {{ date('Y') }} {{ $portfolio->full_name }}</div>
        <a class="biz-footer-top" href="#top">Back to top ↑</a>
      </div>
    </div>
  </footer>

  <script>
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

    function pgCopyPublicLink(){
      const el = document.getElementById('pgPublicLink');
      if(!el) return;

      const text = (el.getAttribute('href') || el.textContent || '').trim();
      if(!text) return;

      navigator.clipboard.writeText(text)
        .then(() => {
          const btns = document.querySelectorAll('.pg-pubbar-btn');
          btns.forEach(b => b.classList.add('is-copied'));
          setTimeout(() => btns.forEach(b => b.classList.remove('is-copied')), 900);
        })
        .catch(() => {
          alert('Copy failed. Please copy manually.');
        });
    }
  </script>

</body>
</html>