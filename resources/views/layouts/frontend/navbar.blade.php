<nav class="navbar navbar-expand-xl navbar-light text-center py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img loading="prelaod" decoding="async" class="img-fluid" width="80" src="{{ asset('img/favicon.png') }}"
                alt="Wallet">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span
                class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                {{-- <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li> --}}
            </ul>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-primary ms-2 ms-lg-3">Sign Up</a>
            @else
                @if (Auth::user()->role == 'customer')
                    <a type="button" href="#" class="btn btn-primary ms-2 ms-lg-3 " data-bs-toggle="modal"
                        data-bs-target="#cart">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <style>
                                svg {
                                    fill: #fff
                                }
                            </style>
                            <path
                                d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                        </svg>
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-primary ms-2 ms-lg-3">Akun</a>
                    <a href="{{ route('logout') }}" class="btn btn-danger ms-2 ms-lg-3"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('home') }}" class="btn btn-primary ms-2 ms-lg-3">Dashboard</a>
                    <a href="{{ route('logout') }}" class="btn btn-danger ms-2 ms-lg-3"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endif
            @endguest
        </div>
    </div>
</nav>
