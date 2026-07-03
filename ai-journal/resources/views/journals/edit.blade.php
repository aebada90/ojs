<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit Journal</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('journals.update', $journal) }}" class="bg-white rounded-xl shadow-sm border p-6 space-y-6">
                @csrf @method('PUT')
                @include('journals._form', ['journal' => $journal])
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">Save Changes</button>
            </form>
        </div>
    </div>
</x-app-layout>
