<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}} | Helpdesk</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/adminlte.css') }}">
    @stack('after-styles')
    {{$style}}
    <style>
        .table thead tr th {
            text-align: center;
            font-size: 11pt;
            background-color: rgba(168, 165, 170, 0.67);
        }

        .table tbody tr td {
            font-size: 11pt;
        }

        .image {
            position: relative;
            width: 100%;
            overflow: hidden
        }

        .image .overlay {
            position: absolute;
            bottom: 0;
            text-align: center;
            width: 100%;
            color: white;
            font-size: 20px;
            z-index: 5
        }

    </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <x-navbar></x-navbar>
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">{{$ribbon ?? 'Helpdesk'}}</h4>
                </div><!-- /.col -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                {{$slot}}
            </div>
        </div>
    </div>
    <div class="container">
        <footer class="main-footer">
            <div class="d-none d-sm-inline">
                Aplikasi Kinerja Pegawai Kalimantan Selatan
            </div>
            <strong class="float-right ">Copyright © 2021</strong>
        </footer>
    </div>
</div>


@stack('after-script')
{{$script}}
</body>
</html>
