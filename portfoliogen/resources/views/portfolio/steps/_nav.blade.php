@php
  $labels = [
    1 => 'Personal',
    2 => 'Education',
    3 => 'Experience',
    4 => 'Skills',
    5 => 'Projects',
    6 => 'Review',
  ];

  $username = auth()->user()->username;
@endphp

<div class="d-flex flex-wrap gap-2 align-items-center mb-3">
  @for($i=1; $i<=6; $i++)
    @if($i <= $maxStep)
      <a
        href="{{ route('portfolio.step', ['username' => $username, 'portfolio' => $portfolio->id, 'step' => $i]) }}"
        class="btn btn-sm {{ $i == $step ? 'btn-primary' : 'btn-outline-primary' }}"
      >
        {{ $i }}. {{ $labels[$i] }}
      </a>
    @else
      <button class="btn btn-sm btn-outline-secondary" disabled>
        {{ $i }}. {{ $labels[$i] }}
      </button>
    @endif
  @endfor

  <div class="ms-auto">
    <a class="btn btn-sm btn-outline-dark"
       href="{{ route('dashboard', ['username' => $username]) }}">
      Exit
    </a>
  </div>
</div>