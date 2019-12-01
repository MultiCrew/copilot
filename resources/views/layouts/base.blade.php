<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MultiCrew</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body>
        @if(!Cookie::get('cookie_consent'))
            <div class="has-background-success has-text-white">
                <div class="container">
                    <div class="level" style="padding-top: 12px; padding-bottom: 12px;">
                        <div class="level-left">
                            <p class="">
                                MultiCrew uses cookies to ensure you get the best experience. By continuing to browse, you agree to the storage of cookies on your computer.
                            </p>
                        </div>
                        <div class="level-right">
                            <a href="{{ route('cookie-consent')}}"><i class="fas fa-times has-text-white"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('layout')

        <script src="{{ asset('js/app.js') }}"></script>

        @auth
            <script>
                function logout() {
                    $("#logout-form").submit();
                }
            </script>
        @endauth
        <script>
            function toggleBurger() {
                var burger = $('.burger');
                var menu = $('.navbar-menu');
                burger.toggleClass('is-active');
                menu.toggleClass('is-active');
            }
        </script>
        @yield('footer')
    </body>
</html>