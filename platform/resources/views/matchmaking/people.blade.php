@extends('layouts.app')

@section('title', __('platform.matchmaking.people_title'))

@section('content')
<div
    class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8"
    x-data="{
        intent: '{{ $intent }}',
        query: '',
        matches(el) {
            const intentOk = !this.intent || el.dataset.intent === this.intent;
            const q = this.query.trim().toLowerCase();
            const textOk = !q || (el.dataset.search || '').includes(q);
            return intentOk && textOk;
        }
    }"
>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('matchmaking.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.matchmaking.back') }}</a>
            <h1 class="section-heading mt-2">{{ __('platform.matchmaking.people_title') }}</h1>
            <p class="section-subheading">{{ __('platform.matchmaking.people_subtitle') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('network.create') }}" class="btn-gold">{{ __('platform.network.cta_create') }}</a>
            <a href="{{ route('chat.index') }}" class="rounded-full border-2 border-bavarian-300 px-4 py-2 text-sm font-bold text-bavarian-700">{{ __('platform.nav.chat') }}</a>
        </div>
    </div>

    <div class="mb-6 flex flex-col gap-3 sm:flex-row">
        <input type="search" x-model="query" placeholder="{{ __('platform.network.search_placeholder') }}" class="w-full rounded-xl border border-bavarian-200 px-4 py-2 text-sm sm:max-w-xs">
    </div>
    <div class="mb-8 flex flex-wrap gap-2">
        <button type="button" @click="intent = ''" :class="intent === '' ? 'chip-active' : 'chip'">{{ __('platform.matchmaking.all_intents') }}</button>
        @foreach ($intents as $key => $label)
            <button type="button" @click="intent = '{{ $key }}'" :class="intent === '{{ $key }}' ? 'chip-active' : 'chip'">{{ $label }}</button>
        @endforeach
    </div>

    @if ($usingDemo ?? false)
        <p class="mb-6 rounded-xl border border-gold-200 bg-gold-50 px-4 py-3 text-sm text-beer">{{ __('platform.matchmaking.demo_notice') }} <a href="{{ route('network.create') }}" class="font-bold underline">{{ __('platform.network.cta_create') }}</a></p>
    @endif

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($allProfiles ?? $profiles as $profile)
            @include('network.partials.person-card', [
                'profile' => $profile,
                'intents' => $intents,
                'relationships' => $relationships ?? [],
                'statuses' => $statuses ?? [],
                'filterable' => true,
            ])
        @endforeach
    </div>
</div>
@endsection
