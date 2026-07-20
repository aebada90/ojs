@php
    $searchUrl = \Illuminate\Support\Facades\Route::has('search.results') ? route('search.results') : url('/search');
    $nav = [
        'book' => [
            'label' => __('platform.nav.book'),
            'groups' => [
                [
                    'title' => __('platform.nav.groups.tents_events'),
                    'links' => [
                        ['href' => url('/events'), 'label' => __('platform.nav.beer_tents')],
                        ['href' => url('/events/calendar'), 'label' => __('platform.nav.event_calendar')],
                        ['href' => url('/parties'), 'label' => __('platform.nav.parties')],
                        ['href' => url('/nightlife'), 'label' => __('platform.nav.nightlife')],
                    ],
                ],
                [
                    'title' => __('platform.nav.groups.eat_drink'),
                    'links' => [
                        ['href' => url('/restaurants'), 'label' => __('platform.nav.restaurants')],
                        ['href' => url('/bars'), 'label' => __('platform.nav.bars')],
                        ['href' => url('/cafes'), 'label' => __('platform.nav.cafes')],
                    ],
                ],
                [
                    'title' => __('platform.nav.groups.stay_tours'),
                    'links' => [
                        ['href' => url('/hotels'), 'label' => __('platform.nav.hotels_near')],
                        ['href' => url('/properties'), 'label' => __('platform.nav.apartments')],
                        ['href' => url('/experiences'), 'label' => __('platform.nav.experiences')],
                    ],
                ],
            ],
        ],
        'plan' => [
            'label' => __('platform.nav.plan'),
            'groups' => [
                [
                    'title' => __('platform.nav.groups.gear_shop'),
                    'links' => [
                        ['href' => url('/rentals'), 'label' => __('platform.nav.tracht')],
                        ['href' => url('/marketplace'), 'label' => __('platform.nav.marketplace')],
                    ],
                ],
                [
                    'title' => __('platform.nav.groups.explore'),
                    'links' => [
                        ['href' => url('/map'), 'label' => __('platform.nav.digital_twin')],
                        ['href' => url('/jobs'), 'label' => __('platform.nav.jobs')],
                        ['href' => url('/for-vendors'), 'label' => __('platform.nav.for_vendors')],
                    ],
                ],
            ],
        ],
        'social' => [
            'label' => __('platform.nav.meet'),
            'groups' => [
                [
                    'title' => __('platform.nav.groups.connect'),
                    'links' => [
                        ['href' => url('/meet'), 'label' => __('platform.nav.meet_people')],
                        ['href' => url('/meetup'), 'label' => __('platform.nav.meet_up')],
                        ['href' => url('/models'), 'label' => __('platform.nav.models')],
                    ],
                ],
            ],
        ],
    ];
    $quick = [
        ['href' => url('/events'), 'label' => __('platform.nav.beer_tents')],
        ['href' => url('/hotels'), 'label' => __('platform.nav.hotels')],
        ['href' => url('/rentals'), 'label' => __('platform.nav.tracht_short')],
    ];
@endphp

<header
    class="sticky top-0 z-50 border-b border-bavarian-800 bg-bavarian-900"
    x-data="{
        mobileOpen: false,
        openMenu: null,
        openSection: '',
        close() { this.mobileOpen = false; this.openMenu = null; this.openSection = ''; },
        toggleSection(id) { this.openSection = this.openSection === id ? '' : id; },
        openDesktop(id) { this.openMenu = id; },
        closeDesktop() { this.openMenu = null; }
    }"
    @keydown.escape.window="close()"
>
    <div class="relative mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-2.5" @click="close()">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gold-400 text-lg text-beer">🍺</span>
            <div class="min-w-0">
                <div class="truncate font-display text-lg font-bold leading-tight text-white">{{ __('platform.name') }}</div>
                <div class="truncate text-[10px] font-semibold uppercase tracking-[0.14em] text-gold-400">{{ __('platform.tagline_short') }}</div>
            </div>
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden items-center gap-1 lg:flex" aria-label="{{ __('platform.nav.main') }}" @mouseleave="closeDesktop()">
            @foreach ($nav as $key => $section)
                <div class="relative" @mouseenter="openDesktop('{{ $key }}')">
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-white/85 transition hover:bg-white/10 hover:text-white"
                        :class="openMenu === '{{ $key }}' && 'bg-white text-bavarian-900 hover:bg-white hover:text-bavarian-900'"
                        :aria-expanded="openMenu === '{{ $key }}' ? 'true' : 'false'"
                    >
                        {{ $section['label'] }}
                        <svg class="h-3.5 w-3.5 opacity-70 transition" :class="openMenu === '{{ $key }}' && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        x-show="openMenu === '{{ $key }}'"
                        x-cloak
                        x-transition.opacity.duration.150ms
                        class="absolute left-0 top-full z-[120] mt-2 min-w-[20rem] overflow-hidden rounded-xl border border-stone-200 bg-cream p-4 shadow-xl"
                    >
                        <div class="grid gap-4 {{ count($section['groups']) > 1 ? 'sm:grid-cols-2' : '' }}">
                            @foreach ($section['groups'] as $group)
                                <div>
                                    <div class="mb-2 text-xs font-bold uppercase tracking-[0.12em] text-gold-700">{{ $group['title'] }}</div>
                                    <ul class="space-y-0.5">
                                        @foreach ($group['links'] as $link)
                                            <li>
                                                <a href="{{ $link['href'] }}" class="block rounded-lg px-2.5 py-2 text-sm font-medium text-beer transition hover:bg-white hover:text-bavarian-700">
                                                    {{ $link['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <a href="{{ $searchUrl }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-gold-300 transition hover:bg-gold-400/10 hover:text-gold-200">{{ __('platform.nav.search') }}</a>
        </nav>

        <div class="flex items-center gap-2">
            <div class="hidden items-center rounded-lg border border-white/15 bg-white/5 p-0.5 sm:flex">
                <a href="{{ route('locale.switch', 'en') }}" @class(['lang-btn', 'lang-btn-active' => app()->getLocale() === 'en', 'lang-btn-inactive' => app()->getLocale() !== 'en'])>EN</a>
                <a href="{{ route('locale.switch', 'de') }}" @class(['lang-btn', 'lang-btn-active' => app()->getLocale() === 'de', 'lang-btn-inactive' => app()->getLocale() !== 'de'])>DE</a>
            </div>

            @auth
                <a href="{{ route('dashboard') }}" class="hidden rounded-lg border border-white/20 px-3 py-1.5 text-sm font-medium text-white transition hover:border-gold-400/50 hover:text-gold-300 sm:inline-flex">{{ __('platform.nav.dashboard') }}</a>
            @else
                <a href="{{ route('login') }}" class="hidden rounded-lg px-3 py-1.5 text-sm font-medium text-white/85 transition hover:text-gold-300 sm:inline-flex">{{ __('platform.nav.login') }}</a>
                <a href="{{ route('register') }}" class="hidden rounded-lg bg-gold-400 px-3.5 py-1.5 text-sm font-bold text-beer transition hover:bg-gold-300 sm:inline-flex">{{ __('platform.nav.cta') }}</a>
            @endauth

            <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/15 text-white transition hover:bg-white/10 lg:hidden"
                @click="mobileOpen = !mobileOpen; openMenu = null"
                :aria-expanded="mobileOpen ? 'true' : 'false'"
                aria-controls="mobile-nav"
                aria-label="{{ __('platform.nav.menu') }}"
            >
                <svg x-show="!mobileOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg x-show="mobileOpen" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div
        id="mobile-nav"
        x-show="mobileOpen"
        x-cloak
        x-transition.opacity.duration.200ms
        class="fixed inset-0 z-[100] lg:hidden"
        role="dialog"
        aria-modal="true"
        aria-label="{{ __('platform.nav.main') }}"
    >
        <div class="absolute inset-0 bg-bavarian-950/70" @click="close()"></div>

        <div
            class="absolute inset-x-0 bottom-0 top-[3.6rem] flex flex-col overflow-hidden border-t border-gold-400/20 bg-bavarian-900"
            x-show="mobileOpen"
            x-transition:enter="transition transform ease-out duration-200"
            x-transition:enter-start="translate-y-4 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition transform ease-in duration-150"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-4 opacity-0"
        >
            <div class="flex-1 overflow-y-auto px-4 pt-4 pb-28">
                {{-- Search first --}}
                <form action="{{ $searchUrl }}" method="GET" class="mb-5" @submit="close()">
                    <label class="sr-only" for="mobile-search">{{ __('platform.nav.search') }}</label>
                    <div class="flex items-center gap-2 rounded-xl border-2 border-gold-400 bg-bavarian-800 px-3 py-2.5 focus-within:bg-bavarian-800/80">
                        <svg class="h-5 w-5 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            id="mobile-search"
                            type="search"
                            name="q"
                            placeholder="{{ __('platform.search.placeholder') }}"
                            class="w-full bg-transparent text-sm text-white placeholder:text-white/45 focus:outline-none"
                        >
                    </div>
                </form>

                {{-- Quick destinations as text links, not pill cards --}}
                <div class="mb-5 flex flex-wrap items-center gap-x-4 gap-y-2 border-b border-white/10 pb-4">
                    @foreach ($quick as $item)
                        <a href="{{ $item['href'] }}" @click="close()" class="text-sm font-semibold text-gold-300 underline-offset-4 hover:text-gold-200 hover:underline">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Accordion sections --}}
                <div class="space-y-2">
                    @foreach ($nav as $key => $section)
                        <div class="overflow-hidden rounded-xl border border-white/10">
                            <button
                                type="button"
                                class="flex w-full items-center justify-between bg-bavarian-800/80 px-4 py-3.5 text-left"
                                @click="toggleSection('{{ $key }}')"
                                :aria-expanded="openSection === '{{ $key }}' ? 'true' : 'false'"
                            >
                                <span class="text-[15px] font-semibold text-white">{{ $section['label'] }}</span>
                                <svg class="h-4 w-4 text-gold-400 transition" :class="openSection === '{{ $key }}' && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="openSection === '{{ $key }}'" x-cloak class="border-t border-gold-400/20 bg-cream px-3 py-3">
                                @foreach ($section['groups'] as $group)
                                    <div @class(['mt-3' => ! $loop->first])>
                                        <div class="mb-1.5 px-1 text-[11px] font-bold uppercase tracking-[0.14em] text-gold-700">
                                            {{ $group['title'] }}
                                        </div>
                                        <ul class="divide-y divide-stone-200/80 overflow-hidden rounded-lg bg-white">
                                            @foreach ($group['links'] as $link)
                                                <li>
                                                    <a
                                                        href="{{ $link['href'] }}"
                                                        @click="close()"
                                                        class="block px-3.5 py-3 text-sm font-medium text-beer transition hover:bg-gold-50 hover:text-bavarian-700"
                                                    >
                                                        {{ $link['label'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- Account --}}
                    <div class="overflow-hidden rounded-xl border border-white/10">
                        <button
                            type="button"
                            class="flex w-full items-center justify-between bg-bavarian-800/80 px-4 py-3.5 text-left"
                            @click="toggleSection('account')"
                            :aria-expanded="openSection === 'account' ? 'true' : 'false'"
                        >
                            <span class="text-[15px] font-semibold text-white">{{ __('platform.nav.account') }}</span>
                            <svg class="h-4 w-4 text-gold-400 transition" :class="openSection === 'account' && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openSection === 'account'" x-cloak x-collapse class="border-t border-gold-400/20 bg-cream px-3 py-3">
                            <ul class="divide-y divide-stone-200/80 overflow-hidden rounded-lg bg-white">
                                @auth
                                    <li>
                                        <a href="{{ route('dashboard') }}" @click="close()" class="block px-3.5 py-3 text-sm font-medium text-beer hover:bg-gold-50">{{ __('platform.nav.dashboard') }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('login') }}" @click="close()" class="block px-3.5 py-3 text-sm font-medium text-beer hover:bg-gold-50">{{ __('platform.nav.login') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('register') }}" @click="close()" class="block px-3.5 py-3 text-sm font-medium text-beer hover:bg-gold-50">{{ __('platform.nav.register') }}</a>
                                    </li>
                                @endauth
                            </ul>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('locale.switch', 'en') }}" @class(['flex-1 rounded-lg py-2 text-center text-xs font-bold', 'bg-gold-400 text-beer' => app()->getLocale() === 'en', 'bg-white text-beer' => app()->getLocale() !== 'en'])>EN</a>
                                <a href="{{ route('locale.switch', 'de') }}" @class(['flex-1 rounded-lg py-2 text-center text-xs font-bold', 'bg-gold-400 text-beer' => app()->getLocale() === 'de', 'bg-white text-beer' => app()->getLocale() !== 'de'])>DE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky CTA --}}
            <div class="absolute inset-x-0 bottom-0 border-t border-white/10 bg-bavarian-950/95 px-4 py-3 backdrop-blur">
                @auth
                    <a href="{{ route('dashboard') }}" @click="close()" class="flex w-full items-center justify-center rounded-xl bg-gold-400 py-3 text-sm font-bold text-beer">{{ __('platform.nav.dashboard') }}</a>
                @else
                    <a href="{{ route('register') }}" @click="close()" class="flex w-full items-center justify-center rounded-xl bg-gold-400 py-3 text-sm font-bold text-beer">{{ __('platform.nav.cta') }}</a>
                @endauth
            </div>
        </div>
    </div>
</header>
