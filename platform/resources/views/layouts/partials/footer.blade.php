<footer class="relative overflow-hidden bg-beer text-white/80">
    {{-- Decorative top border --}}
    <div class="h-1.5 bg-gradient-to-r from-bavarian-500 via-gold-400 to-bavarian-500"></div>

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🍺</span>
                    <div class="font-display text-2xl font-bold text-white">{{ __('platform.name') }}</div>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-white/60">{{ __('platform.tagline') }}</p>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-gold-400">{{ __('platform.footer.discover') }}</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="#hotels" class="transition hover:text-gold-300">{{ __('platform.nav.hotels') }}</a></li>
                    <li><a href="#rentals" class="transition hover:text-gold-300">{{ __('platform.nav.rentals') }}</a></li>
                    <li><a href="#marketplace" class="transition hover:text-gold-300">{{ __('platform.nav.marketplace') }}</a></li>
                    <li><a href="#events" class="transition hover:text-gold-300">{{ __('platform.nav.events') }}</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-gold-400">{{ __('platform.footer.business') }}</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="#" class="transition hover:text-gold-300">{{ __('platform.footer.become_vendor') }}</a></li>
                    <li><a href="#" class="transition hover:text-gold-300">{{ __('platform.footer.list_property') }}</a></li>
                    <li><a href="#" class="transition hover:text-gold-300">{{ __('platform.footer.post_job') }}</a></li>
                    <li><a href="#" class="transition hover:text-gold-300">{{ __('platform.footer.event_organizer') }}</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-gold-400">{{ __('platform.footer.newsletter') }}</h3>
                <p class="mt-4 text-sm text-white/60">{{ __('platform.footer.newsletter_text') }}</p>
                <form class="mt-4 flex gap-2" onsubmit="return false;">
                    <input type="email" placeholder="{{ __('platform.footer.email_placeholder') }}" class="w-full rounded-xl border border-white/15 bg-white/5 px-4 py-2.5 text-sm text-white placeholder:text-white/40 focus:border-gold-400 focus:outline-none">
                    <button class="shrink-0 rounded-xl bg-gradient-to-r from-gold-400 to-gold-500 px-4 py-2.5 text-sm font-bold text-beer transition hover:from-gold-300">{{ __('platform.footer.join') }}</button>
                </form>
            </div>
        </div>
        <div class="mt-12 flex flex-col gap-4 border-t border-white/10 pt-8 text-sm text-white/50 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ __('platform.name') }}. {{ __('platform.footer.rights') }}</p>
            <div class="flex gap-6">
                <a href="#" class="transition hover:text-gold-300">{{ __('platform.footer.privacy') }}</a>
                <a href="#" class="transition hover:text-gold-300">{{ __('platform.footer.terms') }}</a>
                <a href="#" class="transition hover:text-gold-300">{{ __('platform.footer.cookies') }}</a>
            </div>
        </div>
    </div>
</footer>
