@extends('layouts.auth')

@section('title', __('platform.verify.title'))

@section('content')
@php
    $inlineUrl = session('verification_inline_url');
    if (! $inlineUrl && auth()->check() && ! auth()->user()->hasVerifiedEmail()) {
        try {
            $inlineUrl = \App\Notifications\VerifyEmail::signedUrl(auth()->user());
        } catch (\Throwable $e) {
            report($e);
            $inlineUrl = null;
        }
    }
    $resendAction = \Illuminate\Support\Facades\Route::has('verification.send')
        ? route('verification.send')
        : url('/email/verification-notification');
@endphp
<div class="mx-auto max-w-md px-4 py-16 text-center">
    <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <h1 class="text-2xl font-bold text-bavarian-800" style="font-family: 'Playfair Display', Georgia, serif;">
            {{ __('platform.verify.title') }}
        </h1>
        <p class="mt-4 text-sm text-stone-600">
            {{ __('platform.verify.body') }}
        </p>

        @auth
            <p class="mt-2 text-sm font-medium text-stone-800">{{ auth()->user()->email }}</p>
        @endauth

        @if (session('verification_mail_failed'))
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                {{ __('platform.verify.send_failed') }}
            </div>
        @elseif (session('status') === 'verification-link-sent')
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                {{ __('platform.verify.sent') }}
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        @if ($inlineUrl)
            <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-950">
                <p class="font-medium">{{ __('platform.verify.inline_title') }}</p>
                <p class="mt-1 text-xs text-amber-800">{{ __('platform.verify.inline_hint') }}</p>
                <a href="{{ $inlineUrl }}"
                   class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-bavarian-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-bavarian-600">
                    {{ __('platform.verify.inline_action') }}
                </a>
            </div>
        @endif

        <p class="mt-4 text-xs text-stone-500">{{ __('platform.verify.hint') }}</p>

        <form method="POST" action="{{ $resendAction }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full rounded-xl bg-amber-500 px-6 py-3 text-sm font-semibold text-stone-950 transition hover:bg-amber-400">
                {{ __('platform.verify.resend') }}
            </button>
        </form>

        <form method="POST" action="{{ url('/logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="text-sm text-stone-500 underline underline-offset-2 hover:text-stone-800">
                {{ __('platform.verify.logout') }}
            </button>
        </form>
    </div>
</div>
@endsection
