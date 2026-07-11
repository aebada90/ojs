<header class="sticky top-0 z-50 border-b border-bavarian-700/30 bg-bavarian-900/95 shadow-lg shadow-bavarian-900/20 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="group flex items-center gap-3">
            <span class="relative flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-gold-400 to-gold-600 text-xl shadow-lg shadow-gold-500/30 transition group-hover:scale-105">
                🍺
                <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-bavarian-900 bg-gold-300"></span>
            </span>
            <div>
                <div class="font-display text-lg font-bold tracking-tight text-white">{{ __('platform.name') }}</div>
                <div class="text-[11px] font-medium uppercase tracking-wider text-gold-300/80">{{ __('platform.tagline_short') }}</div>
            </div>
        </a>

        <nav class="hidden items-center gap-1 text-sm font-medium lg:flex">
            @foreach ([
                ['#hotels', 'nav.hotels'],
                ['#rentals', 'nav.rentals'],
                ['#marketplace', 'nav.marketplace'],
                ['#events', 'nav.events'],
                ['#experiences', 'nav.experiences'],
                ['#map', 'nav.digital_twin'],
            ] as [$href, $key])
                <a href="{{ $href }}" class="rounded-lg px-3 py-2 text-white/80 transition hover:bg-white/10 hover:text-gold-300">{{ __("platform.{$key}") }}</a>
            @endforeach
            <a href="{{ route('search.results') }}" class="rounded-lg px-3 py-2 text-gold-300 transition hover:bg-gold-400/10">{{ __('platform.nav.search') }}</a>
        </nav>

        <div class="flex items-center gap-2 sm:gap-3">
            {{-- Language switcher --}}
            <div class="flex items-center rounded-xl border border-white/15 bg-white/5 p-0.5">
                <a href="{{ route('locale.switch', 'en') }}"
                   @class(['lang-btn', 'lang-btn-active' => app()->getLocale() === 'en', 'lang-btn-inactive' => app()->getLocale() !== 'en'])>
                    EN
                </a>
                <a href="{{ route('locale.switch', 'de') }}"
                   @class(['lang-btn', 'lang-btn-active' => app()->getLocale() === 'de', 'lang-btn-inactive' => app()->getLocale() !== 'de'])>
                    DE
                </a>
            </div>

            @auth
                <a href="{{ route('dashboard') }}" class="hidden rounded-full border border-white/20 px-4 py-2 text-sm font-medium text-white transition hover:border-gold-400/50 hover:text-gold-300 sm:inline-flex">{{ __('platform.nav.dashboard') }}</a>
            @else
                <a href="{{ route('login') }}" class="hidden rounded-full px-4 py-2 text-sm font-medium text-white/80 transition hover:text-gold-300 sm:inline-flex">{{ __('platform.nav.login') }}</a>
                <a href="{{ route('register') }}" class="rounded-full bg-gradient-to-r from-gold-400 to-gold-500 px-4 py-2 text-sm font-bold text-beer shadow-md shadow-gold-500/25 transition hover:from-gold-300 hover:to-gold-400">{{ __('platform.nav.register') }}</a>
            @endauth
        </div>
    </div>
</header>
