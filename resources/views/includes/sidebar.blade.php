<!-- Bootstrap row -->
<main class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block col-2">
        <!-- d-* hides the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group sticky-top sticky-offset">
            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small class="text-uppercase">Flights</small>
            </li>
            <!-- /END Separator -->
            <!-- Menu with submenu -->
            <a href="#flightsSubmenu" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <i class="fa fa-search fa-fw mr-3"></i>
                    <span class="menu-collapsed">Find Flights</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="flightsSubmenu" class="collapse sidebar-submenu">
                <a href="{{ route('flights.index') }}" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">
                        <i class="fas fa-fw mr-2 fa-table"></i>All Flights
                    </span>
                </a>
            </div>
            <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <i class="fa fa-user fa-fw mr-3"></i>
                    <span class="menu-collapsed">My Flights</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="userSubmenu" class="collapse sidebar-submenu">
                <a href="{{ route('flights.user-flights') }}" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed"><i class="fas fa-fw mr-2 fa-plane"></i>My Requests</span>
                </a>
                <a href="{{ url('/flights/my-flights#createRequestModal') }}" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed"><i class="fas fa-fw mr-2 fa-plus"></i>New Request</span>
                </a>
            </div>
            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>OPTIONS</small>
            </li>
            <!-- /END Separator -->
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
            <!-- Separator without title -->
            <li class="list-group-item sidebar-separator menu-collapsed"></li>
            <!-- /END Separator -->
            <a href="#" class="bg-dark list-group-item list-group-item-action disabled">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <i class="fa fa-question-circle fa-fw mr-3"></i>
                    <span class="menu-collapsed">Help</span>
                </div>
            </a>
            <a href="#" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <i id="collapse-icon" class="fa fa-2x mr-3"></i>
                    <span id="collapse-text" class="menu-collapsed">Collapse</span>
                </div>
            </a>
            <!-- Logo -->
            <li class="list-group-item logo-separator d-flex justify-content-center">
                <img src="/img/icon_circle_light.png" width="30" height="30">
            </li>
        </ul>
        <!-- List Group END-->
    </div>
    <!-- sidebar-container END -->
