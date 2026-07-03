<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ Str::limit($article->title, 60) }}</h2>
            <div class="flex gap-2">
                @if($article->user_id === Auth::id() && in_array($article->status, ['submitted', 'revision_required']))
                    <a href="{{ route('articles.edit', $article) }}" class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-50">Edit</a>
                @endif
                @if(!$article->review && $article->status === 'submitted')
                    <form method="POST" action="{{ route('articles.review', $article) }}">@csrf
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">Run AI Review</button>
                    </form>
                @endif
                @if($article->review)
                    <a href="{{ route('reviews.show', $article->review) }}" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">View Review Report</a>
                @endif
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('partials.flash')

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex flex-wrap gap-3 mb-4">
                    <x-status-badge :label="$article->statusLabel()" :color="$article->statusColor()" />
                    <span class="text-sm text-gray-500">{{ $article->journal->name }}</span>
                    <span class="text-sm text-gray-500">{{ $article->word_count }} words</span>
                    <span class="text-sm text-gray-500">Submitted {{ $article->submitted_at?->format('M d, Y') }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $article->title }}</h1>
                <p class="text-sm text-gray-500 mt-2">By {{ $article->author->name }}</p>
                @if($article->keywords)
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach($article->keywords as $kw)
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">{{ $kw }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-900 mb-3">Abstract</h3>
                <p class="text-gray-700 leading-relaxed">{{ $article->abstract }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-900 mb-3">Manuscript</h3>
                <div class="prose max-w-none text-gray-700 whitespace-pre-wrap text-sm leading-relaxed">{{ $article->content }}</div>
            </div>

            @if($article->review)
            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6">
                <h3 class="font-semibold text-indigo-900 mb-2">AI Review Summary</h3>
                <div class="flex items-center gap-4">
                    <div class="text-4xl font-bold text-indigo-600">{{ $article->review->overall_score }}</div>
                    <div>
                        <x-status-badge :label="$article->review->recommendationLabel()" :color="$article->review->recommendationColor()" />
                        <p class="text-sm text-indigo-800 mt-2">{{ $article->review->summary }}</p>
                    </div>
                </div>
                <a href="{{ route('reviews.show', $article->review) }}" class="inline-block mt-4 text-sm text-indigo-600 hover:underline">View full review report &rarr;</a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
