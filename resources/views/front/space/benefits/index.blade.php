<x-space-layout>
	@push('seo')
		<title>{{ __('My space') }}</title>
		<meta name="description" content="{{ __(':siteName', ['siteName' => env('APP_NAME')]) }}">
		<meta name="keywords" content="{{ __(':siteName, ', ['siteName' => env('APP_NAME')]) }}" />
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
	@endpush

	<x-slot name="side_menu">
		@include('components.front.space.profile.side-menu')
	</x-slot>
	
	<div class="w-full mt-8">
		<x-front.form-part-title>
			{{ __('My benefits') }}
		</x-front.form-part-title>
	
		<hr class="h-px border border-jobboard-deepblue w-full my-[30px]">
	</div>

	<div x-data="{width: (window.innerWidth > 0) ? window.innerWidth : screen.width}" class="w-full bg-white pl-6 max-md:pr-6 py-10 mb-6">
		@if($user->hasRole('adopter'))
			{{-- <div class="w-full flex flex-col justify-between bg-jobboard-orange text-jobboard-deepblue rounded-xl min-h-[480px] md:min-h-[507px] p-6 xlsm:p-12">
				<div class="flex gap-x-4">
					<svg class="flex-none" width="47" height="53" viewBox="0 0 47 53" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_1707_24927)">
						<path d="M17.7354 23.5372H29.4223C28.6288 17.2991 18.7285 17.2991 17.7354 23.5372Z" fill="#0E1954"/>
						<path d="M44.2148 11.1861L26.2903 0.750367C24.5667 -0.256633 22.4385 -0.256633 20.7149 0.750367L2.79036 11.1861C1.06675 12.1931 0 14.0481 0 16.0568V36.9281C0 38.9368 1.06149 40.7971 2.79036 41.7988L20.7149 52.2345C22.4385 53.2415 24.5667 53.2415 26.2903 52.2345L44.2148 41.7988C45.9385 40.7918 47.0052 38.9368 47.0052 36.9281V16.0621C47.0052 14.0534 45.9437 12.1931 44.2148 11.1914V11.1861ZM33.2951 34.983C32.9851 35.3593 32.654 35.6932 32.3072 35.99C31.561 36.6737 30.7255 37.2514 29.7954 37.739C28.8652 38.2213 27.851 38.5976 26.7528 38.8679C26.222 38.9951 25.6755 39.0905 25.108 39.1647C24.5404 39.2336 23.9624 39.2707 23.3739 39.2707C21.8657 39.2707 20.4994 39.0693 19.2698 38.6665C18.0401 38.2637 16.9524 37.7231 15.9907 37.0394C14.9134 36.2868 14.0096 35.3593 13.2844 34.2993L19.0806 31.8507C19.4537 32.2111 19.8478 32.5026 20.2577 32.7358C20.6676 32.969 21.1721 33.1492 21.7553 33.2711C22.0076 33.3453 22.2808 33.3983 22.5646 33.4301C22.8484 33.4672 23.1479 33.4831 23.4632 33.4831C24.4038 33.4831 25.2656 33.34 26.0539 33.0538C26.8368 32.7676 27.4727 32.3648 27.9667 31.8454L34.0834 33.9177C33.8364 34.2993 33.5789 34.6544 33.3056 34.983H33.2951ZM36.1643 28.5965H10.988C10.8882 27.9446 10.8356 26.3069 10.8356 25.6073C10.8356 24.2612 11.0511 22.9733 11.4767 21.7384C11.9024 20.5035 12.5067 19.4011 13.2792 18.4312C14.0727 17.4454 15.0028 16.6027 16.0695 15.9031C17.1363 15.2035 18.3134 14.6682 19.5956 14.2919C20.8988 13.9156 22.2493 13.7248 23.6524 13.7248C25.0554 13.7248 26.3481 13.9262 27.6514 14.329C28.9546 14.7318 30.1001 15.2936 31.0986 16.0091C32.1338 16.7617 33.0376 17.6203 33.7996 18.5902C34.5616 19.5601 35.1449 20.6519 35.5548 21.8709C35.9594 23.0528 36.1643 24.2983 36.1643 25.6073V28.5965Z" fill="#0E1954"/>
						</g>
						<defs>
						<clipPath id="clip0_1707_24927">
						<rect width="47" height="53" fill="white"/>
						</clipPath>
						</defs>
					</svg>

					<h1 class="md:text-[40px] text-[28px] font-normal"><strong>{{__('Special package')}}</strong> {{__('New puppy or kitten')}} !</h1>
				</div>

				<p class="md:text-base text-sm font-medium">{{__('For any adoption made on breeders-online')}}</p>

				<livewire:front.space.benefits.benefits 
					:type="'package-special'" 
					:withNav="true" 
					:key="'benefits-available-type-package-special'" />
			</div> --}}
		@endif
		
		@if($benefitTypesAvailable->isNotEmpty())
			@foreach($benefitTypesAvailable as $benefitTypeAvailable)
				@if($benefitTypeAvailable->benefits->count() > 0)
					<div class="mt-10">
						<div class="mb-6">
							<x-front.space-title>
								{{ $benefitTypeAvailable->name }}
							</x-front.space-title>
						</div>

						<div class="flex flex-row items-stretch w-full">
							<livewire:front.space.benefits.benefits 
								:type="$benefitTypeAvailable->slug" 
								:withNav="true" 
								:key="'benefits-available-type-'.$benefitTypeAvailable->slug" />
						</div>
					</div>
					@if($loop->index == 0)
						@php
							if ($user->hasRole('professionnal')) $targetRole = 'pro';
							elseif ($user->hasRole('adopter')) $targetRole = 'adoptant';
							else $targetRole = 'eleveur';
						@endphp
						<div class="flex justify-center items-center mx-auto max-w-[1000px] w-full">
							<x-front.ad-slot slotName="banniere_basse" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => $targetRole, 'loggue' => 'loggue']" />
						</div>
					@endif
				@endif
			@endforeach
		@endif
	</div>
</x-space-layout>
