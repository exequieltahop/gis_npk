<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-$classType"]) }}>
    {{$slot}}
</button>