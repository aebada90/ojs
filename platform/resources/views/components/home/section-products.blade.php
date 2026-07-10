@props(['id', 'title', 'subtitle', 'products'])

<section id="{{ $id }}" class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h2 class="font-display text-3xl font-bold text-stone-900">{{ $title }}</h2>
            <p class="mt-2 text-stone-600">{{ $subtitle }}</p>
        </div>

        @if ($products->isEmpty())
            <div class="rounded-3xl border border-dashed border-stone-300 p-10 text-center text-stone-500">
                Marketplace products will appear here after seeding.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($products as $product)
                    <article class="overflow-hidden rounded-3xl border border-stone-200 bg-stone-50 shadow-sm">
                        <div class="aspect-square bg-gradient-to-br from-stone-100 to-amber-50"></div>
                        <div class="p-5">
                            <h3 class="font-semibold text-stone-900">{{ $product->name }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-stone-600">{{ $product->summary }}</p>
                            <div class="mt-4 text-sm font-semibold">€{{ number_format((float) $product->price, 2) }}</div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
