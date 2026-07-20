<div>
    {{-- Hero --}}
    <section class="pattern-hero relative overflow-hidden">
        {{-- Decorative elements --}}
        <div class="pointer-events-none absolute -left-20 top-10 h-64 w-64 rounded-full bg-gold-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-10 bottom-0 h-80 w-80 rounded-full bg-bavarian-400/10 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8 lg:py-28">
            <div>
                <span class="badge-fest">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400 animate-pulse"></span>
                    {{ __('platform.hero.badge') }}
                </span>
                <h1 class="mt-6 font-display text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    {{ __('platform.hero.title') }}
                    <span class="mt-2 block bg-gradient-to-r from-gold-300 via-gold-400 to-gold-500 bg-clip-text text-transparent">{{ __('platform.hero.title_highlight') }}</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/75">
                    {{ __('platform.hero.subtitle') }}
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#planner" class="btn-gold">{{ __('platform.hero.cta_planner') }}</a>
                    <a href="{{ route('search.results') }}" class="btn-outline-light">{{ __('platform.hero.cta_explore') }}</a>
                </div>

                {{-- Quick stats --}}
                <div class="mt-10 flex flex-wrap gap-6 border-t border-white/10 pt-8">
                    @foreach (__('platform.hero.stats') as $stat)
                        <div>
                            <div class="font-display text-2xl font-bold text-gold-400">{{ $stat['value'] }}</div>
                            <div class="text-xs font-medium uppercase tracking-wider text-white/50">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="glass-panel">
                <div class="mb-4 flex items-center gap-2 text-sm font-semibold text-gold-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    {{ __('platform.search.label') }}
                </div>
                <livewire:search.universal-search />
            </div>
        </div>

        {{-- Wave divider --}}
        <div class="relative h-16">
            <svg class="absolute bottom-0 w-full text-cream" viewBox="0 0 1440 60" preserveAspectRatio="none">
                <path fill="currentColor" d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,50 1440,40 L1440,60 L0,60 Z"/>
            </svg>
        </div>
    </section>

    {{-- AI Trip Planner --}}
    <section id="planner" class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <span class="inline-block rounded-full bg-bavarian-100 px-4 py-1 text-xs font-bold uppercase tracking-widest text-bavarian-600">AI</span>
            <h2 class="section-heading mt-4">{{ __('platform.planner.title') }}</h2>
            <p class="section-subheading mx-auto max-w-2xl">{{ __('platform.planner.subtitle') }}</p>
        </div>
        <div class="mx-auto max-w-3xl rounded-3xl border border-bavarian-200 bg-white p-6 shadow-xl shadow-bavarian-500/5">
            <livewire:ai.trip-planner />
        </div>
    </section>

    @include('components.home.section-grid', ['id' => 'hotels', 'title' => __('platform.sections.hotels.title'), 'subtitle' => __('platform.sections.hotels.subtitle'), 'items' => $featuredHotels, 'type' => 'hotel'])
    @include('components.home.section-grid', ['id' => 'rentals', 'title' => __('platform.sections.rentals.title'), 'subtitle' => __('platform.sections.rentals.subtitle'), 'items' => $featuredRentals, 'type' => 'rental', 'alt' => true])
    @include('components.home.section-products', ['id' => 'marketplace', 'title' => __('platform.sections.marketplace.title'), 'subtitle' => __('platform.sections.marketplace.subtitle'), 'products' => $featuredProducts])
    @include('components.home.section-grid', ['id' => 'experiences', 'title' => __('platform.sections.experiences.title'), 'subtitle' => __('platform.sections.experiences.subtitle'), 'items' => $featuredExperiences, 'type' => 'experience'])
    @include('components.home.section-grid', ['id' => 'restaurants', 'title' => __('platform.sections.restaurants.title'), 'subtitle' => __('platform.sections.restaurants.subtitle'), 'items' => $featuredRestaurants, 'type' => 'restaurant', 'alt' => true])
    @include('components.home.section-grid', ['id' => 'events', 'title' => __('platform.sections.events.title'), 'subtitle' => __('platform.sections.events.subtitle'), 'items' => $featuredEvents, 'type' => 'event'])
    @include('components.home.section-grid', ['id' => 'jobs', 'title' => __('platform.sections.jobs.title'), 'subtitle' => __('platform.sections.jobs.subtitle'), 'items' => $featuredJobs, 'type' => 'job', 'alt' => true])
    @include('components.home.section-grid', ['id' => 'properties', 'title' => __('platform.sections.properties.title'), 'subtitle' => __('platform.sections.properties.subtitle'), 'items' => $featuredProperties, 'type' => 'property'])

    {{-- Digital Twin --}}
    <section id="map" class="relative overflow-hidden bg-bavarian-900 py-20 text-white">
        <div class="pointer-events-none absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, rgba(245,184,0,0.3) 1px, transparent 0); background-size: 32px 32px;"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <span class="badge-fest">{{ __('platform.nav.digital_twin') }}</span>
                    <h2 class="mt-4 font-display text-3xl font-bold sm:text-4xl">{{ __('platform.map.title') }}</h2>
                    <p class="mt-4 leading-relaxed text-white/70">{{ __('platform.map.subtitle') }}</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (__('platform.map.layers') as $layer)
                            <span class="rounded-full border border-gold-400/30 bg-gold-400/10 px-3 py-1 text-xs font-semibold text-gold-300">{{ $layer }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="aspect-video overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-bavarian-700/50 to-bavarian-900 p-1 shadow-2xl">
                    <div class="flex h-full items-center justify-center rounded-[1.35rem] border border-dashed border-gold-400/30 bg-bavarian-800/50 text-center">
                        <div>
                            <div class="text-5xl">🗺️</div>
                            <p class="mt-4 text-lg font-semibold text-gold-300">{{ __('platform.map.ready_title') }}</p>
                            <p class="mt-2 text-sm text-white/50">{{ __('platform.map.ready_subtitle') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sponsors & Testimonials --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <div>
                <h2 class="section-heading">{{ __('platform.partners.title') }}</h2>
                <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3">
                    @foreach (__('platform.partners.names') as $partner)
                        <div class="flex h-20 items-center justify-center rounded-2xl border border-bavarian-100 bg-white p-3 text-center text-xs font-bold text-bavarian-600 shadow-sm transition hover:border-gold-400 hover:shadow-md">{{ $partner }}</div>
                    @endforeach
                </div>
            </div>
            <div>
                <h2 class="section-heading">{{ __('platform.testimonials.title') }}</h2>
                <div class="mt-6 space-y-4">
                    @foreach (__('platform.testimonials.items') as $testimonial)
                        <blockquote class="relative rounded-2xl border border-bavarian-100 bg-white p-6 shadow-sm">
                            <span class="absolute -top-3 left-6 text-4xl leading-none text-gold-400">"</span>
                            <p class="text-bavarian-800/90">{{ $testimonial['quote'] }}</p>
                            <footer class="mt-4 text-sm font-bold text-bavarian-600">— {{ $testimonial['author'] }}</footer>
                        </blockquote>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Mobile App CTA --}}
    <section class="relative overflow-hidden bg-gradient-to-r from-bavarian-700 via-bavarian-600 to-bavarian-700 py-16">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_80%_50%,rgba(245,184,0,0.2),transparent_50%)]"></div>
        <div class="relative mx-auto flex max-w-7xl flex-col items-center justify-between gap-8 px-4 text-center sm:px-6 lg:flex-row lg:text-left lg:px-8">
            <div>
                <h2 class="font-display text-3xl font-bold text-white">{{ __('platform.mobile.title') }}</h2>
                <p class="mt-3 max-w-xl text-white/70">{{ __('platform.mobile.subtitle') }}</p>
            </div>
            <div class="flex gap-4">
                <span class="rounded-2xl bg-beer px-6 py-3 text-sm font-bold text-gold-300 shadow-lg">{{ __('platform.mobile.app_store') }}</span>
                <span class="rounded-2xl border-2 border-gold-400 bg-gold-400 px-6 py-3 text-sm font-bold text-beer shadow-lg">{{ __('platform.mobile.google_play') }}</span>
            </div>
        </div>
    </section>
</div>
