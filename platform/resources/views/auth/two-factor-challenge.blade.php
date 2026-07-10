@extends('layouts.app')

@section('title', 'Two-Factor Challenge')

@section('content')
<div class="mx-auto max-w-md px-4 py-16">
    <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <h1 class="font-display text-2xl font-bold">Two-factor authentication</h1>
        <form method="POST" action="{{ route('two-factor.login') }}" class="mt-6 space-y-4">
            @csrf
            <input name="code" type="text" inputmode="numeric" placeholder="Authentication code" class="w-full rounded-xl border border-stone-200 px-4 py-3">
            <button class="w-full rounded-xl bg-stone-900 py-3 text-sm font-semibold text-white">Verify</button>
        </form>
    </div>
</div>
@endsection
