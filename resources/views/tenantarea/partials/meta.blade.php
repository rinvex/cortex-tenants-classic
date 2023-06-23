{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Basic Meta --}}
<meta name="title" content="@yield('meta-title', 'Rinvex - Enterprise Solutions for SMEs')" />
<meta name="headline" content="@yield('meta-headline', 'Rinvex - Enterprise Solutions for SMEs')" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="@yield('meta-description', 'Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016.')" />
<meta name="keywords" content="@yield('meta-keywords', 'Rinvex Integrated Enterprise Software Solutions SMEs Opesource Laravel Package')" />
<meta name="author" content="@yield('meta-author', config('app.name'))" />
<meta name="kind" content="SMEs & Developers" />
<meta name="generator" content="@yield('meta-generator', config('app.name'))" />
<meta name="copyright" content="{!! config('app.copyright') !!}" />
<meta name="subject" content="Enterprise Solutions for SMEs" />
<meta name="coverage" content="Worldwide" />
<meta name="directory" content="submission" />
<meta name="distribution" content="Global" />
<meta name="rating" content="General" />
<meta name="target" content="all" />
<meta name="HandheldFriendly" content="true" />
<meta name="original" content="yes" />
<meta name="language" content="English" />
<meta name="robots" content="index, follow" />
<meta name="revisit-after" CONTENT="0 days" />
<meta name="identifier" content="{{ request()->url() }}" />
<meta name="identifier-URL" content="{{ request()->url() }}" />
<link rel="canonical" href="{{ request()->url() }}" />


{{-- Vendor Meta --}}
<meta name="googlebot" content="index, follow" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />

{{-- Favicon --}}
<link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}" />
<link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}" />
<link rel="fluid-icon" title="Rinvex" href="{{ asset('images/favicon/favicon.png') }}" />
<link rel="mask-icon" href="{{ asset('images/favicon/favicon.svg') }}" color="#4078c0" />
<link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-icon-120x120.png') }}" />
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicon/apple-icon-57x57.png') }}" />
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicon/apple-icon-60x60.png') }}" />
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon/apple-icon-72x72.png') }}" />
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon/apple-icon-76x76.png') }}" />
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon/apple-icon-114x114.png') }}" />
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon/apple-icon-120x120.png') }}" />
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/apple-icon-144x144.png') }}" />
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-icon-152x152.png') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-icon-180x180.png') }}" />
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon/android-icon-192x192.png') }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}" />
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}" />
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}" />
<link rel="manifest" href="{{ asset('manifest.json') }}" />
<meta name="msapplication-TileColor" content="#ffffff" />
<meta name="msapplication-TileImage" content="{{ asset('images/favicon/ms-icon-144x144.png') }}" />
<meta name="theme-color" content="#ffffff" />

{{-- Open Graph --}}
<meta property="og:locale" content="en_US" />
<meta property="og:url" content="https://rinvex.com" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="@yield('meta-site-name', config('app.name'))" />
<meta property="og:title" content="@yield('meta-title', 'Rinvex - Enterprise Solutions for SMEs')" />
<meta property="og:description" content="@yield('meta-description', 'Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016.')" />
<meta property="og:image" content="@yield('meta-image', asset('images/favicon/favicon-1500x1500.png'))" />
<meta property="og:image:type" content="image/png" />
<meta property="og:image:width" content="1500" />
<meta property="og:image:height" content="1500" />
<meta name="og:email" content="help@rinvex.com" />
<meta name="og:phone_number" content="+20-122-816-0181" />

<meta name="og:latitude" content="31.2467601" />
<meta name="og:longitude" content="29.9020376" />
<meta name="og:street-address" content="16 Ibrahim Nosir Street" />
<meta name="og:locality" content="Louran" />
<meta name="og:region" content="Alexandria" />
<meta name="og:postal-code" content="21532" />
<meta name="og:country-name" content="Egypt" />

{{-- Twitter Card --}}
<meta property="twitter:site" content="@rinvex" />
<meta property="twitter:site:id" content="1711790082" />
<meta property="twitter:creator" content="@omranic" />
<meta property="twitter:creator:id" content="19497181" />
<meta property="twitter:card" content="summary" />
<meta property="twitter:title" content="@yield('meta-title', 'Rinvex - Enterprise Solutions for SMEs')" />
<meta property="twitter:description" content="@yield('meta-description', 'Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016.')" />
<meta property="twitter:image:src" content="@yield('meta-image', asset('images/favicon/favicon-512x512.png'))" />
<meta property="twitter:image:width" content="512" />
<meta property="twitter:image:height" content="512" />
