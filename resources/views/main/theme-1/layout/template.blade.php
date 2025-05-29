<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @yield('meta-add')
  <title>@yield('title') | {{ $web->name }}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.3/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/splide-4.1.3/dist/css/splide.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/main/theme-1/css/main.css') }}">

  @yield('css-addon')
</head>
<body>
  @include('main.theme-1.layout.navbar-top')

  <div class="position-relative">
    @include('main.theme-1.layout.main-nav')

    @yield('content')

    @include('main.theme-1.layout.footer')
  </div>

  <script src="{{ asset('assets/vendor/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/splide-4.1.3/dist/js/splide.min.js') }}"></script>
  <script src="{{ asset('assets/main/theme-1/js/main.js') }}"></script>
  @yield('js-addon')
</body>
</html>