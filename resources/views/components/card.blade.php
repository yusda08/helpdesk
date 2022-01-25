<div class="card my-3 shadow-lg">
    @if($header)
        <div class="card-header">
            {{ $header }}
        </div>
    @endif
    <div class="card-body">
        {{$slot}}
    </div>
    @if($footer)
        <div class="card-footer">
            {{$footer}}
        </div>
    @endif
</div>
