<div {{$attributes->merge(['class' => 'mb-3'])}}>
    <label for="{{$id}}" class="text-uppercase mb-1" style="font-size: 0.9rem;">{{$label}}</label>
    <select name="{{$id}}" id="{{$id}}" class="form-select" {{$required ? 'required' : ''}}>
        {{$slot}}
    </select>
</div>
