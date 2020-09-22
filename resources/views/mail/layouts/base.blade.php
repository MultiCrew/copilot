<!DOCTYPE html>
<html>
<head>
    <title>MultiCrew</title>
    <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
    crossorigin="anonymous">
    <script
    src="https://kit.fontawesome.com/c000864a8c.js"
    crossorigin="anonymous"></script>

    <style type="text/css">
        .icon-links > a {
            color: #888;
            margin: 0 25px;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                <img
                src="{{ asset('/img/icon_circle_light.png') }}"
                width="30" height="30"
                class="d-inline-block align-top mr-2"
                alt="MultiCrew logo">
                MultiCrew
            </a>
        </div>
    </nav>

    <main class="container py-5">
        <h1>@yield('title')</h1>
        @hasSection('subtitle')
            <h3 class="text-muted">@yield('subtitle')</h3>
        @endif
        <hr>

        <p>
            Dear @yield('name'),
        </p>

        @yield('content')

        <p class="lead">
            Kind regards,<br>
            The MultiCrew Team
        </p>
    </main>

    <footer class="py-5 bg-light">
        <div class="container text-center">
            <img
            src="{{ asset('/img/logo_long_dark.png') }}"
            class="d-inline-block img-fluid align-top mr-2 w-50"
            alt="MultiCrew logo">

            <p class="lead mt-5">
                We're all about bringing people from the aviation industry and the flight simulation community together
                to enjoy flight simulators. We are a community-driven organisation which specialises in shared cockpit
                flying, training and support.
            </p>

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
    </footer>
</body>
</html>
