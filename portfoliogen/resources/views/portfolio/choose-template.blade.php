@extends('layouts.choose-template')

@section('title', 'Choose Template - PortfolioGen')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/templates.css') }}">
<style>
.pg-app-wrapper{
  position: relative;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:40px 20px;
}

.pg-app-box{
  width:100%;
  max-width:1000px;
  background:rgba(255,255,255,0.05);
  backdrop-filter:blur(18px);
  border-radius:28px;
  padding:40px;
  border:1px solid rgba(255,255,255,0.12);
  box-shadow:0 40px 120px rgba(0,0,0,0.45);
  animation:fadeIn .6s ease;
}

@keyframes fadeIn{
  from{opacity:0; transform:translateY(20px);}
  to{opacity:1; transform:translateY(0);}
}

.pg-app-title{
  font-size:32px;
  font-weight:900;
  margin-bottom:6px;
}

.pg-app-sub{
  color:rgba(255,255,255,0.6);
  margin-bottom:30px;
}

.pg-option{
  border-radius:20px;
  padding:22px;
  margin-bottom:18px;
  background:linear-gradient(135deg, rgba(38,28,193,0.25), rgba(58,154,255,0.12));
  border:1px solid rgba(255,255,255,0.15);
  display:flex;
  align-items:center;
  justify-content:space-between;
  transition:all .25s ease;
  cursor:pointer;
}

.pg-option:hover{
  transform:translateY(-4px);
  box-shadow:0 25px 70px rgba(38,28,193,0.4);
}

.pg-option h4{
  font-weight:900;
  margin:0;
}

.pg-option p{
  margin:4px 0 0;
  color:rgba(255,255,255,0.65);
  font-size:14px;
}

.pg-use-btn{
  border:none;
  padding:10px 18px;
  border-radius:14px;
  font-weight:800;
  background:linear-gradient(135deg,#261CC1,#3A9AFF);
  color:white;
  box-shadow:0 12px 30px rgba(38,28,193,0.4);
  transition:all .2s ease;
}

.pg-use-btn:hover{
  transform:translateY(-2px);
  box-shadow:0 18px 40px rgba(58,154,255,0.3);
}

.pg-back-inline{
  text-decoration:none;
  font-weight:800;
  font-size:14px;
  padding:8px 16px;
  border-radius:12px;
  background:rgba(255,255,255,0.08);
  color:white;
  border:1px solid rgba(255,255,255,0.15);
  transition:all .2s ease;
  white-space:nowrap;
  height:fit-content;
}

.pg-back-inline:hover{
  transform:translateY(-2px);
  background:linear-gradient(135deg,#261CC1,#3A9AFF);
  box-shadow:0 12px 28px rgba(38,28,193,0.4);
}

.pg-app-header{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  margin-bottom:30px;
  gap:20px;
}
</style>
@endpush

@section('content')
@php
  $u = auth()->user()->username;
@endphp

<div class="pg-templates">
  <div class="pg-app-wrapper">

    <div class="pg-app-box">
      <div class="pg-app-header">
        <div>
          <div class="pg-app-title">Choose Your Portfolio Style</div>
          <div class="pg-app-sub">
            Select a layout to begin. You can change it anytime later.
          </div>
        </div>

        {{-- ✅ FIX: pass username --}}
        <a href="{{ route('dashboard', ['username' => $u]) }}" class="pg-back-inline">
          ← Back
        </a>
      </div>

      @php
        $templates = [
          ['key'=>'minimal','title'=>'Modern Minimalist','desc'=>'Clean layout, simple sections.'],
          ['key'=>'developer','title'=>'Developer','desc'=>'Skills & projects focused design.'],
          ['key'=>'designer','title'=>'Designer','desc'=>'Creative and visual-first portfolio.'],
          ['key'=>'business','title'=>'Business','desc'=>'Professional corporate presentation.'],
        ];
      @endphp

      @foreach($templates as $t)
        {{-- ✅ FIX: pass username --}}
        <form method="POST" action="{{ route('portfolio.storeTemplate', ['username' => $u]) }}">
          @csrf
          <input type="hidden" name="template_key" value="{{ $t['key'] }}">

          <div class="pg-option">
            <div>
              <h4>{{ $t['title'] }}</h4>
              <p>{{ $t['desc'] }}</p>
            </div>

            <button class="pg-use-btn" type="submit">
              Use Template →
            </button>
          </div>
        </form>
      @endforeach

    </div>

  </div>
</div>
@endsection