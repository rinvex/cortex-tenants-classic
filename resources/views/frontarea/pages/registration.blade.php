{{-- Master Layout --}}
@extends('cortex/foundation::frontarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/fort::common.register') }}
@endsection

{{-- Scripts --}}
@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Fort\Http\Requests\Frontarea\RegistrationProcessRequest::class)->selector("#frontarea-registration-form") !!}

    <script>
        window.countries = {!! $countries !!};
        window.selectedCountry = '{{ old('country_code') }}';
    </script>
@endpush

@section('body-attributes')class="auth-page"@endsection

{{-- Main Content --}}
@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <section class="auth-form">

                    {{ Form::open(['url' => route('frontarea.register.process'), 'id' => 'frontarea-registration-form', 'role' => 'auth']) }}

                        <div class="centered"><strong>{{ trans('cortex/fort::common.account_register') }}</strong></div>

                        <div id="accordion" class="wizard">
                            <div class="panel wizard-step">
                                <div>
                                    <h4 class="wizard-step-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">{{ trans('cortex/tenants::common.user_account') }}</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse in">
                                    <div class="wizard-step-body">

                                        <div class="form-group has-feedback{{ $errors->has('user.username') ? ' has-error' : '' }}">
                                            {{ Form::text('user[username]', old('user.username'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/fort::common.username'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                            @if ($errors->has('user.username'))
                                                <span class="help-block">{{ $errors->first('user.username') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('user.email') ? ' has-error' : '' }}">
                                            {{ Form::email('user[email]', old('user.email'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/fort::common.email'), 'required' => 'required']) }}

                                            @if ($errors->has('user.email'))
                                                <span class="help-block">{{ $errors->first('user.email') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('user.password') ? ' has-error' : '' }}">
                                            {{ Form::password('user[password]', ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/fort::common.password'), 'required' => 'required']) }}

                                            @if ($errors->has('user.password'))
                                                <span class="help-block">{{ $errors->first('user.password') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('user.password_confirmation') ? ' has-error' : '' }}">
                                            {{ Form::password('user[password_confirmation]', ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/fort::common.password_confirmation'), 'required' => 'required']) }}

                                            @if ($errors->has('user.password_confirmation'))
                                                <span class="help-block">{{ $errors->first('user.password_confirmation') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="panel wizard-step">
                                <div role="tab" id="headingTwo">
                                    <h4 class="wizard-step-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">{{ trans('cortex/tenants::common.tenant_details') }}</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="wizard-step-body">

                                        <div class="form-group has-feedback{{ $errors->has('tenant.name') ? ' has-error' : '' }}">
                                            {{ Form::text('tenant[name]', old('tenant.name'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/tenants::common.name'), 'data-slugify' => '[name="tenant\[slug\]"]', 'required' => 'required']) }}

                                            @if ($errors->has('tenant.name'))
                                                <span class="help-block">{{ $errors->first('tenant.name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('tenant.slug') ? ' has-error' : '' }}">
                                            {{ Form::text('tenant[slug]', old('tenant.slug'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/tenants::common.slug'), 'required' => 'required']) }}

                                            @if ($errors->has('tenant.slug'))
                                                <span class="help-block">{{ $errors->first('tenant.slug') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('tenant.email') ? ' has-error' : '' }}">
                                            {{ Form::text('tenant[email]', old('tenant.email'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/tenants::common.email'), 'required' => 'required']) }}

                                            @if ($errors->has('tenant.email'))
                                                <span class="help-block">{{ $errors->first('tenant.email') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('tenant.country_code') ? ' has-error' : '' }}">
                                            {{ Form::hidden('tenant[country_code]', '') }}
                                            {{ Form::select('tenant[country_code]', [], null, ['class' => 'form-control select2 input-lg', 'placeholder' => trans('cortex/tenants::common.select_country'), 'required' => 'required', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                            @if ($errors->has('tenant.country_code'))
                                                <span class="help-block">{{ $errors->first('tenant.country_code') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('tenant.language_code') ? ' has-error' : '' }}">
                                            {{ Form::hidden('tenant[language_code]', '') }}
                                            {{ Form::select('tenant[language_code]', $languages, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/tenants::common.select_language'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                            @if ($errors->has('tenant.language_code'))
                                                <span class="help-block">{{ $errors->first('tenant.language_code') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{ Form::button('<i class="fa fa-user-plus"></i> '.trans('cortex/fort::common.register'), ['class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit']) }}

                        <div>
                            {{ Html::link(route('frontarea.login'), trans('cortex/fort::common.account_login')) }}
                            {{ trans('cortex/foundation::common.or') }}
                            {{ Html::link(route('frontarea.passwordreset.request'), trans('cortex/fort::common.password_reset')) }}
                        </div>

                    {{ Form::close() }}

                </section>

            </div>

        </div>

    </div>

@endsection
