<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ $journal->name }}</h2>
            <a href="{{ route('journals.edit', $journal) }}" class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-50">Edit</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('partials.flash')
            <div class="bg-white rounded-xl shadow-sm border p-6">
                @if($journal->subject_area)<span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded">{{ $journal->subject_area }}</span>@endif
                <p class="mt-3 text-gray-700">{{ $journal->description }}</p>
                <div class="mt-4 flex gap-4 text-sm text-gray-500">
                    @if($journal->issn)<span>ISSN: {{ $journal->issn }}</span>@endif
                    <span>Editor: {{ $journal->editor->name }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="font-semibold">Submissions ({{ $articles->total() }})</h3></div>
                <div class="divide-y">
                    @forelse($articles as $article)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div>
                            <a href="{{ route('articles.show', $article) }}" class="font-medium text-indigo-600 hover:underline">{{ $article->title }}</a>
                            <p class="text-sm text-gray-500">{{ $article->author->name }} &middot; {{ $article->word_count }} words</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($article->review)
                                <a href="{{ route('reviews.show', $article->review) }}" class="text-sm font-medium text-indigo-600">{{ $article->review->overall_score }}/100</a>
                            @elseif($article->status === 'submitted')
                                <form method="POST" action="{{ route('articles.review', $article) }}">@csrf
                                    <button class="text-sm px-3 py-1 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Review</button>
                                </form>
                            @endif
                            <x-status-badge :label="$article->statusLabel()" :color="$article->statusColor()" />
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">No submissions yet.</div>
                    @endforelse
                </div>
                @if($articles->hasPages())<div class="px-6 py-4 border-t">{{ $articles->links() }}</div>@endif
            </div>
        </div>
    </div>
</x-app-layout>
