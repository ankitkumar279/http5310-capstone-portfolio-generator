@extends('layouts.dashboard')

@section('title','Create Portfolio - Step 2')

@section('content')

<div class="pg-step-wrapper">
  <div class="pg-step-box">

    <div class="pg-step-header">
      <div class="pg-step-title">Education</div>
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
          'step' => 2
        ]) }}">
          @csrf

          <label class="pg-label">Institution Name *</label>
          <input id="eduInstitution" name="institution_name" class="pg-input" value="{{ old('institution_name') }}">
          @error('institution_name')
            <div style="color:#ff6b6b; margin-bottom:12px;">{{ $message }}</div>
          @enderror

          <label class="pg-label">Degree *</label>
          <input id="eduDegree" name="degree" class="pg-input" value="{{ old('degree') }}">
          @error('degree')
            <div style="color:#ff6b6b; margin-bottom:12px;">{{ $message }}</div>
          @enderror

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div>
              <label class="pg-label">Start Date *</label>
              <input type="date" name="start_date" class="pg-input" value="{{ old('start_date') }}">
              @error('start_date')
                <div style="color:#ff6b6b;">{{ $message }}</div>
              @enderror
            </div>

            <div>
              <label class="pg-label">End Date</label>
              <input type="date" name="end_date" class="pg-input" value="{{ old('end_date') }}">
              @error('end_date')
                <div style="color:#ff6b6b;">{{ $message }}</div>
              @enderror
            </div>
          </div>

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
        <div class="pg-edu-head">Your Educations</div>

        @if($portfolio->educations->count() === 0)
          <div class="pg-muted">No education added yet.</div>
        @else
          <div class="pg-edu-list">
            @foreach($portfolio->educations as $e)
              @php $editId = "edu-edit-".$e->id; @endphp

              <div class="pg-edu-item" style="flex-direction:column; align-items:stretch;">

                <div style="display:flex; justify-content:space-between; gap:12px; align-items:flex-start; width:100%;">
                  <div class="pg-edu-content" style="width:100%;">
                    <div class="pg-edu-title">{{ $e->institution_name }}</div>
                    <div class="pg-edu-meta">
                      {{ $e->degree }} • {{ $e->start_date }} → {{ $e->end_date ?? 'Present' }}
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
                          action="{{ route('portfolio.education.delete', [
                            'username' => auth()->user()->username,
                            'portfolio' => $portfolio->id,
                            'education' => $e->id
                          ]) }}"
                          onsubmit="return confirm('Delete this education?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="pg-delete-btn">🗑</button>
                    </form>
                  </div>
                </div>

                <div id="{{ $editId }}"
                     style="display:none; width:100%; margin-top:16px; padding:16px; border-radius:16px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12);">
                  <form method="POST" action="{{ route('portfolio.education.update', [
                    'username' => auth()->user()->username,
                    'portfolio' => $portfolio->id,
                    'education' => $e->id
                  ]) }}">
                    @csrf
                    @method('PUT')

                    <label class="pg-label">Institution Name *</label>
                    <input id="eduInstitutionEdit-{{ $e->id }}" name="institution_name" class="pg-input" value="{{ $e->institution_name }}">

                    <label class="pg-label">Degree *</label>
                    <input id="eduDegreeEdit-{{ $e->id }}" name="degree" class="pg-input" value="{{ $e->degree }}">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                      <div>
                        <label class="pg-label">Start Date</label>
                        <input type="date" name="start_date" class="pg-input" value="{{ $e->start_date }}">
                      </div>

                      <div>
                        <label class="pg-label">End Date</label>
                        <input type="date" name="end_date" class="pg-input" value="{{ $e->end_date }}">
                        <div class="pg-muted" style="margin-top:6px;">Leave empty if currently studying.</div>
                      </div>
                    </div>

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
            Minimum 1 required <span class="pg-check">✓</span>
          </div>
        @endif

        <div style="margin-top:25px;">
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 1
          ]) }}" class="pg-btn-secondary">
            ← Previous
          </a>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
  function toggleInlineEdit(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
  }

  pgBindAiAutocomplete({
    inputId: "eduInstitution",
    type: "education",
    contextBuilder: () => ({ job_title: @json($portfolio->job_title) }),
    onPick: (val) => {
      const parts = String(val).split("—").map(s => s.trim());
      if (parts[0]) document.getElementById("eduInstitution").value = parts[0];
      if (parts[1]) document.getElementById("eduDegree").value = parts[1];
    }
  });

  pgBindAiAutocomplete({
    inputId: "eduDegree",
    type: "degree",
    contextBuilder: () => ({ job_title: @json($portfolio->job_title) })
  });
</script>

@endsection