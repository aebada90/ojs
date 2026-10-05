@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="font-display text-3xl font-bold text-stone-900">{{ __('platform.dashboard.welcome', ['name' => auth()->user()->name]) }}</h1>
            <p class="mt-2 text-stone-600">{{ __('platform.dashboard.subtitle') }}</p>
        </div>
        <a href="{{ route('network.create') }}" class="btn-gold">{{ $myProfile ? __('platform.network.edit_mine') : __('platform.network.cta_create') }}</a>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-3">
        <a href="{{ url('/network') }}" class="rounded-2xl border border-bavarian-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gold-400">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.nav.network') }}</p>
            <p class="mt-2 font-display text-3xl font-bold text-bavarian-900">{{ $peopleCount }}</p>
            <p class="text-sm text-stone-500">{{ __('platform.dashboard.stats.people') }}</p>
        </a>
        <a href="{{ url('/competition') }}" class="rounded-2xl border border-bavarian-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gold-400">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.nav.competition') }}</p>
            <p class="mt-2 font-display text-3xl font-bold text-bavarian-900">{{ $votesCast }}</p>
            <p class="text-sm text-stone-500">{{ __('platform.dashboard.stats.votes') }}</p>
        </a>
        <a href="{{ url('/chat') }}" class="rounded-2xl border border-bavarian-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gold-400">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.nav.chat') }}</p>
            <p class="mt-2 font-display text-3xl font-bold text-bavarian-900">{{ $chatCount }}</p>
            <p class="text-sm text-stone-500">{{ __('platform.dashboard.stats.chats') }}</p>
        </a>
    </div>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($tiles as $tile)
            <a href="{{ $tile['href'] }}" class="group card-fest flex flex-col overflow-hidden">
                <div class="relative h-32 overflow-hidden">
                    <img src="{{ $tile['image'] }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    <span class="absolute left-3 top-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-bavarian-800 shadow">
                        @include('network.partials.dash-icon', ['icon' => $tile['icon']])
                    </span>
                </div>
                <div class="flex flex-1 flex-col p-5">
                    <h2 class="font-semibold text-stone-900">{{ $tile['title'] }}</h2>
                    <p class="mt-2 flex-1 text-sm text-stone-500">{{ $tile['body'] }}</p>
                    <p class="mt-4 text-xs font-bold uppercase tracking-wider text-gold-700">{{ $tile['cta'] }} →</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
