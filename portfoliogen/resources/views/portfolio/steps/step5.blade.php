@extends('layouts.dashboard')

@section('title','Create Portfolio - Step 5')

@section('content')

<div class="pg-step-wrapper">
  <div class="pg-step-box">

    <div class="pg-step-header">
      <div class="pg-step-title">Projects</div>
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

    <div class="pg-form-grid pg-projects-grid">

      <div class="pg-card">
        <form method="POST"
              action="{{ route('portfolio.step.save', [
                'username' => auth()->user()->username,
                'portfolio' => $portfolio->id,
                'step' => 5
              ]) }}"
              enctype="multipart/form-data">
          @csrf

          <label class="pg-label">Project Title *</label>
          <input id="projTitle" name="title" class="pg-input"
                 value="{{ old('title') }}"
                 placeholder="e.g., PortfolioGen SaaS">
          @error('title')
            <div style="color:#ff6b6b; margin-bottom:12px;">{{ $message }}</div>
          @enderror

          <label class="pg-label">Description *</label>
          <textarea id="projDesc" name="description" class="pg-input" rows="4" style="resize:vertical;"
                    placeholder="What did you build? What tech did you use?">{{ old('description') }}</textarea>
          @error('description')
            <div style="color:#ff6b6b; margin-bottom:12px;">{{ $message }}</div>
          @enderror

          <button type="button"
                  class="pg-btn-secondary"
                  id="aiProjDescBtn"
                  style="padding:8px 14px; border-radius:14px;">
            ✨ Improve Description
          </button>

          <br><br>
          <div id="aiProjDescOut"></div>

          <label class="pg-label">Image (optional)</label>
          <input type="file" name="image" class="pg-input" style="padding:10px 14px;">
          @error('image')
            <div style="color:#ff6b6b; margin-bottom:12px;">{{ $message }}</div>
          @enderror

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div>
              <label class="pg-label">Live URL (optional)</label>
              <input name="live_url" class="pg-input" value="{{ old('live_url') }}" placeholder="https://...">
            </div>

            <div>
              <label class="pg-label">GitHub URL (optional)</label>
              <input name="github_url" class="pg-input" value="{{ old('github_url') }}" placeholder="https://github.com/...">
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

        <div class="pg-edu-head">Your Projects</div>

        @if($portfolio->projects->count() === 0)
          <div class="pg-muted">No projects added. You can continue next.</div>
        @else
          <div class="pg-edu-list">
            @foreach($portfolio->projects as $p)
              @php $editId = "proj-edit-".$p->id; @endphp

              <div class="pg-edu-item" style="flex-direction:column; align-items:stretch;">

                <div style="display:flex; justify-content:space-between; gap:12px; align-items:flex-start; width:100%;">
                  <div class="pg-edu-content" style="width:100%;">
                    <div class="pg-edu-title">{{ $p->title }}</div>

                    
                   @if($p->image_path)
  <div style="margin-top:10px;">
    <img
     src="{{ '/storage/' . ltrim($p->image_path, '/') }}"
      alt="project"
      style="width:100%; max-height:200px; object-fit:cover; border-radius:14px; border:1px solid rgba(255,255,255,.12);"
    >
  </div>
@endif

                    <div class="pg-muted" style="margin-top:10px; line-height:1.5;">
                      {{ $p->description }}
                    </div>

                    <div style="display:flex; gap:10px; margin-top:12px; flex-wrap:wrap;">
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

                  <div style="display:flex; gap:10px; flex-shrink:0;">
                    <button type="button"
                            class="pg-btn-secondary"
                            style="padding:8px 14px; border-radius:14px;"
                            onclick="toggleInlineEdit('{{ $editId }}')">
                      Edit
                    </button>

                    <form method="POST"
                          action="{{ route('portfolio.project.delete', [
                            'username' => auth()->user()->username,
                            'portfolio' => $portfolio->id,
                            'project' => $p->id
                          ]) }}"
                          onsubmit="return confirm('Delete this project?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="pg-delete-btn">🗑</button>
                    </form>
                  </div>
                </div>

                <div id="{{ $editId }}"
                     style="display:none; width:100%; margin-top:16px; padding:16px; border-radius:16px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12);">
                  <form method="POST"
                        action="{{ route('portfolio.project.update', [
                          'username' => auth()->user()->username,
                          'portfolio' => $portfolio->id,
                          'project' => $p->id
                        ]) }}"
                        enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="pg-label">Project Title *</label>
                    <input name="title" class="pg-input" value="{{ $p->title }}">

                    <label class="pg-label">Description *</label>
                    <textarea name="description" class="pg-input" rows="4" style="resize:vertical;">{{ $p->description }}</textarea>

                    <label class="pg-label">Replace Image (optional)</label>
                    <input type="file" name="image" class="pg-input" style="padding:10px 14px;">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                      <div>
                        <label class="pg-label">Live URL (optional)</label>
                        <input name="live_url" class="pg-input" value="{{ $p->live_url }}">
                      </div>
                      <div>
                        <label class="pg-label">GitHub URL (optional)</label>
                        <input name="github_url" class="pg-input" value="{{ $p->github_url }}">
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
        @endif

        <div style="margin-top:25px;">
          <a href="{{ route('portfolio.step', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 4
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

  pgBindAiAutocomplete({ inputId:"projTitle", type:"project_title" });

  document.getElementById("aiProjDescBtn")?.addEventListener("click", async () => {
    const btn = document.getElementById("aiProjDescBtn");
    const out = document.getElementById("aiProjDescOut");
    const title = document.getElementById("projTitle");
    const desc = document.getElementById("projDesc");

    const text =
`Title: ${title?.value || ""}
Draft: ${desc?.value || ""}`;

    btn.disabled = true;
    btn.textContent = "Thinking...";
    out.innerHTML = "";

    try{
      const suggestions = await pgAiSuggest("project", text, { job_title: @json($portfolio->job_title) });

      pgRenderAiList(out, suggestions, (picked) => {
        desc.value = picked;
        out.innerHTML = "";
      });
    } catch(e){
      out.innerHTML = `<div class="pg-card" style="color:#ff6b6b;">AI failed: ${e?.message || e}</div>`;
    } finally{
      btn.disabled = false;
      btn.textContent = "✨ Improve Description";
    }
  });
</script>

@endsection