@extends('layouts.app')

@section('title', 'Log in')

@section('content')
<div class="mx-auto flex min-h-[70vh] max-w-md items-center px-4 py-16">
    <div class="w-full rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <h1 class="font-display text-2xl font-bold text-stone-900">Welcome back</h1>
        <p class="mt-2 text-sm text-stone-600">Log in to manage bookings, orders, and your AI trip plans.</p>

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-medium text-stone-700">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-xl border border-stone-200 px-4 py-3">
            </div>
            <div>
                <label class="text-sm font-medium text-stone-700">Password</label>
                <input name="password" type="password" required class="mt-1 w-full rounded-xl border border-stone-200 px-4 py-3">
            </div>
            <label class="flex items-center gap-2 text-sm text-stone-600">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button class="w-full rounded-xl bg-stone-900 py-3 text-sm font-semibold text-white">Log in</button>
        </form>

        <div class="mt-6 grid grid-cols-2 gap-3">
            @foreach (['google', 'facebook', 'apple', 'linkedin'] as $provider)
                <a href="{{ route('auth.social.redirect', $provider) }}" class="rounded-xl border border-stone-200 px-3 py-2 text-center text-xs font-semibold capitalize hover:bg-stone-50">{{ $provider }}</a>
            @endforeach
        </div>

        <p class="mt-6 text-center text-sm text-stone-600">
            <a href="{{ route('password.request') }}" class="text-amber-700">Forgot password?</a>
            · <a href="{{ route('register') }}" class="text-amber-700">Create account</a>
        </p>
    </div>
</div>
@endsection
