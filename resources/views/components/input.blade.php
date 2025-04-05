@props(['step' => ''])
<div {{$attributes->merge(['class' => 'mb-3'])}}>
    <label for="{{$id}}" class="text-uppercase mb-1" style="font-size: 0.9rem;">{{$label}}</label>
    <input type="{{$type}}" class="form-control {{$inputClass}}" id="{{$id}}" name="{{$name}}" placeholder="" step="{{$step}}" value="{{$value}}" {{$required ? 'required' : ''}}>
</div>
