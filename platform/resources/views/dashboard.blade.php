@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="font-display text-3xl font-bold text-stone-900">Welcome, {{ auth()->user()->name }}</h1>
    <p class="mt-2 text-stone-600">Manage your orders, bookings, tickets, wallet, messages, and profile from one place.</p>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach (['Orders', 'Bookings', 'Tickets', 'Wishlist', 'Wallet', 'Messages', 'Rewards', 'Profile'] as $card)
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="font-semibold text-stone-900">{{ $card }}</h2>
                <p class="mt-2 text-sm text-stone-500">Module-ready dashboard section.</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
