{{-- Master Layout --}}
@extends('cortex/tenants::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.managerarea') }} » {{ $phrase }} » {{ $resource->name }} » {{ trans('cortex/foundation::common.logs') }}
@endsection

{{-- Main Content --}}
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="nav-tabs-custom">
                {!! Menu::render("{$tabs}", 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="logs-tab">
                        {!! $dataTable->table(['class' => 'table table-striped table-hover responsive dataTableBuilder', 'id' => "{$id}"]) !!}
                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

@push('head-elements')
    <meta name="turbolinks-cache-control" content="no-cache">
@endpush

@push('styles')
    <link href="{{ mix('css/datatables.css', 'assets') }}" rel="stylesheet">
@endpush

@push('vendor-scripts')
    <script src="{{ mix('js/datatables.js', 'assets') }}" defer></script>
@endpush

@push('inline-scripts')
    {!! $dataTable->scripts() !!}
@endpush
