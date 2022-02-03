@php($log = (array)\App\Helpers\CookieHelper::logAccess())
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-warning shadow-lg">
    <div class="container">
        <div class="navbar-header">
            <img src="/images/logo.png" class="me-2" height="30" loading="lazy"/>
            <a class="navbar-brand" href="{{\App\Providers\RouteServiceProvider::HOME}}">APIK</a>
        </div>
        {{--        <a class="navbar-brand" href="#">Navbar</a>--}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                @foreach($navbar as $name => $url)
                    <li class="nav-item">
                        <a style="color: black; font-weight: bold" class="nav-link" href="{{$url}}">{{ $name }}</a>
                    </li>
                @endforeach
            </ul>
            <ul class="navbar-nav d-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        @isset($log)
                            @if(array_key_exists('pegawai',$log))
                                {{$log['pegawai']->nama}}
                            @else
                                {{$log['administrator']->name}}
                            @endif
                        @endisset

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            {{--                            <form action="{{route('logout')}}" method="post">--}}
                            {{--                                @csrf--}}
                            {{--                                <button class="dropdown-item btn-logout">logout</button>--}}
                            {{--                            </form>--}}
                            <button data-url="{{ route('logout') }}" class="dropdown-item btn-logout">logout</button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
