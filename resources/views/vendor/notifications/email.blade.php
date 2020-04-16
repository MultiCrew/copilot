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
            <a class="navbar-brand" href="#">
                <img
                src="{{asset('img/icon_circle_light.png')}}"
                width="30" height="30"
                alt="">
                MultiCrew
            </a>
        </div>
    </nav>

    <main class="container py-5">
        <h1>Email Verification</h1>
        <h3 class="text-muted">Email subtitle</h3>
        <hr>
        <p>
            Dear Name,
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
        <p>
            <button class="btn btn-primary">Primary Action</button>
            <button class="btn btn-secondary">Secondary Action</button>
        </p>
    </main>

    <footer class="py-5 bg-light">
        <div class="container text-center">
            <img src="https://via.placeholder.com/468x60?text=MultiCrew+logo" alt="">
            <p class="lead mt-5">
                We're all about bringing people from the aviation industry and the flight simulation community together to enjoy flight simulators. We are a community-driven, non-profit organisation, which specialises in shared cockpit flying, training and support.
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
