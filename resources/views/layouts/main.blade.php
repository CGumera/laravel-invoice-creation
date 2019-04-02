<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body>
        <header>
            @include('layouts.partials.header')
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            @include('layouts.partials.footer')
        </footer>
    </body>
</html>
