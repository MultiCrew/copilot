<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <script src="https://kit.fontawesome.com/c000864a8c.js" crossorigin="anonymous"></script>
        <style>
            html, body {
                background: url('img/bg.jpeg') no-repeat;
                color: #eee;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .text-links > a {
                color: #ccc;
                padding: 0 25px;
                font-size: 15px;
                font-weight: 800;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                -webkit-text-stroke: 0.5px #eee;
            }

            .icon-links > a {
                color: #ccc;
                margin: 0 25px;
                font-size: 15px;
                font-weight: 800;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .mr-2 {
                margin-right: 0.6rem;
            }

            .mt-5 {
                margin-top: 5rem;
            }
        </style>
    </head>

    <body>
        <div class="flex-center position-ref full-height" id="app">
            @if (Route::has('login'))
                <div class="top-right text-links">
                    @auth
                        <a href="{{ route('account.index') }}">
                            <i class="fas fa-fw fa-home mr-2"></i>Account
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <i class="fas fa-fw fa-key mr-2"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}">
                            <i class="fas fa-fw fa-user-plus mr-2"></i>
                            Register
                        </a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{ config('app.name') }}
                </div>

                <div class="text-links">
                    @auth
                        <a href="{{ route('flights.index') }}">Copilot</a>
                        <a href="{{ route('account.index') }}">Account</a>
                    @else
                        <a href="{{ route('register') }}">
                            <i class="fas fa-fw fa-user-plus mr-2"></i>
                            Register
                        </a>
                    @endguest
                </div>

                <div class="icon-links mt-5">
                    <a href="https://fb.me/flymulticrew">
                        <i class="fab fa-facebook-square fa-2x"></i>
                    </a>
                    <a href="https://twitter.com/flymulticrew">
                        <i class="fab fa-twitter fa-2x"></i>
                    </a>
                    <a href="https://discord.gg/3jHRAkE">
                        <i class="fab fa-discord fa-2x"></i>
                    </a>
                    <a href="https://github.com/MultiCrew">
                        <i class="fab fa-github fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
