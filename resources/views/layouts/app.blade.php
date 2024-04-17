<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    {{-- <link href="{{ asset('asset/css/app.css') }}" rel="stylesheet"> --}}
    @vite('resources/css/app.css')
    <script src="{{ asset('asset/libs/axios/dist/axios.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body class="">
    @include('components.sidebar')


    <main class="main-content position-relative border-radius-lg ">

        @yield('content')
    </main>

</body>

</html>
