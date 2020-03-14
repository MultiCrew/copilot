<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MultiCrew') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <div id="app">
        @include('includes.nav')

        @auth
        <main class="row" id="body-row">
            @if(!(strpos(Route::currentRouteName(), 'blog') !== false))
                @include('includes.sidebar')
            @endif
            <div class="p-4 col" id="content-div">
                <div class="notify-toast-parent" aria-live="polite" aria-atomic="true">
                    <div class="notify-toast-position" id="notification-div"></div>
                </div>
                @yield('content')
            </div>
        </main>
        @endauth

        @guest
        <main class="py-4 container">
            @yield('content')
        </main>
        @endguest

        @include('includes.cookies')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @if (!auth()->guest())
    <script>
        window.Laravel.userId = {!! auth()->user()->id !!};
    </script>
    @endif
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
		$('#cookieAlert').on('closed.bs.alert', function () {
			window.location.href = '{{ route('cookie-consent')}}'
		})

        $('.dropdown-menu.keep-open').on('click', function (e) {
            e.stopPropagation();
        });

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
</body>
</html>
