<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Welcome, {{ auth()->user()->name ?? 'Guest' }}</title>
    <link rel="stylesheet" href="css/pico.css"/>
</head>
<body>
<header class="container">
    <nav>
        <ul>
            <li><strong>Wallet</strong></li>
        </ul>
        <ul>
            @guest
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            @endguest
            @auth
                <li><a href="/profile">Profile</a></li>
                <li><a href="/logout"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>

            @endauth
        </ul>
    </nav>
</header>
<main>

    <h1>layout.blade.php</h1>
    <hr/>
    {{ $slot }}

    @if (session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif
</main>
<footer>
    Footer
</footer>
</body>
</html>
