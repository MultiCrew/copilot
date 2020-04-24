<div id="sidebar-container" class="sidebar-expanded d-none d-lg-block col-lg-2">
    <!-- hidden on <=md -->
    <div class="list-group sticky-top sticky-offset">
        <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
            <small class="text-uppercase">Flights</small>
        </li>

        <a
        href="{{ route('flights.index') }}"
        class="bg-dark list-group-item list-group-item-action
        @if(Route::currentRouteName() === 'flights.index')) active @endif">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fas fa-fw mr-2 fa-search"></i>Find Flights
            </div>
        </a>

        <a
        href="{{ route('flights.user-flights') }}"
        class="bg-dark list-group-item list-group-item-action
        @if(strpos(Route::currentRouteName(), 'flights') !== false && Route::currentRouteName() !== 'flights.index') active @endif">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fas fa-fw mr-2 fa-plane"></i>My Flights
            </div>
        </a>

        <a
        href="{{ route('dispatch.index') }}"
        class="bg-dark list-group-item list-group-item-action
        @if(strpos(Route::currentRouteName(), 'dispatch') !== false) active @endif">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fas fa-fw mr-2 fa-file-contract"></i>Dispatch
            </div>
        </a>

        <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
            <small class="text-uppercase">Options</small>
        </li>

        <a
        href="{{ route('profile.show', Auth::user()->profile) }}"
        class="bg-dark list-group-item list-group-item-action
        @if(strpos(Route::currentRouteName(), 'profile') !== false) active @endif">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fa fa-id-card fa-fw mr-3"></i>Profile
            </div>
        </a>

        <a
        href="{{ route('account.index') }}"
        class="bg-dark list-group-item list-group-item-action
        @if(strpos(Route::currentRouteName(), 'account') !== false && !(strpos(Route::currentRouteName(), 'account.admin') !== false)) active @endif">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fa fa-user-cog fa-fw mr-3"></i>Account
            </div>
        </a>

        @role('admin')
            <a
            href="{{ route('admin.users.index') }}"
            class="bg-dark list-group-item list-group-item-action
            @if(strpos(Route::currentRouteName(), 'admin') !== false) active @endif">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <i class="fa fa-user-shield fa-fw mr-3"></i>Admin
                </div>
            </a>
        @endrole


        <li class="list-group-item sidebar-separator menu-collapsed"></li>

        <a
        href="#"
        class="bg-dark list-group-item list-group-item-action"
        data-toggle="modal"
        data-target="#helpModal">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fa fa-question-circle fa-fw mr-3"></i>
                    Help
            </div>
        </a>

        <li class="list-group-item logo-separator d-flex justify-content-center">
            <img src="/img/icon_circle_light.png" width="30" height="30">
        </li>

        <!-- Menu with submenu example
            <a href="#flightsSubmenu"
            data-toggle="collapse"
            aria-expanded="false"
            class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <i class="fa fa-search fa-fw mr-3"></i>
                    <span class="menu-collapsed">Find Flights</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>

            <div id="flightsSubmenu" class="collapse sidebar-submenu">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">
                        <i class="fas fa-fw mr-2 fa-table"></i>All Flights
                    </span>
                </a>
            </div>
        -->
    </div>
</div>

<nav id="pills-container" class="nav nav-pills nav-fill d-lg-none px-3 pt-3">
    <a
    href="{{ route('flights.index') }}"
    class="nav-item nav-link
    @if(Route::currentRouteName() === 'flights.index')) active @endif">
        <i class="fas fa-fw mr-2 fa-search"></i>Find Flights
    </a>

    <a
    href="{{ route('flights.user-flights') }}"
    class="nav-item nav-link
    @if(strpos(Route::currentRouteName(), 'flights') !== false && Route::currentRouteName() !== 'flights.index') active @endif">
        <i class="fas fa-fw mr-2 fa-plane"></i>My Flights
    </a>

    <a
    href="{{ route('dispatch.index') }}"
    class="nav-item nav-link
    @if(strpos(Route::currentRouteName(), 'dispatch') !== false) active @endif">
        <i class="fas fa-fw mr-2 fa-file-contract"></i>Dispatch
    </a>

    <a href="#" class="nav-item nav-link disabled">
        <i class="fa fa-id-card fa-fw mr-3"></i>Profile
    </a>

    <a
    href="{{ route('account.index') }}"
    class="nav-item nav-link
    @if(strpos(Route::currentRouteName(), 'account') !== false && !(strpos(Route::currentRouteName(), 'account.admin') !== false)) active @endif">
        <i class="fa fa-user-cog fa-fw mr-3"></i>Account
    </a>

    @role('admin')
        <a
        href="{{ route('admin.users.index') }}"
        class="nav-item nav-link
        @if(strpos(Route::currentRouteName(), 'admin') !== false) active @endif">
            <i class="fa fa-user-shield fa-fw mr-3"></i>Admin
        </a>
    @endrole

    <a
    href="#"
    class="nav-item nav-link"
    data-toggle="modal"
    data-target="#helpModal">
        <i class="fa fa-question-circle fa-fw mr-3"></i>Help
    </a>

</nav>
