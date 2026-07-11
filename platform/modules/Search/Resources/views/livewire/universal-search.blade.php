<div>
    @php
        $inputClass = $variant === 'hero'
            ? 'w-full rounded-xl border border-white/20 bg-white/90 px-4 py-3.5 text-bavarian-900 shadow-inner placeholder:text-bavarian-400 focus:border-gold-400 focus:outline-none focus:ring-2 focus:ring-gold-400/30'
            : 'w-full rounded-xl border border-bavarian-200 bg-white px-4 py-3.5 text-bavarian-900 placeholder:text-bavarian-400 focus:border-gold-400 focus:outline-none focus:ring-2 focus:ring-gold-400/20';
        $selectClass = $variant === 'hero'
            ? 'rounded-xl border border-white/20 bg-white/90 px-4 py-3 text-sm text-bavarian-800 focus:border-gold-400 focus:outline-none'
            : 'rounded-xl border border-bavarian-200 bg-white px-4 py-3 text-sm text-bavarian-800 focus:border-gold-400 focus:outline-none';
    @endphp

    <form wire:submit="search" class="space-y-4">
        <div>
            @if ($variant !== 'hero')
                <label class="mb-1 block text-sm font-semibold text-bavarian-700">{{ __('platform.search.label') }}</label>
            @endif
            <input
                wire:model.live.debounce.300ms="query"
                type="search"
                placeholder="{{ __('platform.search.placeholder') }}"
                class="{{ $inputClass }}"
            >
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <select wire:model="type" class="{{ $selectClass }}">
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <input wire:model="city" type="text" placeholder="{{ __('platform.search.city_placeholder') }}" class="{{ $selectClass }}">
        </div>

        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-gold-400 to-gold-500 py-3.5 text-sm font-bold text-beer shadow-lg transition hover:from-gold-300 hover:to-gold-400">
            {{ __('platform.search.submit') }}
        </button>
    </form>

    @if (count($suggestions) > 0)
        <ul @class([
            'mt-4 divide-y overflow-hidden rounded-xl shadow-lg',
            'divide-bavarian-100 border border-bavarian-200 bg-white' => $variant !== 'hero',
            'divide-bavarian-100 border border-white/20 bg-white/95' => $variant === 'hero',
        ])>
            @foreach ($suggestions as $item)
                <li class="px-4 py-3 text-sm transition hover:bg-gold-50">
                    <div class="font-semibold text-bavarian-900">{{ $item['title'] }}</div>
                    <div class="text-bavarian-500">{{ __("platform.types.{$item['type']}") }} • {{ $item['city'] ?? config('platform.default_city') }}</div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
