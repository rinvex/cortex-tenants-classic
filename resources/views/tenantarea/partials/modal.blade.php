<div class="modal overlay fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header{{ isset($hideHeader) ? ' hidden' : '' }}">
                {{ Form::button('<span aria-hidden="true">&times;</span>', ['class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => trans('cortex/foundation::common.close'), 'title' => trans('cortex/foundation::common.close')]) }}
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer{{ isset($hideFooter) ? ' hidden' : '' }}">
                {{ Form::button(trans('cortex/foundation::common.cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) }}
                <span class="modal-button"></span>
            </div>
        </div>
    </div>
</div>
