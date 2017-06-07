{{-- Master Layout --}}
@extends('cortex/foundation::backend.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.backend') }} » {{ trans('cortex/tenantable::common.tenants') }} » {{ $tenant->exists ? $tenant->slug : trans('cortex/tenantable::common.create_tenant') }}
@stop

@push('scripts')
    <script>
        (function($) {
            $(function() {
                var countries = [
                        @foreach($countries as $code => $country)
                    { id: '{{ $code }}', text: '{{ $country['name'] }}', emoji: '{{ $country['emoji'] }}' },
                    @endforeach
                ];

                function formatCountry (country) {
                    if (! country.id) {
                        return country.text;
                    }

                    var $country = $(
                        '<span style="padding-right: 10px">' + country.emoji + '</span>' +
                        '<span>' + country.text + '</span>'
                    );

                    return $country;
                };

                $("[name='country_code']").select2({
                    placeholder: "Select a country",
                    templateSelection: formatCountry,
                    templateResult: formatCountry,
                    data: countries
                }).val('{{ $tenant->country_code }}').trigger('change');

            });
        })(jQuery);
    </script>
@endpush

{{-- Main Content --}}
@section('content')

    @if($tenant->exists)
        @include('cortex/foundation::backend.partials.confirm-deletion', ['type' => 'tenant'])
    @endif

    <div class="content-wrapper">
        <!-- Breadcrumbs -->
        <section class="content-header">
            <h1>{{ $tenant->exists ? $tenant->slug : trans('cortex/tenantable::common.create_tenant') }}</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> {{ trans('cortex/foundation::common.backend') }}</a></li>
                <li><a href="{{ route('backend.tenants.index') }}">{{ trans('cortex/tenantable::common.tenants') }}</a></li>
                <li class="active">{{ $tenant->exists ? $tenant->slug : trans('cortex/tenantable::common.create_tenant') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            @if ($tenant->exists)
                {{ Form::model($tenant, ['url' => route('backend.tenants.update', ['tenant' => $tenant]), 'method' => 'put']) }}
            @else
                {{ Form::model($tenant, ['url' => route('backend.tenants.store')]) }}
            @endif

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#details" data-toggle="tab">{{ trans('cortex/tenantable::common.details') }}</a></li>
                        <li><a href="#social" data-toggle="tab">{{ trans('cortex/tenantable::common.social') }}</a></li>
                        @if($tenant->exists) <li><a href="{{ route('backend.tenants.logs', ['tenant' => $tenant]) }}">{{ trans('cortex/tenantable::common.logs') }}</a></li> @endif
                        @if($tenant->exists && $currentUser->can('delete-tenants', $tenant)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('backend.tenants.delete', ['tenant' => $tenant]) }}" data-item-name="{{ $tenant->slug }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="details">

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/tenantable::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.name'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Slug --}}
                                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                        {{ Form::label('slug', trans('cortex/tenantable::common.slug'), ['class' => 'control-label']) }}
                                        {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.slug'), 'required' => 'required']) }}

                                        @if ($errors->has('slug'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('slug') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Owner --}}
                                    <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                                        {{ Form::label('owner_id', trans('cortex/tenantable::common.owner'), ['class' => 'control-label']) }}
                                        {{ Form::select('owner_id', $owners, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/tenantable::common.owner'), 'required' => 'required']) }}

                                        @if ($errors->has('owner_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('owner_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Email --}}
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        {{ Form::label('email', trans('cortex/tenantable::common.email'), ['class' => 'control-label']) }}
                                        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.email'), 'required' => 'required']) }}

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Phone --}}
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {{ Form::label('phone', trans('cortex/tenantable::common.phone'), ['class' => 'control-label']) }}
                                        {{ Form::number('phone', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.phone')]) }}

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Language Code --}}
                                    <div class="form-group{{ $errors->has('language_code') ? ' has-error' : '' }}">
                                        {{ Form::label('language_code', trans('cortex/tenantable::common.language'), ['class' => 'control-label']) }}
                                        {{ Form::select('language_code', $languages, null, ['class' => 'form-control select2', 'data-allow-clear' => true, 'placeholder' => trans('cortex/tenantable::common.select_language')]) }}
{{--                                        {{ Form::select('language_code', $languages, null, ['class' => 'form-control select2', 'data-allow-clear' => true, 'placeholder' => trans('cortex/tenantable::common.select_language'), 'required' => 'required']) }}--}}

                                        @if ($errors->has('language_code'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('language_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Country Code --}}
                                    <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
                                        {{ Form::label('country_code', trans('cortex/tenantable::common.country'), ['class' => 'control-label']) }}
                                        {{ Form::select('country_code', [], null, ['class' => 'form-control select2', 'data-allow-clear' => true, 'placeholder' => trans('cortex/tenantable::common.select_country'), 'required' => 'required']) }}

                                        @if ($errors->has('country_code'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('country_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    {{-- State --}}
                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        {{ Form::label('state', trans('cortex/tenantable::common.state'), ['class' => 'control-label']) }}
                                        {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.state')]) }}

                                        @if ($errors->has('state'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('state') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- City --}}
                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                        {{ Form::label('city', trans('cortex/tenantable::common.city'), ['class' => 'control-label']) }}
                                        {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.city')]) }}

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Postal Code --}}
                                    <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                        {{ Form::label('postal_code', trans('cortex/tenantable::common.postal_code'), ['class' => 'control-label']) }}
                                        {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.postal_code')]) }}

                                        @if ($errors->has('postal_code'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('postal_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Active --}}
                                    <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                        {{ Form::label('active', trans('cortex/tenantable::common.active'), ['class' => 'control-label']) }}
                                        {{ Form::select('active', [1 => trans('cortex/tenantable::common.yes'), 0 => trans('cortex/tenantable::common.no')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity']) }}

                                        @if ($errors->has('active'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('active') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Launch Date --}}
                                    <div class="form-group{{ $errors->has('launch_date') ? ' has-error' : '' }}">
                                        {{ Form::label('launch_date', trans('cortex/tenantable::common.launch_date'), ['class' => 'control-label']) }}

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>

                                            {{ Form::text('launch_date', null, ['class' => 'form-control datepicker', 'data-auto-update-input' => 'false']) }}
                                        </div>

                                        @if ($errors->has('launch_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('launch_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Address --}}
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        {{ Form::label('address', trans('cortex/tenantable::common.address'), ['class' => 'control-label']) }}
                                        {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.address')]) }}

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Description --}}
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        {{ Form::label('description', trans('cortex/tenantable::common.description'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.description'), 'rows' => 3]) }}

                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="tab-pane" id="social">

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Twitter --}}
                                    <div class="form-group{{ $errors->has('twitter') ? ' has-error' : '' }}">
                                        {{ Form::label('twitter', trans('cortex/tenantable::common.twitter'), ['class' => 'control-label']) }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-twitter"></i>
                                            </div>

                                            {{ Form::text('twitter', null, ['class' => 'form-control']) }}
                                        </div>

                                        @if ($errors->has('twitter'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('twitter') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Facebook --}}
                                    <div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }}">
                                        {{ Form::label('facebook', trans('cortex/tenantable::common.facebook'), ['class' => 'control-label']) }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-facebook"></i>
                                            </div>

                                            {{ Form::text('facebook', null, ['class' => 'form-control']) }}
                                        </div>

                                        @if ($errors->has('facebook'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('facebook') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Linkedin --}}
                                    <div class="form-group{{ $errors->has('linkedin') ? ' has-error' : '' }}">
                                        {{ Form::label('linkedin', trans('cortex/tenantable::common.linkedin'), ['class' => 'control-label']) }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-linkedin"></i>
                                            </div>

                                            {{ Form::text('linkedin', null, ['class' => 'form-control']) }}
                                        </div>

                                        @if ($errors->has('linkedin'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('linkedin') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Google Plus --}}
                                    <div class="form-group{{ $errors->has('google_plus') ? ' has-error' : '' }}">
                                        {{ Form::label('google_plus', trans('cortex/tenantable::common.google_plus'), ['class' => 'control-label']) }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-google-plus"></i>
                                            </div>

                                            {{ Form::text('google_plus', null, ['class' => 'form-control']) }}
                                        </div>

                                        @if ($errors->has('google_plus'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('google_plus') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Skype --}}
                                    <div class="form-group{{ $errors->has('skype') ? ' has-error' : '' }}">
                                        {{ Form::label('skype', trans('cortex/tenantable::common.skype'), ['class' => 'control-label']) }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-skype"></i>
                                            </div>

                                            {{ Form::text('skype', null, ['class' => 'form-control']) }}
                                        </div>

                                        @if ($errors->has('skype'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('skype') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    {{-- Wesbite --}}
                                    <div class="form-group{{ $errors->has('wesbite') ? ' has-error' : '' }}">
                                        {{ Form::label('wesbite', trans('cortex/tenantable::common.website'), ['class' => 'control-label']) }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-globe"></i>
                                            </div>

                                            {{ Form::text('wesbite', null, ['class' => 'form-control']) }}
                                        </div>

                                        @if ($errors->has('wesbite'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('wesbite') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="pull-right">
                                    {{ Form::button(trans('cortex/tenantable::common.reset'), ['class' => 'btn btn-default btn-flat', 'type' => 'reset']) }}
                                    {{ Form::button(trans('cortex/tenantable::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                </div>

                                @include('cortex/foundation::backend.partials.timestamps', ['model' => $tenant])

                            </div>

                        </div>

                    </div>

                </div>

            {{ Form::close() }}

        </section>

    </div>

@endsection
