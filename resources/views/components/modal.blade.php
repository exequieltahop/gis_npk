<div {{ $attributes->merge(['class' => 'modal fade']) }} id="{{$modalId}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="dialog">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <h5 class="m-0">{{ $modalTitle }}</h5>
            </div>
            <div class="modal-body {{$modalBodyClass}}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>