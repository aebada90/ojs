<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Oktoberfest') | Oktoberfest</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-100 text-stone-900 antialiased" style="font-family: 'DM Sans', system-ui, sans-serif;">
    <header class="border-b border-stone-200 bg-white">
        <div class="mx-auto flex max-w-3xl items-center justify-between px-4 py-4">
            <a href="{{ url('/') }}" class="font-semibold text-bavarian-800" style="font-family: 'Playfair Display', Georgia, serif;">
                Oktoberfest
            </a>
            <a href="{{ url('/') }}" class="text-sm text-stone-500 hover:text-stone-800">← Home</a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
