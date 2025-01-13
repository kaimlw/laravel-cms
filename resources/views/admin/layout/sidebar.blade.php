<div class="sidebar-wrapper active">
    <div class="sidebar-header d-flex align-items-center col-gap-3">
        <img src="{{ asset("assets/img/ULM.png") }}" alt="" class="mr-3">
        <h5 class="m-0">
            FKIP CMS
        </h5>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class='sidebar-title'>Main Menu</li>
            <li class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
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
                        <a href="{{ route('admin.post') }}">Semua Post</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.category') }}">Kategori</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.post') }}?type=page" class='sidebar-link'>
                    <i class="bi bi-file-fill"></i>
                    <span>Pages</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.menu') }}" class='sidebar-link'>
                    <i class="bi bi-menu-app-fill"></i>
                    <span>Menu</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="" class='sidebar-link'>
                    <i class="bi bi-images"></i>
                    <span>Media</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="" class='sidebar-link'>
                    <i class="bi bi-person-fill"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="" class='sidebar-link'>
                    <i class="bi bi-gear-fill"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
