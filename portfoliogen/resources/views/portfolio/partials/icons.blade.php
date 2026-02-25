@php($n = $name ?? '')
@switch($n)

  @case('github')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
      d="M12 2C6.48 2 2 6.6 2 12.27c0 4.54 2.87 8.39 6.84 9.75.5.1.68-.22.68-.48v-1.7c-2.78.62-3.37-1.2-3.37-1.2-.45-1.2-1.1-1.52-1.1-1.52-.9-.64.07-.63.07-.63 1 .07 1.53 1.06 1.53 1.06.9 1.58 2.36 1.12 2.93.86.1-.67.35-1.12.63-1.38-2.22-.26-4.56-1.14-4.56-5.08 0-1.12.38-2.04 1.02-2.76-.1-.26-.45-1.3.1-2.71 0 0 .84-.27 2.75 1.05.8-.23 1.65-.35 2.5-.35.85 0 1.7.12 2.5.35 1.9-1.32 2.74-1.05 2.74-1.05.56 1.41.2 2.45.1 2.71.64.72 1.03 1.64 1.03 2.76 0 3.95-2.34 4.82-4.57 5.08.36.32.68.95.68 1.92v2.84c0 .27.18.59.69.48A10.2 10.2 0 0 0 22 12.27C22 6.6 17.52 2 12 2Z" />
  </svg>
  @break

  @case('linkedin')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
      d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4V9h4v2a4 4 0 0 1 2-3Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M2 9h4v12H2z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 4a2 2 0 1 0 0.01 0Z"/>
  </svg>
  @break

  @case('user')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
      d="M20 21a8 8 0 1 0-16 0"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
      d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z"/>
  </svg>
  @break

  @case('up')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 5v14"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M6 11l6-6 6 6"/>
  </svg>
  @break

  {{-- keep your existing icons --}}
  @case('html')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 3h16l-1.5 17L12 22l-6.5-2L4 3Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h8M8 15h6"/>
  </svg>
  @break

  @case('css')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 3h16l-1.5 17L12 22l-6.5-2L4 3Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h6M8 15h7"/>
  </svg>
  @break

  @case('js')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 3h16v18H4z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M9 16a2 2 0 0 0 2 2c1.1 0 2-.9 2-2V9"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M15 16c.2 1.1 1 2 2.2 2 1 0 1.8-.7 1.8-1.7 0-2.2-3.8-1.4-3.8-4 0-1 .8-1.8 1.9-1.8 1 0 1.7.6 1.9 1.4"/>
  </svg>
  @break

  @case('figma')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 2h3a3 3 0 1 1 0 6h-3V2Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M9 2h3v6H9a3 3 0 1 1 0-6Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M9 8h6a3 3 0 1 1 0 6H9V8Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M9 14h3v3a3 3 0 1 1-3-3Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M9 14h3v6H9a3 3 0 1 1 0-6Z"/>
  </svg>
  @break

  @case('bolt')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13 2 3 14h7l-1 8 12-14h-7l-1-6Z"/>
  </svg>
  @break

  @case('scroll')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M8 3h8a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 7v4"/>
  </svg>
  @break

  @case('cube')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 2 3 7v10l9 5 9-5V7l-9-5Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 22V12"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M21 7l-9 5-9-5"/>
  </svg>
  @break

  @case('chart')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 19V5"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4 19h16"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M8 16v-6"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 16V8"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M16 16v-3"/>
  </svg>
  @break

  @case('spark')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5L12 2Z"/>
  </svg>
  @break

  @case('layers')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 3 3 8l9 5 9-5-9-5Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M3 12l9 5 9-5"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M3 16l9 5 9-5"/>
  </svg>
  @break

  @case('eye')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
  </svg>
  @break

  @case('cpu')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M9 3v2M15 3v2M9 19v2M15 19v2M3 9h2M3 15h2M19 9h2M19 15h2"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M7 7h10v10H7z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M10 10h4v4h-4z"/>
  </svg>
  @break

  @case('cap')
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M2 8l10-5 10 5-10 5L2 8Z"/>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M6 10v6c0 2 3 4 6 4s6-2 6-4v-6"/>
  </svg>
  @break

  @default
  <svg viewBox="0 0 24 24" stroke-width="1.8" fill="none" aria-hidden="true">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12 2 2 7l10 5 10-5-10-5Z"/>
  </svg>

@endswitch