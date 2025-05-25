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
            <li class="sidebar-item">
                <a href="{{ route('admin.user') }}" class='sidebar-link'>
                    <i class="bi bi-person-fill"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.web') }}" class='sidebar-link'>
                    <i class="bi bi-globe2"></i>
                    <span>Web</span>
                </a>
            </li>
            <li class="sidebar-item has-sub">
                <a href="" class='sidebar-link'>
                    <i class="bi bi-file-fill"></i>
                    <span>Web Default</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.default.page') }}">Page</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.default.category') }}">Category</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.default.menu') }}">Menu</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
