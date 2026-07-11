@extends('layouts.app')

@section('title', __('platform.nav.login'))

@section('content')
<div class="flex min-h-[70vh] items-center justify-center px-4 py-16">
    <div class="w-full max-w-md overflow-hidden rounded-3xl border border-bavarian-200 bg-white shadow-2xl">
        <div class="bg-gradient-to-r from-bavarian-700 to-bavarian-600 px-8 py-6 text-center">
            <span class="text-3xl">🍺</span>
            <h1 class="mt-2 font-display text-2xl font-bold text-white">{{ __('platform.nav.login') }}</h1>
        </div>
        <div class="p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-bavarian-700">Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-3 focus:border-gold-400 focus:outline-none focus:ring-2 focus:ring-gold-400/20">
                </div>
                <div>
                    <label class="text-sm font-semibold text-bavarian-700">Password</label>
                    <input name="password" type="password" required class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-3 focus:border-gold-400 focus:outline-none focus:ring-2 focus:ring-gold-400/20">
                </div>
                <label class="flex items-center gap-2 text-sm text-bavarian-600">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <button class="w-full rounded-xl bg-gradient-to-r from-gold-400 to-gold-500 py-3 text-sm font-bold text-beer shadow-md transition hover:from-gold-300">{{ __('platform.nav.login') }}</button>
            </form>

            <div class="mt-6 grid grid-cols-2 gap-3">
                @foreach (['google', 'facebook', 'apple', 'linkedin'] as $provider)
                    <a href="{{ route('auth.social.redirect', $provider) }}" class="rounded-xl border border-bavarian-200 px-3 py-2 text-center text-xs font-semibold capitalize text-bavarian-700 transition hover:border-gold-400 hover:bg-gold-50">{{ $provider }}</a>
                @endforeach
            </div>

            <p class="mt-6 text-center text-sm text-bavarian-600">
                <a href="{{ route('password.request') }}" class="font-semibold text-bavarian-700 hover:text-gold-600">Forgot password?</a>
                · <a href="{{ route('register') }}" class="font-semibold text-bavarian-700 hover:text-gold-600">{{ __('platform.nav.register') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
