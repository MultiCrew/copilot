<!-- Bootstrap row -->
<main class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-lg-block col-lg-2">
        <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>COPILOT</small>
            </li>

            <!-- item with submenu -->
            <li>
                <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <i class="fas fa-lg fa-search fa-fw mr-3"></i>
                        <span class="menu-collapsed">Find Flights</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- submenu -->
                <div id='submenu1' class="collapse sidebar-submenu">
                    <a href="{{ route('flights.index') }}" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed"><i class="fas fa-table fa-fw mr-2"></i>All</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed"><i class="fas fa-filter fa-fw mr-2"></i>My Filters</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed"><i class="fas fa-plus fa-fw mr-2"></i>New Filter</span>
                    </a>
                </div>
            </li>

            <li>
                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-lg fa-plane fa-fw mr-3"></span>
                        <span class="menu-collapsed">My Flights</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- submenu -->
                <div id='submenu2' class="collapse sidebar-submenu">
                    <a href="{{ route('flights.user-flights') }}" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed"><i class="fas fa-folder-open fa-fw mr-2"></i>Open Requests</span>
                    </a>
                    <a href="{{ url('/flights/my-flights#createRequestModal' )}}" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed"><i class="fas fa-plus fa-fw mr-2"></i>New Request</span>
                    </a>
                </div>
            </li>

            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>OPTIONS</small>
            </li>

            <li>
                <a href="#" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <i class="fas fa-lg fa-user fa-fw mr-3"></i>
                            <span class="menu-collapsed">Profile</span>
                    </div>
                </a>
            </li>

            <li>
                <a href="#" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <i class="fas fa-lg fa-bell fa-fw mr-3"></i>
                        <span class="menu-collapsed">Notifications <span class="badge badge-pill badge-success ml-2">5</span></span>
                    </div>
                </a>
            </li>

            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed"></li>

            <li>
                <a href="#" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <i class="fas fa-lg fa-question-circle fa-fw mr-3"></i>
                        <span class="menu-collapsed">Help</span>
                    </div>
                </a>
            </li>

            <li>
                <a href="#top" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span id="collapse-icon" class="fa fa-lg mr-3"></span>
                        <span id="collapse-text" class="menu-collapsed">Collapse</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
