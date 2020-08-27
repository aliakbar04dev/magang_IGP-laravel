<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Q. Anianda -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</title>

    <link rel="shortcut icon" href="{{ asset('images/splash.png') }}"/>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('asset-ops/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-ops/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-ops/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    @include('monitoring.ehs.layouts._flash')
    @yield('content')
    <!-- Scripts -->
    @include ('layouts.script')
    @yield('scripts')
    @include ('layouts.script2')
</body>
</html>