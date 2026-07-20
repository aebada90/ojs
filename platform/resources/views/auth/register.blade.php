@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="mx-auto flex min-h-[70vh] max-w-md items-center px-4 py-16">
    <div class="w-full rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <h1 class="font-display text-2xl font-bold text-stone-900">Create your account</h1>
        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-medium text-stone-700">Name</label>
                <input name="name" type="text" value="{{ old('name') }}" required class="mt-1 w-full rounded-xl border border-stone-200 px-4 py-3">
            </div>
            <div>
                <label class="text-sm font-medium text-stone-700">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-xl border border-stone-200 px-4 py-3">
            </div>
            <div>
                <label class="text-sm font-medium text-stone-700">Password</label>
                <input name="password" type="password" required class="mt-1 w-full rounded-xl border border-stone-200 px-4 py-3">
            </div>
            <div>
                <label class="text-sm font-medium text-stone-700">Confirm Password</label>
                <input name="password_confirmation" type="password" required class="mt-1 w-full rounded-xl border border-stone-200 px-4 py-3">
            </div>
            <button class="w-full rounded-xl bg-amber-500 py-3 text-sm font-semibold text-stone-950">Register</button>
        </form>
        <p class="mt-6 text-center text-sm text-stone-600"><a href="{{ route('login') }}" class="text-amber-700">Already registered?</a></p>
    </div>
</div>
@endsection
