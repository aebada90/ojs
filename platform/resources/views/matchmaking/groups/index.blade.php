@extends('layouts.app')

@section('title', __('platform.matchmaking.groups_title'))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="section-heading">{{ __('platform.matchmaking.groups_title') }}</h1>
            <p class="section-subheading">{{ __('platform.matchmaking.groups_subtitle') }}</p>
        </div>
        @auth
            <a href="{{ route('matchmaking.groups.create') }}" class="btn-gold">{{ __('platform.matchmaking.create_group') }}</a>
        @else
            <a href="{{ url('/login') }}" class="btn-gold">{{ __('platform.matchmaking.login_to_connect') }}</a>
        @endauth
    </div>

    @if ($groups->isEmpty())
        <div class="rounded-3xl border border-dashed border-bavarian-200 bg-white p-10 text-center">
            <p class="text-stone-600">{{ __('platform.matchmaking.groups_empty') }}</p>
            <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="btn-gold mt-5 inline-flex">{{ __('platform.connect.open_nexora') }}</a>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($groups as $group)
                <a href="{{ route('matchmaking.groups.show', $group->slug) }}" class="card-fest block p-6">
                    <span class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ config('connect.intents.'.$group->intent, $group->intent) }}</span>
                    <h3 class="mt-2 font-display text-xl font-bold text-bavarian-900">{{ $group->title }}</h3>
                    <p class="mt-2 line-clamp-3 text-sm text-stone-600">{{ $group->description }}</p>
                    <p class="mt-4 text-xs text-stone-500">{{ $group->city }} · {{ __('platform.matchmaking.capacity', ['count' => $group->capacity]) }}</p>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
