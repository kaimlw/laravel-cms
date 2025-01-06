<div class="sidebar-wrapper active">
    {{-- <div class="sidebar-header d-flex align-items-center">
        <img src="{{ asset('img/balangan.png') }}" alt="" srcset="">
        <h5>
            Dashboard Admin - Website Desa
        </h5>
    </div> --}}
    <div class="sidebar-menu">
        <ul class="menu">
                <li class='sidebar-title'>Main Menu</li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.main') }}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="" class='sidebar-link'>
                        <i class="bi bi-pin-angle-fill"></i>
                        <span>Posts</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('dashboard.post') }}">Semua Post</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.category') }}">Kategori</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.post') }}?type=page" class='sidebar-link'>
                        <i class="bi bi-file-fill"></i>
                        <span>Pages</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.menu') }}" class='sidebar-link'>
                        <i class="bi bi-menu-app-fill"></i>
                        <span>Menu</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.media') }}" class='sidebar-link'>
                        <i class="bi bi-images"></i>
                        <span>Media</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.user') }}" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.setting') }}" class='sidebar-link'>
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                </li>



                {{-- <li class="sidebar-item active has-sub">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="briefcase" width="20"></i> 
                        <span>Extra Components</span>
                    </a>
                    
                    <ul class="submenu active">
                        
                        <li>
                            <a href="component-extra-avatar.html">Avatar</a>
                        </li>
                        
                        <li>
                            <a href="component-extra-divider.html">Divider</a>
                        </li>
                        
                    </ul>
                    
                </li> --}}

        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
