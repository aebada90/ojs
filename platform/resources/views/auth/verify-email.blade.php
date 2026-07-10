@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="mx-auto max-w-md px-4 py-16 text-center">
    <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <h1 class="font-display text-2xl font-bold">Verify your email</h1>
        <p class="mt-4 text-sm text-stone-600">Please verify your email address to access your dashboard.</p>
        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button class="rounded-xl bg-amber-500 px-6 py-3 text-sm font-semibold text-stone-950">Resend verification email</button>
        </form>
    </div>
</div>
@endsection
