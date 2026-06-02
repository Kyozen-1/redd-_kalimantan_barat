@extends('auth.login.layouts.app')
@section('title', 'Login | REDD++ Kalimantan Barat')

@section('content')
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <a href="index.html" class="logo">
                            <img src="{{ asset('backend_template/images/logo-light.png') }}" alt="" height="22" class="logo-light mx-auto">
                            <img src="{{ asset('backend_template/images/logo-dark.png') }}" alt="" height="22" class="logo-dark mx-auto">
                        </a>
                        <p class="text-muted mt-2 mb-4">Responsive Admin Dashboard</p>
                    </div>
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Login</h4>
                            </div>
                            @if (session('failed'))
                                <div class="alert alert-danger">{{session('failed')}}</div>
                            @endif
                            <form action="{{ route('login-process') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email address</label>
                                    <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email" name="email">
                                    @error('email')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>

                                    <div class="input-group">
                                        <input class="form-control"
                                            type="password"
                                            id="password"
                                            placeholder="Enter your password"
                                            name="password"
                                            required>

                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" style="cursor:pointer;">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection

@section('js')
    <script>
        $('.toggle-password').click(function () {

            let passwordInput = $('#password');
            let icon = $(this).find('i');

            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }

        });
    </script>
@endsection
