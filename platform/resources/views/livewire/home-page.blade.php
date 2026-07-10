<div>
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-amber-50 via-orange-50 to-stone-100">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(251,191,36,0.25),_transparent_45%)]"></div>
        <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8 lg:py-28">
            <div>
                <span class="inline-flex rounded-full bg-amber-100 px-4 py-1 text-xs font-semibold uppercase tracking-wider text-amber-800">Oktoberfest 2026 • Munich</span>
                <h1 class="mt-6 font-display text-4xl font-bold tracking-tight text-stone-900 sm:text-5xl lg:text-6xl">
                    Discover. Book. Celebrate. <span class="text-amber-600">All in one AI platform.</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-stone-600">
                    Hotels, rentals, marketplace, events, restaurants, experiences, jobs, and a live Digital Twin map — powered by AI for the world's greatest festivals and tourism destinations.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#planner" class="rounded-full bg-amber-500 px-6 py-3 text-sm font-semibold text-stone-950 shadow-lg shadow-amber-500/30 hover:bg-amber-400">Plan My Trip with AI</a>
                    <a href="{{ route('search.results') }}" class="rounded-full border border-stone-300 bg-white px-6 py-3 text-sm font-semibold text-stone-800 hover:bg-stone-50">Explore Everything</a>
                </div>
            </div>
            <div class="rounded-3xl border border-white/70 bg-white/80 p-6 shadow-2xl shadow-amber-500/10 backdrop-blur">
                <livewire:search.universal-search />
            </div>
        </div>
    </section>

    {{-- AI Trip Planner --}}
    <section id="planner" class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h2 class="font-display text-3xl font-bold text-stone-900 sm:text-4xl">AI Trip Planner</h2>
            <p class="mt-3 text-stone-600">Personalized itineraries, restaurant picks, and festival tips in seconds.</p>
        </div>
        <div class="mx-auto max-w-3xl rounded-3xl border border-stone-200 bg-white p-6 shadow-xl">
            <livewire:ai.trip-planner />
        </div>
    </section>

    @include('components.home.section-grid', ['id' => 'hotels', 'title' => 'Featured Hotels', 'subtitle' => 'From luxury suites to cozy guesthouses near Theresienwiese.', 'items' => $featuredHotels, 'type' => 'hotel'])
    @include('components.home.section-grid', ['id' => 'rentals', 'title' => 'Featured Rentals', 'subtitle' => 'Cars, bikes, traditional outfits, party gear, and more.', 'items' => $featuredRentals, 'type' => 'rental'])
    @include('components.home.section-products', ['id' => 'marketplace', 'title' => 'Featured Products', 'subtitle' => 'Shop authentic Bavarian goods from verified vendors.', 'products' => $featuredProducts])
    @include('components.home.section-grid', ['id' => 'experiences', 'title' => 'Featured Experiences', 'subtitle' => 'Beer tours, river cruises, cooking classes, and nightlife.', 'items' => $featuredExperiences, 'type' => 'experience'])
    @include('components.home.section-grid', ['id' => 'restaurants', 'title' => 'Restaurants', 'subtitle' => 'Reserve tables, browse digital menus, and order delivery.', 'items' => $featuredRestaurants, 'type' => 'restaurant'])
    @include('components.home.section-grid', ['id' => 'events', 'title' => 'Events & Tickets', 'subtitle' => 'Oktoberfest tents, concerts, football, and corporate events.', 'items' => $featuredEvents, 'type' => 'event'])
    @include('components.home.section-grid', ['id' => 'jobs', 'title' => 'Seasonal Jobs', 'subtitle' => 'Find temporary and festival jobs across Munich.', 'items' => $featuredJobs, 'type' => 'job'])
    @include('components.home.section-grid', ['id' => 'properties', 'title' => 'Property Listings', 'subtitle' => 'Buy, sell, or rent residential and commercial properties.', 'items' => $featuredProperties, 'type' => 'property'])

    {{-- Digital Twin --}}
    <section id="map" class="bg-stone-900 py-20 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <h2 class="font-display text-3xl font-bold sm:text-4xl">Digital Twin Live Map</h2>
                    <p class="mt-4 text-stone-300">Interactive layers for crowds, weather, traffic, parking, hotels, restaurants, toilets, medical, charging stations, events, and emergency navigation.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['Crowds', 'Weather', 'Traffic', 'Parking', 'Hotels', 'Events', 'Emergency'] as $layer)
                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium">{{ $layer }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="aspect-video overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-amber-500/20 to-stone-800 p-8">
                    <div class="flex h-full items-center justify-center rounded-2xl border border-dashed border-white/20 text-center">
                        <div>
                            <div class="text-5xl">🗺️</div>
                            <p class="mt-4 text-lg font-semibold">Map Module Ready</p>
                            <p class="mt-2 text-sm text-stone-400">Plug in real-time APIs without architecture changes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sponsors & Partners --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-2">
            <div>
                <h2 class="font-display text-2xl font-bold">Sponsors & Partners</h2>
                <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3">
                    @foreach (['Bavaria Tourism', 'Munich Hotels', 'Festival Breweries', 'Local Artisans', 'Transport Alliance', 'EventTech'] as $partner)
                        <div class="flex h-20 items-center justify-center rounded-2xl border border-stone-200 bg-white text-sm font-semibold text-stone-500">{{ $partner }}</div>
                    @endforeach
                </div>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold">Testimonials</h2>
                <div class="mt-6 space-y-4">
                    <blockquote class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-stone-700">"We booked our hotel, rented lederhosen, and got AI restaurant recommendations — all in one place."</p>
                        <footer class="mt-4 text-sm font-semibold text-amber-700">— Sarah K., Festival Visitor</footer>
                    </blockquote>
                    <blockquote class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-stone-700">"Our vendor storefront, analytics, and payouts are finally unified. Perfect for shared hosting."</p>
                        <footer class="mt-4 text-sm font-semibold text-amber-700">— Hans M., Marketplace Vendor</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    {{-- Mobile App --}}
    <section class="bg-gradient-to-r from-amber-500 to-orange-600 py-16 text-stone-950">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-8 px-4 text-center sm:px-6 lg:flex-row lg:text-left lg:px-8">
            <div>
                <h2 class="font-display text-3xl font-bold">Take the platform everywhere</h2>
                <p class="mt-3 max-w-xl text-stone-900/80">REST APIs ready for Flutter, iOS, Android, React, and Vue mobile apps.</p>
            </div>
            <div class="flex gap-4">
                <span class="rounded-2xl bg-stone-950 px-6 py-3 text-sm font-semibold text-white">App Store Soon</span>
                <span class="rounded-2xl bg-white px-6 py-3 text-sm font-semibold">Google Play Soon</span>
            </div>
        </div>
    </section>
</div>
