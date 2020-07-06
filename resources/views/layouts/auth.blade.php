<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MultiCrew') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    @yield('content')
    @yield('scripts')
</body>
</html>
