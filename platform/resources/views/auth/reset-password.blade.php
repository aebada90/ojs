@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="mx-auto max-w-md px-4 py-16">
    <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input name="email" type="email" value="{{ old('email', $request->email) }}" required class="w-full rounded-xl border border-stone-200 px-4 py-3">
            <input name="password" type="password" required placeholder="New password" class="w-full rounded-xl border border-stone-200 px-4 py-3">
            <input name="password_confirmation" type="password" required placeholder="Confirm password" class="w-full rounded-xl border border-stone-200 px-4 py-3">
            <button class="w-full rounded-xl bg-stone-900 py-3 text-sm font-semibold text-white">Reset Password</button>
        </form>
    </div>
</div>
@endsection
