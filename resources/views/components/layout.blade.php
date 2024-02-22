<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Welcome, {{ auth()->user()->name ?? 'Guest' }}</title>
    <link rel="stylesheet" href="/css/pico.css"/>
    <link rel="stylesheet" href="/css/pico.colors.css"/>
</head>
<body>
<header class="container">
    <nav>
        <ul>
            @guest
                <li><a href="/">Welcome</a></li>
            @endguest
            @auth
                <li><a href="/wallets"><strong>Wallets</strong></a></li>
            @endauth
        </ul>
        <ul>
            @guest
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            @endguest
            @auth
                <li><a href="javascript:void(0);"
                       onclick="document.getElementById('logout-form').submit();"
                       class="pico-color-red-600">
                        Logout
                    </a>
                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            @endauth
        </ul>
    </nav>
</header>
<main class="container">
    @if (session()->has('success'))
        <div class="container">
            <article>
                <div class="pico-color-green" role="alert">{{ session('success') }}</div>
            </article>
        </div>
    @endif
    {{ $slot }}


</main>
<footer class="container">

</footer>
</body>
</html>
