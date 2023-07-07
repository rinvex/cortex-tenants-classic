<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', config('app.name'))</title>

    {{-- Meta Data --}}
    @include('cortex/tenants::managerarea.partials.meta')
    @stack('head-elements')

    {{-- Styles --}}
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/theme-managerarea.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('styles')

    {{-- Scripts --}}
    <script>
        window.Laravel = @json(['csrfToken' => csrf_token()]);
        window.Cortex = @json(['accessarea' => request()->accessarea(), 'routeDomains' => default_route_domains()]);
    </script>
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    @stack('vendor-scripts')
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="hold-transition login-page">

    {{-- Main content --}}
    <div id="app" class="wrapper">

        @yield('content')

    </div>

    {{-- Scripts --}}
    @stack('inline-scripts')
    <script src="{{ route('frontarea.cortex.foundation.turbo.js') }}" data-turbolinks-eval="false" data-turbo-eval="false"></script>

    {{-- Alerts --}}
    @alerts('default')
</body>
</html>
