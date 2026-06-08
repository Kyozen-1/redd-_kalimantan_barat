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
                            <i class="mdi mdi-format-list-bulleted"></i>
                            <span> Master Data </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('cms.master-data.wilayah-cakupan.index') }}">Wilayah Cakupan</a></li>
                            <li><a href="{{ route('cms.master-data.lsm.index') }}">LSM</a></li>
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
