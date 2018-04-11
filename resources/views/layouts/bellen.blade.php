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
@yield('nav')

@include('inc.nav')

<div class="app-body">

    <!-- Main content -->
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

            @yield('content')
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