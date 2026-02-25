@extends('layouts.dashboard')

@section('title','Change Template')

@section('content')

@php
  $username = request()->route('username')
    ?? ($portfolio->user->username ?? null)
    ?? (auth()->user()->username ?? auth()->user()->name ?? null);
@endphp

<div class="pg-step-wrapper">
  <div class="pg-step-box">

    <div class="pg-step-header">
      <div class="pg-step-title">Change Template</div>

      {{-- ✅ FIX: use the real show route name --}}
      <a href="{{ route('portfolio.owner.view', [
          'username'  => $username,
          'portfolio' => $portfolio->id
      ]) }}" class="pg-exit">
        Exit
      </a>
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

    <div class="pg-card" style="max-width:600px; margin:auto;">

      <form method="POST"
            action="{{ route('portfolio.template.update', [
              'username'  => $username,
              'portfolio' => $portfolio->id
            ]) }}">
        @csrf
        @method('PATCH')

        <label class="pg-label">Select Template</label>

        <select name="template_key"
                class="pg-input"
                style="appearance:none;">
          <option value="minimal"  @selected($portfolio->template_key==='minimal')>
            Modern Minimalist
          </option>
          <option value="developer" @selected($portfolio->template_key==='developer')>
            Developer
          </option>
          <option value="designer" @selected($portfolio->template_key==='designer')>
            Designer
          </option>
          <option value="business" @selected($portfolio->template_key==='business')>
            Business
          </option>
        </select>

        @error('template_key')
          <div style="color:#ff6b6b; margin-top:10px;">
            {{ $message }}
          </div>
        @enderror

        <div style="display:flex; gap:12px; margin-top:25px;">

          {{-- ✅ FIX: use the real show route name --}}
          <a href="{{ route('portfolio.owner.view', [
              'username'  => $username,
              'portfolio' => $portfolio->id
          ]) }}"
             class="pg-btn-secondary"
             style="flex:1;">
            Cancel
          </a>

          <button class="pg-submit" style="flex:1;">
            Save Template
          </button>
        </div>

      </form>

    </div>

  </div>
</div>

@endsection