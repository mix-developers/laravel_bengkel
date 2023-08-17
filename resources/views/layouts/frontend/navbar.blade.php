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
                    <a href="{{ route('home') }}" class="btn btn-primary ms-2 ms-lg-3">Akun</a>
                @else
                    <a href="{{ route('home') }}" class="btn btn-primary ms-2 ms-lg-3">Dashboard</a>
                @endif
            @endguest
        </div>
    </div>
</nav>
