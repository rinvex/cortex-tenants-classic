<div id="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('tenantarea.home') }}"><b>{{ app('request.tenant')->name }}</b></a>
        </div>
        <div class="navbar-collapse collapse">
            {!! Menu::render('tenantarea.header.navigation') !!}

            <div class="navbar-right">
                {!! Menu::render('tenantarea.header.language') !!}
                {!! Menu::render('tenantarea.header.user') !!}
            </div>
        </div>
    </div>
</div>
