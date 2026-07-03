<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">AI Review Report</h2>
            <a href="{{ route('articles.show', $review->article) }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to article</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('partials.flash')

            {{-- Header --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h1 class="text-xl font-bold text-gray-900">{{ $review->article->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $review->article->journal->name }} &middot; Reviewed {{ $review->completed_at?->format('M d, Y H:i') }}</p>
                <div class="mt-6 flex flex-wrap items-center gap-6">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-indigo-600">{{ number_format($review->overall_score, 1) }}</div>
                        <div class="text-sm text-gray-500">Overall Score</div>
                    </div>
                    <div>
                        <x-status-badge :label="$review->recommendationLabel()" :color="$review->recommendationColor()" />
                        <p class="text-gray-700 mt-3 max-w-xl">{{ $review->summary }}</p>
                    </div>
                </div>
            </div>

            {{-- Criteria Scores --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Criteria Scores</h3>
                <div class="space-y-4">
                    @foreach($criteriaLabels as $key => $label)
                        @php $score = $review->criteria_scores[$key] ?? 0; @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">{{ $label }}</span>
                                <span class="font-semibold {{ $score >= 70 ? 'text-green-600' : ($score >= 50 ? 'text-amber-600' : 'text-red-600') }}">{{ number_format($score, 0) }}/100</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full {{ $score >= 70 ? 'bg-green-500' : ($score >= 50 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $score }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Flags --}}
            @if(!empty($review->flags))
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Flagged Issues</h3>
                <div class="space-y-2">
                    @foreach($review->flags as $flag)
                    <div class="flex items-start gap-3 p-3 rounded-lg {{ ($flag['type'] ?? '') === 'error' ? 'bg-red-50 border border-red-200' : 'bg-amber-50 border border-amber-200' }}">
                        <span class="text-xs font-bold uppercase mt-0.5 {{ ($flag['type'] ?? '') === 'error' ? 'text-red-600' : 'text-amber-600' }}">{{ $flag['type'] ?? 'info' }}</span>
                        <p class="text-sm text-gray-700">{{ $flag['message'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Feedback --}}
            <div class="grid md:grid-cols-3 gap-6">
                @foreach(['strengths' => ['green', 'Strengths'], 'weaknesses' => ['red', 'Weaknesses'], 'suggestions' => ['blue', 'Suggestions']] as $key => [$color, $title])
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="font-semibold text-{{ $color }}-700 mb-3">{{ $title }}</h3>
                    <ul class="space-y-2">
                        @forelse($review->feedback[$key] ?? [] as $item)
                            <li class="text-sm text-gray-700 flex gap-2"><span class="text-{{ $color }}-500 mt-1">&bull;</span>{{ $item }}</li>
                        @empty
                            <li class="text-sm text-gray-400">None identified.</li>
                        @endforelse
                    </ul>
                </div>
                @endforeach
            </div>

            {{-- Editor Notes --}}
            @if(Auth::user()->isJournalEditor() || Auth::user()->isAdmin())
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-900 mb-3">Editor Notes</h3>
                <form method="POST" action="{{ route('reviews.notes', $review) }}">
                    @csrf @method('PATCH')
                    <textarea name="editor_notes" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Add private notes for editorial team...">{{ old('editor_notes', $review->editor_notes) }}</textarea>
                    <button type="submit" class="mt-3 px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900">Save Notes</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
