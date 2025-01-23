<nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
            @if (auth()->user()->web_id != 0)
            <li class="mr-2">
                <a href="{{ route('main') }}" class="btn btn-primary"><i class="bi bi-house-door-fill"></i> Halaman Utama</a>
            </li>
            @endif
            
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="avatar mr-1">
                        <img src="{{ asset('assets/img/anon-user.jpg') }}" alt="" srcset="">
                    </div>
                    <div class="d-none d-md-block d-lg-inline-block">Hi, {{ auth()->user()->display_name }}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn text-dark"><i data-feather="log-out"></i> Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>