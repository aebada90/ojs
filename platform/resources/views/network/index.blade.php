@extends('layouts.app')

@section('title', __('platform.network.page_title'))
@section('meta_description', __('platform.network.page_subtitle'))

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-bavarian-900 via-bavarian-800 to-beer text-white">
    <div class="pointer-events-none absolute inset-0 opacity-25" style="background-image: url('https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <span class="inline-block rounded-full bg-gold-400/20 px-4 py-1 text-xs font-bold uppercase tracking-widest text-gold-200">{{ __('platform.network.badge') }}</span>
        <h1 class="mt-5 max-w-3xl font-display text-4xl font-bold sm:text-5xl">{{ __('platform.network.title') }}</h1>
        <p class="mt-5 max-w-2xl text-lg text-white/80">{{ __('platform.network.subtitle') }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('network.create') }}" class="btn-gold">{{ __('platform.network.cta_create') }}</a>
            <a href="{{ route('chat.index') }}" class="inline-flex rounded-full border-2 border-white/40 px-6 py-2.5 text-sm font-bold text-white hover:bg-white/10">{{ __('platform.network.cta_chat') }}</a>
            <a href="#people" class="inline-flex rounded-full border-2 border-gold-400/50 px-6 py-2.5 text-sm font-bold text-gold-200 hover:bg-gold-400/10">{{ __('platform.network.cta_people') }}</a>
        </div>
        <p class="mt-6 text-sm text-white/50">{{ __('platform.network.people_ready', ['count' => $peopleCount]) }}</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="grid gap-6 md:grid-cols-3">
        <a href="{{ route('network.create') }}" class="card-fest block overflow-hidden hover:border-gold-400">
            <div class="h-28 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&q=80');"></div>
            <div class="p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.network.tile_create_badge') }}</p>
                <h2 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ __('platform.network.tile_create_title') }}</h2>
                <p class="mt-2 text-sm text-stone-600">{{ __('platform.network.tile_create_body') }}</p>
            </div>
        </a>
        <a href="{{ route('chat.index') }}" class="card-fest block overflow-hidden hover:border-gold-400">
            <div class="h-28 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=800&q=80');"></div>
            <div class="p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.network.tile_chat_badge') }}</p>
                <h2 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ __('platform.network.tile_chat_title') }}</h2>
                <p class="mt-2 text-sm text-stone-600">{{ __('platform.network.tile_chat_body') }}</p>
            </div>
        </a>
        <a href="{{ route('matchmaking.groups.index') }}" class="card-fest block overflow-hidden hover:border-gold-400">
            <div class="h-28 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1569931080489-627940a2e4c8?auto=format&fit=crop&w=800&q=80');"></div>
            <div class="p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.network.tile_groups_badge') }}</p>
                <h2 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ __('platform.network.tile_groups_title') }}</h2>
                <p class="mt-2 text-sm text-stone-600">{{ __('platform.network.tile_groups_body') }}</p>
            </div>
        </a>
    </div>
</section>

<section
    id="people"
    class="mx-auto max-w-7xl px-4 pb-8 sm:px-6 lg:px-8"
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
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h2 class="section-heading">{{ __('platform.network.people_title') }}</h2>
            <p class="section-subheading">{{ __('platform.network.people_subtitle') }}</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <input
                type="search"
                x-model="query"
                placeholder="{{ __('platform.network.search_placeholder') }}"
                class="w-full rounded-xl border border-bavarian-200 px-4 py-2 text-sm sm:w-64"
            >
            @if ($myProfile ?? null)
                <a href="{{ route('network.create') }}" class="rounded-full border-2 border-gold-400 px-4 py-2 text-center text-sm font-bold text-beer">{{ __('platform.network.edit_mine') }}</a>
            @else
                <a href="{{ route('network.create') }}" class="btn-gold px-4 py-2 text-center text-sm">{{ __('platform.network.cta_create') }}</a>
            @endif
        </div>
    </div>

    <div class="mb-8 flex flex-wrap gap-2">
        <button type="button" @click="intent = ''" :class="intent === '' ? 'chip-active' : 'chip'">{{ __('platform.matchmaking.all_intents') }}</button>
        @foreach ($intents as $key => $label)
            <button type="button" @click="intent = '{{ $key }}'" :class="intent === '{{ $key }}' ? 'chip-active' : 'chip'">{{ $label }}</button>
        @endforeach
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($allProfiles as $profile)
            @include('network.partials.person-card', [
                'profile' => $profile,
                'intents' => $intents,
                'relationships' => $relationships,
                'statuses' => $statuses,
                'filterable' => true,
            ])
        @endforeach
    </div>
</section>

<section class="bg-cream py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="section-heading">{{ __('platform.network.groups_title') }}</h2>
        <p class="section-subheading">{{ __('platform.network.groups_subtitle') }}</p>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($groups as $group)
                <a href="{{ route('matchmaking.groups.index') }}" class="card-fest block p-6 hover:border-gold-400">
                    <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ $intents[$group['intent']] ?? $group['intent'] }}</p>
                    <h3 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ $group['title'] }}</h3>
                    <p class="mt-2 text-sm text-stone-600">{{ $group['description'] }}</p>
                    <p class="mt-4 text-xs text-stone-500">{{ $group['city'] }} · {{ __('platform.matchmaking.capacity', ['count' => $group['capacity']]) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
