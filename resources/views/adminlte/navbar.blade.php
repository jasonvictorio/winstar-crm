<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>


    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <div class="position-relative ml-auto mr-2">
        <button class="d-flex align-items-center navbar-user-button" data-toggle="dropdown">
            <span class="mr-2">{{ Auth::user()->name }}</span>
            <div class="navbar-avatar">
                <img src="{{ URL::to('/') }}/storage/uploads/user/{{ Auth::user()->avatar }}" alt="">
            </div>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <span class="dropdown-item">
                Company: {{ Auth::user()->company_id }}
            </span>
            <span class="dropdown-item mb-2">
                Role: {{ Auth::user()->role_id }}
            </span>
            <a href="#" class="dropdown-item">
                <i class="fas fa-lock mr-2"></i> {{ __('Change Password') }}
            </a>
            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Logout') }}
            </a>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
<!-- /.navbar -->
