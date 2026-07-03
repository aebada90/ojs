<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Journals</h2>
            <a href="{{ route('journals.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">+ New Journal</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($journals as $journal)
                <a href="{{ route('journals.show', $journal) }}" class="bg-white rounded-xl shadow-sm border p-6 hover:border-indigo-300 transition block">
                    <h3 class="font-semibold text-gray-900">{{ $journal->name }}</h3>
                    @if($journal->subject_area)<span class="inline-block mt-2 px-2 py-1 bg-indigo-50 text-indigo-700 text-xs rounded">{{ $journal->subject_area }}</span>@endif
                    <p class="text-sm text-gray-500 mt-3">{{ $journal->articles_count }} articles</p>
                    @if($journal->issn)<p class="text-xs text-gray-400 mt-1">ISSN: {{ $journal->issn }}</p>@endif
                </a>
                @empty
                <div class="col-span-full text-center py-12 text-gray-500">No journals yet. <a href="{{ route('journals.create') }}" class="text-indigo-600 hover:underline">Create one</a></div>
                @endforelse
            </div>
            @if($journals->hasPages())<div class="mt-6">{{ $journals->links() }}</div>@endif
        </div>
    </div>
</x-app-layout>
