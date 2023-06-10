@if(request()->user()->can('delete', $model) || request()->user()->can('create', $model))
    <div class="pull-right">

        @if (request()->user()->can('create', $model))
            <a href="{{ route("{$routePrefix}.create", ['replicate' => $model->getRouteKey()]) }}" title="{{ trans('cortex/foundation::common.replicate') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-clone text-default"></i></a>
        @endif

        @if (request()->user()->can('delete', $model))
            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
               data-modal-action="{{ route("{$routePrefix}.destroy", [$name => $model]) }}"
               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
               data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => $resource, 'identifier' => $model->getRouteKey()]) }}"
               title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i>
            </a>
        @endif

    </div>
@endif
