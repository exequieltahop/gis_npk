<div {{$attributes->merge(['class' => 'card'])}}>
    <div class="card-header">
        <h5 class="m-0">{{$cardTitle}}</h5>
    </div>
    <div class="card-body {{$cardBodyClass}}">
        {{$slot}}
    </div>
</div>