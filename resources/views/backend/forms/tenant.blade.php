{{-- Master Layout --}}
@extends('cortex/foundation::backend.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.backend') }} » {{ trans('cortex/tenantable::common.tenants') }} » {{ $tenant->exists ? $tenant->name : trans('cortex/tenantable::common.create_tenant') }}
@stop

@push('scripts')
    {!! JsValidator::formRequest(Cortex\Tenantable\Http\Requests\Backend\TenantFormRequest::class)->selector('#backend-tenants-save') !!}

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

                $("select[name='country_code']").select2({
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
        <section class="content-header">
            <h1>{{ $tenant->exists ? $tenant->name : trans('cortex/tenantable::common.create_tenant') }}</h1>
            <!-- Breadcrumbs -->
            {{ Breadcrumbs::render() }}
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details-tab" data-toggle="tab">{{ trans('cortex/tenantable::common.details') }}</a></li>
                    @if($tenant->exists) <li><a href="{{ route('backend.tenants.logs', ['tenant' => $tenant]) }}">{{ trans('cortex/tenantable::common.logs') }}</a></li> @endif
                    @if($tenant->exists && $currentUser->can('delete-tenants', $tenant)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('backend.tenants.delete', ['tenant' => $tenant]) }}" data-item-name="{{ $tenant->slug }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($tenant->exists)
                            {{ Form::model($tenant, ['url' => route('backend.tenants.update', ['tenant' => $tenant]), 'method' => 'put', 'id' => 'backend-tenants-save']) }}
                        @else
                            {{ Form::model($tenant, ['url' => route('backend.tenants.store'), 'id' => 'backend-tenants-save']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/tenantable::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.name'), 'data-slugify' => '#slug', 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Slug --}}
                                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                        {{ Form::label('slug', trans('cortex/tenantable::common.slug'), ['class' => 'control-label']) }}
                                        {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.slug'), 'required' => 'required']) }}

                                        @if ($errors->has('slug'))
                                            <span class="help-block">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Owner --}}
                                    <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                                        {{ Form::label('owner_id', trans('cortex/tenantable::common.owner'), ['class' => 'control-label']) }}
                                        {{ Form::select('owner_id', $owners, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/tenantable::common.select_owner'), 'required' => 'required', 'data-width' => '100%']) }}

                                        @if ($errors->has('owner_id'))
                                            <span class="help-block">{{ $errors->first('owner_id') }}</span>
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
                                            <span class="help-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Phone --}}
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {{ Form::label('phone', trans('cortex/tenantable::common.phone'), ['class' => 'control-label']) }}
                                        {{ Form::number('phone', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.phone')]) }}

                                        @if ($errors->has('phone'))
                                            <span class="help-block">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Language Code --}}
                                    <div class="form-group{{ $errors->has('language_code') ? ' has-error' : '' }}">
                                        {{ Form::label('language_code', trans('cortex/tenantable::common.language'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('language_code', '') }}
                                        {{ Form::select('language_code', $languages, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/tenantable::common.select_language'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('language_code'))
                                            <span class="help-block">{{ $errors->first('language_code') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Country Code --}}
                                    <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
                                        {{ Form::label('country_code', trans('cortex/tenantable::common.country'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('country_code', '') }}
                                        {{ Form::select('country_code', [], null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/tenantable::common.select_country'), 'required' => 'required', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('country_code'))
                                            <span class="help-block">{{ $errors->first('country_code') }}</span>
                                        @endif
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    {{-- State --}}
                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        {{ Form::label('state', trans('cortex/tenantable::common.state'), ['class' => 'control-label']) }}
                                        {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.state')]) }}

                                        @if ($errors->has('state'))
                                            <span class="help-block">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- City --}}
                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                        {{ Form::label('city', trans('cortex/tenantable::common.city'), ['class' => 'control-label']) }}
                                        {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenantable::common.city')]) }}

                                        @if ($errors->has('city'))
                                            <span class="help-block">{{ $errors->first('city') }}</span>
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
                                            <span class="help-block">{{ $errors->first('postal_code') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Active --}}
                                    <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                        {{ Form::label('is_active', trans('cortex/tenantable::common.active'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_active', [1 => trans('cortex/tenantable::common.yes'), 0 => trans('cortex/tenantable::common.no')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('is_active'))
                                            <span class="help-block">{{ $errors->first('is_active') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Launch Date --}}
                                    <div class="form-group has-feedback{{ $errors->has('launch_date') ? ' has-error' : '' }}">
                                        {{ Form::label('launch_date', trans('cortex/tenantable::common.launch_date'), ['class' => 'control-label']) }}
                                        {{ Form::text('launch_date', null, ['class' => 'form-control datepicker', 'data-auto-update-input' => 'false']) }}
                                        <span class="fa fa-calendar form-control-feedback"></span>

                                        @if ($errors->has('launch_date'))
                                            <span class="help-block">{{ $errors->first('launch_date') }}</span>
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
                                            <span class="help-block">{{ $errors->first('address') }}</span>
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
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
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

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
