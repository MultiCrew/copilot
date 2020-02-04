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
            @include('includes.sidebar')
        		<div class="p-4 col">
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
        
        function removeNotification(id) {
            var elem = document.getElementById(id);
            elem.parentElement.removeChild(elem);
            var count = $('#notify-count').text();
            count--;
            $('#notify-count').text(count);
            if ($('#notify-count').text() == 0) {
                $('#notify-count').text('')
            }
            if ($('#notificationDropdownMenu').children().length === 0) {
                $('#notificationDropdownMenu').attr("hidden", "hidden");
            }
        }
    </script>
    @yield('scripts')

    @yield('footer')
</body>
</html>