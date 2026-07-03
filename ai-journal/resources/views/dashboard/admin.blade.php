<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('partials.flash')

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach(['users' => 'Users', 'journals' => 'Journals', 'articles' => 'Articles', 'reviews' => 'Reviews'] as $key => $label)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats[$key] }}</div>
                    <div class="text-sm text-gray-500 mt-1">{{ $label }}</div>
                </div>
                @endforeach
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Recent Submissions</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Journal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentArticles as $article)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"><a href="{{ route('articles.show', $article) }}" class="text-indigo-600 hover:underline text-sm font-medium">{{ Str::limit($article->title, 50) }}</a></td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $article->journal->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $article->author->name }}</td>
                                <td class="px-6 py-4"><x-status-badge :label="$article->statusLabel()" :color="$article->statusColor()" /></td>
                                <td class="px-6 py-4 text-sm">{{ $article->review?->overall_score ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No articles yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
