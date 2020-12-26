<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark shadow">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('/img/icon_circle_light.png') }}" width="30" height="30" class="d-inline-block align-top mr-2"
            alt="MultiCrew logo">
        <span class="menu-collapsed">{{ config('app.name', 'MultiCrew') }}</span>
    </a>

    <a href="#" data-toggle="modal" data-target="#versionModal">
        <h5 class="pt-2 ml-2 mr-3">
            <span class="badge badge-primary">v0.2.5</span>
        </h5>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- left nav (with sidebar) -->
        <ul class="navbar-nav mr-auto d-none d-lg-flex">
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'home.about') active @endif"
                    href="{{ route('home.about') }}">
                    <i class="fas fa-info-circle fa-fw mr-2"></i>About
                </a>
            </li>

            <li class="nav-item">
                <a
                class="nav-link
                @if(Route::currentRouteName() === 'home.policy')
                    active
                @endif"
                href="{{ route('home.policy') }}">
                    <i class="fas fa-file-alt fa-fw mr-2"></i>Policies
                </a>
            </li>

            @auth
                @role('new')
                    @can('apply to beta')
                        <li class="nav-item">
                            <a class="nav-link @if(Route::currentRouteName() == 'apply.create') active @endif"
                                href="{{ route('apply.create') }}">
                                <i class="fas fa-check fa-fw mr-2"></i>Apply
                            </a>
                        </li>
                    @endcan
                @else
                    <li class="nav-item">
                        <a
                        class="nav-link
                        @if(strpos(Route::currentRouteName(), 'flights') !== false
                         || strpos(Route::currentRouteName(), 'dispatch') !== false)
                            active
                        @endif"
                        href="{{ route('flights.index') }}">
                            <i class="fas fa-paper-plane fa-fw mr-2"></i>Copilot
                        </a>
                    </li>
                @endrole
            @endauth
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'login') active @endif" href="{{ route('login') }}">
                    <i class="fas fa-key fa-fw mr-2"></i>{{ __('Login') }}
                </a>
            </li>

            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link @if(Route::currentRouteName() == 'register') active @endif"
                    href="{{ route('register') }}">
                    <i class="fas fa-user-plus fa-fw mr-2"></i>{{ __('Register') }}
                </a>
            </li>
            @endif

            @else
            <li class="nav-item">
                <span class="nav-link mr-2" id="time"></span>
            </li>
            <li class="nav-item">
                <span class="nav-link mr-2" id="time-local"></span>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link mr-2" href="#" id="notificationDropdown" data-toggle="dropdown">
                    <i class="fas fa-bell notification-bell mr-lg-2"></i>
                    <span class="badge badge-notify d-none" id="notify-count">
                    </span>
                    <span class="d-lg-none ml-3">Notifications</span>
                </a>

                <div class="dropdown-menu keep-open dropdown-menu-right" aria-labelledby="notificationDropdown"
                    id="notificationDropdownMenu">
                    <button class="btn btn-sm btn-outline-success ml-2 d-none" id="markAllRead" onclick="markAllRead()">
                        <i class="fas fa-check mr-2"></i>Mark all as read
                    </button>
                    <a class="btn btn-sm btn-outline-secondary mx-2" href="{{ route('account.index').'#notifications' }}">
                        <i class="fas fa-cog mr-2"></i>Manage
                    </a>

                    <div id="noNotifications">
                        <div class="dropdown-divider"></div>

                        <button class="dropdown-item disabled">
                            You have no unread notifications
                        </button>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle
                @if(Route::currentRouteNamed('account*') ||
                isset($profile) && ($profile->id === Auth::user()->profile->id)) active @endif"
                href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw mr-2 fa-user-circle"></i>{{ Auth::user()->username }}
                    <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item @if(isset($profile) && ($profile->id === Auth::user()->profile->id)) active @endif"
                         href="{{ route('profile.show', Auth::user()->profile) }}">
                        <i class="fas fa-user fa-fw mr-3"></i>Profile
                    </a>
                    <a class="dropdown-item @if(Route::currentRouteName() === 'account.index') active @endif"
                        href="{{ route('account.index') }}">
                        <i class="fas fa-cog fa-fw mr-3"></i>Account
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" id="logoutFormSubmit">
                        <i class="fas fa-sign-out-alt fa-fw mr-3"></i>Logout
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
