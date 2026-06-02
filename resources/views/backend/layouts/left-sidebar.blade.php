<div class="left-side-menu">

    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">
                @if (auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
                    <li>
                        <a href="{{ route('cms.dashboard.index') }}">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role == 'superadmin')
                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-page-layout-sidebar-left"></i>
                            <span> Layouts </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="layouts-horizontal.html">Horizontal</a></li>
                            <li><a href="layouts-sidebar-sm.html">Small Sidebar</a></li>
                            <li><a href="layouts-dark-sidebar.html">Dark Sidebar</a></li>
                            <li><a href="layouts-dark-topbar.html">Dark Topbar</a></li>
                            <li><a href="layouts-preloader.html">Preloader</a></li>
                            <li><a href="layouts-sidebar-collapsed.html">Sidebar Collapsed</a></li>
                            <li><a href="layouts-boxed.html">Boxed</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
