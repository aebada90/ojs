@extends('layouts.app')

@section('title', __('platform.name').' — '.__('platform.meta.home_title'))

@section('content')
    <livewire:home-page />
@endsection

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "{{ __('platform.name') }}",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@@type": "SearchAction",
    "target": "{{ route('search.results') }}?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endpush
