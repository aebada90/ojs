<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editor Dashboard</h2>
            <a href="{{ route('journals.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">+ New Journal</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('partials.flash')

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-indigo-600">{{ $stats['journals'] }}</div><div class="text-sm text-gray-500 mt-1">My Journals</div></div>
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-amber-600">{{ $stats['pending'] }}</div><div class="text-sm text-gray-500 mt-1">Pending Review</div></div>
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-green-600">{{ $stats['reviewed'] }}</div><div class="text-sm text-gray-500 mt-1">Reviewed</div></div>
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-purple-600">{{ $stats['avg_score'] ? number_format($stats['avg_score'], 1) : '—' }}</div><div class="text-sm text-gray-500 mt-1">Avg Score</div></div>
            </div>

            @if($journals->count())
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($journals as $journal)
                <a href="{{ route('journals.show', $journal) }}" class="bg-white p-6 rounded-xl shadow-sm border hover:border-indigo-300 transition block">
                    <h3 class="font-semibold text-gray-900">{{ $journal->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $journal->articles_count }} articles</p>
                </a>
                @endforeach
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="font-semibold">Recent Submissions</h3></div>
                <div class="divide-y">
                    @forelse($articles as $article)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div>
                            <a href="{{ route('articles.show', $article) }}" class="font-medium text-indigo-600 hover:underline">{{ Str::limit($article->title, 60) }}</a>
                            <p class="text-sm text-gray-500">{{ $article->author->name }} &middot; {{ $article->journal->name }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($article->review)<span class="text-sm font-medium">{{ $article->review->overall_score }}/100</span>@endif
                            <x-status-badge :label="$article->statusLabel()" :color="$article->statusColor()" />
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">No submissions yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
