<h1>Admin</h1>

<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a
        href="{{ route('admin.users.index') }}"
        class="nav-link @if(Route::currentRouteName() === 'admin.users.index') active @endif">
            <i class="fas fa-users mr-2"></i>
            Users
        </a>
    </li>
    <li class="nav-item">
        <a
        href="{{ route('admin.applications.index') }}"
        class="nav-link @if(Route::currentRouteName() === 'admin.applications.index') active @endif">
            <i class="fas fa-file-signature mr-2"></i>
            Applications
        </a>
    </li>
</ul>
