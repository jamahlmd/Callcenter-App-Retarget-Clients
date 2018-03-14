<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('/img/resellivit-favicon.png')}}" sizes="16x16">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Resellivit</title>
    <!-- Main styles for this application -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
@yield('loader')

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{url('home')}}"><img class="img-responsive header-logo ml-3" src="{{asset('/img/resellivit-header.png')}}"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

        </ul>
        <ul class="navbar-nav">
            @guest
            <li class="nav-link" ><a  href="{{ route('login') }}">Login</a></li>
            <li class="nav-link"><a  href="{{ route('register') }}">Register</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        {{ Auth::user()->email }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        @endguest
                    </ul>
        </ul>
    </div>
</nav>

        @if($flash = session('succes'))
            <div class="alert alert-success">
                {{$flash}}
            </div>
        @endif
        @if($flash = session('danger'))
            <div class="alert alert-danger">
                {{$flash}}
            </div>
        @endif

        @if(count($errors) )
            <div class="alert alert-danger">
                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{$error}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


<div id="root">
    @yield('content')
</div>

<footer class="footer">
    <div class="container text-right">
        <span>&copy;<img class="footer-logo" src="{{asset('/img/resellivit-footer.png')}}"></span>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/layout.js') }}"></script>
@yield('scripts')


</body>
</html>