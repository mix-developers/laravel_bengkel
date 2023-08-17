<!DOCTYPE html>

<html lang="en-us">

@include('layouts.frontend.head')

<body>

    <!-- navigation -->
    <header class="navigation bg-tertiary">
        @include('layouts.frontend.navbar')

    </header>
    <!-- /navigation -->

    @yield('content')
    @include('layouts.frontend.footer')

    <!-- # JS Plugins -->
    <script src="{{ asset('frontend_theme/') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('frontend_theme/') }}/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('frontend_theme/') }}/plugins/slick/slick.min.js"></script>
    <script src="{{ asset('frontend_theme/') }}/plugins/scrollmenu/scrollmenu.min.js"></script>

    <!-- Main Script -->
    <script src="{{ asset('frontend_theme/') }}/js/script.js"></script>
    @stack('js')
</body>

</html>
