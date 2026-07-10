<header class="sticky top-0 z-50 border-b border-amber-100/60 bg-white/90 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-lg font-bold text-white shadow-lg shadow-amber-500/30">🍺</span>
            <div>
                <div class="font-display text-lg font-bold tracking-tight text-stone-900">{{ config('platform.name') }}</div>
                <div class="text-xs text-stone-500">AI Tourism & Festival OS</div>
            </div>
        </a>

        <nav class="hidden items-center gap-6 text-sm font-medium text-stone-600 lg:flex">
            <a href="#hotels" class="hover:text-amber-700">Hotels</a>
            <a href="#rentals" class="hover:text-amber-700">Rentals</a>
            <a href="#marketplace" class="hover:text-amber-700">Marketplace</a>
            <a href="#events" class="hover:text-amber-700">Events</a>
            <a href="#experiences" class="hover:text-amber-700">Experiences</a>
            <a href="{{ route('search.results') }}" class="hover:text-amber-700">Search</a>
            <a href="#map" class="hover:text-amber-700">Digital Twin</a>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="hidden rounded-full px-4 py-2 text-sm font-medium text-stone-700 hover:bg-stone-100 sm:inline-flex">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hidden rounded-full px-4 py-2 text-sm font-medium text-stone-700 hover:bg-stone-100 sm:inline-flex">Log in</a>
                <a href="{{ route('register') }}" class="rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-white hover:bg-stone-800">Get Started</a>
            @endauth
        </div>
    </div>
</header>
