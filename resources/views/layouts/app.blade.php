<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}} | Helpdesk</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    @stack('after-styles')
    {{$style}}
</head>
<body>
<x-navbar></x-navbar>
<div class="container mt-2">
    {{$slot}}
</div>
<footer class="footer d-sm-block d-none">
    <div class="container">
        <span class="text-muted">Aplikasi Kinerja Pemerintah Provinsi Kalimantan Selatan.</span>
    </div>
</footer>
<script src="{{ mix('js/app.js') }}"></script>
@stack('after-script')
{{$script}}
</body>
</html>
