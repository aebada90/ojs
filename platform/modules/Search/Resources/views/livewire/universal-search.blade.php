<div>
    <form wire:submit="search" class="space-y-4">
        <div>
            <label class="text-sm font-semibold text-stone-700">Search everything</label>
            <input
                wire:model.live.debounce.300ms="query"
                type="search"
                placeholder="Hotels, events, rentals, products, jobs..."
                class="mt-2 w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-stone-900 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-200"
            >
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <select wire:model="type" class="rounded-2xl border border-stone-200 px-4 py-3 text-sm">
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <input wire:model="city" type="text" placeholder="City (e.g. Munich)" class="rounded-2xl border border-stone-200 px-4 py-3 text-sm">
        </div>

        <button type="submit" class="w-full rounded-2xl bg-amber-500 px-4 py-3 text-sm font-semibold text-stone-950 hover:bg-amber-400">
            Search Platform
        </button>
    </form>

    @if (count($suggestions) > 0)
        <ul class="mt-4 divide-y divide-stone-100 rounded-2xl border border-stone-200 bg-white">
            @foreach ($suggestions as $item)
                <li class="px-4 py-3 text-sm">
                    <div class="font-medium text-stone-900">{{ $item['title'] }}</div>
                    <div class="text-stone-500">{{ ucfirst($item['type']) }} • {{ $item['city'] ?? 'Munich' }}</div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
