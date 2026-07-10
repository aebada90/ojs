<div class="space-y-4">
    <div class="max-h-96 space-y-3 overflow-y-auto">
        @forelse ($conversation as $message)
            <div @class([
                'rounded-2xl px-4 py-3 text-sm',
                'bg-amber-50 text-stone-800' => $message['role'] === 'user',
                'bg-stone-100 text-stone-700' => $message['role'] === 'assistant',
            ])>
                {{ $message['content'] }}
            </div>
        @empty
            <p class="text-sm text-stone-500">Ask me to plan your Oktoberfest trip, recommend hotels, or find the best beer tents.</p>
        @endforelse
    </div>

    <form wire:submit="send" class="flex gap-3">
        <input
            wire:model="message"
            type="text"
            placeholder="Plan a 3-day Munich trip with hotels and beer tours..."
            class="flex-1 rounded-2xl border border-stone-200 px-4 py-3 text-sm focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-200"
        >
        <button type="submit" class="rounded-2xl bg-stone-900 px-5 py-3 text-sm font-semibold text-white hover:bg-stone-800">
            Ask AI
        </button>
    </form>
</div>
