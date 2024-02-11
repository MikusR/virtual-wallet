<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ $title ?? 'L' }}</title>
</head>
<body style="background-color: aquamarine">
<h1>layout.blade.php</h1>
<hr/>
{{ $slot }}

@if (session()->has('success'))
    <p>{{ session('success') }}</p>
@endif
</body>
</html>
