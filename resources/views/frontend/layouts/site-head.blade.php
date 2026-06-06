<head>
    <meta charset="utf-8">
    <title>@yield('title', 'REDD+ Kalimantan Barat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Portal resmi REDD+ Kalimantan Barat')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('backend_template/images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend_template/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}">
    @stack('styles')
</head>
