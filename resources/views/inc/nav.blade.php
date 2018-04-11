
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
                        @teamleider
                        <li>
                            <a class="dropdown-item" href="{{url('import')}}">Importeer lijsten</a>
                        </li>
                        @endteamleider
                        <li>
                            <a class="dropdown-item" href="{{url('bellijstkiezen')}}">Bellijst kiezen</a>
                        </li>
                        @endguest
                    </ul>
        </ul>
    </div>
</nav>