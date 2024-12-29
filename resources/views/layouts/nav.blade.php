@php
$currentRouteName = Route::currentRouteName();
@endphp

<nav class="navbar navbar-expand-md navbar-dark bg-primary" style="margin-bottom: -15px;">
    <div class="container">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="navbar-brand mb-0 h1">
            <i class="bi-hexagon-fill me-2"></i> Data Master
        </a>

        <!-- Toggler -->
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Menu -->
            <ul class="navbar-nav flex-row flex-wrap">
                <li class="nav-item col-2 col-md-auto">
                    <a href="{{ route('home') }}" class="nav-link @if($currentRouteName == 'home') active @endif">Home</a>
                </li>
                <li class="nav-item col-2 col-md-auto">
                    <a href="{{ route('employees.index') }}" class="nav-link @if($currentRouteName == 'employees.index') active @endif">Employee List</a>
                </li>
            </ul>

            <!-- Divider for Mobile -->
            <hr class="d-md-none text-white-50">

            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <!-- User Dropdown -->
                        <a id="navbarDropdown"
                           class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false"
                           style="text-decoration: none; color: white;">
                            <i class="bi-person-circle me-1" style="color: white;"></i> {{ Auth::user()->name }}
                        </a>

                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- My Profile -->
                            <a class="dropdown-item" href="{{ route('profile') }}" style="color: black;">
                                <i class="bi-person me-1" style="color: black;"></i> My Profile
                            </a>

                            <!-- Garis Abu-Abu Pemisah -->
                            <div style="border-top: 1px solid #d3d3d3; margin: 5px 0;"></div>

                            <!-- Logout -->
                            <a class="dropdown-item" href="{{ route('logout') }}" style="color: red;"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="bi-box-arrow-right me-1" style="color: red;"></i> Logout
                            </a>

                            <!-- Hidden Logout Form -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
