{{-- Master Layout --}}
@extends('cortex/tenants::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

{{-- Main Content --}}
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                {!! Menu::render($tabs, 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="{{ $id }}-tab">
                        {{ Form::open(['url' => $url, 'class' => 'dropzone', 'id' => "$id-dropzone", 'data-dz-accepted-files' => implode(',', config('cortex.foundation.datatables.imports'))]) }}
                            <div class="dz-message" data-dz-message><span>{{ trans('cortex/foundation::common.drop_to_import') }}</span></div>
                        {{ Form::close() }}
                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
