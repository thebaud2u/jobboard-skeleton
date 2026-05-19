<x-app-layout>
	@push('seo')
		<title>{{ $company->name }} entreprise à {{ $company->address?->city?->name }} - {{ $company->address?->department?->name }}</title>
		<meta name="description" content="{{ Str::limit($company->description, 250) }}">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
		<meta property="og:title" content="{{ $company->name }} entreprise à {{ $company->address?->city?->name }} - {{ $company->address?->department?->name }}">
		<meta property="og:description" content="{{ Str::limit($company->description, 250) }}">

		@if($photos->first())
			<meta property="og:image" content="{{ $photos->first()->getAvailableUrl(['optimized']) }}" />
		@else
			<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		@endif

		<meta property="og:url" content="{{ Request::url() }}">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="{{ env('APP_NAME') }}">
		<meta property="og:locale" content="fr_FR">
	@endpush

	@include('components.front.companies.show')

	{{-- Recently viewed/published posts
		<div class="w-full  py-6">
			@if(Auth::guard('web')->check())
				<livewire:front.posts.recently-viewed :key="'recently-viewed'" />
			@else
				<livewire:front.posts.recently-published :key="'recently-published'" />
			@endif
		</div>
	--}}
</x-app-layout>
