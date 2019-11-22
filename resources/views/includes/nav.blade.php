<div class="container">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home.home') }}">
        </a>
        <div class="navbar-burger burger" data-target="navbarMenuHeroA" onclick="toggleBurger()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div id="navbarMenuHeroA" class="navbar-menu">
        <div class="navbar-end">
            <a class="navbar-item" href="{{ route('home.home') }}">
                Home
            </a>
            @auth
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Hello, {{ Auth::user()->name }}
                    </a>
                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="{{ route('user.profile', ['user' => Auth::user()->username]) }}">
                            My Profile
                        </a>
                        <a class="navbar-item" href="{{ route('user.account') }}">
                            My Account
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" onclick="event.preventDefault(); logout();">
                            Logout
                        </a>
                        <form action="{{ route('auth.logout') }}" method="post" class="is-hidden" id="logout-form">
                            @csrf
                        </form>
                    </div>
                </div>
            @endauth
            @guest
            <a class="navbar-item" href={{ route('auth.auth') }}>
                    Login or Register
            </a>
            @endguest
        </div>
    </div>
</div>