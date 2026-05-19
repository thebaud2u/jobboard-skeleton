<div class="flex justify-center items-center mx-auto max-w-[1200px] bg-white w-full my-8">
	<x-front.ad-slot slotName="banniere_haute" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'adoptant', 'espece' => $company->species?->first()->name == 'dog' ? 'chien' : 'chat']" />
</div>

<div class="flex flex-row xlsm:justify-between max-xlsm:flex-col max-xlsm:items-center mt-2 max-w-[1200px] w-full text-breeder-deepblue">
	{{-- Content --}}
	<div class="text-sm lg:text-base max-w-[870px] w-full">
		<div class="flex flex-col gap-y-2 max-md:px-4 w-full mb-8">
			<div class="flex flex-row justify-between items-center gap-x-4">
				<div class="flex flex-row gap-x-4">
					@if($logo)
						<div class="flex flex-col shrink-0">
							<img src="{{ $logo->getAvailableUrl(['optimized']) }}" alt="{{ $name }}" class="inline-block object-cover w-[100px] h-[100px] rounded-full">
						</div>
					@endif

					<div class="flex flex-col gap-y-3 justify-center">
						<h1 class="flex flex-col md:flex-row gap-y-2 text-[28px] leading-tight lg:text-[40px] font-medium">
							{{ __('Company') }}&nbsp;<span class="font-bold">{{ $name }}</span>
						</h1>

						<div class="flex flex-row gap-x-2 text-sm items-center mt-2 mb-4">
							@php
								$x = $company->countCommentsReceivedPublished();
							@endphp

							<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M19.487 16.2696C20.4435 14.7391 21 12.9391 21 11C21 5.47826 16.5217 1 11 1C5.47824 1 1 5.47826 1 11C1 16.5217 5.47824 21 11 21C12.9391 21 14.7391 20.4435 16.2696 19.487L21 21L19.487 16.2696Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.08789 8.82617H14.914" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.08789 13.1738H12.3053" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

							{{ $x == 0 ? __('No comments yet') : ($x > 1 ? __(':x comments', ['x' => $x]) : __(':x comment', ['x' => $x])) }}
						</div>
					</div>
				</div>

				<div class="flex flex-row items-center">
					<livewire:front.space.favorites.toggle-favorite
						:target="$company"
						:key="'toggle-favorite-component'" />
				</div>
			</div>

			@if($company->species->isNotEmpty())
				@foreach($company->species as $companySpecies)
					@php
						$speciesSlug = $companySpecies->getTranslation('slug', 'en');
						$breedsOfSpecies = $company->getSpeciesBreeds($speciesSlug);
						$litterAvailableForSpecies = $company->countLittersWithAvailableAnimalsOfSpecies($speciesSlug);
					@endphp
					@if($breedsOfSpecies->isNotEmpty())
						<div class="flex flex-row flex-wrap gap-2">
							@if($speciesSlug == 'dog')
								<svg width="31" height="25" viewBox="0 0 31 25" fill="none"	xmlns="http://www.w3.org/2000/svg">
									<path d="M11.1426 0.310601C10.2318 -0.594043 8.35108 0.739673 7.43613 1.05461C4.95812 1.90641 2.29373 2.14103 0.773032 4.55059C-1.77487 8.5919 2.45257 17.5348 6.51905 14.5122C8.69631 12.8932 6.6546 8.5454 8.32355 6.16754C8.99283 5.21639 10.2318 4.85496 10.8842 3.65018C11.2845 2.91251 11.7801 0.942584 11.1404 0.308487L11.1426 0.310601ZM29.3316 3.50433C27.813 1.98884 25.8666 1.95502 23.9986 1.32304C22.2555 0.735446 18.9621 -1.74599 19.4725 2.24882C19.8156 4.93316 22.7214 5.29037 23.1726 7.43362C23.6321 9.62125 22.2428 14.1825 25.1655 14.954C27.3555 15.531 28.7407 13.9669 29.6599 12.2401C31.081 9.57052 31.6804 5.84415 29.3337 3.50433H29.3316ZM10.7126 7.27087C9.09449 7.60271 9.57526 10.2025 11.0472 10.1391C12.9894 10.0546 12.9513 6.8122 10.7126 7.27087ZM18.6592 9.71637C19.9744 11.0987 22.1602 8.80538 20.7157 7.55832C19.2713 6.31127 17.5197 8.51792 18.6592 9.71637ZM6.74355 15.2668V24.4612C6.74355 24.5965 7.25398 24.9664 7.49119 24.9917C9.36135 25.1947 8.29813 21.8255 8.44004 20.7623C10.6342 22.5801 13.1588 23.2311 15.3509 20.9906C17.6171 23.1085 19.8495 22.6329 22.2046 20.9737V24.2499C22.2046 25.2665 24.1108 25.0911 24.1108 24.4612V15.2668C21.8425 15.1823 22.355 16.5033 21.8255 17.9533C21.1668 19.752 18.7799 21.593 17.0305 19.9042C16.3421 19.2405 16.0393 17.3298 16.2722 16.4737C16.3739 16.0975 18.2419 15.5733 17.9306 13.9479C17.4604 11.4982 12.8009 11.8279 12.9005 14.2988C12.9661 15.9178 14.5567 16.3258 14.5906 16.4653C15.298 19.4117 12.6738 22.0242 10.1259 19.6083C8.40615 17.9765 9.43336 15.0533 6.74355 15.2689V15.2668Z" fill="#FF7E71" />
									<path d="M11.1426 0.310634C11.7823 0.94473 11.2845 2.91466 10.8864 3.65232C10.234 4.85711 8.99291 5.21854 8.32576 6.16969C6.65469 8.54543 8.6964 12.8953 6.52126 14.5144C2.45266 17.5348 -1.77478 8.59194 0.773119 4.55063C2.29381 2.14106 4.9582 1.90644 7.43621 1.05464C8.35117 0.739706 10.2319 -0.596124 11.1426 0.310634Z" fill="#FF7E71" />
									<path d="M29.3316 3.50427C31.6783 5.84409 31.0789 9.57046 29.6577 12.24C28.7385 13.9647 27.3534 15.531 25.1634 14.9539C22.2385 14.1825 23.63 9.62119 23.1704 7.43355C22.7193 5.29031 19.8135 4.9331 19.4704 2.24876C18.9599 -1.74605 22.2534 0.735382 23.9964 1.32298C25.8645 1.95496 27.8109 1.98878 29.3295 3.50427H29.3316Z" fill="#FF7E71" />
									<path d="M6.74356 15.2668C9.43337 15.0533 8.40616 17.9744 10.1259 19.6061C12.6717 22.022 15.2959 19.4095 14.5906 16.4631C14.5567 16.3236 12.9661 15.9157 12.9005 14.2966C12.8009 11.8257 17.4604 11.496 17.9306 13.9457C18.242 15.5711 16.3739 16.0974 16.2723 16.4716C16.0414 17.3276 16.3443 19.2383 17.0305 19.902C18.7799 21.5929 21.1669 19.7498 21.8255 17.9511C22.3571 16.5011 21.8425 15.1801 24.1108 15.2647V24.4591C24.1108 25.0889 22.2047 25.2644 22.2047 24.2477V20.9715C19.8495 22.6307 17.6172 23.1063 15.3509 20.9884C13.1589 23.2289 10.6342 22.5779 8.44004 20.7602C8.29814 21.8233 9.36136 25.1946 7.4912 24.9896C7.25399 24.9642 6.74356 24.5943 6.74356 24.4591V15.2647V15.2668Z" fill="#FF7E71" />
									<path d="M18.6592 9.71633C17.5197 8.51788 19.2437 6.29009 20.7157 7.55828C22.1877 8.82648 19.9744 11.0987 18.6592 9.71633Z" fill="#FF7E71" />
									<path d="M10.7126 7.27081C12.9534 6.81214 12.9894 10.0566 11.0472 10.139C9.57527 10.2024 9.09449 7.60265 10.7126 7.27081Z" fill="#FF7E71" />
								</svg>
							@elseif($speciesSlug == 'cat')
								<svg width="27" height="25" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_755_7626)">
										<path d="M15.2591 14.3962C14.9539 14.197 13.3136 14.4767 12.7987 14.3665C12.4747 15.2546 13.4444 15.6679 13.3447 16.2762C13.0457 18.1139 11.4179 17.4632 11.3328 18.2877C11.231 19.2796 12.2692 19.0995 12.9191 18.8324C13.3738 18.6459 13.7932 18.0142 13.9676 17.9825C14.1628 17.9464 16.1561 19.9939 16.8579 18.6077C17.2586 17.8193 15.1802 17.8214 14.7982 16.4394C14.5656 15.5959 16.0544 14.9134 15.2591 14.3962Z" fill="#3DD8AC" />
										<path d="M19.1315 13.9447C17.7009 13.9447 16.1623 11.236 15.7014 10.0278C15.3152 9.0168 14.9705 6.61324 14.6341 6.03248C13.0478 4.37712 13.0873 8.49327 12.6512 9.44707C12.1446 11.3038 10.8718 13.4742 8.95948 13.9447L3.44678 12.4526C3.34504 11.3462 4.86285 9.86462 5.07879 9.12914C5.34249 8.23257 4.42474 4.43011 4.49534 3.13507C4.51402 2.78535 4.43305 0.379665 5.53351 0.0447777C6.38896 -0.215926 7.32124 0.731509 7.60986 1.01553C11.6068 4.93244 10.1409 4.99179 14.1275 4.21604C16.7188 3.71159 17.2545 4.99391 17.676 4.62087C19.1149 2.28937 23.3008 -3.19812 23.3901 2.92312C23.5271 4.55304 22.7942 8.18806 23.0143 9.11854C23.0932 9.44919 24.1272 10.9286 24.4033 11.5348C24.53 11.8125 24.611 12.4187 24.6463 12.4505M9.42043 9.74168C7.91923 10.1825 8.46323 12.6667 9.9499 12.4271C11.8145 12.1283 11.2995 9.18848 9.42043 9.74168ZM19.1751 9.98119C17.8421 8.87479 15.9505 10.9032 17.5805 12.1346C18.9446 13.1669 20.3794 10.9816 19.1751 9.98119Z" fill="#3DD8AC" />
										<path d="M7.60363 16.9926C8.51099 16.821 9.01139 17.796 8.38226 18.1308C7.84241 18.417 5.11824 19.5594 5.04142 19.375C4.96459 19.1906 6.3329 20.8227 6.58622 21.0283C11.2185 24.9452 19.6547 24.5382 22.9727 19.2457C22.3166 19.0465 20.234 18.5102 19.8561 18.08C19.5426 17.7239 19.5281 17.0605 19.987 16.9269C20.7801 17.0054 24.0462 18.2432 25.047 18.6077C20.8798 27.5331 7.42506 26.7213 2.83011 18.6077C2.83011 18.6077 6.82915 17.1389 7.60155 16.9926H7.60363Z" fill="#3DD8AC" />
										<path d="M15.2591 14.3962C16.0544 14.9155 14.5656 15.5958 14.7982 16.4394C15.1802 17.8214 17.2586 17.8192 16.8579 18.6077C16.1561 19.9939 14.1628 17.9464 13.9676 17.9825C13.7932 18.0142 13.3717 18.6437 12.9191 18.8324C12.2692 19.0994 11.231 19.2817 11.3328 18.2877C11.4179 17.4653 13.0457 18.1139 13.3447 16.2762C13.4444 15.6679 12.4747 15.2546 12.7987 14.3665C13.3946 13.9426 14.956 14.1969 15.2591 14.3962Z" fill="#3DD8AC" />
										<path d="M7.38291 14.6911L1.4755 15.0452C1.14581 15.0649 0.894231 15.3538 0.913588 15.6903C0.932944 16.0269 1.2159 16.2837 1.5456 16.2639L7.45301 15.9099C7.7827 15.8901 8.03428 15.6013 8.01492 15.2647C7.99556 14.9282 7.7126 14.6714 7.38291 14.6911Z" fill="#3DD8AC" />
										<path d="M20.3693 15.9093L26.2767 16.2633C26.6064 16.2831 26.8893 16.0262 26.9087 15.6897C26.928 15.3531 26.6765 15.0643 26.3468 15.0445L20.4393 14.6905C20.1097 14.6707 19.8267 14.9275 19.8073 15.2641C19.788 15.6006 20.0396 15.8895 20.3693 15.9093Z" fill="#3DD8AC" />
										<path d="M19.3849 13.9439L26.2615 12.4813C26.5848 12.4125 26.7923 12.0892 26.7249 11.7592C26.6575 11.4291 26.3408 11.2173 26.0175 11.2861L19.1409 12.7487C18.8176 12.8175 18.6101 13.1408 18.6775 13.4708C18.7449 13.8009 19.0616 14.0127 19.3849 13.9439Z" fill="#3DD8AC" />
										<path d="M8.99575 12.7479L2.11917 11.2853C1.79585 11.2165 1.47914 11.4283 1.41177 11.7584C1.34441 12.0884 1.55189 12.4117 1.87521 12.4805L8.7518 13.9431C9.07511 14.0119 9.39182 13.8001 9.45919 13.47C9.52656 13.14 9.31907 12.8167 8.99575 12.7479Z" fill="#3DD8AC" />
									</g>

									<defs>
										<clipPath id="clip0_755_7626">
											<rect width="26" height="25" fill="white" transform="translate(0.91156 0.000274658)" />
										</clipPath>
									</defs>
								</svg>
							@endif

							@if($company->hasSpeciesPureBreed($speciesSlug))
								@if($company->address?->country?->code == 'FRA')
									@if($speciesSlug == 'dog')
										<span class="px-3 py-1 rounded-md font-medium bg-breeder-coral text-breeder-deepblue text-sm w-fit">
											LOF
										</span>
									@elseif($speciesSlug == 'cat')
										<span class="px-3 py-1 rounded-md font-medium bg-breeder-green text-breeder-deepblue text-sm w-fit">
											LOOF
										</span>
									@endif
								@else
									<span class="px-3 py-1 rounded-md font-medium bg-breeder-coral text-breeder-deepblue text-sm w-fit">
										{{ __('Origin book') }}
									</span>
								@endif
							@endif

							@php
								$count = $breedsOfSpecies->count();
							@endphp

							@foreach($breedsOfSpecies as $index => $breed)
								<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit">
									{{ $breed->name }}
								</span>
							@endforeach

							@if($litterAvailableForSpecies > 0)
								<span class="flex flex-row items-center gap-x-2">
									<div class="w-3 h-3 bg-breeder-green rounded-full"></div> {{ $litterAvailableForSpecies > 1 ? __('Litters available') : __('Litter available') }}
								</span>
							@endif
						</div>
					@endif
				@endforeach
			@endif

			<div class="flex flex-row flex-wrap justify-between items-center gap-4 mt-4">
				@if($addressMain)
					<div class="flex flex-col">
						<div class="flex flex-row items-center gap-x-1 font-bold">
							<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M15 7.45455C15 12.1527 8 17.5 8 17.5C8 17.5 1 12.1527 1 7.45455C1 2.75636 4.13444 0.5 8 0.5C11.8656 0.5 15 2.75636 15 7.45455Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.99978 9.77362C9.718 9.77362 11.1109 8.38977 11.1109 6.68271C11.1109 4.97564 9.718 3.5918 7.99978 3.5918C6.28156 3.5918 4.88867 4.97564 4.88867 6.68271C4.88867 8.38977 6.28156 9.77362 7.99978 9.77362Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

							{{ $addressMain }}
						</div>
					</div>
				@endif
			</div>

			<div class="font-medium mt-4 block whitespace-normal">
				{!! nl2br(e($description)) !!}
			</div>

			{{-- Contact --}}
			@if($company->offer()->hasOption('contact-button'))
				<div class="flex flex-row items-center my-4">
					@include('components.front.responses.contact', [
						'target' => $company,
						'type' => 'company',
						'hasContacted' => $hasContacted,
						'response' => $response,
						'title' => true
					])
				</div>
			@endif

			@if($company->offer()->hasOption('display-posts'))
				@php
					$littersAvailable = $company->littersAvailable;
				@endphp
				@if($littersAvailable->count() > 0)
					<div class="flex flex-col gap-2 mt-4">
						<h2 class="text-[28px] font-bold mt-6 mb-4">
							<b>{{ $littersAvailable->count() }}</b> {{ $littersAvailable->count() > 1 ? strtolower(__('Litters available')) : strtolower(__('Litter available')) }}
						</h2>

						<div x-data="{
							width: (window.innerWidth > 0) ? window.innerWidth : screen.width,
							numberOfVisibleElements: 5,
							showNextElement:function() {
								let visibleElements = document.getElementsByClassName('visible-recently-published-animal');
								let firstVisibleElement = visibleElements[0];

								document.getElementById('recently-published-cards').appendChild(firstVisibleElement);
							},
							showPreviousElement:function() {
								let visibleElements = document.getElementsByClassName('visible-recently-published-animal');
								let lastVisibleElement = visibleElements[visibleElements.length - 1];

								document.getElementById('recently-published-cards').prepend(lastVisibleElement);
							}
						}" class="flex flex-row justify-center items-center relative max-w-full">
						@php
							$countLitterAvailable = count($littersAvailable);
						@endphp
							@if($countLitterAvailable > 3)
								{{-- Previous button --}}
								<div x-on:click="showPreviousElement();" class="max-s:hidden mr-10 cursor-pointer absolute z-20 left-0 h-[220px] flex items-center bg-gradient-to-l from-transparent to-white">
									<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g filter="url(#filter0_d_5245_39654)">
											<path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF"/>
										</g>
										<path d="M56.0454 36.6364L42.1818 50.5L56.0454 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										<defs>
											<filter id="filter0_d_5245_39654" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
												<feFlood flood-opacity="0" result="BackgroundImageFix"/>
												<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
												<feOffset/>
												<feGaussianBlur stdDeviation="10"/>
												<feComposite in2="hardAlpha" operator="out"/>
												<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
												<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5245_39654"/>
												<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5245_39654" result="shape"/>
											</filter>
										</defs>
									</svg>
								</div>
							@endif

							<div id="recently-published-cards" class="s-30 w-full flex flex-row gap-x-4 items-stretch max-w-[1200px] overflow-x-scroll s:overflow-x-hidden scrollbar-none">
								@foreach($littersAvailable as $litterAvailable)
									<a href="{{ route('post-search.post.show', ['company' => $litterAvailable->company->slug, 'post' => $litterAvailable->post->slug, 'breed' => $litterAvailable->breed->slug]) }}"  id="{{ $loop->index }}" class="visible-recently-published-animal">
										<article class="w-[220px] h-[220px] relative">
											<div class="absolute w-[220px] top-0 z-10">
												<div class="flex flex-row gap-2 p-2 items-center">
													<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit grow-0">
														{{ ($litterAvailable->mother ? $litterAvailable->mother->values->get('pure_breed') : $litterAvailable->values->get('pure_breed')) ? $litterAvailable->breed->name : __('Of appearance :breed', ['breed' => $litterAvailable->breed->name]) }}
													</span>

													@if($litterAvailable->mother ? $litterAvailable->mother->values->get('pure_breed') : $litterAvailable->values->get('pure_breed'))
														<span class="px-3 py-1 rounded-md font-medium text-breeder-deepblue text-sm w-fit @if($litterAvailable->species->getTranslation('slug', 'en') == 'cat' && $litterAvailable->company->address?->country?->code == 'FRA') bg-breeder-green @elseif($litterAvailable->species->getTranslation('slug', 'en') == 'dog' && $litterAvailable->company->address?->country?->code == 'FRA') bg-breeder-coral @else bg-breeder-cream @endif">
															@if($litterAvailable->company->address?->country?->code == 'FRA')
																@if($litterAvailable->species->getTranslation('slug', 'en') == 'cat')
																	LOOF
																@elseif($litterAvailable->species->getTranslation('slug', 'en') == 'dog')
																	LOF
																@endif
															@else
																{{ __('Origin book') }}
															@endif
														</span>
													@endif
												</div>
											</div>

											@if($litterAvailable->post->type->getTranslation('slug', 'en') == 'litter-yet-to-come')
												<img src="{{ asset('storage/litter-yet-to-come-for-dogs.png') }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
											@else
												@if($photo = $litterAvailable->post->getFirstMedia('photos'.$litterAvailable->post->id))
													<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
												@else
													@php
														if($litterAvailable->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
														elseif($litterAvailable->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
													@endphp
													<img src="{{ $src }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
												@endif
											@endif
										</article>
									</a>
								@endforeach
							</div>

							@if($countLitterAvailable > 3)
								<div x-on:click="showNextElement();" class="max-s:hidden ml-10 cursor-pointer absolute z-20 right-0 h-[220px] flex items-center bg-gradient-to-r from-transparent to-white">
									<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g filter="url(#filter0_d_2188_51292)">
											<path d="M50.5 81C67.3447 81 81 67.3447 81 50.5C81 33.6553 67.3447 20 50.5 20C33.6553 20 20 33.6553 20 50.5C20 67.3447 33.6553 81 50.5 81Z" fill="#F7F6EF"/>
										</g>
										<path d="M44.9546 36.6364L58.8182 50.5L44.9546 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										<defs>
											<filter id="filter0_d_2188_51292" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
												<feFlood flood-opacity="0" result="BackgroundImageFix"/>
												<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
												<feOffset/>
												<feGaussianBlur stdDeviation="10"/>
												<feComposite in2="hardAlpha" operator="out"/>
												<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
												<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2188_51292"/>
												<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2188_51292" result="shape"/>
											</filter>
										</defs>
									</svg>
								</div>
							@endif
						</div>
					</div>
				@endif

				@php
					$retiredBreederPosts = $company->getRetiredBreederPosts();
					$countRetiredBreeders = $retiredBreederPosts->count();
				@endphp
				@if($countRetiredBreeders > 0)
					<div class="flex flex-col gap-2 mt-4">
						<h2 class="text-[28px] font-bold mt-6 mb-4">
							<b>{{ $countRetiredBreeders }}</b> {{ $countRetiredBreeders > 1 ? __('adults available') : __('adult available') }}
						</h2>

						<div class="flex flex-row gap-2">
							<div x-data="{
							width: (window.innerWidth > 0) ? window.innerWidth : screen.width,
							numberOfVisibleElements: 5,
							showNextElement:function() {
								let visibleElements = document.getElementsByClassName('visible-recently-published-animal-retired');
								let firstVisibleElement = visibleElements[0];

								document.getElementById('recently-published-cards-retired').appendChild(firstVisibleElement);
							},
							showPreviousElement:function() {
								let visibleElements = document.getElementsByClassName('visible-recently-published-animal-retired');
								let lastVisibleElement = visibleElements[visibleElements.length - 1];

								document.getElementById('recently-published-cards-retired').prepend(lastVisibleElement);
							}
							}" class="flex flex-row justify-center items-center relative max-w-full">
								@if($countRetiredBreeders > 3)
									{{-- Previous button --}}
									<div x-on:click="showPreviousElement();" class="max-s:hidden mr-10 cursor-pointer absolute z-20 left-0 h-[220px] flex items-center bg-gradient-to-l from-transparent to-white">
										<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g filter="url(#filter0_d_5245_39654)">
												<path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF"/>
											</g>
											<path d="M56.0454 36.6364L42.1818 50.5L56.0454 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											<defs>
												<filter id="filter0_d_5245_39654" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
													<feFlood flood-opacity="0" result="BackgroundImageFix"/>
													<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
													<feOffset/>
													<feGaussianBlur stdDeviation="10"/>
													<feComposite in2="hardAlpha" operator="out"/>
													<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
													<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5245_39654"/>
													<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5245_39654" result="shape"/>
												</filter>
											</defs>
										</svg>
									</div>
								@endif

								<div id="recently-published-cards-retired" class="s-30 w-full flex flex-row gap-x-4 items-stretch max-w-[1200px] overflow-x-scroll s:overflow-x-hidden scrollbar-none">
									@foreach($retiredBreederPosts as $post)
										<a href="{{ route('post-search.post.show', ['company' => $post->model->company->slug, 'post' => $post->slug, 'breed' => $post->model->breed->slug]) }}"  id="{{ $loop->index }}" class="visible-recently-published-animal-retired">
											<article class="w-[220px] h-[220px] relative">
												<div class="absolute w-[220px] top-0 z-10">
													<div class="flex flex-row gap-2 p-2 items-center">
														<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit grow-0">
															{{ $post->model->values->get('pure_breed') ? $post->model->breed->name : __('Of appearance :breed', ['breed' => $post->model->breed->name]) }}
														</span>

														@if($post->model->values->get('pure_breed'))
															<span class="px-3 py-1 rounded-md font-medium text-breeder-deepblue text-sm w-fit @if($post->model->species->getTranslation('slug', 'en') == 'cat' && $post->model->company->address?->country?->code == 'FRA') bg-breeder-green @elseif($post->model->species->getTranslation('slug', 'en') == 'dog' && $post->model->company->address?->country?->code == 'FRA') bg-breeder-coral @else bg-breeder-cream @endif">
																@if($post->model->company->address?->country?->code == 'FRA')
																	@if($post->model->species->getTranslation('slug', 'en') == 'cat')
																		LOOF
																	@elseif($post->model->species->getTranslation('slug', 'en') == 'dog')
																		LOF
																	@endif
																@else
																	{{ __('Origin book') }}
																@endif
															</span>
														@endif
													</div>
												</div>

												@php
													$photo = $post->getFirstMedia('photos'.$post->id);

													if(!$photo) $photo = $post->model->getFirstMedia('photos'.$post->model->id);
												@endphp

												@if($photo)
													<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
												@else
													@php
														if($post->model->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
														elseif($post->model->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
													@endphp
													<img src="{{ $src }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
												@endif
											</article>
										</a>
									@endforeach
								</div>

								@if($countRetiredBreeders > 3)
									<div x-on:click="showNextElement();" class="max-s:hidden ml-10 cursor-pointer absolute z-20 right-0 h-[220px] flex items-center bg-gradient-to-r from-transparent to-white">
										<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g filter="url(#filter0_d_2188_51292)">
												<path d="M50.5 81C67.3447 81 81 67.3447 81 50.5C81 33.6553 67.3447 20 50.5 20C33.6553 20 20 33.6553 20 50.5C20 67.3447 33.6553 81 50.5 81Z" fill="#F7F6EF"/>
											</g>
											<path d="M44.9546 36.6364L58.8182 50.5L44.9546 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											<defs>
												<filter id="filter0_d_2188_51292" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
													<feFlood flood-opacity="0" result="BackgroundImageFix"/>
													<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
													<feOffset/>
													<feGaussianBlur stdDeviation="10"/>
													<feComposite in2="hardAlpha" operator="out"/>
													<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
													<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2188_51292"/>
													<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2188_51292" result="shape"/>
												</filter>
											</defs>
										</svg>
									</div>
								@endif
							</div>
						</div>
					</div>
				@endif

				@php
					$studPosts = $company->getStudPosts();
					$countStuds = $studPosts->count();
				@endphp
				@if($countStuds > 0)
					<div class="flex flex-col gap-2 mt-4">
						<h2 class="text-[28px] font-bold mt-6 mb-4">
							<b>{{ $countStuds }}</b> {{ $countStuds > 1 ? __('studs available') : __('stud available') }}
						</h2>

						<div class="flex flex-row gap-2">
							<div x-data="{
							width: (window.innerWidth > 0) ? window.innerWidth : screen.width,
							numberOfVisibleElements: 5,
							showNextElement:function() {
								let visibleElements = document.getElementsByClassName('visible-recently-published-animal-stud');
								let firstVisibleElement = visibleElements[0];

								document.getElementById('recently-published-cards-stud').appendChild(firstVisibleElement);
							},
							showPreviousElement:function() {
								let visibleElements = document.getElementsByClassName('visible-recently-published-animal-stud');
								let lastVisibleElement = visibleElements[visibleElements.length - 1];

								document.getElementById('recently-published-cards-stud').prepend(lastVisibleElement);
							}
							}" class="flex flex-row justify-center items-center relative max-w-full">
								@if($countStuds > 3)
									{{-- Previous button --}}
									<div x-on:click="showPreviousElement();" class="max-s:hidden mr-10 cursor-pointer absolute z-20 left-0 h-[220px] flex items-center bg-gradient-to-l from-transparent to-white">
										<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g filter="url(#filter0_d_5245_39654)">
												<path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF"/>
											</g>
											<path d="M56.0454 36.6364L42.1818 50.5L56.0454 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											<defs>
												<filter id="filter0_d_5245_39654" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
													<feFlood flood-opacity="0" result="BackgroundImageFix"/>
													<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
													<feOffset/>
													<feGaussianBlur stdDeviation="10"/>
													<feComposite in2="hardAlpha" operator="out"/>
													<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
													<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5245_39654"/>
													<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5245_39654" result="shape"/>
												</filter>
											</defs>
										</svg>
									</div>
								@endif

								<div id="recently-published-cards-stud" class="s-30 w-full flex flex-row gap-x-4 items-stretch max-w-[1200px] overflow-x-scroll s:overflow-x-hidden scrollbar-none">
									@foreach($studPosts as $post)
										<a href="{{ route('post-search.post.show', ['company' => $post->model->company->slug, 'post' => $post->slug, 'breed' => $post->model->breed->slug]) }}"  id="{{ $loop->index }}" class="visible-recently-published-animal-stud">
											<article class="w-[220px] h-[220px] relative">
												<div class="absolute w-[220px] top-0 z-10">
													<div class="flex flex-row gap-2 p-2 items-center">
														<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit grow-0">
															{{ $post->model->values->get('pure_breed') ? $post->model->breed->name : __('Of appearance :breed', ['breed' => $post->model->breed->name]) }}
														</span>

														@if($post->model->values->get('pure_breed'))
															<span class="px-3 py-1 rounded-md font-medium text-breeder-deepblue text-sm w-fit @if($post->model->species->getTranslation('slug', 'en') == 'cat' && $post->model->company->address?->country?->code == 'FRA') bg-breeder-green @elseif($post->model->species->getTranslation('slug', 'en') == 'dog' && $post->model->company->address?->country?->code == 'FRA') bg-breeder-coral @else bg-breeder-cream @endif">
																@if($post->model->company->address?->country?->code == 'FRA')
																	@if($post->model->species->getTranslation('slug', 'en') == 'cat')
																		LOOF
																	@elseif($post->model->species->getTranslation('slug', 'en') == 'dog')
																		LOF
																	@endif
																@else
																	{{ __('Origin book') }}
																@endif
															</span>
														@endif
													</div>
												</div>

												@php
													$photo = $post->getFirstMedia('photos'.$post->id);

													if(!$photo) $photo = $post->model->getFirstMedia('photos'.$post->model->id);
												@endphp

												@if($photo)
													<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
												@else
													@php
														if($post->model->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
														elseif($post->model->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
													@endphp
													<img src="{{ $src }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
												@endif
											</article>
										</a>
									@endforeach
								</div>

								@if($countStuds > 3)
									<div x-on:click="showNextElement();" class="max-s:hidden ml-10 cursor-pointer absolute z-20 right-0 h-[220px] flex items-center bg-gradient-to-r from-transparent to-white">
										<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g filter="url(#filter0_d_2188_51292)">
												<path d="M50.5 81C67.3447 81 81 67.3447 81 50.5C81 33.6553 67.3447 20 50.5 20C33.6553 20 20 33.6553 20 50.5C20 67.3447 33.6553 81 50.5 81Z" fill="#F7F6EF"/>
											</g>
											<path d="M44.9546 36.6364L58.8182 50.5L44.9546 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											<defs>
												<filter id="filter0_d_2188_51292" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
													<feFlood flood-opacity="0" result="BackgroundImageFix"/>
													<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
													<feOffset/>
													<feGaussianBlur stdDeviation="10"/>
													<feComposite in2="hardAlpha" operator="out"/>
													<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
													<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2188_51292"/>
													<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2188_51292" result="shape"/>
												</filter>
											</defs>
										</svg>
									</div>
								@endif
							</div>
						</div>
					</div>
				@endif
			@endif

			@include('components.front.warning-sensitive-animal')

			@if($company->offer()->hasOption('display-breeders') && $company->hasDisplayBreeders())
				<div class="mt-6">
					<livewire:front.animals.breeders.breeders
						:company="$company"
						:isDisplayedOnCompanyPage="true"
						:key="'display-breeders-of-company-'.$company->slug" />
				</div>
			@endif

			<div class="flex flex-row text-[28px] font-bold mt-8 mb-4">
				{{ $company->breeds()->count() > 1 ? __('Breeds breeded') : __('Breed breeded') }}
			</div>

			<div class="flex flex-row flex-wrap items-stretch gap-3">
				@foreach($breeds as $breed)
					<x-front.breeds.card :breed="$breed" :companyShow="true"/>
				@endforeach
			</div>

			@if($photos->isNotEmpty())
				<div class="flex flex-row text-[28px] font-bold mt-6 mb-4">
					{{ __('Company\'s photos') }}
				</div>

				@php
					//Carousel à terminer losque vidéo
					$videos = 1;
				@endphp
				<div class="overflow-hidden aspect-[100/75] flex flex-row justify-center items-stretch rounded-xl w-full">
						@if(count($photos) > 1 || (!empty(json_decode($medias, true)) && count(json_decode($medias, true)) > 1))
							{{-- Need a media json see CompanyController l.86 --}}
							@include('components.front.carousel-eol')
						@else
							<img src="{{ $photos->first()->getAvailableUrl(['optimized']) }}" alt="{{ $company->title }}" class="object-cover w-full aspect-[100/75] rounded-xl" />
						@endif

						{{-- <img src="{{ $photos->getFirstMedia('photos')->getAvailableUrl(['optimized']) }}" alt="{{ $company->title }}" class="object-cover w-full h-[500px] max-sm:shadow-lg" /> --}}

					<x-front.modal name="full_screen_carousel" :class="'w-full max-w-screen-xl'" focusable>
						<div class="flex overflow-x-hidden w-full rounded-xl"  x-data="{
								medias: {{$medias}},
								currentSlideIndex: 1,
								previous() {
									if (this.currentSlideIndex > 1) {
										this.currentSlideIndex = this.currentSlideIndex - 1
									} else {
										// If it's the first media, go to the last media
										this.currentSlideIndex = this.medias.length
									}
								},
								next() {
									if (this.currentSlideIndex < this.medias.length) {
										this.currentSlideIndex = this.currentSlideIndex + 1
									} else {
										// If it's the last media, go to the first media
										this.currentSlideIndex = 1
									}
								},
								}">
							{{-- nav Left --}}
							<div class="relative">
								<div class="absolute top-[50%] transform translate-y-[-50%] cursor-pointer z-10" x-on:click="previous();">
									<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g filter="url(#filter0_d_2400_38252)">
											<path d="M30 50C18.9543 50 10 41.0457 10 30C10 18.9543 18.9543 10 30 10C41.0457 10 50 18.9543 50 30C50 41.0457 41.0457 50 30 50Z" fill="white"/>
										</g>
										<path d="M33.6367 20.9092L24.5458 30.0001L33.6367 39.091" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<defs>
											<filter id="filter0_d_2400_38252" x="0" y="0" width="60" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
												<feFlood flood-opacity="0" result="BackgroundImageFix"/>
												<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
												<feOffset/>
												<feGaussianBlur stdDeviation="5"/>
												<feComposite in2="hardAlpha" operator="out"/>
												<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
												<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2400_38252"/>
												<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2400_38252" result="shape"/>
											</filter>
										</defs>
									</svg>
								</div>
							</div>

							<div class="flex flex-col w-full items-center">
								<div class="flex flex-row w-full max-w-[870px] h-[300px] md:h-[600px] relative">
									<template x-for="(media, index) in medias">
										<div>
											<template x-if="media.type === 'video'">
												<div x-show="currentSlideIndex == index + 1" class="absolute inset-0 max-w-[870px] aspect-[100/75]" x-transition.opacity.duration.1000ms>
													<iframe class=" absolute w-full inset-0 max-w-[870px] aspect-[100/75]" x-bind:src="media.url + (media.url.includes('?') ? '&' : '?') + 'rel=0'" title="Chiots et chatons, trois mois pour devenir grand" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
												</div>
											</template>
											<template x-if="media.type === 'image'">
												<div x-show="currentSlideIndex == index + 1" class="absolute inset-0 max-w-[870px] rounded-xl bg-breeder-cream flex justify-center" x-transition.opacity.duration.1000ms>
													<img class="inset-0 text-on-surface dark:text-on-surface-dark h-[300px] md:h-[600px]" x-bind:src="media.url" x-bind:alt="media.url" />
												</div>
											</template>
										</div>
									</template>
								</div>

								<div class="relative w-full">
									<div class="absolute left-[50%] transform translate-x-[-50%] translate-y-[-150%] flex gap-x-4 z-10">
										<template x-for="(media, index) in medias">
											<button class="w-[12px] h-[12px] bg-white cursor-pointer rounded-full" x-on:click="currentSlideIndex = index + 1" x-bind:class="[currentSlideIndex === index + 1 ? 'opacity-100' : 'opacity-75']" x-bind:aria-label="'media ' + (index + 1)"></button>
										</template>
									</div>
								</div>
							</div>

							<div class="relative">
								{{-- nav Right --}}
								<div class="absolute top-[50%] transform translate-y-[-50%] translate-x-[-100%] cursor-pointer z-10" x-on:click="next()">
									<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g filter="url(#filter0_d_2400_38251)">
											<path d="M30 50C41.0457 50 50 41.0457 50 30C50 18.9543 41.0457 10 30 10C18.9543 10 10 18.9543 10 30C10 41.0457 18.9543 50 30 50Z" fill="white"/>
										</g>
										<path d="M26.3633 20.9092L35.4542 30.0001L26.3633 39.091" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<defs>
											<filter id="filter0_d_2400_38251" x="0" y="0" width="60" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
												<feFlood flood-opacity="0" result="BackgroundImageFix"/>
												<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
												<feOffset/>
												<feGaussianBlur stdDeviation="5"/>
												<feComposite in2="hardAlpha" operator="out"/>
												<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
												<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2400_38251"/>
												<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2400_38251" result="shape"/>
											</filter>
										</defs>
									</svg>
								</div>
							</div>
						</div>
					</x-front.modal>
				</div>
			@endif

			@if(
				(($company->user->values->get('interested_in') == 'both' || $company->user->values->get('interested_in') == 'dogs') && ($company->values->has('dog_facebook') || $company->values->has('dog_instagram'))) ||
				(($company->user->values->get('interested_in') == 'both' || $company->user->values->get('interested_in') == 'cats') && ($company->values->has('cat_facebook') || $company->values->has('cat_instagram'))) ||
				$company->values->has('website')
			)
				<div class="flex flex-col gap-y-2">
					<div class="flex flex-row text-[28px] font-bold mt-6 mb-4">
						{{ __('Follow them !') }}
					</div>

					<div class="flex flex-row gap-x-4">
						@if($company->user->values->get('interested_in') == 'both' || $company->user->values->get('interested_in') == 'dogs')
							@if($company->values->has('dog_facebook') && $company->values->get('dog_facebook') != '')
								<a href="{{ $company->values->get('dog_facebook') }}" target="_blank">
									<div class="flex justify-center items-center bg-breeder-deepblue w-[37px] h-[37px] rounded-full">
										<svg width="9" height="17" viewBox="0 0 9 17" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M2.76756 16.7882V9.46084H0.301758V6.60522H2.76756V4.49929C2.76756 2.05537 4.26023 0.724609 6.44037 0.724609C7.48468 0.724609 8.38222 0.802361 8.64378 0.837113V3.39115L7.13173 3.39184C5.94605 3.39184 5.71647 3.95526 5.71647 4.78204V6.60522H8.54422L8.17603 9.46084H5.71647V16.7882H2.76756Z" fill="#F7F6EF"/>
										</svg>
									</div>
								</a>
							@endif

							@if($company->values->has('dog_instagram') && $company->values->get('dog_instagram') != '')
								<a href="{{ $company->values->get('dog_instagram') }}" target="_blank">
									<div class="flex justify-center items-center bg-breeder-deepblue w-[37px] h-[37px] rounded-full">
										<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M9.35878 2.14568C11.7452 2.14568 12.0278 2.15461 12.9705 2.1976C13.5373 2.20454 14.0988 2.30862 14.6304 2.50532C15.016 2.654 15.3661 2.88177 15.6583 3.17396C15.9505 3.46615 16.1782 3.81628 16.3269 4.20181C16.5236 4.73345 16.6277 5.29489 16.6346 5.86171C16.6772 6.80444 16.6866 7.08705 16.6866 9.47346C16.6866 11.8599 16.6776 12.1425 16.6346 13.0852C16.6277 13.652 16.5236 14.2135 16.3269 14.7451C16.1782 15.1306 15.9505 15.4808 15.6583 15.773C15.3661 16.0651 15.016 16.2929 14.6304 16.4416C14.0988 16.6383 13.5373 16.7424 12.9705 16.7493C12.0282 16.7919 11.7456 16.8012 9.35878 16.8012C6.97194 16.8012 6.68933 16.7923 5.74702 16.7493C5.1802 16.7424 4.61877 16.6383 4.08713 16.4416C3.70159 16.2929 3.35146 16.0651 3.05928 15.773C2.76709 15.4808 2.53932 15.1306 2.39064 14.7451C2.19394 14.2135 2.08985 13.652 2.08292 13.0852C2.04036 12.1425 2.03099 11.8599 2.03099 9.47346C2.03099 7.08705 2.03993 6.80444 2.08292 5.86171C2.08985 5.29489 2.19394 4.73345 2.39064 4.20181C2.53932 3.81628 2.76709 3.46615 3.05928 3.17396C3.35146 2.88177 3.70159 2.654 4.08713 2.50532C4.61877 2.30862 5.1802 2.20454 5.74702 2.1976C6.68976 2.15504 6.97236 2.14568 9.35878 2.14568ZM9.35878 0.535156C6.93278 0.535156 6.62719 0.545371 5.67382 0.588783C4.93199 0.603539 4.19804 0.743996 3.50319 1.00418C2.90712 1.22876 2.36722 1.5807 1.92119 2.03544C1.46603 2.48164 1.11379 3.02184 0.889073 3.6183C0.628887 4.31315 0.48843 5.0471 0.473675 5.78893C0.431113 6.74145 0.420898 7.04704 0.420898 9.47303C0.420898 11.899 0.431113 12.2046 0.474526 13.158C0.489281 13.8998 0.629739 14.6338 0.889924 15.3286C1.1144 15.925 1.46634 16.4652 1.92119 16.9115C2.36747 17.3663 2.90766 17.7183 3.50404 17.9427C4.1989 18.2029 4.93284 18.3434 5.67467 18.3581C6.62804 18.4007 6.93236 18.4118 9.35963 18.4118C11.7869 18.4118 12.0912 18.4015 13.0446 18.3581C13.7864 18.3434 14.5204 18.2029 15.2152 17.9427C15.8088 17.7127 16.3478 17.3613 16.7977 16.911C17.2477 16.4607 17.5988 15.9215 17.8285 15.3278C18.0887 14.6329 18.2291 13.899 18.2439 13.1571C18.2864 12.2046 18.2967 11.899 18.2967 9.47303C18.2967 7.04704 18.2864 6.74145 18.243 5.78807C18.2283 5.04625 18.0878 4.3123 17.8276 3.61745C17.6032 3.02107 17.2512 2.48088 16.7964 2.03459C16.3501 1.57975 15.8099 1.2278 15.2135 1.00333C14.5187 0.743145 13.7847 0.602687 13.0429 0.587932C12.0904 0.545371 11.7848 0.535156 9.35878 0.535156Z" fill="#F7F6EF"/>
											<path d="M9.35935 4.88477C8.45157 4.88477 7.56417 5.15395 6.80938 5.65829C6.05459 6.16262 5.4663 6.87945 5.11891 7.71813C4.77152 8.55681 4.68063 9.47967 4.85773 10.37C5.03482 11.2603 5.47196 12.0782 6.11386 12.7201C6.75576 13.362 7.57358 13.7991 8.46392 13.9762C9.35426 14.1533 10.2771 14.0624 11.1158 13.715C11.9545 13.3676 12.6713 12.7793 13.1756 12.0245C13.68 11.2698 13.9492 10.3824 13.9492 9.47458C13.9492 8.25728 13.4656 7.08985 12.6048 6.22909C11.7441 5.36833 10.5766 4.88477 9.35935 4.88477ZM9.35935 12.4539C8.7701 12.4539 8.19408 12.2791 7.70414 11.9518C7.2142 11.6244 6.83233 11.1591 6.60684 10.6147C6.38134 10.0703 6.32234 9.47127 6.4373 8.89335C6.55226 8.31542 6.83601 7.78456 7.25267 7.3679C7.66933 6.95124 8.20019 6.66749 8.77812 6.55253C9.35604 6.43758 9.95508 6.49658 10.4995 6.72207C11.0439 6.94757 11.5092 7.32943 11.8365 7.81937C12.1639 8.30931 12.3386 8.88533 12.3386 9.47458C12.3386 10.2647 12.0248 11.0225 11.466 11.5813C10.9073 12.14 10.1495 12.4539 9.35935 12.4539Z" fill="#F7F6EF"/>
											<path d="M14.1302 5.77595C14.7225 5.77595 15.2027 5.29576 15.2027 4.7034C15.2027 4.11105 14.7225 3.63086 14.1302 3.63086C13.5378 3.63086 13.0576 4.11105 13.0576 4.7034C13.0576 5.29576 13.5378 5.77595 14.1302 5.77595Z" fill="#F7F6EF"/>
										</svg>
									</div>
								</a>
							@endif
						@endif

						@if($company->user->values->get('interested_in') == 'both' || $company->user->values->get('interested_in') == 'cats')
							@if($company->values->has('cat_facebook') && $company->values->get('cat_facebook') != '')
								<a href="{{ $company->values->get('cat_facebook') }}" target="_blank">
									<div class="flex justify-center items-center bg-breeder-deepblue w-[37px] h-[37px] rounded-full">
										<svg width="9" height="17" viewBox="0 0 9 17" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M2.76756 16.7882V9.46084H0.301758V6.60522H2.76756V4.49929C2.76756 2.05537 4.26023 0.724609 6.44037 0.724609C7.48468 0.724609 8.38222 0.802361 8.64378 0.837113V3.39115L7.13173 3.39184C5.94605 3.39184 5.71647 3.95526 5.71647 4.78204V6.60522H8.54422L8.17603 9.46084H5.71647V16.7882H2.76756Z" fill="#F7F6EF"/>
										</svg>
									</div>
								</a>
							@endif

							@if($company->values->has('cat_instagram') && $company->values->get('cat_instagram') != '')
								<a href="{{ $company->values->get('cat_instagram') }}" target="_blank">
									<div class="flex justify-center items-center bg-breeder-deepblue w-[37px] h-[37px] rounded-full">
										<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M9.35878 2.14568C11.7452 2.14568 12.0278 2.15461 12.9705 2.1976C13.5373 2.20454 14.0988 2.30862 14.6304 2.50532C15.016 2.654 15.3661 2.88177 15.6583 3.17396C15.9505 3.46615 16.1782 3.81628 16.3269 4.20181C16.5236 4.73345 16.6277 5.29489 16.6346 5.86171C16.6772 6.80444 16.6866 7.08705 16.6866 9.47346C16.6866 11.8599 16.6776 12.1425 16.6346 13.0852C16.6277 13.652 16.5236 14.2135 16.3269 14.7451C16.1782 15.1306 15.9505 15.4808 15.6583 15.773C15.3661 16.0651 15.016 16.2929 14.6304 16.4416C14.0988 16.6383 13.5373 16.7424 12.9705 16.7493C12.0282 16.7919 11.7456 16.8012 9.35878 16.8012C6.97194 16.8012 6.68933 16.7923 5.74702 16.7493C5.1802 16.7424 4.61877 16.6383 4.08713 16.4416C3.70159 16.2929 3.35146 16.0651 3.05928 15.773C2.76709 15.4808 2.53932 15.1306 2.39064 14.7451C2.19394 14.2135 2.08985 13.652 2.08292 13.0852C2.04036 12.1425 2.03099 11.8599 2.03099 9.47346C2.03099 7.08705 2.03993 6.80444 2.08292 5.86171C2.08985 5.29489 2.19394 4.73345 2.39064 4.20181C2.53932 3.81628 2.76709 3.46615 3.05928 3.17396C3.35146 2.88177 3.70159 2.654 4.08713 2.50532C4.61877 2.30862 5.1802 2.20454 5.74702 2.1976C6.68976 2.15504 6.97236 2.14568 9.35878 2.14568ZM9.35878 0.535156C6.93278 0.535156 6.62719 0.545371 5.67382 0.588783C4.93199 0.603539 4.19804 0.743996 3.50319 1.00418C2.90712 1.22876 2.36722 1.5807 1.92119 2.03544C1.46603 2.48164 1.11379 3.02184 0.889073 3.6183C0.628887 4.31315 0.48843 5.0471 0.473675 5.78893C0.431113 6.74145 0.420898 7.04704 0.420898 9.47303C0.420898 11.899 0.431113 12.2046 0.474526 13.158C0.489281 13.8998 0.629739 14.6338 0.889924 15.3286C1.1144 15.925 1.46634 16.4652 1.92119 16.9115C2.36747 17.3663 2.90766 17.7183 3.50404 17.9427C4.1989 18.2029 4.93284 18.3434 5.67467 18.3581C6.62804 18.4007 6.93236 18.4118 9.35963 18.4118C11.7869 18.4118 12.0912 18.4015 13.0446 18.3581C13.7864 18.3434 14.5204 18.2029 15.2152 17.9427C15.8088 17.7127 16.3478 17.3613 16.7977 16.911C17.2477 16.4607 17.5988 15.9215 17.8285 15.3278C18.0887 14.6329 18.2291 13.899 18.2439 13.1571C18.2864 12.2046 18.2967 11.899 18.2967 9.47303C18.2967 7.04704 18.2864 6.74145 18.243 5.78807C18.2283 5.04625 18.0878 4.3123 17.8276 3.61745C17.6032 3.02107 17.2512 2.48088 16.7964 2.03459C16.3501 1.57975 15.8099 1.2278 15.2135 1.00333C14.5187 0.743145 13.7847 0.602687 13.0429 0.587932C12.0904 0.545371 11.7848 0.535156 9.35878 0.535156Z" fill="#F7F6EF"/>
											<path d="M9.35935 4.88477C8.45157 4.88477 7.56417 5.15395 6.80938 5.65829C6.05459 6.16262 5.4663 6.87945 5.11891 7.71813C4.77152 8.55681 4.68063 9.47967 4.85773 10.37C5.03482 11.2603 5.47196 12.0782 6.11386 12.7201C6.75576 13.362 7.57358 13.7991 8.46392 13.9762C9.35426 14.1533 10.2771 14.0624 11.1158 13.715C11.9545 13.3676 12.6713 12.7793 13.1756 12.0245C13.68 11.2698 13.9492 10.3824 13.9492 9.47458C13.9492 8.25728 13.4656 7.08985 12.6048 6.22909C11.7441 5.36833 10.5766 4.88477 9.35935 4.88477ZM9.35935 12.4539C8.7701 12.4539 8.19408 12.2791 7.70414 11.9518C7.2142 11.6244 6.83233 11.1591 6.60684 10.6147C6.38134 10.0703 6.32234 9.47127 6.4373 8.89335C6.55226 8.31542 6.83601 7.78456 7.25267 7.3679C7.66933 6.95124 8.20019 6.66749 8.77812 6.55253C9.35604 6.43758 9.95508 6.49658 10.4995 6.72207C11.0439 6.94757 11.5092 7.32943 11.8365 7.81937C12.1639 8.30931 12.3386 8.88533 12.3386 9.47458C12.3386 10.2647 12.0248 11.0225 11.466 11.5813C10.9073 12.14 10.1495 12.4539 9.35935 12.4539Z" fill="#F7F6EF"/>
											<path d="M14.1302 5.77595C14.7225 5.77595 15.2027 5.29576 15.2027 4.7034C15.2027 4.11105 14.7225 3.63086 14.1302 3.63086C13.5378 3.63086 13.0576 4.11105 13.0576 4.7034C13.0576 5.29576 13.5378 5.77595 14.1302 5.77595Z" fill="#F7F6EF"/>
										</svg>
									</div>
								</a>
							@endif
						@endif

						@if($company->values->has('website') && $company->values->get('website') != '')
							<a href="{{ $company->values->get('website') }}" target="_blank">
								<div class="flex justify-center items-center bg-breeder-deepblue w-[37px] h-[37px] rounded-full">
									<svg width="37" height="38" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="18.4716" cy="19.415" r="18.4716" fill="#0E1954"/>
										<path d="M25.5549 14.8682C24.5125 15.4941 23.3586 15.9923 22.1242 16.34C20.8277 16.7031 19.4408 16.9008 18.0006 16.9008C16.5604 16.9008 15.1735 16.7031 13.8771 16.3387C12.642 15.9923 11.4881 15.4941 10.4464 14.8682M25.5549 23.7411C24.5125 23.1152 23.3586 22.617 22.1242 22.2693C20.8277 21.9062 19.4408 21.7085 18.0006 21.7085C16.5604 21.7085 15.1735 21.9062 13.8771 22.2706C12.642 22.617 11.4881 23.1152 10.4464 23.7411M18.0161 9.95265V27.6905M11.636 12.5794C8.12132 16.0941 8.12132 21.7926 11.636 25.3073C15.1508 28.822 20.8492 28.822 24.364 25.3073C27.8787 21.7926 27.8787 16.0941 24.364 12.5794C20.8492 9.06468 15.1508 9.06468 11.636 12.5794ZM13.4012 18.9434C13.4012 23.9139 15.4601 27.9434 18 27.9434C20.5399 27.9434 22.5989 23.9139 22.5989 18.9434C22.5989 13.9728 20.5399 9.94336 18 9.94336C15.4601 9.94336 13.4012 13.9728 13.4012 18.9434Z" stroke="#F7F6EF" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
							</a>
						@endif
					</div>
				</div>
			@endif

			<div class="flex flex-col text-xs italic mt-6">
				@if($company->user->hasRole('professionnal_breeder') && $company->user->lastModeration?->isValidated())
					<span>
						{{ __('Siret checked and validated on :date', ['date' => $company->user->getValidatedModeration()->created_at->format('d/m/Y H:i:s')]) }}
					</span>
				@endif

				@if($company->isValidated())
					<span>
						{{ __('This breeder is listed on :siteName since :date', ['siteName' => env('APP_NAME'), 'date' => $company->created_at->diffForHumans(null, true)]) }}
					</span>
				@endif
			</div>

			@if($company->user->publishedProfessionnalActivities->isNotEmpty())
				<div class="flex flex-col gap-y-2">
					<div class="flex flex-row text-[28px] mt-6 mb-4 gap-x-2">
						<span class="font-bold">
							{{ __('Other services') }}
						</span>

						{{ __('available from the company') }}
					</div>

					<div class="flex flex-col w-full gap-4 px-4">
						@foreach($company->user->publishedProfessionnalActivities as $professionnalActivity)
							@include('components.front.professionnal-activities.banner')
						@endforeach
					</div>
				</div>
			@endif

			@if($company->getCommentsReceivedPublished()->isNotEmpty())
				<livewire:front.comments.recently-published
					:target="$company"
					:source="'user'"
					:key="'last-adopters-comments'" />
			@endif
		</div>
	</div>

	{{-- Column right --}}
	<div class="max-xlsm:mb-10 w-full max-xlsm:px-4 max-sm:mx-2 xlsm:w-[300px]">
		<div class="border border-x border-breeder-greige rounded-xl w-full">
			@if($company->user->lastModeration?->isValidated())
				<div class="flex flex-row justify-center items-center gap-x-2 mb-4 bg-breeder-cream rounded-t-xl p-2">
					<svg class="shrink-0" width="90" height="100" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M84.6574 21.1795L50.3376 1.5532C47.0375 -0.340652 42.9626 -0.340652 39.6624 1.5532L5.34265 21.1795C2.04248 23.0734 0 26.5621 0 30.3398V69.5925C0 73.3702 2.03242 76.8689 5.34265 78.7528L39.6624 98.3791C42.9626 100.273 47.0375 100.273 50.3376 98.3791L84.6574 78.7528C87.9575 76.8589 90 73.3702 90 69.5925V30.3498C90 26.572 87.9676 23.0734 84.6574 21.1895V21.1795Z" fill="white"/>
						<path d="M48.8404 23.0655C47.6377 22.4683 46.2795 22.1328 44.8477 22.1328C39.8731 22.1328 35.8477 26.1583 35.8477 31.1328C35.8477 36.1074 39.8731 40.1328 44.8477 40.1328C49.8222 40.1328 53.8477 36.1074 53.8477 31.1328C53.8477 29.9792 53.6267 28.8746 53.234 27.8601" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M40.7578 31.1328L44.0305 34.4055L48.8415 28.3919L49.2669 27.8601L51.5005 25.0701L53.8487 22.1328" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M20.2944 51.9088C20.2944 51.0768 20.4744 50.3368 20.8344 49.6888C21.1944 49.0328 21.6944 48.5248 22.3344 48.1648C22.9824 47.7968 23.7144 47.6128 24.5304 47.6128C25.5304 47.6128 26.3864 47.8768 27.0984 48.4048C27.8104 48.9328 28.2864 49.6528 28.5264 50.5648H26.2704C26.1024 50.2128 25.8624 49.9448 25.5504 49.7608C25.2464 49.5768 24.8984 49.4848 24.5064 49.4848C23.8744 49.4848 23.3624 49.7048 22.9704 50.1448C22.5784 50.5848 22.3824 51.1728 22.3824 51.9088C22.3824 52.6448 22.5784 53.2328 22.9704 53.6728C23.3624 54.1128 23.8744 54.3328 24.5064 54.3328C24.8984 54.3328 25.2464 54.2408 25.5504 54.0568C25.8624 53.8728 26.1024 53.6048 26.2704 53.2528H28.5264C28.2864 54.1648 27.8104 54.8848 27.0984 55.4128C26.3864 55.9328 25.5304 56.1928 24.5304 56.1928C23.7144 56.1928 22.9824 56.0128 22.3344 55.6528C21.6944 55.2848 21.1944 54.7768 20.8344 54.1288C20.4744 53.4808 20.2944 52.7408 20.2944 51.9088ZM32.8311 56.2288C32.1751 56.2288 31.5831 56.0888 31.0551 55.8088C30.5351 55.5288 30.1231 55.1288 29.8191 54.6088C29.5231 54.0888 29.3751 53.4808 29.3751 52.7848C29.3751 52.0968 29.5271 51.4928 29.8311 50.9728C30.1351 50.4448 30.5511 50.0408 31.0791 49.7608C31.6071 49.4808 32.1991 49.3408 32.8551 49.3408C33.5111 49.3408 34.1031 49.4808 34.6311 49.7608C35.1591 50.0408 35.5751 50.4448 35.8791 50.9728C36.1831 51.4928 36.3351 52.0968 36.3351 52.7848C36.3351 53.4728 36.1791 54.0808 35.8671 54.6088C35.5631 55.1288 35.1431 55.5288 34.6071 55.8088C34.0791 56.0888 33.4871 56.2288 32.8311 56.2288ZM32.8311 54.4528C33.2231 54.4528 33.5551 54.3088 33.8271 54.0208C34.1071 53.7328 34.2471 53.3208 34.2471 52.7848C34.2471 52.2488 34.1111 51.8368 33.8391 51.5488C33.5751 51.2608 33.2471 51.1168 32.8551 51.1168C32.4551 51.1168 32.1231 51.2608 31.8591 51.5488C31.5951 51.8288 31.4631 52.2408 31.4631 52.7848C31.4631 53.3208 31.5911 53.7328 31.8471 54.0208C32.1111 54.3088 32.4391 54.4528 32.8311 54.4528ZM45.9677 49.3648C46.7997 49.3648 47.4597 49.6168 47.9477 50.1208C48.4437 50.6248 48.6917 51.3248 48.6917 52.2208V56.1328H46.6517V52.4968C46.6517 52.0648 46.5357 51.7328 46.3037 51.5008C46.0797 51.2608 45.7677 51.1408 45.3677 51.1408C44.9677 51.1408 44.6517 51.2608 44.4197 51.5008C44.1957 51.7328 44.0837 52.0648 44.0837 52.4968V56.1328H42.0437V52.4968C42.0437 52.0648 41.9277 51.7328 41.6957 51.5008C41.4717 51.2608 41.1597 51.1408 40.7597 51.1408C40.3597 51.1408 40.0437 51.2608 39.8117 51.5008C39.5877 51.7328 39.4757 52.0648 39.4757 52.4968V56.1328H37.4237V49.4368H39.4757V50.2768C39.6837 49.9968 39.9557 49.7768 40.2917 49.6168C40.6277 49.4488 41.0077 49.3648 41.4317 49.3648C41.9357 49.3648 42.3837 49.4728 42.7757 49.6888C43.1757 49.9048 43.4877 50.2128 43.7117 50.6128C43.9437 50.2448 44.2597 49.9448 44.6597 49.7128C45.0597 49.4808 45.4957 49.3648 45.9677 49.3648ZM52.1788 50.3848C52.3788 50.0728 52.6548 49.8208 53.0068 49.6288C53.3588 49.4368 53.7708 49.3408 54.2428 49.3408C54.7948 49.3408 55.2948 49.4808 55.7428 49.7608C56.1908 50.0408 56.5428 50.4408 56.7988 50.9608C57.0628 51.4808 57.1948 52.0848 57.1948 52.7728C57.1948 53.4608 57.0628 54.0688 56.7988 54.5968C56.5428 55.1168 56.1908 55.5208 55.7428 55.8088C55.2948 56.0888 54.7948 56.2288 54.2428 56.2288C53.7788 56.2288 53.3668 56.1328 53.0068 55.9408C52.6548 55.7488 52.3788 55.5008 52.1788 55.1968V59.3248H50.1268V49.4368H52.1788V50.3848ZM55.1068 52.7728C55.1068 52.2608 54.9628 51.8608 54.6748 51.5728C54.3948 51.2768 54.0468 51.1288 53.6308 51.1288C53.2228 51.1288 52.8748 51.2768 52.5868 51.5728C52.3068 51.8688 52.1668 52.2728 52.1668 52.7848C52.1668 53.2968 52.3068 53.7008 52.5868 53.9968C52.8748 54.2928 53.2228 54.4408 53.6308 54.4408C54.0388 54.4408 54.3868 54.2928 54.6748 53.9968C54.9628 53.6928 55.1068 53.2848 55.1068 52.7728ZM62.0033 54.3928V56.1328H60.9593C60.2153 56.1328 59.6353 55.9528 59.2193 55.5928C58.8033 55.2248 58.5953 54.6288 58.5953 53.8048V51.1408H57.7793V49.4368H58.5953V47.8048H60.6473V49.4368H61.9913V51.1408H60.6473V53.8288C60.6473 54.0288 60.6953 54.1728 60.7913 54.2608C60.8873 54.3488 61.0473 54.3928 61.2713 54.3928H62.0033ZM69.4583 52.6768C69.4583 52.8688 69.4463 53.0688 69.4223 53.2768H64.7783C64.8103 53.6928 64.9423 54.0128 65.1743 54.2368C65.4143 54.4528 65.7063 54.5608 66.0503 54.5608C66.5623 54.5608 66.9183 54.3448 67.1183 53.9128H69.3023C69.1903 54.3528 68.9863 54.7488 68.6903 55.1008C68.4023 55.4528 68.0383 55.7288 67.5983 55.9288C67.1583 56.1288 66.6663 56.2288 66.1223 56.2288C65.4663 56.2288 64.8823 56.0888 64.3703 55.8088C63.8583 55.5288 63.4583 55.1288 63.1703 54.6088C62.8823 54.0888 62.7383 53.4808 62.7383 52.7848C62.7383 52.0888 62.8783 51.4808 63.1583 50.9608C63.4463 50.4408 63.8463 50.0408 64.3583 49.7608C64.8703 49.4808 65.4583 49.3408 66.1223 49.3408C66.7703 49.3408 67.3463 49.4768 67.8503 49.7488C68.3543 50.0208 68.7463 50.4088 69.0263 50.9128C69.3143 51.4168 69.4583 52.0048 69.4583 52.6768ZM67.3583 52.1368C67.3583 51.7848 67.2383 51.5048 66.9983 51.2968C66.7583 51.0888 66.4583 50.9848 66.0983 50.9848C65.7543 50.9848 65.4623 51.0848 65.2223 51.2848C64.9903 51.4848 64.8463 51.7688 64.7903 52.1368H67.3583ZM29.1857 70.2128L30.6377 65.4368H32.8217L30.4457 72.1328H27.9137L25.5377 65.4368H27.7337L29.1857 70.2128ZM39.9974 68.6768C39.9974 68.8688 39.9854 69.0688 39.9614 69.2768H35.3174C35.3494 69.6928 35.4814 70.0128 35.7134 70.2368C35.9534 70.4528 36.2454 70.5608 36.5894 70.5608C37.1014 70.5608 37.4574 70.3448 37.6574 69.9128H39.8414C39.7294 70.3528 39.5254 70.7488 39.2294 71.1008C38.9414 71.4528 38.5774 71.7288 38.1374 71.9288C37.6974 72.1288 37.2054 72.2288 36.6614 72.2288C36.0054 72.2288 35.4214 72.0888 34.9094 71.8088C34.3974 71.5288 33.9974 71.1288 33.7094 70.6088C33.4214 70.0888 33.2774 69.4808 33.2774 68.7848C33.2774 68.0888 33.4174 67.4808 33.6974 66.9608C33.9854 66.4408 34.3854 66.0408 34.8974 65.7608C35.4094 65.4808 35.9974 65.3408 36.6614 65.3408C37.3094 65.3408 37.8854 65.4768 38.3894 65.7488C38.8934 66.0208 39.2854 66.4088 39.5654 66.9128C39.8534 67.4168 39.9974 68.0048 39.9974 68.6768ZM37.8974 68.1368C37.8974 67.7848 37.7774 67.5048 37.5374 67.2968C37.2974 67.0888 36.9974 66.9848 36.6374 66.9848C36.2934 66.9848 36.0014 67.0848 35.7614 67.2848C35.5294 67.4848 35.3854 67.7688 35.3294 68.1368H37.8974ZM38.0414 63.7208L35.1494 64.9328V63.5168L38.0414 62.1248V63.7208ZM43.1319 66.5528C43.3719 66.1848 43.6719 65.8968 44.0319 65.6888C44.3919 65.4728 44.7919 65.3648 45.2319 65.3648V67.5368H44.6679C44.1559 67.5368 43.7719 67.6488 43.5159 67.8728C43.2599 68.0888 43.1319 68.4728 43.1319 69.0248V72.1328H41.0799V65.4368H43.1319V66.5528ZM47.2448 64.7408C46.8848 64.7408 46.5888 64.6368 46.3568 64.4288C46.1328 64.2128 46.0208 63.9488 46.0208 63.6368C46.0208 63.3168 46.1328 63.0528 46.3568 62.8448C46.5888 62.6288 46.8848 62.5208 47.2448 62.5208C47.5968 62.5208 47.8848 62.6288 48.1088 62.8448C48.3408 63.0528 48.4568 63.3168 48.4568 63.6368C48.4568 63.9488 48.3408 64.2128 48.1088 64.4288C47.8848 64.6368 47.5968 64.7408 47.2448 64.7408ZM48.2648 65.4368V72.1328H46.2128V65.4368H48.2648ZM53.1118 67.1408H52.0078V72.1328H49.9558V67.1408H49.2118V65.4368H49.9558V65.2448C49.9558 64.4208 50.1918 63.7968 50.6638 63.3728C51.1358 62.9408 51.8278 62.7248 52.7398 62.7248C52.8918 62.7248 53.0038 62.7288 53.0758 62.7368V64.4768C52.6838 64.4528 52.4078 64.5088 52.2478 64.6448C52.0878 64.7808 52.0078 65.0248 52.0078 65.3768V65.4368H53.1118V67.1408ZM55.108 64.7408C54.748 64.7408 54.452 64.6368 54.22 64.4288C53.996 64.2128 53.884 63.9488 53.884 63.6368C53.884 63.3168 53.996 63.0528 54.22 62.8448C54.452 62.6288 54.748 62.5208 55.108 62.5208C55.46 62.5208 55.748 62.6288 55.972 62.8448C56.204 63.0528 56.32 63.3168 56.32 63.6368C56.32 63.9488 56.204 64.2128 55.972 64.4288C55.748 64.6368 55.46 64.7408 55.108 64.7408ZM56.128 65.4368V72.1328H54.076V65.4368H56.128ZM63.9271 68.6768C63.9271 68.8688 63.9151 69.0688 63.8911 69.2768H59.2471C59.2791 69.6928 59.4111 70.0128 59.6431 70.2368C59.8831 70.4528 60.1751 70.5608 60.5191 70.5608C61.0311 70.5608 61.3871 70.3448 61.5871 69.9128H63.7711C63.6591 70.3528 63.4551 70.7488 63.1591 71.1008C62.8711 71.4528 62.5071 71.7288 62.0671 71.9288C61.6271 72.1288 61.1351 72.2288 60.5911 72.2288C59.9351 72.2288 59.3511 72.0888 58.8391 71.8088C58.3271 71.5288 57.9271 71.1288 57.6391 70.6088C57.3511 70.0888 57.2071 69.4808 57.2071 68.7848C57.2071 68.0888 57.3471 67.4808 57.6271 66.9608C57.9151 66.4408 58.3151 66.0408 58.8271 65.7608C59.3391 65.4808 59.9271 65.3408 60.5911 65.3408C61.2391 65.3408 61.8151 65.4768 62.3191 65.7488C62.8231 66.0208 63.2151 66.4088 63.4951 66.9128C63.7831 67.4168 63.9271 68.0048 63.9271 68.6768ZM61.8271 68.1368C61.8271 67.7848 61.7071 67.5048 61.4671 67.2968C61.2271 67.0888 60.9271 66.9848 60.5671 66.9848C60.2231 66.9848 59.9311 67.0848 59.6911 67.2848C59.4591 67.4848 59.3151 67.7688 59.2591 68.1368H61.8271ZM61.9711 63.7208L59.0791 64.9328V63.5168L61.9711 62.1248V63.7208Z" fill="#0E1954"/>
					</svg>

					@if($company->user->hasRole('professionnal_breeder') && (data_get($company->user->values, 'agreement_EOL.cats') || data_get($company->user->values, 'agreement_EOL.dogs')))
						<svg class="shrink-0" width="90" height="100" viewBox="0 0 90 100" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M84.6574 21.1795L50.3376 1.5532C47.0375 -0.340652 42.9626 -0.340652 39.6624 1.5532L5.34265 21.1795C2.04248 23.0734 0 26.5621 0 30.3398V69.5925C0 73.3702 2.03242 76.8689 5.34265 78.7528L39.6624 98.3791C42.9626 100.273 47.0375 100.273 50.3376 98.3791L84.6574 78.7528C87.9575 76.8589 90 73.3702 90 69.5925V30.3498C90 26.572 87.9676 23.0734 84.6574 21.1895V21.1795Z" fill="white"/>
							<path d="M48.8404 23.0655C47.6377 22.4683 46.2795 22.1328 44.8477 22.1328C39.8731 22.1328 35.8477 26.1583 35.8477 31.1328C35.8477 36.1074 39.8731 40.1328 44.8477 40.1328C49.8222 40.1328 53.8477 36.1074 53.8477 31.1328C53.8477 29.9792 53.6267 28.8746 53.234 27.8601" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M40.7578 31.1328L44.0305 34.4055L48.8415 28.3919L49.2669 27.8601L51.5005 25.0701L53.8487 22.1328" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M18.9135 47.7088V49.3528H15.4815V51.1288H18.0495V52.7248H15.4815V56.1328H13.4295V47.7088H18.9135ZM23.04 56.2288C22.384 56.2288 21.792 56.0888 21.264 55.8088C20.744 55.5288 20.332 55.1288 20.028 54.6088C19.732 54.0888 19.584 53.4808 19.584 52.7848C19.584 52.0968 19.736 51.4928 20.04 50.9728C20.344 50.4448 20.76 50.0408 21.288 49.7608C21.816 49.4808 22.408 49.3408 23.064 49.3408C23.72 49.3408 24.312 49.4808 24.84 49.7608C25.368 50.0408 25.784 50.4448 26.088 50.9728C26.392 51.4928 26.544 52.0968 26.544 52.7848C26.544 53.4728 26.388 54.0808 26.076 54.6088C25.772 55.1288 25.352 55.5288 24.816 55.8088C24.288 56.0888 23.696 56.2288 23.04 56.2288ZM23.04 54.4528C23.432 54.4528 23.764 54.3088 24.036 54.0208C24.316 53.7328 24.456 53.3208 24.456 52.7848C24.456 52.2488 24.32 51.8368 24.048 51.5488C23.784 51.2608 23.456 51.1168 23.064 51.1168C22.664 51.1168 22.332 51.2608 22.068 51.5488C21.804 51.8288 21.672 52.2408 21.672 52.7848C21.672 53.3208 21.8 53.7328 22.056 54.0208C22.32 54.3088 22.648 54.4528 23.04 54.4528ZM29.6847 50.5528C29.9247 50.1848 30.2247 49.8968 30.5847 49.6888C30.9447 49.4728 31.3447 49.3648 31.7847 49.3648V51.5368H31.2207C30.7087 51.5368 30.3247 51.6488 30.0687 51.8728C29.8127 52.0888 29.6847 52.4728 29.6847 53.0248V56.1328H27.6327V49.4368H29.6847V50.5528ZM41.3095 49.3648C42.1415 49.3648 42.8015 49.6168 43.2895 50.1208C43.7855 50.6248 44.0335 51.3248 44.0335 52.2208V56.1328H41.9935V52.4968C41.9935 52.0648 41.8775 51.7328 41.6455 51.5008C41.4215 51.2608 41.1095 51.1408 40.7095 51.1408C40.3095 51.1408 39.9935 51.2608 39.7615 51.5008C39.5375 51.7328 39.4255 52.0648 39.4255 52.4968V56.1328H37.3855V52.4968C37.3855 52.0648 37.2695 51.7328 37.0375 51.5008C36.8135 51.2608 36.5015 51.1408 36.1015 51.1408C35.7015 51.1408 35.3855 51.2608 35.1535 51.5008C34.9295 51.7328 34.8175 52.0648 34.8175 52.4968V56.1328H32.7655V49.4368H34.8175V50.2768C35.0255 49.9968 35.2975 49.7768 35.6335 49.6168C35.9695 49.4488 36.3495 49.3648 36.7735 49.3648C37.2775 49.3648 37.7255 49.4728 38.1175 49.6888C38.5175 49.9048 38.8295 50.2128 39.0535 50.6128C39.2855 50.2448 39.6015 49.9448 40.0015 49.7128C40.4015 49.4808 40.8375 49.3648 41.3095 49.3648ZM45.0606 52.7728C45.0606 52.0848 45.1886 51.4808 45.4446 50.9608C45.7086 50.4408 46.0646 50.0408 46.5126 49.7608C46.9606 49.4808 47.4606 49.3408 48.0126 49.3408C48.4846 49.3408 48.8966 49.4368 49.2486 49.6288C49.6086 49.8208 49.8846 50.0728 50.0766 50.3848V49.4368H52.1286V56.1328H50.0766V55.1848C49.8766 55.4968 49.5966 55.7488 49.2366 55.9408C48.8846 56.1328 48.4726 56.2288 48.0006 56.2288C47.4566 56.2288 46.9606 56.0888 46.5126 55.8088C46.0646 55.5208 45.7086 55.1168 45.4446 54.5968C45.1886 54.0688 45.0606 53.4608 45.0606 52.7728ZM50.0766 52.7848C50.0766 52.2728 49.9326 51.8688 49.6446 51.5728C49.3646 51.2768 49.0206 51.1288 48.6126 51.1288C48.2046 51.1288 47.8566 51.2768 47.5686 51.5728C47.2886 51.8608 47.1486 52.2608 47.1486 52.7728C47.1486 53.2848 47.2886 53.6928 47.5686 53.9968C47.8566 54.2928 48.2046 54.4408 48.6126 54.4408C49.0206 54.4408 49.3646 54.2928 49.6446 53.9968C49.9326 53.7008 50.0766 53.2968 50.0766 52.7848ZM57.3451 54.3928V56.1328H56.3011C55.5571 56.1328 54.9771 55.9528 54.5611 55.5928C54.1451 55.2248 53.9371 54.6288 53.9371 53.8048V51.1408H53.1211V49.4368H53.9371V47.8048H55.9891V49.4368H57.3331V51.1408H55.9891V53.8288C55.9891 54.0288 56.0371 54.1728 56.1331 54.2608C56.2291 54.3488 56.3891 54.3928 56.6131 54.3928H57.3451ZM59.5201 48.7408C59.1601 48.7408 58.8641 48.6368 58.6321 48.4288C58.4081 48.2128 58.2961 47.9488 58.2961 47.6368C58.2961 47.3168 58.4081 47.0528 58.6321 46.8448C58.8641 46.6288 59.1601 46.5208 59.5201 46.5208C59.8721 46.5208 60.1601 46.6288 60.3841 46.8448C60.6161 47.0528 60.7321 47.3168 60.7321 47.6368C60.7321 47.9488 60.6161 48.2128 60.3841 48.4288C60.1601 48.6368 59.8721 48.7408 59.5201 48.7408ZM60.5401 49.4368V56.1328H58.4881V49.4368H60.5401ZM65.0752 56.2288C64.4192 56.2288 63.8272 56.0888 63.2992 55.8088C62.7792 55.5288 62.3672 55.1288 62.0632 54.6088C61.7672 54.0888 61.6192 53.4808 61.6192 52.7848C61.6192 52.0968 61.7712 51.4928 62.0752 50.9728C62.3792 50.4448 62.7952 50.0408 63.3232 49.7608C63.8512 49.4808 64.4432 49.3408 65.0992 49.3408C65.7552 49.3408 66.3472 49.4808 66.8752 49.7608C67.4032 50.0408 67.8192 50.4448 68.1232 50.9728C68.4272 51.4928 68.5792 52.0968 68.5792 52.7848C68.5792 53.4728 68.4232 54.0808 68.1112 54.6088C67.8072 55.1288 67.3872 55.5288 66.8512 55.8088C66.3232 56.0888 65.7312 56.2288 65.0752 56.2288ZM65.0752 54.4528C65.4672 54.4528 65.7992 54.3088 66.0712 54.0208C66.3512 53.7328 66.4912 53.3208 66.4912 52.7848C66.4912 52.2488 66.3552 51.8368 66.0832 51.5488C65.8192 51.2608 65.4912 51.1168 65.0992 51.1168C64.6992 51.1168 64.3672 51.2608 64.1032 51.5488C63.8392 51.8288 63.7072 52.2408 63.7072 52.7848C63.7072 53.3208 63.8352 53.7328 64.0912 54.0208C64.3552 54.3088 64.6832 54.4528 65.0752 54.4528ZM73.7478 49.3648C74.5318 49.3648 75.1558 49.6208 75.6198 50.1328C76.0918 50.6368 76.3278 51.3328 76.3278 52.2208V56.1328H74.2878V52.4968C74.2878 52.0488 74.1718 51.7008 73.9398 51.4528C73.7078 51.2048 73.3958 51.0808 73.0038 51.0808C72.6118 51.0808 72.2998 51.2048 72.0678 51.4528C71.8358 51.7008 71.7198 52.0488 71.7198 52.4968V56.1328H69.6678V49.4368H71.7198V50.3248C71.9278 50.0288 72.2078 49.7968 72.5598 49.6288C72.9118 49.4528 73.3078 49.3648 73.7478 49.3648ZM25.4884 70.2128L26.9404 65.4368H29.1244L26.7484 72.1328H24.2164L21.8404 65.4368H24.0364L25.4884 70.2128ZM36.3001 68.6768C36.3001 68.8688 36.2881 69.0688 36.2641 69.2768H31.6201C31.6521 69.6928 31.7841 70.0128 32.0161 70.2368C32.2561 70.4528 32.5481 70.5608 32.8921 70.5608C33.4041 70.5608 33.7601 70.3448 33.9601 69.9128H36.1441C36.0321 70.3528 35.8281 70.7488 35.5321 71.1008C35.2441 71.4528 34.8801 71.7288 34.4401 71.9288C34.0001 72.1288 33.5081 72.2288 32.9641 72.2288C32.3081 72.2288 31.7241 72.0888 31.2121 71.8088C30.7001 71.5288 30.3001 71.1288 30.0121 70.6088C29.7241 70.0888 29.5801 69.4808 29.5801 68.7848C29.5801 68.0888 29.7201 67.4808 30.0001 66.9608C30.2881 66.4408 30.6881 66.0408 31.2001 65.7608C31.7121 65.4808 32.3001 65.3408 32.9641 65.3408C33.6121 65.3408 34.1881 65.4768 34.6921 65.7488C35.1961 66.0208 35.5881 66.4088 35.8681 66.9128C36.1561 67.4168 36.3001 68.0048 36.3001 68.6768ZM34.2001 68.1368C34.2001 67.7848 34.0801 67.5048 33.8401 67.2968C33.6001 67.0888 33.3001 66.9848 32.9401 66.9848C32.5961 66.9848 32.3041 67.0848 32.0641 67.2848C31.8321 67.4848 31.6881 67.7688 31.6321 68.1368H34.2001ZM34.3441 63.7208L31.4521 64.9328V63.5168L34.3441 62.1248V63.7208ZM39.4347 66.5528C39.6747 66.1848 39.9747 65.8968 40.3347 65.6888C40.6947 65.4728 41.0947 65.3648 41.5347 65.3648V67.5368H40.9707C40.4587 67.5368 40.0747 67.6488 39.8187 67.8728C39.5627 68.0888 39.4347 68.4728 39.4347 69.0248V72.1328H37.3827V65.4368H39.4347V66.5528ZM43.5475 64.7408C43.1875 64.7408 42.8915 64.6368 42.6595 64.4288C42.4355 64.2128 42.3235 63.9488 42.3235 63.6368C42.3235 63.3168 42.4355 63.0528 42.6595 62.8448C42.8915 62.6288 43.1875 62.5208 43.5475 62.5208C43.8995 62.5208 44.1875 62.6288 44.4115 62.8448C44.6435 63.0528 44.7595 63.3168 44.7595 63.6368C44.7595 63.9488 44.6435 64.2128 44.4115 64.4288C44.1875 64.6368 43.8995 64.7408 43.5475 64.7408ZM44.5675 65.4368V72.1328H42.5155V65.4368H44.5675ZM49.4145 67.1408H48.3105V72.1328H46.2585V67.1408H45.5145V65.4368H46.2585V65.2448C46.2585 64.4208 46.4945 63.7968 46.9665 63.3728C47.4385 62.9408 48.1305 62.7248 49.0425 62.7248C49.1945 62.7248 49.3065 62.7288 49.3785 62.7368V64.4768C48.9865 64.4528 48.7105 64.5088 48.5505 64.6448C48.3905 64.7808 48.3105 65.0248 48.3105 65.3768V65.4368H49.4145V67.1408ZM51.4108 64.7408C51.0508 64.7408 50.7548 64.6368 50.5228 64.4288C50.2988 64.2128 50.1868 63.9488 50.1868 63.6368C50.1868 63.3168 50.2988 63.0528 50.5228 62.8448C50.7548 62.6288 51.0508 62.5208 51.4108 62.5208C51.7628 62.5208 52.0508 62.6288 52.2748 62.8448C52.5068 63.0528 52.6228 63.3168 52.6228 63.6368C52.6228 63.9488 52.5068 64.2128 52.2748 64.4288C52.0508 64.6368 51.7628 64.7408 51.4108 64.7408ZM52.4308 65.4368V72.1328H50.3788V65.4368H52.4308ZM60.2298 68.6768C60.2298 68.8688 60.2178 69.0688 60.1938 69.2768H55.5498C55.5818 69.6928 55.7138 70.0128 55.9458 70.2368C56.1858 70.4528 56.4778 70.5608 56.8218 70.5608C57.3338 70.5608 57.6898 70.3448 57.8898 69.9128H60.0738C59.9618 70.3528 59.7578 70.7488 59.4618 71.1008C59.1738 71.4528 58.8098 71.7288 58.3698 71.9288C57.9298 72.1288 57.4378 72.2288 56.8938 72.2288C56.2378 72.2288 55.6538 72.0888 55.1418 71.8088C54.6298 71.5288 54.2298 71.1288 53.9418 70.6088C53.6538 70.0888 53.5098 69.4808 53.5098 68.7848C53.5098 68.0888 53.6498 67.4808 53.9298 66.9608C54.2178 66.4408 54.6178 66.0408 55.1298 65.7608C55.6418 65.4808 56.2298 65.3408 56.8938 65.3408C57.5418 65.3408 58.1178 65.4768 58.6218 65.7488C59.1258 66.0208 59.5178 66.4088 59.7978 66.9128C60.0858 67.4168 60.2298 68.0048 60.2298 68.6768ZM58.1298 68.1368C58.1298 67.7848 58.0098 67.5048 57.7698 67.2968C57.5298 67.0888 57.2298 66.9848 56.8698 66.9848C56.5258 66.9848 56.2338 67.0848 55.9938 67.2848C55.7618 67.4848 55.6178 67.7688 55.5618 68.1368H58.1298ZM58.2738 63.7208L55.3818 64.9328V63.5168L58.2738 62.1248V63.7208ZM67.6244 68.6768C67.6244 68.8688 67.6124 69.0688 67.5884 69.2768H62.9444C62.9764 69.6928 63.1084 70.0128 63.3404 70.2368C63.5804 70.4528 63.8724 70.5608 64.2164 70.5608C64.7284 70.5608 65.0844 70.3448 65.2844 69.9128H67.4684C67.3564 70.3528 67.1524 70.7488 66.8564 71.1008C66.5684 71.4528 66.2044 71.7288 65.7644 71.9288C65.3244 72.1288 64.8324 72.2288 64.2884 72.2288C63.6324 72.2288 63.0484 72.0888 62.5364 71.8088C62.0244 71.5288 61.6244 71.1288 61.3364 70.6088C61.0484 70.0888 60.9044 69.4808 60.9044 68.7848C60.9044 68.0888 61.0444 67.4808 61.3244 66.9608C61.6124 66.4408 62.0124 66.0408 62.5244 65.7608C63.0364 65.4808 63.6244 65.3408 64.2884 65.3408C64.9364 65.3408 65.5124 65.4768 66.0164 65.7488C66.5204 66.0208 66.9124 66.4088 67.1924 66.9128C67.4804 67.4168 67.6244 68.0048 67.6244 68.6768ZM65.5244 68.1368C65.5244 67.7848 65.4044 67.5048 65.1644 67.2968C64.9244 67.0888 64.6244 66.9848 64.2644 66.9848C63.9204 66.9848 63.6284 67.0848 63.3884 67.2848C63.1564 67.4848 63.0124 67.7688 62.9564 68.1368H65.5244Z" fill="#0E1954"/>
						</svg>
					@endif

					@if($company->values->has('snpcc') && $company->values->get('snpcc') == true)
						<img src="{{ asset('/storage/company_ppc.png') }}" alt="" class="w-[66px] h-[60px]">
					@endif
				</div>
			@endif

			<div class="flex flex-col gap-y-4 mb-4 text-sm p-6">
				@if($company->user->hasRole('professionnal_breeder') && $company->user->lastModeration?->isValidated())
					<div class="flex flex-row">
						<span class="w-[126px]">
							{{ __('Siret') }}
						</span>

						<span class="font-bold">
							{{ $company->user->values->get('siret') }}
						</span>
					</div>
				@endif

				<div class="flex flex-row">
					<span class="w-[126px]">
						{{ __('Status') }}
					</span>

					<span class="font-bold">
						{{ __($company->user->hasRole('professionnal_breeder')? 'Professionnal' : 'Individual') }}
					</span>
				</div>

				@if($company->user->last_logon)
					<div class="flex flex-row">
						<span class="w-[126px]">
							{{ __('Last seen online') }}
						</span>

						<span class="font-bold text-right">
							{{ $company->user->last_logon->diffForHumans() }}
						</span>
					</div>
				@endif

				@if($addressPart)
					<div class="flex flex-row">
						<span class="w-[126px]">
							{{ __('Localisation') }}
						</span>

						<span class="font-bold max-w-[111px]">
							{{ $addressPart }}
						</span>
					</div>
				@endif

				@if($company->species()->where('slug->en', 'cat')->first() && $company->values->has('active_female_cat_breeder'))
					<div class="flex flex-row">
						<span class="w-[126px]">
							{{ __('Number of active female cat breeder') }}
						</span>

						<span class="font-bold max-w-[111px]">
							{{ $company->values->get('active_female_cat_breeder') }}
						</span>
					</div>
				@endif

				@if($company->species()->where('slug->en', 'dog')->first() && $company->values->has('active_female_dog_breeder'))
					<div class="flex flex-row">
						<span class="w-[126px]">
							{{ __('Number of active female dog breeder') }}
						</span>

						<span class="font-bold max-w-[111px]">
							{{ $company->values->get('active_female_dog_breeder') }}
						</span>
					</div>
				@endif
			</div>

			{{-- Contact --}}
			@if($company->offer()->hasOption('contact-button'))
				<div class="flex flex-row justify-center items-center mb-4">
					@include('components.front.responses.contact', [
						'target' => $company,
						'type' => 'company',
						'hasContacted' => $hasContacted,
						'response' => $response
					])
				</div>
			@endif
		</div>
		<div class="w-full flex justify-center my-4">
			<x-front.ad-slot slotName="coeur_de_page" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'adoptant']" />
		</div>
	</div>
</div>

{{-- Leurs chiots à adopter --}}
@if($company->offer()->hasOption('display-posts'))
	@php
		$littersAvailable = $company->littersWithAvailableAnimals;
	@endphp
	@if($littersAvailable->count() > 0)
		<div class="flex flex-col items-center  w-full p-4 bg-breeder-deepblue py-8 overflow-hidden">
			<div class="max-w-[1200px] flex flex-col gap-2 w-full">
				<h2 class="text-[28px] text-breeder-cream"><span class="font-bold">{{ __('Their animals') }}</span>
					{{ __('for adoption') }}
				</h2>

				<div x-data="{
					width: (window.innerWidth > 0) ? window.innerWidth : screen.width,
					numberOfVisibleElements: 5,
					showNextElement:function() {
						let visibleElements = document.getElementsByClassName('visible-recently-published-animal-bottom');
						let firstVisibleElement = visibleElements[0];

						document.getElementById('recently-published-cards-bottom').appendChild(firstVisibleElement);
					},
					showPreviousElement:function() {
						let visibleElements = document.getElementsByClassName('visible-recently-published-animal-bottom');
						let lastVisibleElement = visibleElements[visibleElements.length - 1];

						document.getElementById('recently-published-cards-bottom').prepend(lastVisibleElement);
					}
				}" class="flex flex-row justify-center items-center relative">
				@php
					$countLittersAvailable = $littersAvailable->count();
					$countyAvailableAnimal = 0;

					foreach($littersAvailable as $litterAvailable) {
						foreach ($litterAvailable->getAvailableChildren() as $litterAnimal) {
							$countyAvailableAnimal++;
						}
					}
					$countLittersAvailable = $countLittersAvailable + $countyAvailableAnimal;
				@endphp
					@if($countLittersAvailable > 3)
						{{-- Previous button --}}
						<div x-on:click="showPreviousElement();" class="max-s:hidden mr-10 cursor-pointer absolute z-20 left-0 h-[220px] flex items-center bg-gradient-to-l from-transparent to-breeder-deepblue">
							<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g filter="url(#filter0_d_5245_39654)">
									<path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF"/>
								</g>
								<path d="M56.0454 36.6364L42.1818 50.5L56.0454 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<defs>
									<filter id="filter0_d_5245_39654" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
										<feFlood flood-opacity="0" result="BackgroundImageFix"/>
										<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
										<feOffset/>
										<feGaussianBlur stdDeviation="10"/>
										<feComposite in2="hardAlpha" operator="out"/>
										<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
										<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5245_39654"/>
										<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5245_39654" result="shape"/>
									</filter>
								</defs>
							</svg>
						</div>
					@endif

					<div id="recently-published-cards-bottom" class="s-30 w-full flex flex-row gap-x-4 items-stretch max-w-[1200px] overflow-x-scroll s:overflow-x-hidden scrollbar-none">
						@foreach($littersAvailable as $litterAvailable)
							@foreach($litterAvailable->getAvailableChildren() as $litterAnimal)
								<a href="{{ route('animal-search.animal.show', ['company' => $litterAnimal->company->slug, 'post' => $litterAnimal->litters[0]->post->slug, 'breed' => $breed->slug, 'animal' => $litterAnimal->id, 'type' => ($litterAnimal->species->getTranslation('slug', 'en') == 'cat' ? __('kitten') : __('puppy')), 'sex' => Str::slugify(__($litterAnimal->getSex()))]) }}"  id="{{ $loop->index }}" class="visible-recently-published-animal-bottom">
									<article class="w-[220px] h-[220px] relative">
										<div class="absolute w-[220px] top-0 z-10">
											<div class="flex flex-row gap-2 p-2 items-center">
												<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit grow-0">
													{{ ($litterAnimal->mother ? $litterAnimal->mother->values->get('pure_breed') : $litterAnimal->values->get('pure_breed')) ? $litterAnimal->breed->name : __('Of appearance :breed', ['breed' => $litterAnimal->breed->name]) }}
												</span>

												@if($litterAnimal->mother ? $litterAnimal->mother->values->get('pure_breed') : $litterAnimal->values->get('pure_breed'))
												<span class="px-3 py-1 rounded-md font-medium text-breeder-deepblue text-sm w-fit @if($litterAnimal->species->getTranslation('slug', 'en') == 'cat' && $litterAnimal->company->address?->country?->code == 'FRA') bg-breeder-green @elseif($litterAnimal->species->getTranslation('slug', 'en') == 'dog' && $litterAnimal->company->address?->country?->code == 'FRA') bg-breeder-coral @else bg-breeder-cream @endif">
													@if($litterAnimal->company->address?->country?->code == 'FRA')
														@if($litterAnimal->species->getTranslation('slug', 'en') == 'cat')
															LOOF
														@elseif($litterAnimal->species->getTranslation('slug', 'en') == 'dog')
															LOF
														@endif
													@else
														{{ __('Origin book') }}
													@endif
												</span>
												@endif
											</div>
										</div>

										@if($photo = $litterAnimal->getFirstMedia('photos'.$litterAnimal->id))
											<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $litterAnimal->getConstructedName() }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
											<div class="w-[220px] h-[220px] absolute inset-0 bg-[linear-gradient(0deg,rgba(0,0,0,0)_70.91%,rgba(0,0,0,0.6)_94.77%)]"></div>
										@else
											@php
												if($litterAnimal->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
												elseif($litterAnimal->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
											@endphp
											<img src="{{ $src }}" alt="{{ $litterAnimal->getConstructedName() }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
										@endif
									</article>
								</a>
							@endforeach
						@endforeach
					</div>

					@if($countLittersAvailable > 3)
						<div x-on:click="showNextElement();" class="max-s:hidden ml-10 cursor-pointer absolute z-20 right-0 h-[220px] flex items-center bg-gradient-to-r from-transparent to-breeder-deepblue">
							<svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g filter="url(#filter0_d_2188_51292)">
									<path d="M50.5 81C67.3447 81 81 67.3447 81 50.5C81 33.6553 67.3447 20 50.5 20C33.6553 20 20 33.6553 20 50.5C20 67.3447 33.6553 81 50.5 81Z" fill="#F7F6EF"/>
								</g>
								<path d="M44.9546 36.6364L58.8182 50.5L44.9546 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<defs>
									<filter id="filter0_d_2188_51292" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
										<feFlood flood-opacity="0" result="BackgroundImageFix"/>
										<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
										<feOffset/>
										<feGaussianBlur stdDeviation="10"/>
										<feComposite in2="hardAlpha" operator="out"/>
										<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
										<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2188_51292"/>
										<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2188_51292" result="shape"/>
									</filter>
								</defs>
							</svg>
						</div>
					@endif
				</div>
			</div>
		</div>
	@endif
@endif

{{-- Listes chiots à vendre etc --}}
<div class="w-full bg-breeder-cream text-breeder-deepblue flex justify-center py-8 px-4 max-md:hidden mb-20">
	<livewire:front.multi-column-widget
		:forSpecies="$company->species->first()"
		:key="'breeder-component'" />
</div>

{{-- NL inscription --}}
@include('components.front.nl', ['bgcolor' => 'bg-breeder-coral'])
{{-- CTA Create post --}}
@include('components.front.cta-post')

@include('components.front.footer-partner-sitemap')

@if (session('gtm'))
	<script>
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push(@json(session('gtm')));
	</script>
@endif
