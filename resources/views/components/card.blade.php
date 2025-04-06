<div {{$attributes->merge(['class' => 'card'])}} style="min-width: 100px;">
    <div class="card-header">
        <h5 class="m-0">{{$cardTitle}}</h5>
    </div>
    <div class="card-body {{$cardBodyClass}}">
        {{$slot}}
    </div>
</div>