<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    {{-- @stack('styles') --}}
</head>

<body class="nav-fixed">

    @include('layouts.navigation')
    <div id="layoutSidenav">
        @include('layouts.sidebar')

        <div id="layoutSidenav_content">
            <main>
                {{-- Tampilkan pesan sukses --}}
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Tampilkan pesan error --}}
                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    {{-- @stack('scripts') --}}
    @yield('scripts')

</body>

</html>