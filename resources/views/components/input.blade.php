<div class="mb-3">

    @isset($title)
        <label>{{$title}}</label>
    @endisset
    <input type="{{$type ?? 'text'}}" {{$attr ?? ''}}
    class="form-control {{$name}} {{$class ?? ''}}" name="{{$name}}" value="{{ $value ?? '' }}"
           placeholder="{{ $placeholder ?? '' }}" required>
    @error($name)
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
