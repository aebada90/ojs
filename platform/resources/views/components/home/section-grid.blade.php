@props(['id', 'title', 'subtitle', 'items', 'type', 'alt' => false])

<section id="{{ $id }}" @class(['py-16', 'bg-white/60' => $alt, 'mx-auto max-w-7xl px-4 sm:px-6 lg:px-8' => !$alt])>
    <div @class(['mx-auto max-w-7xl px-4 sm:px-6 lg:px-8' => $alt])>
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <h2 class="section-heading">{{ $title }}</h2>
                <p class="section-subheading">{{ $subtitle }}</p>
            </div>
            <a href="{{ route('search.results', ['type' => $type]) }}" class="hidden shrink-0 items-center gap-1 text-sm font-bold text-bavarian-600 transition hover:text-gold-600 sm:inline-flex">
                {{ __('platform.sections.view_all') }}
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @if ($items->isEmpty())
            <div class="rounded-2xl border-2 border-dashed border-bavarian-200 bg-white/80 p-12 text-center text-bavarian-500">
                {{ __('platform.sections.empty_listings', ['type' => __("platform.types.{$type}")]) }}
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($items as $item)
                    <article class="card-fest group">
                        <div class="card-fest-image">
                            <div class="absolute bottom-3 left-3 rounded-full bg-bavarian-900/80 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gold-300 backdrop-blur-sm">
                                {{ __("platform.types.{$item->type}") }}
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-bavarian-900 transition group-hover:text-bavarian-600">{{ $item->title }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-bavarian-700/70">{{ $item->summary }}</p>
                            <div class="mt-4 flex items-center justify-between border-t border-bavarian-50 pt-3 text-sm">
                                <span class="font-bold text-bavarian-900">€{{ number_format((float) $item->price, 0) }}</span>
                                <span class="flex items-center gap-1 font-semibold text-gold-600">
                                    <svg class="h-3.5 w-3.5 fill-gold-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ number_format((float) $item->rating, 1) }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
