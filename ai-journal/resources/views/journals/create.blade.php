<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Create Journal</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('journals.store') }}" class="bg-white rounded-xl shadow-sm border p-6 space-y-6">
                @csrf
                @include('journals._form')
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">Create Journal</button>
            </form>
        </div>
    </div>
</x-app-layout>
