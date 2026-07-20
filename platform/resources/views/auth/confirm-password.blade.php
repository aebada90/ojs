@extends('layouts.app')

@section('title', 'Confirm Password')

@section('content')
<div class="mx-auto max-w-md px-4 py-16">
    <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-xl">
        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf
            <input name="password" type="password" required placeholder="Password" class="w-full rounded-xl border border-stone-200 px-4 py-3">
            <button class="w-full rounded-xl bg-stone-900 py-3 text-sm font-semibold text-white">Confirm</button>
        </form>
    </div>
</div>
@endsection
