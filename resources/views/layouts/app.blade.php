<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.header')

<body>
    <div id="app">
        @guest

        @else
            @include('partials.nav')
        @endguest

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
