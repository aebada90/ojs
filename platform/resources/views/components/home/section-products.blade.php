@props(['id', 'title', 'subtitle', 'products'])

<section id="{{ $id }}" class="bg-gradient-to-b from-white to-cream py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <h2 class="section-heading">{{ $title }}</h2>
                <p class="section-subheading">{{ $subtitle }}</p>
            </div>
            <a href="{{ route('search.results', ['type' => 'product']) }}" class="hidden text-sm font-bold text-bavarian-600 hover:text-gold-600 sm:inline">{{ __('platform.sections.view_all') }} →</a>
        </div>

        @if ($products->isEmpty())
            <div class="rounded-2xl border-2 border-dashed border-bavarian-200 bg-white p-12 text-center text-bavarian-500">
                {{ __('platform.sections.empty_products') }}
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($products as $product)
                    <article class="card-fest group">
                        <div class="aspect-square bg-gradient-to-br from-gold-50 via-cream to-bavarian-50 relative overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center text-4xl opacity-30">🛍️</div>
                            @if ($product->is_featured)
                                <span class="absolute left-3 top-3 rounded-full bg-gold-400 px-2 py-0.5 text-[10px] font-bold uppercase text-beer">Featured</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-bavarian-900 group-hover:text-bavarian-600">{{ $product->name }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-bavarian-700/70">{{ $product->summary }}</p>
                            <div class="mt-4 text-lg font-bold text-bavarian-800">€{{ number_format((float) $product->price, 2) }}</div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
