<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

  <!-- FontAwesome JS-->
  <script defer src="{{ asset('plugins/fontawesome/js/all.min.js') }}"></script>

  <!-- App CSS -->
  <link id="theme-style" rel="stylesheet" href="{{ asset('css/portal.css') }}" />
</head>

@yield('content')

</html>
