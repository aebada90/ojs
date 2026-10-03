@extends('layouts.app')

@section('title', $group->title)

@section('content')
<div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
    <a href="{{ route('matchmaking.groups.index') }}" class="text-sm font-semibold text-bavarian-600">← {{ __('platform.matchmaking.groups_title') }}</a>
    <span class="mt-4 inline-block rounded-full bg-bavarian-100 px-3 py-1 text-xs font-bold uppercase tracking-widest text-bavarian-600">{{ config('connect.intents.'.$group->intent, $group->intent) }}</span>
    <h1 class="mt-3 font-display text-4xl font-bold text-bavarian-900">{{ $group->title }}</h1>
    <p class="mt-2 text-stone-500">{{ $group->city }} · {{ __('platform.matchmaking.capacity', ['count' => $group->capacity]) }}</p>
    <p class="mt-5 leading-relaxed text-stone-700">{{ $group->description }}</p>

    <div class="mt-8 flex flex-wrap gap-3">
        @auth
            <form method="POST" action="{{ route('matchmaking.groups.join', $group->slug) }}">@csrf<button class="btn-gold">{{ __('platform.matchmaking.join_group') }}</button></form>
            <form method="POST" action="{{ route('matchmaking.groups.leave', $group->slug) }}">@csrf<button class="rounded-full border-2 border-bavarian-300 px-5 py-2.5 text-sm font-bold text-bavarian-700">{{ __('platform.matchmaking.leave_group') }}</button></form>
        @else
            <a href="{{ url('/login') }}" class="btn-gold">{{ __('platform.matchmaking.login_to_connect') }}</a>
        @endauth
        <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="rounded-full border-2 border-gold-400 px-5 py-2.5 text-sm font-bold text-beer">{{ __('platform.connect.open_nexora') }}</a>
    </div>
</div>
@endsection
