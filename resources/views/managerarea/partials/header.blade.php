<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo" data-toggle="push-menu" role="button">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><i class="fa fa-home"></i></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ config('app.name') }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <ul class="nav navbar-nav">
            <li><a href="{{ route('adminarea.home') }}"><i class="fa fa-home"></i> {{ trans('cortex/foundation::common.home') }}</a></li>
        </ul>

        <div class="navbar-custom-menu">
            {!! Menu::render('managerarea.topbar') !!}
        </div>
    </nav>
</header>
