<div style="padding-top: 5px;">
    @if($model->exists)
        @if($model->created_at)
            <small>
                <strong>{{ trans('cortex/foundation::common.created_at') }}:</strong>
                <time datetime="{{ $model->created_at }}">{{ $model->created_at->format(config('app.date_format')) }}</time>
            </small>
        @endif

        @if($model->created_at && $model->updated_at) | @endif

        @if($model->updated_at)
            <small>
                <strong>{{ trans('cortex/foundation::common.updated_at') }}:</strong>
                <time datetime="{{ $model->updated_at }}">{{ $model->updated_at->format(config('app.date_format')) }}</time>
            </small>
        @endif
    @endif
</div>
