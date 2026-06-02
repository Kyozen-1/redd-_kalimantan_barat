<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ asset('images/logo_pemprov_kalbar.webp') }}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    {{auth()->user()->name}} <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Selamat Datang !</h6>
                </div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-settings"></i>
                    <span>Settings</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ route('cms.dashboard.index') }}" class="logo logo-dark text-center">
            <span class="logo-lg">
                <img src="{{ asset('images/logo_pemprov_kalbar_text.webp') }}" alt="" height="80">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('images/logo_pemprov_kalbar_text.webp') }}" alt="" height="80">
            </span>
        </a>
        <a href="{{ route('cms.dashboard.index') }}" class="logo logo-light text-center">
            <span class="logo-lg">
                <img src="{{ asset('images/logo_pemprov_kalbar_text.webp') }}" alt="" height="80">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('images/logo_pemprov_kalbar_text.webp') }}" alt="" height="80">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <h4 class="page-title-main">@yield('header', 'Dashboard')</h4>
        </li>

    </ul>

</div>
