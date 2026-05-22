@props([
	'showCommentComponent' => false,
	'company' => null,
	'addressInFrance' => false,
	'addressPart' => null
])

@if(!$showCommentComponent)
	<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}" class="w-full border border-jobboard-greige rounded-xl flex flex-col">
@else
	<div class="w-full border border-jobboard-greige rounded-xl flex flex-col">
@endif
	<div class="flex flex-row bg-jobboard-cream text-jobboard-deepblue p-6 justify-start items-center gap-x-8 rounded-t-xl max-h-[118px]">
		@if($logo = $company->getFirstMedia('logo'))
			<div class="relative w-[118px] h-[118px] md:w-[140px] md:h-[140px] max-sm:hidden">
				<img src="{{ $logo->getAvailableUrl(['optimized']) }}" class="md:absolute md:-bottom-[40px] inline-block object-cover w-[118px] h-[118px] md:w-[140px] md:h-[140px] rounded-full" />
			</div>
		@endif

		<div class="flex flex-col font-medium">
			<strong class="text-[24px] md:text-[28px] mb-1">{{ $company->name }}</strong>

			@php
				$x = $company->countCommentsReceivedPublished();
			@endphp
			{{ $x > 1 ? __(':x comments', ['x' => $x]) : __(':x comment', ['x' => $x]) }}
		</div>
	</div>

	<div class="flex flex-col gap-y-4 md:flex-row bg-white text-jobboard-deepblue p-6 rounded-b-xl md:justify-between @if($logo = $company->getFirstMedia('logo')) md:ml-[160px] @endif gap-x-8">
		<div class="flex flex-col">
			<div class="flex flex-row flex-wrap gap-2 justify-start items-center max-w-[408px]">
				@if($company->hasPureBreedBreeders())
					@if($addressInFrance)
						@php
							$pureBreedTypes = $company->getTypeOfPureBreedBreeders();
						@endphp

						@if($pureBreedTypes['LOOF'])
							<span class="px-3 py-1 rounded-md font-medium bg-jobboard-green text-jobboard-deepblue text-sm w-fit">
								LOOF
							</span>
						@endif

						@if($pureBreedTypes['LOF'])
							<span class="px-3 py-1 rounded-md font-medium bg-jobboard-coral text-jobboard-deepblue text-sm w-fit">
								LOF
							</span>
						@endif
					@else
						{{ __('Origin book') }}
					@endif
				@endif

				@if($company->littersAvailable->count() > 0)
					<span class="px-3 py-1 rounded-md font-medium bg-jobboard-violet text-jobboard-deepblue text-sm w-fit break-keep shrink-0">
						{{ $company->littersAvailable->count() > 1 ? __('Litters available') : __('Litter available') }}
					</span>
				@endif

				@php
					$breeds = $company->breeds;
					$count = $breeds->count();
				@endphp
				@if($breeds->isNotEmpty())
					<span class="px-3 py-1 rounded-md font-medium bg-jobboard-cream text-jobboard-deepblue text-sm w-fit shrink-0" title="{{ $breeds->first()->name }}">
						{{ Str::limit($breeds->first()->name, 10) }}
					</span>

					@if($count > 1)
						<span class="px-3 py-1 rounded-md font-medium bg-jobboard-cream text-jobboard-deepblue text-sm w-fit">
							{{ '+'.$count-1 }}
						</span>
					@endif
				@endif
			</div>

			<div class="flex flex-col gap-y-2 mt-6 text-sm font-medium">
				@if($company->user->hasRole('professionnal_breeder') && $company->user->lastModeration?->isValidated())
					<div class="flex flex-row gap-x-4 flex-wrap">
						<span class="w-[136px]">
							{{ __('Siret') }}
						</span>

						<strong>
							{{ $company->user->values->get('siret') }}
						</strong>
					</div>
				@endif

				<div class="flex flex-row gap-x-4 flex-wrap">
					<span class="w-[136px]">
						{{ __('Status') }}
					</span>

					<strong>
						{{ $company->user->hasRole('professionnal_breeder') ? __('Professionnal') : __('Individual') }}
					</strong>
				</div>

				@if($company->user->last_logon)
					<div class="flex flex-row gap-x-4 flex-wrap">
						<span class="w-[136px]">
							{{ __('Last seen online') }}
						</span>

						<strong>
							{{ $company->user->last_logon->diffForHumans() }}
						</strong>
					</div>
				@endif

				<div class="flex flex-row gap-x-4 flex-wrap">
					<span class="w-[136px]">
						{{ __('Localisation') }}
					</span>

					<strong>
						{{ $company->displayPartOfAddress('department+zipcode+city') }}
					</strong>
				</div>

				<div class="flex flex-row gap-x-2">
					@if($showCommentComponent)
						<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}">
					@endif
						<x-front.secondary-button :class="'mt-6'">
							{{ __('View profile') }}
						</x-front.secondary-button>
					@if($showCommentComponent)
						</a>
					@endif

					@if($showCommentComponent)
						<x-front.secondary-button type="button" x-on:click="$dispatch('open-modal', 'comment-modal')" :class="'mt-6'">
							{{ __('Leave a comment') }}
						</x-front.secondary-button>

						<x-front.modal name="comment-modal" :class="'w-full max-w-2xl'" focusable>
							<div class="space-y-8 text-jobboard-deepblue">
								<livewire:front.comments.comments
									:target="$company"
									:source="Auth::guard('web')->user()"
									:inModal="true"
									:case="'user-about-company'"
									:key="'comments-component'" />
							</div>
						</x-front.modal>
					@endif
				</div>
			</div>
		</div>

		<div class="flex flex-row md:flex-col gap-4 items-center md:pl-20 md:pr-8">
			@if($company->user->lastModeration?->isValidated())
				<div class="relative w-[90px] h-[100px]">
					<svg class="absolute inset-0 w-full h-full" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M84.6574 21.0467L50.3376 1.42039C47.0375 -0.473464 42.9626 -0.473464 39.6624 1.42039L5.34265 21.0467C2.04248 22.9406 0 26.4293 0 30.207V69.4597C0 73.2374 2.03242 76.7361 5.34265 78.62L39.6624 98.2463C42.9626 100.14 47.0375 100.14 50.3376 98.2463L84.6574 78.62C87.9575 76.7261 90 73.2374 90 69.4597V30.217C90 26.4392 87.9676 22.9406 84.6574 21.0567V21.0467Z" fill="#F7F6EF"/>
					</svg>

					<div class="absolute inset-0 flex flex-col items-center justify-center gap-y-1">
						<svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M13.8384 1.93273C12.6357 1.33545 11.2775 1 9.8457 1C4.87116 1 0.845703 5.02545 0.845703 10C0.845703 14.9745 4.87116 19 9.8457 19C14.8202 19 18.8457 14.9745 18.8457 10C18.8457 8.84636 18.6248 7.74182 18.2321 6.72727" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M5.75488 10L9.02761 13.2727L13.8385 7.25909L14.264 6.72727L16.4976 3.93727L18.8458 1" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						<p class="text-jobboard-deepblue font-bold text-xs text-center">
							{{ __('Verified account' )}}
						</p>
					</div>
				</div>

				@if(data_get($company->user->values, 'agreement_EOL.cats') || data_get($company->user->values, 'agreement_EOL.dogs'))
					<div class="relative w-[90px] h-[100px]">
						<svg class="absolute inset-0 w-full h-full" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M84.6574 21.0467L50.3376 1.42039C47.0375 -0.473464 42.9626 -0.473464 39.6624 1.42039L5.34265 21.0467C2.04248 22.9406 0 26.4293 0 30.207V69.4597C0 73.2374 2.03242 76.7361 5.34265 78.62L39.6624 98.2463C42.9626 100.14 47.0375 100.14 50.3376 98.2463L84.6574 78.62C87.9575 76.7261 90 73.2374 90 69.4597V30.217C90 26.4392 87.9676 22.9406 84.6574 21.0567V21.0467Z" fill="#F7F6EF"/>
						</svg>

						<div class="absolute inset-0 flex flex-col items-center justify-center gap-y-1">
							<svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M13.8384 1.93273C12.6357 1.33545 11.2775 1 9.8457 1C4.87116 1 0.845703 5.02545 0.845703 10C0.845703 14.9745 4.87116 19 9.8457 19C14.8202 19 18.8457 14.9745 18.8457 10C18.8457 8.84636 18.6248 7.74182 18.2321 6.72727" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M5.75488 10L9.02761 13.2727L13.8385 7.25909L14.264 6.72727L16.4976 3.93727L18.8458 1" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

							<p class="text-jobboard-deepblue font-bold text-xs text-center">
								{{ __('Formation vérifiée') }}
							</p>
						</div>
					</div>
				@endif

				@if($company->values->has('snpcc') && $company->values->get('snpcc') == true)
					<img src="{{ asset('/storage/company_ppc.png') }}" alt="" class="w-[66px] h-[60px]">
				@endif
			@endif
		</div>
	</div>
@if(!$showCommentComponent)
	</a>
@else
	</div>
@endif
