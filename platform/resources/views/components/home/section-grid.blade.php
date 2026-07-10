@props(['id', 'title', 'subtitle', 'items', 'type'])

<section id="{{ $id }}" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="mb-8 flex items-end justify-between gap-4">
        <div>
            <h2 class="font-display text-3xl font-bold text-stone-900">{{ $title }}</h2>
            <p class="mt-2 text-stone-600">{{ $subtitle }}</p>
        </div>
        <a href="{{ route('search.results', ['type' => $type]) }}" class="hidden text-sm font-semibold text-amber-700 hover:text-amber-800 sm:inline">View all →</a>
    </div>

    @if ($items->isEmpty())
        <div class="rounded-3xl border border-dashed border-stone-300 bg-white p-10 text-center text-stone-500">
            Featured {{ str($type)->headline() }} listings will appear here after seeding.
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($items as $item)
                <article class="group overflow-hidden rounded-3xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="aspect-[4/3] bg-gradient-to-br from-amber-100 to-orange-100"></div>
                    <div class="p-5">
                        <div class="text-xs font-semibold uppercase tracking-wider text-amber-700">{{ str($item->type)->headline() }}</div>
                        <h3 class="mt-2 font-semibold text-stone-900 group-hover:text-amber-700">{{ $item->title }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm text-stone-600">{{ $item->summary }}</p>
                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="font-semibold text-stone-900">€{{ number_format((float) $item->price, 0) }}</span>
                            <span class="text-amber-600">★ {{ number_format((float) $item->rating, 1) }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>
