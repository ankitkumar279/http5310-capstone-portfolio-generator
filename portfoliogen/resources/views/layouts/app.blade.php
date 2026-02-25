<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'PortfolioGen') }}</title>
<link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>

@php
  $isDarkPage =
      request()->routeIs('home') ||
      request()->routeIs('how') ||
      request()->routeIs('templates');
@endphp

<body class="{{ $isDarkPage ? '' : 'bg-light' }}"
      style="{{ $isDarkPage ? 'background:#07061a;' : '' }}">

  @include('layouts.navigation')

  <main class="{{ $isDarkPage ? '' : 'py-4' }}">
    @yield('content')
  </main>

  @include('layouts.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')

</body>
</html>