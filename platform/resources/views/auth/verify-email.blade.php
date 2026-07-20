@extends('layouts.app')

@section('title', __('platform.verify.title'))

@section('content')
<div class="mx-auto max-w-md px-4 py-16 text-center">
    <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <h1 class="font-display text-2xl font-bold text-oktober-navy">{{ __('platform.verify.title') }}</h1>
        <p class="mt-4 text-sm text-stone-600">
            {{ __('platform.verify.body') }}
        </p>

        @auth
            <p class="mt-2 text-sm font-medium text-stone-800">{{ auth()->user()->email }}</p>
        @endauth

        @if (session('status') === 'verification-link-sent')
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                {{ __('platform.verify.sent') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <p class="mt-4 text-xs text-stone-500">{{ __('platform.verify.hint') }}</p>

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full rounded-xl bg-amber-500 px-6 py-3 text-sm font-semibold text-stone-950 transition hover:bg-amber-400">
                {{ __('platform.verify.resend') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="text-sm text-stone-500 underline underline-offset-2 hover:text-stone-800">
                {{ __('platform.verify.logout') }}
            </button>
        </form>
    </div>
</div>
@endsection
