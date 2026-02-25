@extends('layouts.dashboard')

@section('title','Create Portfolio - Step 6')

@section('content')

<div class="pg-step-wrapper">
  <div class="pg-step-box">

    <div class="pg-step-header">
      <div class="pg-step-title">Review Your Information</div>
      <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="pg-exit">Exit</a>
    </div>

    @php
      $labels = [
        1 => 'Personal',
        2 => 'Education',
        3 => 'Experience',
        4 => 'Skills',
        5 => 'Projects',
        6 => 'Review',
      ];
    @endphp

    <div class="pg-steps">
      @for($i=1; $i<=6; $i++)
        @if($i <= $maxStep)
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => $i
          ]) }}"
             class="pg-step-pill {{ $i == $step ? 'active' : '' }}">
            {{ $i }}. {{ $labels[$i] }}
          </a>
        @else
          <span class="pg-step-pill disabled">
            {{ $i }}. {{ $labels[$i] }}
          </span>
        @endif
      @endfor
    </div>

    @if(session('error'))
      <div class="pg-card" style="margin-bottom:20px; color:#ff6b6b;">
        {{ session('error') }}
      </div>
    @endif

    @if(session('success'))
      <div id="pgToast" class="pg-toast pg-toast-success">
        {{ session('success') }}
      </div>

      <script>
        (function(){
          const t = document.getElementById('pgToast');
          if(!t) return;
          setTimeout(() => {
            t.style.opacity = '0';
            t.style.transform = 'translateY(-8px)';
            t.style.transition = 'all .25s ease';
            setTimeout(() => t.remove(), 260);
          }, 2000);
        })();
      </script>
    @endif

    <div class="pg-muted" style="margin:-6px 0 18px 0;">
      Step 6: Confirm everything, then generate.
    </div>

    <div style="display:grid; grid-template-columns:1.35fr .65fr; gap:26px;">
      <div class="pg-card">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
          <div class="pg-edu-head" style="margin:0;">Personal</div>
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 1
          ]) }}" class="pg-btn-secondary" style="padding:8px 14px; border-radius:14px;">
            Edit
          </a>
        </div>

        <div class="pg-edu-list" style="gap:10px;">
          <div class="pg-edu-item" style="align-items:flex-start;">
            <div class="pg-edu-content" style="gap:6px;">
              <div class="pg-edu-title">{{ $portfolio->full_name ?: '—' }}</div>
              <div class="pg-edu-meta">{{ $portfolio->job_title ?: '—' }} • {{ $portfolio->location ?: '—' }}</div>
              @if($portfolio->short_bio)
                <div class="pg-muted" style="margin-top:8px; line-height:1.55;">
                  {{ $portfolio->short_bio }}
                </div>
              @endif
            </div>
          </div>
        </div>

        <div style="height:18px;"></div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
          <div class="pg-edu-head" style="margin:0;">Education</div>
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 2
          ]) }}" class="pg-btn-secondary" style="padding:8px 14px; border-radius:14px;">
            Edit
          </a>
        </div>

        @if($portfolio->educations->count() === 0)
          <div class="pg-muted">No education added.</div>
        @else
          <div class="pg-edu-list">
            @foreach($portfolio->educations as $e)
              <div class="pg-edu-item" style="align-items:flex-start;">
                <div class="pg-edu-content">
                  <div class="pg-edu-title">{{ $e->degree }} — {{ $e->institution_name }}</div>
                  <div class="pg-edu-meta">
                    {{ $e->start_date ?? '-' }} → {{ $e->end_date ?? 'Present' }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <div style="height:18px;"></div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
          <div class="pg-edu-head" style="margin:0;">Experience</div>
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 3
          ]) }}" class="pg-btn-secondary" style="padding:8px 14px; border-radius:14px;">
            Edit
          </a>
        </div>

        @if($portfolio->experiences->count() === 0)
          <div class="pg-muted">No experience added.</div>
        @else
          <div class="pg-edu-list">
            @foreach($portfolio->experiences as $x)
              <div class="pg-edu-item" style="align-items:flex-start;">
                <div class="pg-edu-content">
                  <div class="pg-edu-title">{{ $x->role }} — {{ $x->company_name }}</div>
                  <div class="pg-edu-meta">
                    {{ $x->start_date ?? '-' }} → {{ $x->end_date ?? 'Present' }}
                  </div>
                  @if($x->description)
                    <div class="pg-muted" style="margin-top:8px; line-height:1.55;">
                      {{ $x->description }}
                    </div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <div style="height:18px;"></div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
          <div class="pg-edu-head" style="margin:0;">Skills</div>
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 4
          ]) }}" class="pg-btn-secondary" style="padding:8px 14px; border-radius:14px;">
            Edit
          </a>
        </div>

        @if($portfolio->skills->count() === 0)
          <div class="pg-muted">No skills added.</div>
        @else
          <div class="pg-edu-list">
            @foreach($portfolio->skills as $s)
              <div class="pg-edu-item" style="align-items:flex-start;">
                <div class="pg-edu-content" style="width:100%;">
                  <div class="pg-edu-title">{{ $s->name }}</div>
                  <div class="pg-edu-meta">{{ $s->level }}%</div>
                  <div class="pg-progress" role="progressbar"
                       aria-valuenow="{{ $s->level }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="pg-progress-bar" style="width: {{ $s->level }}%"></div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <div style="height:18px;"></div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
          <div class="pg-edu-head" style="margin:0;">Projects</div>
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 5
          ]) }}" class="pg-btn-secondary" style="padding:8px 14px; border-radius:14px;">
            Edit
          </a>
        </div>

        @if($portfolio->projects->count() === 0)
          <div class="pg-muted">No projects added.</div>
        @else
          <div class="pg-edu-list">
            @foreach($portfolio->projects as $p)
              <div class="pg-edu-item" style="align-items:flex-start;">
                <div class="pg-edu-content" style="width:100%;">
                  <div class="pg-edu-title">{{ $p->title }}</div>
                  @if($p->description)
                    <div class="pg-muted" style="margin-top:8px; line-height:1.55;">
                      {{ $p->description }}
                    </div>
                  @endif

                  <div style="display:flex; gap:10px; margin-top:10px; flex-wrap:wrap;">
                    @if($p->live_url)
                      <a href="{{ $p->live_url }}" target="_blank"
                         class="pg-btn-secondary" style="padding:8px 14px; border-radius:14px;">
                        Live
                      </a>
                    @endif

                    @if($p->github_url)
                      <a href="{{ $p->github_url }}" target="_blank"
                         class="pg-btn-secondary" style="padding:8px 14px; border-radius:14px;">
                        GitHub
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

      </div>

      <div class="pg-card" style="height:fit-content;">
        <div class="pg-edu-head">Ready to generate?</div>
        <div class="pg-muted" style="line-height:1.55;">
          Make sure everything looks correct. You can edit any section using the buttons.
        </div>

        <div style="margin-top:18px;">
          <div class="pg-edu-min" style="margin-top:0;">
            <span class="pg-check">✓</span> Review completed
          </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:12px; margin-top:18px;">
          <a class="pg-btn-secondary" href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 5
          ]) }}">
            ← Previous
          </a>

          <form method="POST" action="{{ route('portfolio.step.save', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 6
          ]) }}">
            @csrf
            <button class="pg-submit" style="width:100%;">Generate Portfolio</button>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection