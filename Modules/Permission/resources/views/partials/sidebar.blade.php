<li class="nav-item {{ request()->routeIs('permission.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('permission.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-box-seam-fill"></i>
        <p>
            PERMISSIONS
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('Access Role')
        <li class="nav-item">
            <a href="{{ route('permission.roles.index') }}"
               class="nav-link {{ request()->routeIs('permission.roles.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Roles</p>
            </a>
        </li>
        @endcan
        <li class="nav-item">
            <a href="{{ route('permission.employees.index') }}"
               class="nav-link {{ request()->routeIs('permission.employees.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Employee</p>
            </a>
        </li>
    </ul>
</li>
