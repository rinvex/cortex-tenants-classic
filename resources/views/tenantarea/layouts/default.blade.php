<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', config('app.name'))</title>

    <!-- Meta Data -->
    @include('cortex/foundation::common.partials.meta')

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ mix('css/vendor.css', 'assets') }}" rel="stylesheet">
    <link href="{{ mix('css/theme-adminlte.css', 'assets') }}" rel="stylesheet">
    <link href="{{ mix('css/theme-pratt.css', 'assets') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css', 'assets') }}" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
        window.Accessarea = "<?php echo request('accessarea'); ?>";
    </script>
</head>
<body @yield('body-attributes')>
    @include('cortex/tenants::tenantarea.partials.header')

    @yield('content')

    @include('cortex/tenants::tenantarea.partials.footer')

    <!-- JavaScripts -->
    <script src="{{ mix('js/manifest.js', 'assets') }}" type="text/javascript"></script>
    <script src="{{ mix('js/vendor.js', 'assets') }}" type="text/javascript"></script>
    @stack('scripts-vendor')
    <script src="{{ mix('js/app.js', 'assets') }}" type="text/javascript"></script>
    @stack('scripts')

    <!-- Alerts -->
    @alerts('default')
</body>
</html>
