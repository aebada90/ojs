<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Submit Article</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')
            <form method="POST" action="{{ route('articles.store') }}" class="bg-white rounded-xl shadow-sm border p-6 space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Journal</label>
                    <select name="journal_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a journal...</option>
                        @foreach($journals as $journal)
                            <option value="{{ $journal->id }}" @selected(old('journal_id') == $journal->id)>{{ $journal->name }}</option>
                        @endforeach
                    </select>
                    @error('journal_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Abstract</label>
                    <textarea name="abstract" rows="5" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('abstract') }}</textarea>
                    @error('abstract')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keywords (comma-separated)</label>
                    <input type="text" name="keywords" value="{{ old('keywords') }}" placeholder="machine learning, peer review, NLP" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Manuscript Content</label>
                    <textarea name="content" rows="20" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm">{{ old('content') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Include all sections: Introduction, Methods, Results, Discussion, Conclusion, References</p>
                    @error('content')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('articles.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">Submit Article</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
