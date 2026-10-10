@extends('layouts.app')

@section('title', __('platform.dating.page_title'))
@section('meta_description', __('platform.dating.page_subtitle'))

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-bavarian-900 via-bavarian-800 to-beer text-white">
    <div class="pointer-events-none absolute inset-0 opacity-20" style="background-image: url('https://images.pexels.com/photos/28753305/pexels-photo-28753305.jpeg?auto=compress&cs=tinysrgb&w=1920&h=823&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <span class="inline-block rounded-full bg-gold-400/20 px-4 py-1 text-xs font-bold uppercase tracking-widest text-gold-200">{{ __('platform.dating.badge') }}</span>
                <h1 class="mt-6 font-display text-4xl font-bold sm:text-5xl">{{ __('platform.dating.title') }}</h1>
                <p class="mt-6 text-lg leading-relaxed text-white/80">{{ __('platform.dating.subtitle') }}</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="btn-gold">{{ __('platform.dating.cta_open') }}</a>
                    <a href="{{ $nexora['register'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-full border-2 border-white/40 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">{{ __('platform.dating.cta_register') }}</a>
                </div>
                <p class="mt-6 text-sm text-white/50">{{ __('platform.dating.powered_by', ['app' => $nexora['name']]) }}</p>
            </div>
            <div class="relative aspect-[4/5] overflow-hidden rounded-3xl shadow-2xl ring-1 ring-white/20">
                <img src="https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=800&h=1000" alt="{{ __('platform.dating.title') }}" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-bavarian-900/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 rounded-2xl border border-white/20 bg-black/40 p-5 backdrop-blur-md">
                    <p class="text-sm font-semibold text-gold-200">{{ $nexora['name'] }}</p>
                    <p class="mt-1 text-sm text-white/80">{{ $nexora['tagline'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
    <h2 class="section-heading">{{ __('platform.dating.why_title') }}</h2>
    <p class="section-subheading mx-auto mt-3 max-w-2xl">{{ __('platform.dating.why_subtitle') }}</p>
    <div class="mt-10 grid gap-6 md:grid-cols-3">
        <div class="card-fest p-6 text-left">
            <h3 class="font-display text-lg font-bold text-bavarian-900">{{ __('platform.dating.why_1_title') }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.dating.why_1_body') }}</p>
        </div>
        <div class="card-fest p-6 text-left">
            <h3 class="font-display text-lg font-bold text-bavarian-900">{{ __('platform.dating.why_2_title') }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.dating.why_2_body') }}</p>
        </div>
        <div class="card-fest p-6 text-left">
            <h3 class="font-display text-lg font-bold text-bavarian-900">{{ __('platform.dating.why_3_title') }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.dating.why_3_body') }}</p>
        </div>
    </div>
    <div class="mt-12 flex flex-wrap justify-center gap-3">
        <a href="{{ route('matchmaking.index') }}" class="inline-flex rounded-full border-2 border-bavarian-300 px-6 py-2.5 text-sm font-bold text-bavarian-700 hover:border-gold-400">{{ __('platform.connect.cta_matchmaking') }}</a>
        <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="btn-gold">{{ __('platform.dating.cta_open') }} →</a>
    </div>
</section>
@endsection
