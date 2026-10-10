@extends('layouts.app')

@section('title', __('platform.festivals.page_title', ['year' => $year]))
@section('meta_description', __('platform.festivals.page_subtitle', ['year' => $year]))

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-bavarian-900 via-bavarian-800 to-beer text-white">
    <div class="pointer-events-none absolute inset-0 opacity-25" style="background-image: url('https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <span class="inline-block rounded-full bg-gold-400/20 px-4 py-1 text-xs font-bold uppercase tracking-widest text-gold-200">{{ __('platform.festivals.badge', ['year' => $year]) }}</span>
        <h1 class="mt-5 max-w-3xl font-display text-4xl font-bold sm:text-5xl">{{ __('platform.festivals.title', ['year' => $year]) }}</h1>
        <p class="mt-5 max-w-2xl text-lg text-white/80">{{ __('platform.festivals.subtitle', ['year' => $year]) }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="#calendar" class="btn-gold">{{ __('platform.festivals.cta_calendar') }}</a>
            <a href="{{ url('/network') }}" class="inline-flex rounded-full border-2 border-white/40 px-6 py-2.5 text-sm font-bold text-white hover:bg-white/10">{{ __('platform.nav.network') }}</a>
        </div>
        @if ($featured)
            <p class="mt-6 text-sm text-white/55">{{ __('platform.festivals.next_up') }}: <strong class="text-gold-300">{{ $featured['name'] }}</strong> · {{ $featured['dates_label'] }}</p>
        @endif
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-bavarian-100 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.festivals.stat_seasons') }}</p>
            <p class="mt-2 font-display text-3xl font-bold text-bavarian-900">4</p>
        </div>
        <div class="rounded-2xl border border-bavarian-100 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.festivals.stat_festivals') }}</p>
            <p class="mt-2 font-display text-3xl font-bold text-bavarian-900">{{ count($festivals) }}</p>
        </div>
        <div class="rounded-2xl border border-bavarian-100 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.festivals.stat_wiesn') }}</p>
            <p class="mt-2 font-display text-3xl font-bold text-bavarian-900">{{ $year }}</p>
            <p class="text-sm text-stone-500">18 Sep – 3 Oct</p>
        </div>
    </div>
</section>

<section id="calendar" class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
    <h2 class="section-heading">{{ __('platform.festivals.grid_title', ['year' => $year]) }}</h2>
    <p class="section-subheading">{{ __('platform.festivals.grid_subtitle') }}</p>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($festivals as $festival)
            <a href="{{ route('festivals.show', $festival['slug']) }}" class="card-fest group flex flex-col overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden bg-bavarian-100">
                    <img src="{{ $festival['image'] }}" alt="{{ $festival['name'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                    <span class="absolute left-3 top-3 rounded-full bg-beer/80 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider text-gold-300">{{ $festival['season'] }}</span>
                </div>
                <div class="flex flex-1 flex-col p-5">
                    <h3 class="font-display text-xl font-bold text-bavarian-900">{{ $festival['name'] }}</h3>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-gold-700">{{ $festival['dates_label'] }}</p>
                    <p class="mt-3 flex-1 text-sm text-stone-600">{{ $festival['blurb'] }}</p>
                    <p class="mt-4 text-xs text-stone-500">{{ $festival['location'] }}</p>
                    <p class="mt-3 text-xs font-bold uppercase tracking-wider text-bavarian-700">{{ __('platform.festivals.view') }} →</p>
                </div>
            </a>
        @endforeach
    </div>
</section>

<section class="bg-cream py-14">
    <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
        <h2 class="section-heading">{{ __('platform.festivals.countdown_title', ['year' => $year]) }}</h2>
        <p class="section-subheading mx-auto max-w-2xl">{{ __('platform.festivals.countdown_subtitle') }}</p>
        <div class="mt-8 flex justify-center">
            <x-interactive.countdown :target="$oktoberfestOpensAt" />
        </div>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ url('/hotels') }}" class="btn-gold">{{ __('platform.nav.hotels') }}</a>
            <a href="{{ url('/competition') }}" class="inline-flex rounded-full border-2 border-bavarian-300 px-5 py-2.5 text-sm font-bold text-bavarian-700">{{ __('platform.nav.competition') }}</a>
            <a href="{{ url('/network') }}" class="inline-flex rounded-full border-2 border-bavarian-300 px-5 py-2.5 text-sm font-bold text-bavarian-700">{{ __('platform.nav.network') }}</a>
        </div>
    </div>
</section>
@endsection
