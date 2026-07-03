<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Journal Name</label>
    <input type="text" name="name" value="{{ old('name', $journal->name ?? '') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">ISSN</label>
    <input type="text" name="issn" value="{{ old('issn', $journal->issn ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Subject Area</label>
    <input type="text" name="subject_area" value="{{ old('subject_area', $journal->subject_area ?? '') }}" placeholder="e.g. Computer Science" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
    <input type="url" name="website" value="{{ old('website', $journal->website ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
    <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $journal->description ?? '') }}</textarea>
</div>
