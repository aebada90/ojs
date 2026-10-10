@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="mx-auto max-w-md px-4 py-16">
    <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <h1 class="font-display text-2xl font-bold">Reset password</h1>
        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
            @csrf
            <input name="email" type="email" required placeholder="Email" class="w-full rounded-xl border border-stone-200 px-4 py-3">
            <button class="w-full rounded-xl bg-stone-900 py-3 text-sm font-semibold text-white">Send reset link</button>
        </form>
    </div>
</div>
@endsection
