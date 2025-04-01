<div {{$attributes->merge(['class' => 'form-floating mb-3'])}}>
    <input type="{{$type}}" class="form-control {{$inputClass}}" id="{{$id}}" name="{{$name}}" placeholder="" {{$required ? 'required' : ''}}>
    <label for="{{$name}}">{{$label}}</label>
</div>