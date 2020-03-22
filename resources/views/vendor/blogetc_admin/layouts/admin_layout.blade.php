<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} Blog Admin</title>

    <!-- jQuery is only used for hide(), show() and slideDown(). All other features use vanilla JS -->
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    <!-- fonts and styles -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito" crossorigin="anonymous">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ config('app.url') }}">
                {{ config('app.name') }} Blog Admin
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                    <li class="nav-item px-2">
                        <a class="nav-link" href="{{ route('blogetc.index') }}">
                            Blog home
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            Logged in as {{ Auth::user()->username }}
                        </a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">

        <div class="container">
            <div class="row">
                <div class="col-md-3 border-right">
                    @include('blogetc_admin::layouts.sidebar')
                </div>
                <div class="col-md-9 ">
                    @if (isset($errors) && count($errors))
                        <div class="alert alert-danger">
                            <b>Sorry, but there was an error:</b>
                            <ul class="m-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{--REPLACING THIS FILE WITH YOUR OWN LAYOUT FILE? Don't forget to include the following section!--}}

                    @if($hasFlashedMessage)
                        <div class="alert alert-info">
                            <h3>{{ $flashedMessage }}</h3>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>

<div class="text-center mt-5 pt-5 mb-3 text-muted">
    <small>
        <a href="https://webdevetc.com/">
            Laravel Blog Package provided by WebDevEtc
        </a>
    </small>
</div>

@if($includeRichTextEditor)
    <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"
            integrity="sha384-BpuqJd0Xizmp9PSp/NTwb/RSBCHK+rVdGWTrwcepj1ADQjNYPWT2GDfnfAr6/5dn"
            crossorigin="anonymous"></script>
    <script>
        if (typeof (CKEDITOR) !== 'undefined') {
            CKEDITOR.replace('post_body');
        }
    </script>
@endif

@stack('js')

</body>
</html>
