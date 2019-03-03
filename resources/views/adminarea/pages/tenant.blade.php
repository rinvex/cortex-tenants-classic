{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest::class)->selector("#adminarea-tenants-create-form, #adminarea-tenants-{$tenant->getRouteKey()}-update-form")->ignore('.skip-validation') !!}

    <script>
        window.countries = @json($countries);
        window.selectedCountry = '{{ old('country_code', $tenant->country_code) }}';
    </script>
@endpush

{{-- Main Content --}}
@section('content')

    @includeWhen($tenant->exists, 'cortex/foundation::common.partials.modal', ['id' => 'delete-confirmation'])

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @if($tenant->exists && $currentUser->can('delete', $tenant))
                    <div class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                           data-modal-action="{{ route('adminarea.tenants.destroy', ['tenant' => $tenant]) }}"
                           data-modal-title="{!! trans('cortex/foundation::messages.delete_confirmation_title') !!}"
                           data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                           data-modal-body="{!! trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $tenant->name]) !!}"
                           title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>
                @endif
                {!! Menu::render('adminarea.tenants.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($tenant->exists)
                            {{ Form::model($tenant, ['url' => route('adminarea.tenants.update', ['tenant' => $tenant]), 'method' => 'put', 'id' => "adminarea-tenants-{$tenant->getRouteKey()}-update-form", 'files' => true]) }}
                        @else
                            {{ Form::model($tenant, ['url' => route('adminarea.tenants.store'), 'id' => 'adminarea-tenants-create-form', 'files' => true]) }}
                        @endif

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/tenants::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.name'), 'data-slugify' => '[name="slug"]', 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Slug --}}
                                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                        {{ Form::label('slug', trans('cortex/tenants::common.slug'), ['class' => 'control-label']) }}
                                        {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.slug'), 'required' => 'required']) }}

                                        @if ($errors->has('slug'))
                                            <span class="help-block">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Email --}}
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        {{ Form::label('email', trans('cortex/tenants::common.email'), ['class' => 'control-label']) }}
                                        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.email'), 'required' => 'required']) }}

                                        @if ($errors->has('email'))
                                            <span class="help-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Website --}}
                                    <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                                        {{ Form::label('website', trans('cortex/tenants::common.website'), ['class' => 'control-label']) }}
                                        {{ Form::text('website', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.website')]) }}

                                        @if ($errors->has('website'))
                                            <span class="help-block">{{ $errors->first('website') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Phone --}}
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {{ Form::label('phone', trans('cortex/tenants::common.phone'), ['class' => 'control-label']) }}
                                        {{ Form::tel('phone_input', $tenant->phone, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.phone'), 'required' => 'required']) }}

                                        <span class="help-block hide">{{ trans('cortex/foundation::messages.invalid_phone') }}</span>
                                        @if ($errors->has('phone'))
                                            <span class="help-block">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Language Code --}}
                                    <div class="form-group{{ $errors->has('language_code') ? ' has-error' : '' }}">
                                        {{ Form::label('language_code', trans('cortex/tenants::common.language'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('language_code', '', ['class' => 'skip-validation', 'id' => 'language_code_hidden']) }}
                                        {{ Form::select('language_code', $languages, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/tenants::common.select_language'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('language_code'))
                                            <span class="help-block">{{ $errors->first('language_code') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Country Code --}}
                                    <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
                                        {{ Form::label('country_code', trans('cortex/tenants::common.country'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('country_code', '', ['class' => 'skip-validation', 'id' => 'country_code_hidden']) }}
                                        {{ Form::select('country_code', [], null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/tenants::common.select_country'), 'required' => 'required', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('country_code'))
                                            <span class="help-block">{{ $errors->first('country_code') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- State --}}
                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        {{ Form::label('state', trans('cortex/tenants::common.state'), ['class' => 'control-label']) }}
                                        {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.state')]) }}

                                        @if ($errors->has('state'))
                                            <span class="help-block">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- City --}}
                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                        {{ Form::label('city', trans('cortex/tenants::common.city'), ['class' => 'control-label']) }}
                                        {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.city')]) }}

                                        @if ($errors->has('city'))
                                            <span class="help-block">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Postal Code --}}
                                    <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                        {{ Form::label('postal_code', trans('cortex/tenants::common.postal_code'), ['class' => 'control-label']) }}
                                        {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.postal_code')]) }}

                                        @if ($errors->has('postal_code'))
                                            <span class="help-block">{{ $errors->first('postal_code') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Is Active --}}
                                    <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                        {{ Form::label('is_active', trans('cortex/tenants::common.is_active'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_active', [1 => trans('cortex/tenants::common.yes'), 0 => trans('cortex/tenants::common.no')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                        @if ($errors->has('is_active'))
                                            <span class="help-block">{{ $errors->first('is_active') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Launch Date --}}
                                    <div class="form-group has-feedback{{ $errors->has('launch_date') ? ' has-error' : '' }}">
                                        {{ Form::label('launch_date', trans('cortex/tenants::common.launch_date'), ['class' => 'control-label']) }}
                                        {{ Form::text('launch_date', null, ['class' => 'form-control datepicker', 'data-locale' => '{"format": "YYYY-MM-DD"}', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                                        <span class="fa fa-calendar form-control-feedback"></span>

                                        @if ($errors->has('launch_date'))
                                            <span class="help-block">{{ $errors->first('launch_date') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Style --}}
                                    <div class="form-group{{ $errors->has('style') ? ' has-error' : '' }}">
                                        {{ Form::label('style', trans('cortex/tenants::common.style'), ['class' => 'control-label']) }}
                                        {{ Form::text('style', null, ['class' => 'form-control style-picker', 'placeholder' => trans('cortex/tenants::common.style'), 'data-placement' => 'bottomRight', 'readonly' => 'readonly']) }}

                                        @if ($errors->has('style'))
                                            <span class="help-block">{{ $errors->first('style') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Tags --}}
                                    <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                                        {{ Form::label('tags[]', trans('cortex/tenants::common.tags'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('tags', '', ['class' => 'skip-validation']) }}
                                        {{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'data-width' => '100%', 'data-tags' => 'true']) }}

                                        @if ($errors->has('tags'))
                                            <span class="help-block">{{ $errors->first('tags') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Profile Picture --}}
                                    <div class="form-group has-feedback{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                                        {{ Form::label('profile_picture', trans('cortex/tenants::common.profile_picture'), ['class' => 'control-label']) }}

                                        <div class="input-group">
                                            {{ Form::text('profile_picture', null, ['class' => 'form-control file-name', 'placeholder' => trans('cortex/tenants::common.profile_picture'), 'readonly' => 'readonly']) }}

                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    {{ trans('cortex/tenants::common.browse') }}
                                                    {{ Form::file('profile_picture', ['class' => 'form-control', 'id' => 'profile_picture_browse']) }}
                                                </span>
                                            </span>
                                        </div>

                                        @if ($tenant->exists && $tenant->getMedia('profile_picture')->count())
                                            <i class="fa fa-paperclip"></i>
                                            <a href="{{ $tenant->getFirstMediaUrl('profile_picture') }}" target="_blank">{{ $tenant->getFirstMedia('profile_picture')->file_name }}</a> ({{ $tenant->getFirstMedia('profile_picture')->human_readable_size }})
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                                               data-modal-action="{{ route('adminarea.tenants.media.destroy', ['tenant' => $tenant, 'media' => $tenant->getFirstMedia('profile_picture')]) }}"
                                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                                               data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => $tenant->getFirstMedia('profile_picture')->file_name]) }}"
                                               title="{{ trans('cortex/foundation::common.delete') }}"><i class="fa fa-trash text-danger"></i></a>
                                        @endif

                                        @if ($errors->has('profile_picture'))
                                            <span class="help-block">{{ $errors->first('profile_picture') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Cover Photo --}}
                                    <div class="form-group has-feedback{{ $errors->has('cover_photo') ? ' has-error' : '' }}">
                                        {{ Form::label('cover_photo', trans('cortex/tenants::common.cover_photo'), ['class' => 'control-label']) }}

                                        <div class="input-group">
                                            {{ Form::text('cover_photo', null, ['class' => 'form-control file-name', 'placeholder' => trans('cortex/tenants::common.cover_photo'), 'readonly' => 'readonly']) }}

                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    {{ trans('cortex/tenants::common.browse') }}
                                                    {{ Form::file('cover_photo', ['class' => 'form-control', 'id' => 'cover_photo_browse']) }}
                                                </span>
                                            </span>
                                        </div>

                                        @if ($tenant->exists && $tenant->getMedia('cover_photo')->count())
                                            <i class="fa fa-paperclip"></i>
                                            <a href="{{ $tenant->getFirstMediaUrl('cover_photo') }}" target="_blank">{{ $tenant->getFirstMedia('cover_photo')->file_name }}</a> ({{ $tenant->getFirstMedia('cover_photo')->human_readable_size }})
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                                               data-modal-action="{{ route('adminarea.tenants.media.destroy', ['tenant' => $tenant, 'media' => $tenant->getFirstMedia('cover_photo')]) }}"
                                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                                               data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => $tenant->getFirstMedia('cover_photo')->file_name]) }}"
                                               title="{{ trans('cortex/foundation::common.delete') }}"><i class="fa fa-trash text-danger"></i></a>
                                        @endif

                                        @if ($errors->has('cover_photo'))
                                            <span class="help-block">{{ $errors->first('cover_photo') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Currency --}}
                                    <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
                                        {{ Form::label('currency', trans('cortex/tenants::common.currency'), ['class' => 'control-label']) }}
                                        {{ Form::text('currency', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.currency'), 'required' => 'required']) }}

                                        @if ($errors->has('currency'))
                                            <span class="help-block">{{ $errors->first('currency') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Timezone --}}
                                    <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
                                        {{ Form::label('timezone', trans('cortex/tenants::common.timezone'), ['class' => 'control-label']) }}
                                        {{ Form::text('timezone', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.timezone'), 'required' => 'required']) }}

                                        @if ($errors->has('timezone'))
                                            <span class="help-block">{{ $errors->first('timezone') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    {{-- Address --}}
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        {{ Form::label('address', trans('cortex/tenants::common.address'), ['class' => 'control-label']) }}
                                        {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.address')]) }}

                                        @if ($errors->has('address'))
                                            <span class="help-block">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Twitter --}}
                                    <div class="form-group{{ $errors->has('social.twitter') ? ' has-error' : '' }}">
                                        {{ Form::label('social[twitter]', trans('cortex/tenants::common.twitter'), ['class' => 'control-label']) }}
                                        {{ Form::text('social[twitter]', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.twitter')]) }}

                                        @if ($errors->has('social.twitter'))
                                            <span class="help-block">{{ $errors->first('social.twitter') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Facebook --}}
                                    <div class="form-group{{ $errors->has('social.facebook') ? ' has-error' : '' }}">
                                        {{ Form::label('social[facebook]', trans('cortex/tenants::common.facebook'), ['class' => 'control-label']) }}
                                        {{ Form::text('social[facebook]', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.facebook')]) }}

                                        @if ($errors->has('social.facebook'))
                                            <span class="help-block">{{ $errors->first('social.facebook') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Linkedin --}}
                                    <div class="form-group{{ $errors->has('social.linkedin') ? ' has-error' : '' }}">
                                        {{ Form::label('social[linkedin]', trans('cortex/tenants::common.linkedin'), ['class' => 'control-label']) }}
                                        {{ Form::text('social[linkedin]', null, ['class' => 'form-control', 'placeholder' => trans('cortex/tenants::common.linkedin')]) }}

                                        @if ($errors->has('social.linkedin'))
                                            <span class="help-block">{{ $errors->first('social.linkedin') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Description --}}
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        {{ Form::label('description', trans('cortex/tenants::common.description'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control tinymce', 'placeholder' => trans('cortex/tenants::common.description'), 'rows' => 3]) }}

                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/tenants::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::adminarea.partials.timestamps', ['model' => $tenant])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
