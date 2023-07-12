{{-- Master Layout --}}
@extends('cortex/tenants::tenantarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

{{-- Main Content --}}
@section('content')

    <div class="container">

        <div class="row profile">
            <div class="col-md-3">
                @include('cortex/auth::tenantarea.partials.sidebar')
            </div>

            <div class="col-md-9">

                <div class="profile-content">

                    <nav aria-label="breadcrumb">
                        {{ Breadcrumbs::render() }}
                    </nav>

                    @yield('datatable-filters')
                    {!! $dataTable->pusher($pusher ?? null)->routePrefix($routePrefix ?? null)->table(['id' => $id]) !!}

                </div>
            </div>
        </div>

    </div>

@endsection

@push('styles')
    <link href="{{ mix('css/datatables.css') }}" rel="stylesheet">
@endpush

@push('vendor-scripts')
    <script src="{{ mix('js/datatables.js') }}" defer></script>
@endpush

@push('inline-scripts')
    {!! $dataTable->scripts() !!}
@endpush
