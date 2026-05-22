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

	@php
		$conditionMet = Auth::guard('web')->user()->checkBenefitConditions($benefit->condition);
	@endphp

	<a href="{{ route('space.benefits.my-benefits') }}"
		class="flex gap-x-2 items-center font-bold text-sm text-jobboard-deepblue my-6">
		<svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M6.51269 1.5L2.14906 5.5L6.5127 9.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round"
				stroke-linejoin="round" />
		</svg>

		{{ __('All my benefits') }}
	</a>

	<div class="flex flex-col s:flex-row lg:min-h-[600px] bg-jobboard-cream rounded-2xl text-jobboard-deepblue">
		<div class="flex-1">
			<div class="w-full">
				<div class="overflow-hidden max-h-80 flex justify-center items-stretch rounded-t-2xl">
					@if($banner = $benefit->getFirstMedia('banner'))
						<img src="{{ $banner->getAvailableUrl(['optimized']) }}" alt="{{ $benefit->name }}" class="object-cover w-full min-h-[281px]" />
					@else
						<img src="{{ asset('storage/default-benefit-image.png') }}" alt="{{ $benefit->name }}" class="object-cover w-full min-h-[281px]" />
					@endif
				</div>

				<div class="flex justify-between">
					<div class="flex flex-row gap-x-6 -mt-[140px] ml-[83px]">
						@if($logo = $benefit->getFirstMedia('logo'))
							<div class="shadow-md aspect-square rounded-xl bg-white flex justify-center items-center">
								<div class="overflow-hidden rounded-xl w-[170px] h-[170px]">
									<img src="{{ $logo->getAvailableUrl(['optimized']) }}" class="rounded-xl object-cover object-center" />
								</div>
							</div>
						@endif

						<div class="flex flex-col gap-2">
							<div class="text-white text-[28px] md:text-[40px] font-bold truncate">
								<span title="{{ $benefit->partner }}">
									{{ $benefit->partner }}
								</span>
							</div>

							<div class="flex flex-row gap-x-4">
								<x-front.benefits.tag :class="'bg-jobboard-cream'">
									{{ $benefit->benefitType->name }}
								</x-front.benefits.tag>

								@if($benefit->species)
									@foreach($benefit->species as $specie)
										<x-front.benefits.tag :class="'capitalize bg-jobboard-cream'">
											{{ __($specie->name) }}
										</x-front.benefits.tag>
									@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>

				<div class="flex flex-col gap-2 ml-[83px] mt-8">
					<div class="flex flex-row font-bold text-[28px]">
						{{ $benefit->name }}
					</div>

					@if($benefit->code)
						<div x-data="{ textToCopy: '{{ $benefit->code }}', copied: false }" @click="navigator.clipboard.writeText(textToCopy).then(() => { copied = true })" class="flex-none">
							<div class="inline-flex flex-row justify-center items-center cursor-pointer font-medium text-sm p-4 rounded-xl bg-jobboard-orange gap-x-1">
								{{ __('use this code') }}

								<span class="uppercase font-bold">{{ $benefit->code }}</span>

								<svg x-show="!copied" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.55 12.55H2.7C2.24913 12.55 1.81673 12.3709 1.49792 12.0521C1.17911 11.7333 1 11.3009 1 10.85V3.2C1 2.74913 1.17911 2.31673 1.49792 1.99792C1.81673 1.67911 2.24913 1.5 2.7 1.5H10.35C10.8009 1.5 11.2333 1.67911 11.5521 1.99792C11.8709 2.31673 12.05 2.74913 12.05 3.2V4.05M8.65 7.45H16.3C17.2389 7.45 18 8.21112 18 9.15V16.8C18 17.7389 17.2389 18.5 16.3 18.5H8.65C7.71112 18.5 6.95 17.7389 6.95 16.8V9.15C6.95 8.21112 7.71112 7.45 8.65 7.45Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
								</svg>

								<svg x-show="copied" width="19" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="transition-opacity duration-200">
									<path d="M5 13L9 17L19 7" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
						</div>
					@endif

					<div class="flex flex-row w-full gap-6 max-w-[750px] font-medium text-base">
						{{ $benefit->description }}
					</div>

					<div class="flex-none mb-4">
						<x-front.primary-button x-data="{ website: '{{ $benefit->link }}'}" @click.prevent="window.open(website, '_blank')">{{ __('I\'m taking advantage of it') }}</x-front.primary-button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<p class="text-jobboard-deepblue text-xs font-medium mt-6 mb-8">
		<strong>{{ __('Duration of the benefit') }} :</strong>
		{{ __('Available until :date', ['date' => $benefit->end_date->format('d/m/Y')]) }}
	</p>

	@if($benefit->condition->value != 'none')
		<p class="text-jobboard-deepblue text-xs font-medium mt-6 mb-8">
			<strong>{{ __('Conditions') }} :</strong> {{ __($benefit->condition->inHuman()) }}
		</p>
	@endif
</x-space-layout>
