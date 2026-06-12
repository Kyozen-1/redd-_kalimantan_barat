<!DOCTYPE html>
<html lang="en">
    @include('backend.layouts.head')
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
                @include('backend.layouts.topbar')
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                @include('backend.layouts.left-sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        @yield('content')

                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <!-- Footer Start -->
                    @include('backend.layouts.footer')
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        @include('backend.layouts.js')
        @include('sweetalert::alert')
    </body>
</html>
