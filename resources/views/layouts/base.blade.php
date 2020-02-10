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
            @include('includes.sidebar')
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

        $(document).ready(function() {
            $.get('/notifications', function(data) {
                for (const notification of data) {
                    const nData = notification.data
                    addNotification(notification.id, nData);
                }
            })
            window.Echo.private(`App.Models.Users.User.${Laravel.userId}`).notification((notification) => {
                newNotification(notification.id, notification)
            })
        })

        function removeNotification(id) {
            if ($(`#${id}`).index() === 0) {
                $(`#${id}`).next().remove()
            } else {
                $(`#${id}`).prev().remove()
            }
            $(`#${id}`).remove()
            var count = $('#notify-count').text();
            count--;
            $('#notify-count').text(count);
            if ($('#notify-count').text() == 0) {
                $('#notify-count').text('')
            }
            if ($('#notificationDropdownMenu').children().length === 0) {
                $('#notificationDropdownMenu').attr("hidden", "hidden");
            }
            $.get(`/notifications/${id}`)
        }

        function viewNotification(id, notification) {
            removeNotification(id)
            switch (notification.title) {
                case 'Request Accepted':
                    window.location.href = `/flights/${notification.flight.id}`
                    break;
                case 'Flight Plan Accepted':
                    window.location.href = `/dispatch/review/${notification.plan_id}`
                    break;
                case 'Flight Plan Rejected':
                    window.location.href = `/flights/${notification.flight_id}`
                    break;
                default:
                    break;
            }
        }

        function newNotification(id, notification) {
            $('#notification-div').append(
                $('<div/>', {'class': 'toast', 'data-autohide': 'false', 'id': id}).append(
                    $('<div/>', {'class': 'toast-header'}).append(
                        $('<strong/>', {'class': 'mr-auto'}).text(notification.title)
                    ).append(
                        $('<small/>').text('Just now')
                    ).append(
                        $('<button/>', {
                            'type': 'button', 
                            'class': 'ml-2 mb-1 close',
                            'data-dismiss': 'toast', 
                            'aria-label': 'Close',
                            'onclick': `removeNotification('${id}')`
                            }).append(
                                $('<span/>', {'aria-hidden': 'true'}).html('&times;')
                            )
                    )
                ).append(
                    $('<div/>', {'class': 'toast-body'}).text(notification.text)
                )
            )
            $(`#${id}`).toast('show');
            addNotification(id, notification)
        }

        function addNotification(id, notification) {
            if ($('#notificationDropdownMenu').children().length >= 1 ) {
                $('<div/>', {'class': 'dropdown-divider'}).appendTo('#notificationDropdownMenu')
            }
            $('<li/>', {'class': 'dropdown-item', 'id': id,}).append(
                $('<button />', {
                    'html': notification.text,
                    'onclick': `viewNotification('${id}', ${JSON.stringify(notification)})`,
                    'class': 'btn',
                    'type': 'button'
                })
            ).append(
                $('<button/>', {
                    'type': 'button',
                    'class': 'btn btn-sm', 
                    'onclick': `removeNotification('${id}')`, 
                    }).append(
                        $('<span/>', {'aria-hidden': 'true'}).html('&times;')
                    )
            ).appendTo('#notificationDropdownMenu');
            var count = $('#notify-count').text();
            count++;
            $('#notify-count').text(count);

            if ($('#notificationDropdownMenu').children().length !== 0 && $('#notificationDropdownMenu').has("hidden")) {
                $('#notificationDropdownMenu').removeAttr("hidden");
            }
        }
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
