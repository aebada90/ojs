<footer class="border-t border-stone-200 bg-stone-950 text-stone-300">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="font-display text-2xl font-bold text-white">{{ config('platform.name') }}</div>
                <p class="mt-4 text-sm leading-6 text-stone-400">{{ config('platform.tagline') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Discover</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#hotels" class="hover:text-amber-400">Hotels</a></li>
                    <li><a href="#rentals" class="hover:text-amber-400">Rentals</a></li>
                    <li><a href="#marketplace" class="hover:text-amber-400">Marketplace</a></li>
                    <li><a href="#events" class="hover:text-amber-400">Events</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">For Business</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#" class="hover:text-amber-400">Become a Vendor</a></li>
                    <li><a href="#" class="hover:text-amber-400">List Your Property</a></li>
                    <li><a href="#" class="hover:text-amber-400">Post a Job</a></li>
                    <li><a href="#" class="hover:text-amber-400">Event Organizer</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Newsletter</h3>
                <p class="mt-4 text-sm text-stone-400">Get AI-curated festival tips and exclusive deals.</p>
                <form class="mt-4 flex gap-2" onsubmit="return false;">
                    <input type="email" placeholder="Email address" class="w-full rounded-xl border border-stone-700 bg-stone-900 px-4 py-2 text-sm text-white placeholder:text-stone-500">
                    <button class="rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-stone-950 hover:bg-amber-400">Join</button>
                </form>
            </div>
        </div>
        <div class="mt-12 flex flex-col gap-4 border-t border-stone-800 pt-8 text-sm text-stone-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ config('platform.name') }}. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white">Privacy</a>
                <a href="#" class="hover:text-white">Terms</a>
                <a href="#" class="hover:text-white">Cookies</a>
            </div>
        </div>
    </div>
</footer>
