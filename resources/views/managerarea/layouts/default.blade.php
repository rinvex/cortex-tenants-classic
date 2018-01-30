<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', config('app.name'))</title>

    {{-- Meta Data --}}
    @include('cortex/foundation::common.partials.meta')
    @stack('head-elements')

    {{-- Styles --}}
    <link href="{{ mix('css/vendor.css', 'assets') }}" rel="stylesheet">
    <link href="{{ mix('css/theme-adminarea.css', 'assets') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css', 'assets') }}" rel="stylesheet">
    @stack('styles')

    {{-- Scripts --}}
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
        window.Accessarea = "<?php echo request('accessarea'); ?>";
    </script>
    <script src="{{ mix('js/manifest.js', 'assets') }}" defer></script>
    <script src="{{ mix('js/vendor.js', 'assets') }}" defer></script>
    @stack('vendor-scripts')
    <script src="{{ mix('js/app.js', 'assets') }}" defer></script>
</head>
<body class="hold-transition skin-green fixed sidebar-mini">
    {{-- Main content --}}
    <div class="wrapper">
        @include('cortex/tenants::managerarea.partials.header')
        @include('cortex/tenants::managerarea.partials.sidebar')

        @yield('content')

        @include('cortex/tenants::managerarea.partials.footer')
    </div>

    {{-- Scripts --}}
    @stack('inline-scripts')

    {{-- Alerts --}}
    @alerts('default')
</body>
</html>
