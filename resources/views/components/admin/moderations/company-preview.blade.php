<x-app-layout>
	@push('seo')
		<title>{{ $company->name }} entreprise de {{ $company->breeds->first()?->name }} à {{ $company->address?->city?->name }} - {{ $company->address?->department?->name }}</title>
		<meta name="description" content="{{ Str::limit($company->description, 250) }}">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
	@endpush

	@include('components.front.companies.show')
</x-app-layout>
