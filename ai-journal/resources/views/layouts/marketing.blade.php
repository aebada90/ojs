<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AI Journal') }} — Automated Peer Review for Academic Publishing</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <nav class="border-b border-gray-100 bg-white/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="font-bold text-xl text-gray-900">{{ config('app.name') }}</span>
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{ $slot }}

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-white font-semibold mb-3">{{ config('app.name') }}</h3>
                    <p class="text-sm">AI-powered manuscript review platform helping journals accelerate peer review while maintaining academic quality standards.</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-3">Platform</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('register') }}" class="hover:text-white">For Authors</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white">For Journal Editors</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-3">Review Criteria</h3>
                    <p class="text-sm">Originality, Methodology, Clarity, Structure, References, Ethics, Reproducibility</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-sm text-center">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Built with Laravel.
            </div>
        </div>
    </footer>
</body>
</html>
