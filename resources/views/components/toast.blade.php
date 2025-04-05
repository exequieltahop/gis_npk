@props(['type'=> 'primary', 'toasttype' => ''])

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast text-bg-{{$type}}" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            <div class="d-flex justify-content-between p-2">
                <strong style="text-transform: uppercase;">
                    {{$slot}}
                </strong>
                <button class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="close"></button>
            </div>
        </div>
    </div>
</div>