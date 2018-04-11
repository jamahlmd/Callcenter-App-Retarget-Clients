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

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
@yield('loader')
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/home') }}"><img class="img-responsive header-logo ml-3" src="{{asset('/img/resellivit-header.png')}}"></a>
@include('inc.nav')

<div class="app-body">
    <div class="sidebar bg-light">
        <nav class="sidebar-nav">
            <ul class="nav pt-5">
                @teamleider
                <li class="nav-title">
                    <i class="far fa-money-bill-alt"></i>
                    Exact / Hubspot import
                </li>
                <li class="nav-item">
                    <a href="{{url('exact/login')}}" class="nav-link"><i class="icon-drop"></i>Importeer klanten</a>
                </li>
                @endteamleider

                {{--<li class="nav-title">--}}
                    {{--<i class="far fa-money-bill-alt"></i>--}}
                    {{--Hubspot--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="{{url('hubspot/login')}}" class="nav-link"><i class="icon-drop"></i>Hubspot login</a>--}}
                {{--</li>--}}
                <li class="nav-title">
                    <i class="fas fa-phone"></i>
                    Bellen
                </li>
                @teamleider
                <li class="nav-item">
                    <a href="{{url('import')}}" class="nav-link"><i class="icon-drop"></i>Importeer lijsten</a>
                </li>
                @endteamleider
                <li class="nav-item">
                    <a href="{{url('bellijstkiezen')}}" class="nav-link"><i class="icon-drop"></i>Bellijst kiezen</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Base</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="base/breadcrumb.html"><i class="icon-puzzle"></i> Breadcrumb</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-cursor"></i> Buttons</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="buttons/buttons.html"><i class="icon-cursor"></i> Buttons</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="buttons/button-group.html"><i class="icon-cursor"></i> Buttons Group</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="buttons/dropdowns.html"><i class="icon-cursor"></i> Dropdowns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="buttons/social-buttons.html"><i class="icon-cursor"></i> Social Buttons</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main content -->
    <main class="main pb-5">
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

        <div class="mt-4 pt-5">
            @yield('content')
        </div>
    </main>
</div>

<footer class="footer fixed-bottom">
    <div class="container text-right">
        <span>&copy;<img class="footer-logo" src="{{asset('/img/resellivit-footer.png')}}"></span>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/layout.js') }}"></script>
@yield('scripts')


</body>
</html>