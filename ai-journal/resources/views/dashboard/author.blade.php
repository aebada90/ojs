<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Author Dashboard</h2>
            <a href="{{ route('articles.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">+ Submit Article</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('partials.flash')

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-indigo-600">{{ $stats['submitted'] }}</div><div class="text-sm text-gray-500 mt-1">Total Submissions</div></div>
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-blue-600">{{ $stats['under_review'] }}</div><div class="text-sm text-gray-500 mt-1">Under Review</div></div>
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-green-600">{{ $stats['accepted'] }}</div><div class="text-sm text-gray-500 mt-1">Accepted</div></div>
                <div class="bg-white p-6 rounded-xl shadow-sm border"><div class="text-3xl font-bold text-amber-600">{{ $stats['revision'] }}</div><div class="text-sm text-gray-500 mt-1">Needs Revision</div></div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-semibold">My Articles</h3>
                    <a href="{{ route('articles.index') }}" class="text-sm text-indigo-600 hover:underline">View all</a>
                </div>
                <div class="divide-y">
                    @forelse($articles as $article)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div>
                            <a href="{{ route('articles.show', $article) }}" class="font-medium text-indigo-600 hover:underline">{{ $article->title }}</a>
                            <p class="text-sm text-gray-500">{{ $article->journal->name }} &middot; {{ $article->submitted_at?->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($article->review)
                                <a href="{{ route('reviews.show', $article->review) }}" class="text-sm text-indigo-600 hover:underline">{{ $article->review->overall_score }}/100</a>
                            @elseif($article->status === 'submitted')
                                <form method="POST" action="{{ route('articles.review', $article) }}">
                                    @csrf
                                    <button type="submit" class="text-sm px-3 py-1 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Run AI Review</button>
                                </form>
                            @endif
                            <x-status-badge :label="$article->statusLabel()" :color="$article->statusColor()" />
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <p>No articles submitted yet.</p>
                        <a href="{{ route('articles.create') }}" class="mt-2 inline-block text-indigo-600 hover:underline">Submit your first article</a>
                    </div>
                    @endforelse
                </div>
            </div>

            @if($journals->count())
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold mb-4">Available Journals</h3>
                <div class="grid md:grid-cols-2 gap-3">
                    @foreach($journals as $journal)
                    <div class="p-4 border rounded-lg">
                        <h4 class="font-medium">{{ $journal->name }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $journal->subject_area }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
