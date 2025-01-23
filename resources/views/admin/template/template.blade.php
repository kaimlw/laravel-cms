<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('meta')
    
    <title> @yield('title') - CMS FKIP</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- MAIN CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/chartjs/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/app.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- CSS AddOn --}}
    @yield('css-addOn')
    <style>
        .sidebar-menu i.bi{
            height: max-content !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <aside id="sidebar" class="active">
            @if (auth()->user()->roles == 'super_admin')
                @include('admin.layout.sidebar-super')
            @else
                @include('admin.layout.sidebar')
            @endif
        </aside>

        <div id="main">
            @include('admin.layout.navbar')

            <div class="main-content container-fluid">
                @yield('content')
            </div>

            @include('admin.layout.footer')
        </div>
    </div>

    {{-- MAIN JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/app.js') }}"></script>
    
    <script src="{{ asset('assets/vendor/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/admin/assets/js/main.js') }}"></script>

    {{-- JS AddOn --}}
    @yield('js-addOn')
   
</body>
</html>