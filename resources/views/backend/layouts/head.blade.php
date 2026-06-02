<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Dashboard | REDD++ Kalimantan Barat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="CMS REDD++ Kalimantan Barat" name="description" />
    <meta content="Kita Serba Digital" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend_template/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend_template/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend_template/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend_template/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @yield('css')
</head>
