<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Articles</h2>
            @if(Auth::user()->isAuthor())
                <a href="{{ route('articles.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">+ Submit Article</a>
            @endif
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="divide-y">
                    @forelse($articles as $article)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div>
                            <a href="{{ route('articles.show', $article) }}" class="font-medium text-indigo-600 hover:underline">{{ $article->title }}</a>
                            <p class="text-sm text-gray-500">{{ $article->journal->name }} &middot; {{ $article->author->name ?? 'You' }} &middot; {{ $article->word_count }} words</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($article->review)<span class="text-sm font-medium">{{ $article->review->overall_score }}/100</span>@endif
                            <x-status-badge :label="$article->statusLabel()" :color="$article->statusColor()" />
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-12 text-center text-gray-500">No articles found.</div>
                    @endforelse
                </div>
                @if($articles->hasPages())<div class="px-6 py-4 border-t">{{ $articles->links() }}</div>@endif
            </div>
        </div>
    </div>
</x-app-layout>
