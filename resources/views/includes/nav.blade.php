<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary shadow">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="/img/icon_circle_light.png" width="30" height="30" class="d-inline-block align-top mr-2"
            alt="MultiCrew logo">
        <span class="menu-collapsed">{{ config('app.name', 'MultiCrew') }}</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- left nav (with sidebar) -->
        <ul class="navbar-nav mr-auto d-none d-lg-block">
            <li class="nav-item">
                <a class="nav-link @if (strpos(Route::currentRouteName(), 'flights') !== false || strpos(Route::currentRouteName(), 'dispatch') !== false) active @endif"
                    href="{{ route('flights.index') }}">
                    <i class="fas fa-paper-plane fa-fw mr-2"></i>Copilot
                </a>
            </li>
        </ul>

        <!-- left nav (without sidebar) -->
        <ul class="navbar-nav mr-auto d-block d-lg-none">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('flights.index') }}">
                    <i class="fas fa-search fa-fw mr-2"></i>Find Flights
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('flights.user-flights') }}">
                    <i class="fas fa-user fa-fw mr-2"></i>My Flights
                </a>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fas fa-key fa-fw mr-2"></i>{{ __('Login') }}
                </a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">
                    <i class="fas fa-user-plus fa-fw mr-2"></i>{{ __('Register') }}
                </a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
                <button class="btn" type="button" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="fas fa-bell fa-lg"></span>
                </button>
                <span class="badge badge-notify" id="notify-count">2</span>

                <div class="dropdown-menu keep-open dropdown-menu-right" aria-labelledby="notificationDropdown"
                    id="notificationDropdownMenu">
                    <button id="1" onclick="removeNotification(this.id)" class="dropdown-item">TestUser has accepted
                        your flight request</button>
                    <button id="2" onclick="removeNotification(this.id)" class="dropdown-item">Something
                        happened</button>
                </div>

            </li>
            <li class="nav-item dropdown @if (strpos(Route::currentRouteName(), 'account') !== false) active @endif">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw mr-2 fa-user-circle"></i>{{ Auth::user()->username }} <span
                        class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item disabled @if (Route::currentRouteName() === 'account.profile') active @endif"
                        href="#">
                        <i class="fas fa-user fa-fw mr-3"></i>Profile
                    </a>
                    <a class="dropdown-item @if (Route::currentRouteName() === 'account.index') active @endif"
                        href="{{ route('account.index') }}">
                        <i class="fas fa-cog fa-fw mr-3"></i>Account
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-fw mr-3"></i>{{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>