<x-app-layout>
	@push('seo')
		<title>Annonce {{ __(ucfirst($postType->name)).' '.$breed->name.' - '.$post->name.' - '.$post->model->company->name.' '.$post->model->company->address?->department?->name }}</title>
		<meta name="description" content="{{ Str::limit($post->model->description, 250) }}">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
		<meta property="og:title" content="Annonce {{ __(ucfirst($postType->name)).' '.$breed->name.' - '.$post->name.' - '.$post->model->company->name.' '.$post->model->company->address?->department?->name }}">
		<meta property="og:description" content="{{ Str::limit($post->model->description, 250) }}">
		@if($photo instanceof \Spatie\MediaLibrary\MediaCollections\Models\Media)
			<meta property="og:image" content="{{ $src }}" />
		@else
			<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		@endif
		<meta property="og:url" content="{{ Request::url() }}">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="{{ env('APP_NAME') }}">
		<meta property="og:locale" content="fr_FR">
	@endpush

	@include('components.front.posts.show')

	{{-- Recently viewed/published posts
	<div class="w-full  py-6">
		@if(Auth::guard('web')->check())
			<livewire:front.posts.recently-viewed :key="'recently-viewed'" />
		@else
			<livewire:front.posts.recently-published :key="'recently-published'" />
		@endif
	</div> --}}

	<div class="flex justify-center items-center mx-auto max-w-[1200px] bg-white w-full mb-8">
		<x-front.ad-slot slotName="banniere_basse" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'adoptant', 'espece' => $species->getTranslation('slug', 'fr')]" />
	</div>

	{{-- To do component create alert html ok --}}
	{{-- <div class="w-full flex flex-col items-center bg-jobboard-darkorange p-10">
		<svg width="45" height="50" viewBox="0 0 45 50" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M20.9467 42.3895C22.3445 45.1823 25.7488 46.3184 28.5374 44.9227C31.3261 43.527 32.4571 40.121 31.0594 37.3282M41.7657 28.5158L37.8162 26.3286C35.4081 25.0009 33.4515 22.9675 32.215 20.4969L29.5885 15.249C26.6547 9.38719 20.2286 6.42461 14.1056 7.62784L12.5926 4.60488C11.648 2.71745 9.37076 1.95749 7.48613 2.90073C5.6015 3.84397 4.84492 6.12231 5.78956 8.00974L7.30252 11.0327C2.66939 15.2128 1.18922 22.1324 4.12297 27.9942L6.74954 33.2422C7.98602 35.7127 8.44099 38.4976 8.06043 41.221L7.44398 45.6935C7.24607 47.0974 8.7111 48.1487 9.98284 47.5122L41.6998 31.6382C42.9716 31.0017 42.9928 29.2065 41.7657 28.5158Z" stroke="#0E1954" stroke-width="3.5" stroke-miterlimit="10"/>
		</svg>
		<h2 class="text-center font-medium leading-tight">
			{!! __('<strong>Create an alert</strong><br>for new litters') !!}
		</h2>
		<p>
			{{ __('Sign up to be notified as soon as a litter becomes available.') }}
		</p>
		<form class="bg-white rounded-xl p-6 flex justify-between items-end gap-6 my-8">
			@csrf
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="email" :value="__('Select a breed')" :required="true" :class="'pl-4'"/>
				</div>

				<select name="email" id="email" value="{{ old('email') }}" required placeholder="{{ __('Account\'s email address') }}" class="border-jobboard-greige focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md shadow-sm text-jobboard-deepblue placeholder:text-gray-400 mt-1 w-full">
				</select>

				@error('email')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>
			<div class="w-[320px]">
				<div class="flex flex-row">
					<x-front.input-label for="email" :value="__('Email address')" :required="true" :class="'pl-4'"/>
				</div>

				<x-front.text-input name="email" id="email" value="{{ old('email') }}" required placeholder="{{ __('Email address') }}" :class="'mt-1 block bg-white w-full'" />

				@error('email')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>
			<div>
				<x-front.primary-button class="">
					{{ __('Create an alert') }}

					<svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.85938 1.46777L7.31392 6.46777L1.85938 11.4678" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</x-front.primary-button>
			</div>
		</form>
	</div> --}}

	@include('components.front.footer-partner-sitemap')
</x-app-layout>
