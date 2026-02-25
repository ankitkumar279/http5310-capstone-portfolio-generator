@extends('layouts.dashboard')

@section('title','Create Portfolio - Step 4')

@section('content')

<div class="pg-step-wrapper">
  <div class="pg-step-box">

    <div class="pg-step-header">
      <div class="pg-step-title">Skills</div>
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

    <div class="pg-form-grid">

      <div class="pg-card">
        <form method="POST" action="{{ route('portfolio.step.save', [
          'username' => auth()->user()->username,
          'portfolio' => $portfolio->id,
          'step' => 4
        ]) }}" id="skillForm">
          @csrf

          <label class="pg-label">Skill Name *</label>
          <input id="skillName" name="name" class="pg-input"
                 value="{{ old('name') }}"
                 placeholder="e.g., Laravel, React, SQL">
          @error('name')
            <div style="color:#ff6b6b; margin-bottom:12px;">{{ $message }}</div>
          @enderror

          <label class="pg-label">Level (0–100) *</label>
          <input
            type="range"
            min="0"
            max="100"
            value="{{ old('level', 70) }}"
            class="pg-range"
            id="levelRange"
            name="level"
          >
          <div class="pg-muted" style="margin-top:10px;">
            Selected: <span id="levelText">{{ old('level', 70) }}</span>%
          </div>

          @error('level')
            <div style="color:#ff6b6b; margin-top:10px;">{{ $message }}</div>
          @enderror

          <div style="display:flex; gap:12px; margin-top:20px;">
            <button name="action" value="add"
                    class="pg-submit"
                    style="flex:1; background:transparent; border:1px solid rgba(255,255,255,.2);">
              + Add
            </button>

            <button name="action" value="next" class="pg-submit" style="flex:1;">
              Next
            </button>
          </div>

        </form>
      </div>

      <div class="pg-card">

        <div class="pg-edu-head">Your Skills</div>

        @if($portfolio->skills->count() === 0)
          <div class="pg-muted">No skills added yet. Minimum 1 required.</div>
        @else
          <div class="pg-edu-list">
            @foreach($portfolio->skills as $s)
              @php $editId = "skill-edit-".$s->id; @endphp

              <div class="pg-edu-item" style="flex-direction:column; align-items:stretch;">

                <div style="display:flex; justify-content:space-between; gap:12px; align-items:flex-start; width:100%;">
                  <div class="pg-edu-content" style="width:100%;">
                    <div class="pg-edu-title">{{ $s->name }}</div>
                    <div class="pg-edu-meta">{{ $s->level }}%</div>

                    <div class="pg-progress" role="progressbar"
                         aria-valuenow="{{ $s->level }}" aria-valuemin="0" aria-valuemax="100">
                      <div class="pg-progress-bar" style="width: {{ $s->level }}%"></div>
                    </div>
                  </div>

                  <div style="display:flex; gap:10px; flex-shrink:0;">
                    <button type="button"
                            class="pg-btn-secondary"
                            style="padding:8px 14px; border-radius:14px;"
                            onclick="toggleInlineEdit('{{ $editId }}')">
                      Edit
                    </button>

                    <form method="POST"
                          action="{{ route('portfolio.skill.delete', [
                            'username' => auth()->user()->username,
                            'portfolio' => $portfolio->id,
                            'skill' => $s->id
                          ]) }}"
                          onsubmit="return confirm('Delete this skill?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="pg-delete-btn">🗑</button>
                    </form>
                  </div>
                </div>

                <div id="{{ $editId }}"
                     style="display:none; width:100%; margin-top:16px; padding:16px; border-radius:16px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12);">
                  <form method="POST" action="{{ route('portfolio.skill.update', [
                    'username' => auth()->user()->username,
                    'portfolio' => $portfolio->id,
                    'skill' => $s->id
                  ]) }}">
                    @csrf
                    @method('PUT')

                    <label class="pg-label">Skill Name *</label>
                    <input name="name" class="pg-input" value="{{ $s->name }}">

                    <label class="pg-label">Level (0–100) *</label>
                    <input type="range"
                           min="0"
                           max="100"
                           value="{{ $s->level }}"
                           class="pg-range pg-skill-edit-range"
                           name="level"
                           oninput="this.nextElementSibling.querySelector('span').textContent=this.value; this.style.setProperty('--pct', this.value + '%');">
                    <div class="pg-muted" style="margin-top:10px;">
                      Selected: <span>{{ $s->level }}</span>%
                    </div>

                    <script>
                      (function(){
                        const el = document.querySelector('#{{ $editId }} .pg-skill-edit-range');
                        if(!el) return;
                        el.style.setProperty('--pct', el.value + '%');
                      })();
                    </script>

                    <div style="display:flex; gap:12px; margin-top:12px;">
                      <button class="pg-submit" style="flex:1;">Save</button>

                      <button type="button"
                              class="pg-submit"
                              style="flex:1; background:transparent; border:1px solid rgba(255,255,255,.2);"
                              onclick="toggleInlineEdit('{{ $editId }}')">
                        Cancel
                      </button>
                    </div>
                  </form>
                </div>

              </div>
            @endforeach
          </div>

          <div class="pg-edu-min">
            <span class="pg-check">✓</span> Minimum 1 required
          </div>
        @endif

        <div style="margin-top:25px;">
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 3
          ]) }}" class="pg-btn-secondary">
            ← Previous
          </a>
        </div>

      </div>

    </div>

  </div>
</div>

<script>
  const r = document.getElementById('levelRange');
  const t = document.getElementById('levelText');

  function setFill(val){
    if (!r) return;
    r.style.setProperty('--pct', `${val}%`);
  }

  if (r && t) {
    t.textContent = r.value;
    setFill(r.value);
    r.addEventListener('input', () => {
      t.textContent = r.value;
      setFill(r.value);
    });
  }
</script>

<script>
  (function () {
    const form = document.getElementById('skillForm');
    if (!form) return;

    let timer = null;

    function autosave() {
      const url = form.getAttribute('action') + '?autosave=1';
      const fd = new FormData(form);

      fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
        body: fd
      }).catch(() => {});
    }

    form.addEventListener('input', function () {
      clearTimeout(timer);
      timer = setTimeout(autosave, 800);
    });
  })();
</script>

<script>
  function toggleInlineEdit(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
  }

  pgBindAiAutocomplete({
    inputId: "skillName",
    type: "skills",
    contextBuilder: () => ({ job_title: @json($portfolio->job_title) }),
    onPick: (val) => {
      const first = String(val).split(",")[0]?.trim();
      document.getElementById("skillName").value = first || val;
    }
  });
</script>

@endsection