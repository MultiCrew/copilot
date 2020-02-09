<div id="sidebar-container" class="sidebar-expanded d-none d-lg-block col-2">
    <!-- hidden on <=md -->
    <ul class="list-group sticky-top sticky-offset">
        <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
            <small class="text-uppercase">Flights</small>
        </li>

        <a href="{{ route('flights.index') }}" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <span class="menu-collapsed">
                    <i class="fas fa-fw mr-2 fa-search"></i>Find Flights
                </span>
            </div>
        </a>

        <a href="{{ route('flights.user-flights') }}" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <span class="menu-collapsed">
                    <i class="fas fa-fw mr-2 fa-plane"></i>My Flights
                </span>
            </div>
        </a>

        <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
            <small class="text-uppercase">Options</small>
        </li>

        <a href="#" class="bg-dark list-group-item list-group-item-action disabled">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fa fa-id-card fa-fw mr-3"></i>
                <span class="menu-collapsed">Profile</span>
            </div>
        </a>

        <a href="{{ route('account.index') }}" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fa fa-user-cog fa-fw mr-3"></i>
                <span class="menu-collapsed">Account</span>
            </div>
        </a>

        <li class="list-group-item sidebar-separator menu-collapsed"></li>

        <a href="#" class="bg-dark list-group-item list-group-item-action disabled">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <i class="fa fa-question-circle fa-fw mr-3"></i>
                <span class="menu-collapsed">Help</span>
            </div>
        </a>

        <li class="list-group-item logo-separator d-flex justify-content-center">
            <img src="/img/icon_circle_light.png" width="30" height="30">
        </li>

        <!-- Menu with submenu example
            <a href="#flightsSubmenu" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
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
    </ul>
</div>