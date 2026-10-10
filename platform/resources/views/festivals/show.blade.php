@extends('layouts.app')

@section('title', $festival['name'].' '.$year)
@section('meta_description', $festival['blurb'])

@section('content')
<section class="relative overflow-hidden bg-bavarian-900 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-30" style="background-image: url('{{ $festival['image'] }}'); background-size: cover; background-position: center;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <a href="{{ route('festivals.index') }}" class="text-sm font-semibold text-gold-300 hover:text-gold-200">← {{ __('platform.festivals.back') }}</a>
        <span class="mt-5 inline-block rounded-full bg-gold-400/20 px-4 py-1 text-xs font-bold uppercase tracking-widest text-gold-200">{{ $festival['season'] }} · {{ $year }}</span>
        <h1 class="mt-4 max-w-3xl font-display text-4xl font-bold sm:text-5xl">{{ $festival['name'] }}</h1>
        <p class="mt-3 text-sm font-semibold uppercase tracking-wider text-gold-300">{{ $festival['dates_label'] }} · {{ $festival['location'] }}</p>
        <p class="mt-5 max-w-2xl text-lg text-white/80">{{ $festival['blurb'] }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ url('/hotels') }}" class="btn-gold">{{ __('platform.festivals.cta_stay') }}</a>
            <a href="{{ url('/network') }}" class="inline-flex rounded-full border-2 border-white/40 px-6 py-2.5 text-sm font-bold text-white hover:bg-white/10">{{ __('platform.festivals.cta_meet') }}</a>
            @if ($festival['slug'] === 'oktoberfest')
                <a href="{{ url('/competition') }}" class="inline-flex rounded-full border-2 border-gold-400/50 px-6 py-2.5 text-sm font-bold text-gold-200 hover:bg-gold-400/10">{{ __('platform.nav.competition') }}</a>
            @endif
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <h2 class="section-heading">{{ __('platform.festivals.more_title') }}</h2>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($festivals as $other)
            @continue($other['slug'] === $festival['slug'])
            <a href="{{ route('festivals.show', $other['slug']) }}" class="card-fest flex gap-4 p-4 hover:border-gold-400">
                <img src="{{ $other['image'] }}" alt="" class="h-20 w-24 shrink-0 rounded-xl object-cover">
                <div>
                    <p class="font-semibold text-bavarian-900">{{ $other['name'] }}</p>
                    <p class="mt-1 text-xs text-gold-700">{{ $other['dates_label'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
