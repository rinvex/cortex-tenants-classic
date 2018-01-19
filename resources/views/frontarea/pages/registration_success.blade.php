{{-- Master Layout --}}
@extends('cortex/foundation::frontarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/fort::common.register') }}
@endsection

@section('body-attributes')class="auth-page"@endsection

{{-- Main Content --}}
@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <section class="auth-form" role="auth">

                    <div class="registration-success"></div>

                    <p class="centered">
                        {!! trans('cortex/tenants::common.congratulations', ['username' => $user->username]) !!}<br />
                        {!! trans('cortex/tenants::common.created', ['tenant' => $tenant->name]) !!}<br />
                    </p>

                    <hr />

                    <p class="centered">
                        <strong>{{ trans('cortex/tenants::common.access_links') }}:</strong><br />
                        {{ trans('cortex/tenants::common.dashboard') }}: <a href="{{ route('managerarea.home', ['subdomain' => $tenant->slug]) }}" target="_blank">{{ route('managerarea.home', ['subdomain' => $tenant->slug]) }}</a><br />
                        {{ trans('cortex/tenants::common.homepage') }}: <a href="{{ route('tenantarea.home', ['subdomain' => $tenant->slug]) }}" target="_blank">{{ route('tenantarea.home', ['subdomain' => $tenant->slug]) }}</a><br />
                    </p>

                    @if (config('rinvex.fort.emailverification.required'))
                        <p class="centered"><small><mark>{{ trans('cortex/tenants::common.activation_required') }}</mark></small></p>
                    @endif

                </section>

            </div>

        </div>

    </div>

@endsection
