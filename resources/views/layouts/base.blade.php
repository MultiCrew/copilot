<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MultiCrew') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('header')
    @stack('prepend-scripts')
</head>

<body>
    <div id="app">
        @include('includes.nav')

        @auth
            @if(Auth::user()->hasRole('new') ||
                strpos(Route::currentRouteName(), 'about') !== false ||
                strpos(Route::currentRouteName(), 'policy') !== false)
                <div class="w-100" id="header-image">
                    <div id="header-text" class="text-center text-white">
                        <h1 class="display-4">MultiCrew</h1>
                        <p class="lead">@yield('title')</p>
                    </div>
                </div>
                <main class="container">
                    <div class="p-4 col" id="content-div">
                        <div class="notify-toast-parent" aria-live="polite" aria-atomic="true">
                            <div class="notify-toast-position" id="notification-div"></div>
                        </div>
                        @yield('content')
                    </div>
                </main>
            @else
                <main class="row" id="body-row">
                    @include('includes.sidebar')
                    <div class="col-lg-10 p-4" id="content-div">
                        <div class="notify-toast-parent" aria-live="polite" aria-atomic="true">
                            <div class="notify-toast-position" id="notification-div"></div>
                        </div>
                        @yield('content')
                    </div>
                </main>
            @endrole
        @endauth

        @guest
            <main class="py-4 container">
                @yield('content')
            </main>
        @endguest

        @if(strpos(Route::currentRouteName(), 'about') !== false ||
            strpos(Route::currentRouteName(), 'policy') !== false)
            <div class="bg-light text-dark py-5">
                <div class="container">
                    <h3 class="text-center display-4 mb-4">MultiCrew</h3>
                    <p class="text-center lead mb-4">
                        We're all about bringing people from the aviation industry and the flight simulation community
                        together to enjoy flight simulators. We are a community-driven organisation, which specialises
                        in shared cockpit flying, training and support.
                    </p>
                    <p class="text-center">
                        <a href="https://fb.me/flymulticrew"><i class="fab fa-facebook-square fa-2x mr-4"></i></a>
                        <a href="https://twitter.com/flymulticrew"><i class="fab fa-twitter fa-2x mr-4"></i></a>
                        <a href="https://discord.gg/3jHRAkE"><i class="fab fa-discord fa-2x mr-4"></i></a>
                        <a href="https://github.com/MultiCrew"><i class="fab fa-github fa-2x"></i></a>
                    </p>
                </div>
            </div>
        @endif
        @include('includes.cookies')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        function acceptCookie() {
            $.get('{!! route('cookie-consent') !!}');
        }
    </script>

    @auth
        <script>
            window.Laravel.userId = {!! auth()->user()->id !!};
            // notification functions
            $(document).ready(function() {
                $.get('/notifications', function(data) {
                    for (const notification of data) {
                        const nData = notification.data;
                        addNotification(notification.id, nData);
                    }
                });
                window.Echo.private(`App.Models.Users.User.${Laravel.userId}`).notification((notification) => {
                    newNotification(notification.id, notification);
                });
            });

            function logout() {
                $("#logout-form").submit();
            }
        </script>
    @endauth

    <script>
		$('#cookieAlert').on('closed.bs.alert', function () {
			$.get('/cookie-consent');
		})
    </script>

    @yield('scripts')
    @yield('footer')

    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="helpModalTitle">@yield('help-title', 'Copilot Help')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @yield('help-content', 'This page has no help section defined. Please visit all help below.')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary disabled">View all help<i class="fas fa-fw ml-2 fa-angle-double-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="versionModal" tabindex="-1" aria-labelledby="versionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="versionModalLabel">Changelog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @include('includes.changelog')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @stack('append-scripts')
</body>
</html>
