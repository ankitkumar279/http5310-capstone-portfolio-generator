@extends('layouts.app')

@section('content')
@push('styles')
  <link rel="stylesheet" href="{{ asset('css/templates.css') }}">
@endpush

<div class="pg-templates">
  <div class="container py-4">

    <h2 class="pg-templates-title">Choose Your Template</h2>
    <p class="pg-templates-sub">
      Select from professionally designed templates. Each one is customizable and optimized for showcasing your work.
    </p>

    <!-- Filters -->
    <div class="pg-filters" id="pgFilters">
      <button type="button" class="pg-pill active" data-filter="all">All</button>
      <button type="button" class="pg-pill" data-filter="minimal">Minimal</button>
      <button type="button" class="pg-pill" data-filter="developer">Developer</button>
      <button type="button" class="pg-pill" data-filter="designer">Designer</button>
      <button type="button" class="pg-pill" data-filter="business">Business</button>
    </div>

    <hr class="pg-divider">

    @php
      $templates = [
        ['key'=>'minimal','cat'=>'minimal','tag'=>'Clean','title'=>'Modern Minimalist','img'=>'https://image2url.com/r2/default/images/1772032929069-e9d0cdd0-092a-4bc2-aa37-ce1a5398b33e.png'],
        ['key'=>'business','cat'=>'business','tag'=>'Leadership','title'=>'Product Manager','img'=>'https://image2url.com/r2/default/images/1772033009040-db99fad3-3845-4d92-a743-93cc190bdfff.png'],
        ['key'=>'designer','cat'=>'designer','tag'=>'Visual','title'=>'Designer','img'=>'https://image2url.com/r2/default/images/1772032798941-8320fd3a-8cee-45d9-9d18-912293a09d27.png'],
        ['key'=>'developer','cat'=>'developer','tag'=>'Projects','title'=>'Full Stack Engineer','img'=>'https://image2url.com/r2/default/images/1772032735055-d72484da-b149-4f76-9160-58793dd0b654.png'],
      ];
    @endphp

    <div class="row g-3" id="pgGrid">
      @foreach($templates as $t)
        <div class="col-md-6 col-lg-4 pg-item" data-cat="{{ $t['cat'] }}">
          <div class="pg-card h-100">
            <div class="pg-thumb">
              <img src="{{ $t['img'] }}" alt="{{ $t['title'] }}" loading="lazy">
              <div class="pg-shine"></div>
            </div>

            <div class="pg-body">
              <div>
                <div class="pg-title">{{ $t['title'] }}</div>
                <span class="pg-tag">{{ $t['tag'] }}</span>
              </div>
              <div class="pg-actions">
                <button
                  type="button"
                  class="pg-btn pg-btn-ghost pg-preview-btn"
                  data-preview="{{ route('templates.preview', $t['key']) }}"
                  data-title="{{ $t['title'] }}"
                >
                  Preview
                </button>

               @auth
  <form method="POST" action="{{ route('portfolio.storeTemplate', ['username' => auth()->user()->username]) }}">
    @csrf
    <input type="hidden" name="template_key" value="{{ $t['key'] }}">
    <button class="pg-btn pg-btn-primary" type="submit">Use</button>
  </form>
@else
  <a class="pg-btn pg-btn-primary" href="{{ route('register') }}">Use</a>
@endauth
              </div>

            </div>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</div>

<!-- ✅ Preview Modal -->
<div class="modal fade" id="pgPreviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content pg-preview-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="pgPreviewTitle">Template Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-0">
        <div class="pg-preview-frame-wrap">
          <iframe id="pgPreviewFrame" src="about:blank" loading="lazy"></iframe>
        </div>
      </div>

      <div class="modal-footer">
        <small class="text-muted me-auto">Preview uses demo data</small>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  (function () {
    // Filters
    const pills = document.querySelectorAll('#pgFilters .pg-pill');
    const items = document.querySelectorAll('#pgGrid .pg-item');

    function setActive(btn){
      pills.forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
    }

    function applyFilter(cat){
      items.forEach(el => {
        const c = el.getAttribute('data-cat');
        el.style.display = (cat === 'all' || c === cat) ? '' : 'none';
      });
    }

    pills.forEach(btn => {
      btn.addEventListener('click', () => {
        setActive(btn);
        applyFilter(btn.getAttribute('data-filter'));
      });
    });

    // Preview modal
    const modalEl = document.getElementById('pgPreviewModal');
    const frame = document.getElementById('pgPreviewFrame');
    const title = document.getElementById('pgPreviewTitle');
    const modal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.pg-preview-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        title.textContent = (btn.getAttribute('data-title') || 'Template') + ' — Preview';
        frame.src = btn.getAttribute('data-preview');
        modal.show();
      });
    });

    modalEl.addEventListener('hidden.bs.modal', () => {
      frame.src = 'about:blank';
    });
  })();
</script>
@endpush
@endsection