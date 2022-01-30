<div class="row">
    <div class="col-md-6">
        <div class="alert alert-{{$type}} alert-dismissible fade show" id="notif" role="alert">
            <i class="bi {{ $status ?  'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }}"></i>
            <strong> {{$title}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="alert alert-{{$type}} alert-dismissible fade show" id="notif" role="alert">--}}
{{--            <i class="bi {{ $status ?  'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }}"></i>--}}
{{--            <strong> {{$title}}</strong>--}}
{{--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
