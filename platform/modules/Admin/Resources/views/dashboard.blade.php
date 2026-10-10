@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="font-display text-3xl font-bold text-stone-900">Admin Panel</h1>
    <p class="mt-2 text-stone-600">Manage users, vendors, content, payments, and platform settings.</p>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($stats as $label => $value)
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <div class="text-sm text-stone-500">{{ str($label)->headline() }}</div>
                <div class="mt-2 text-3xl font-bold text-stone-900">{{ number_format($value) }}</div>
            </div>
        @endforeach
    </div>
</div>
@endsection
