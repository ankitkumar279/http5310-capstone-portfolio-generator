@extends('layouts.dashboard')

@section('content')

<div class="pg-step-wrapper">
  <div class="pg-step-box">

    <div class="pg-step-header">
      <div class="pg-step-title">Create Your Portfolio</div>
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

    @if ($errors->any())
      <div class="alert alert-danger mb-3">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST"
          action="{{ route('portfolio.step.save', [
            'username' => auth()->user()->username,
            'portfolio' => $portfolio->id,
            'step' => 1
          ]) }}"
          enctype="multipart/form-data">
      @csrf

      <div class="pg-form-grid">

        <div class="pg-card">
          <label class="pg-label">Full Name *</label>
          <input name="full_name" class="pg-input"
                 value="{{ old('full_name', $portfolio->full_name) }}">

          <label class="pg-label">Job Title *</label>
          <input id="jobTitle" name="job_title" class="pg-input"
                 value="{{ old('job_title', $portfolio->job_title) }}">

          <label class="pg-label">Short Bio *</label>
          <textarea id="shortBio" name="short_bio" rows="4"
                    class="pg-input">{{ old('short_bio', $portfolio->short_bio) }}</textarea>

          <button type="button" class="pg-btn-secondary" id="aiBioBtn"
                  style="padding:8px 14px; border-radius:14px;">
            ✨ Suggest
          </button>

          <br><br>
          <div id="aiBioOut"></div>

          <label class="pg-label">Location *</label>
          <input name="location" class="pg-input"
                 value="{{ old('location', $portfolio->location) }}">
        </div>

        <div class="pg-card">
          <label class="pg-label">Upload Photo</label>
          <input type="file" name="photo" class="pg-input">

          <label class="pg-label">GitHub URL</label>
          <input name="github_url" class="pg-input"
                 value="{{ old('github_url', $portfolio->github_url) }}">

          <label class="pg-label">LinkedIn URL</label>
          <input name="linkedin_url" class="pg-input"
                 value="{{ old('linkedin_url', $portfolio->linkedin_url) }}">

          <label class="pg-label">Twitter/X URL</label>
          <input name="twitter_url" class="pg-input"
                 value="{{ old('twitter_url', $portfolio->twitter_url) }}">
        </div>

      </div>

      <div style="margin-top:30px; text-align:right;">
        <button type="submit" class="pg-submit">Next</button>
      </div>

    </form>

  </div>
</div>

<script>
  pgBindAiAutocomplete({
    inputId: "jobTitle",
    type: "job_title",
    contextBuilder: () => ({})
  });
</script>

<script>
document.getElementById("aiBioBtn")?.addEventListener("click", async () => {
  const btn = document.getElementById("aiBioBtn");
  const out = document.getElementById("aiBioOut");
  const bio = document.getElementById("shortBio");
  const jobTitle = document.getElementById("jobTitle");

  btn.disabled = true;
  btn.textContent = "Thinking...";
  out.innerHTML = "";

  try{
    const suggestions = await pgAiSuggest("bio", bio?.value || "", {
      full_name: @json($portfolio->full_name),
      job_title: (jobTitle?.value || @json($portfolio->job_title)),
    });

    pgRenderAiList(out, suggestions, (picked) => {
      bio.value = picked;
      out.innerHTML = "";
    });
  } catch(e){
    out.innerHTML = `<div class="pg-card" style="color:#ff6b6b;">AI failed: ${e?.message || e}</div>`;
  } finally{
    btn.disabled = false;
    btn.textContent = "✨ Suggest";
  }
});
</script>

@endsection