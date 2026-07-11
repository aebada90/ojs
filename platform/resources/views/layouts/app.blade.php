<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('platform.name')){{ config('platform.seo.title_suffix') }}</title>
    <meta name="description" content="@yield('meta_description', __('platform.meta.description'))">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <meta property="og:title" content="@yield('og_title', __('platform.name'))">
    <meta property="og:description" content="@yield('og_description', __('platform.meta.description'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    @stack('schema')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('head')
</head>
<body class="min-h-full pattern-bavarian text-beer antialiased">
    @include('layouts.partials.header')

    <main>
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    @include('layouts.partials.footer')

    <livewire:ai.chatbot />

    @livewireScripts
    @stack('scripts')
</body>
</html>
