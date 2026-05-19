<div class="max-md:px-2 w-full max-w-[1200px]">
	<div class="flex justify-center items-center mx-auto max-w-[1200px] bg-white w-full my-8">
		<x-front.ad-slot slotName="banniere_haute" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'adoptant', 'espece' => $species->getTranslation('slug', 'fr')]" />
	</div>

	<div x-data="{}" class="flex flex-row xlsm:justify-between max-xlsm:flex-col max-xlsm:items-center mt-2 max-w-[1200px] w-full text-breeder-deepblue lg:gap-x-4">
		{{-- Content --}}
		<div class="text-sm lg:text-base max-w-[870px] md:w-[870px] w-full">
			<div class="flex flex-col gap-y-8 max-md:px-4 w-full mb-8">
				<div class="overflow-hidden flex flex-row justify-center items-stretch rounded-xl bg-breeder-cream coucou">
					@php
						use App\Models\Media;
					@endphp

					@if($photo === true)
						<div class="relative w-full bg-transparent">
							<div class="absolute right-0 cursor-pointer z-10">
								<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" x-on:click.prevent="$dispatch('open-modal', 'full_screen_img');">
									<g filter="url(#filter0_d_2366_32955)">
									<rect x="10" y="10" width="40" height="40" rx="12" fill="white" shape-rendering="crispEdges"/>
									<path d="M17.5 35.6816V42.4998M17.5 42.4998H24.3182M17.5 42.4998L26.5909 33.4092M35.6818 42.4998H42.5M42.5 42.4998V35.6816M42.5 42.4998L33.4091 33.4092M17.5 24.3182V17.5M17.5 17.5H24.3182M17.5 17.5L26.5909 26.5909M35.6818 17.5H42.5M42.5 17.5V24.3182M42.5 17.5L33.4091 26.5909" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
									</g>
									<defs>
									<filter id="filter0_d_2366_32955" x="0" y="0" width="60" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
									<feFlood flood-opacity="0" result="BackgroundImageFix"/>
									<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
									<feOffset/>
									<feGaussianBlur stdDeviation="5"/>
									<feComposite in2="hardAlpha" operator="out"/>
									<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
									<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2366_32955"/>
									<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2366_32955" result="shape"/>
									</filter>
									</defs>
								</svg>
							</div>

							<img src="{{ $src }}" class="object-cover w-full md:h-[600px]" />
						</div>
					@elseif(!empty(json_decode($medias, true)) && count(json_decode($medias, true)) > 1)
						@include('components.front.carousel-eol')
					@elseif(is_a($photo, Media::class))
						<div class="relative w-full bg-transparent flex justify-center">
							<div class="absolute right-0 cursor-pointer z-10">
								<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" x-on:click.prevent="$dispatch('open-modal', 'full_screen_img');">
									<g filter="url(#filter0_d_2366_32955)">
									<rect x="10" y="10" width="40" height="40" rx="12" fill="white" shape-rendering="crispEdges"/>
									<path d="M17.5 35.6816V42.4998M17.5 42.4998H24.3182M17.5 42.4998L26.5909 33.4092M35.6818 42.4998H42.5M42.5 42.4998V35.6816M42.5 42.4998L33.4091 33.4092M17.5 24.3182V17.5M17.5 17.5H24.3182M17.5 17.5L26.5909 26.5909M35.6818 17.5H42.5M42.5 17.5V24.3182M42.5 17.5L33.4091 26.5909" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
									</g>
									<defs>
									<filter id="filter0_d_2366_32955" x="0" y="0" width="60" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
									<feFlood flood-opacity="0" result="BackgroundImageFix"/>
									<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
									<feOffset/>
									<feGaussianBlur stdDeviation="5"/>
									<feComposite in2="hardAlpha" operator="out"/>
									<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
									<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2366_32955"/>
									<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2366_32955" result="shape"/>
									</filter>
									</defs>
								</svg>
							</div>

							<img src="{{ $src }}" class="h-[300px] md:h-[600px]" />
						</div>
					@else
						@php
							if($species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
							elseif($species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
						@endphp
						<img src="{{ $src }}" class="object-cover w-full md:h-[600px]" />
					@endif
				</div>

				@if($photo === true || is_a($photo, Media::class))
					<x-front.modal name="full_screen_img" :class="'w-full h-[calc(100dvh-50px)]'" focusable>
						<div class="flex overflow-x-hidden w-full rounded-xl">
							<div class="flex flex-col w-full items-center">
								<div class="flex flex-row w-full">
									<div class="absolute top-[68px] inset-0 rounded-xl bg-breeder-cream flex justify-center h-[calc(100dvh-120px)]">
										<img class="inset-0 text-on-surface dark:text-on-surface-dark object-contain @if($photo === true) w-full md:object-cover md:h-full @else sm:h-full @endif bg-transparent" src="{{ $src }}" />
									</div>
								</div>
							</div>
						</div>
					</x-front.modal>
				@endif

				<x-front.modal name="full_screen_carousel" :class="'w-full h-[calc(100dvh-50px)]'" focusable>
					<div class="flex items-center overflow-x-hidden w-full rounded-xl pt-10"  x-data="{
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
							<div class="flex flex-row w-full relative h-[calc(100dvh-120px)]">
								<template x-for="(media, index) in medias">
									<div>
										<template x-if="media.type === 'video'">
											<div x-show="currentSlideIndex == index + 1" class="absolute inset-0 max-w-[870px] aspect-[100/75]" x-transition.opacity.duration.1000ms>
												<iframe class=" absolute w-full inset-0 max-w-[870px] aspect-[100/75]" x-bind:src="media.url + (media.url.includes('?') ? '&' : '?') + 'rel=0'" title="Chiots et chatons, trois mois pour devenir grand" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
											</div>
										</template>
										<template x-if="media.type === 'image'">
											<div x-show="currentSlideIndex == index + 1" class="absolute inset-0 bg-breeder-cream flex justify-center" x-transition.opacity.duration.1000ms>
												<img class="inset-0 text-on-surface dark:text-on-surface-dark object-contain sm:h-full" x-bind:src="media.url" x-bind:alt="media.url" />
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

				{{-- First section : common infos --}}
				<div class="flex flex-col px-4 max-sm:pl-4 pl-0 md:border-t md:border-transparent w-full">
					<div class="flex flex-row justify-between items-center gap-4">
						<div class="flex flex-row gap-x-1">
							<h1 class="font-normal leading-tight mb-0">
								@if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come')
									@if($displayType == 'animal')
										{{ $species->getTranslation('slug', 'en') == 'cat' ? __('Kitten') : __('Puppy') }}
									@elseif($displayType == 'post')
										@if($postType->getTranslation('slug', 'en') == 'litter')
											{{ __('Litter') }}
										@elseif($postType->getTranslation('slug', 'en') == 'litter-yet-to-come')
											{{ __('Litter yet to come') }}
										@endif
									@endif
								@elseif($postType->getTranslation('slug', 'en') === 'retired-breeder')
									{{ __('Adult') }}
								@elseif($postType->getTranslation('slug', 'en') === 'stud')
									{{ __('Stud') }}
								@endif

								<span class="font-bold">
									{{ $animalValues->get('pure_breed') ? $breed->name : __('of appearance :breed', ['breed' => $breed->name]) }}
								</span>
							</h1>
						</div>

						<div class="flex flex-row items-center">
							@php
								if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
									if($displayType == 'animal') $source = $animal;
									elseif($displayType == 'post') $source = $post;
								}
								else $source = $animal;
							@endphp

							<livewire:front.space.favorites.toggle-favorite
								:target="$source"
								:key="'toggle-favorite-component'" />
						</div>
					</div>

					<div class="flex flex-row justify-start items-center gap-x-1 text-breeder-deepblue text-lg mb-8 mt-1">
						{{ __('from the company') }} <span class="font-bold">{{ $company->name }}</span>
					</div>

					{{-- Tags & address --}}
					<div class="flex flex-row justify-start items-center gap-4">
						<div class="flex flex-row gap-2 max-md:flex-wrap items-center">
							@if($animalValues->get('pure_breed'))
								<span class="px-3 py-1 rounded-md font-medium text-breeder-deepblue text-sm w-fit @if($species->getTranslation('slug', 'en') == 'cat' && $addressInFrance) bg-breeder-green @elseif($species->getTranslation('slug', 'en') == 'dog' && $addressInFrance) bg-breeder-coral @else bg-breeder-cream @endif">
									@if($addressInFrance)
										@if($species->getTranslation('slug', 'en') == 'cat')
											LOOF
										@elseif($species->getTranslation('slug', 'en') == 'dog')
											LOF
										@endif
									@else
										{{ __('Origin book') }}
									@endif
								</span>
							@endif

							@if($displayType == 'animal' || ($displayType == 'post' && ($postType->getTranslation('slug', 'en') == 'stud' || $postType->getTranslation('slug', 'en') == 'retired-breeder')))
								<span class="flex flex-row gap-x-1 px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit">
									@if($animalValues->get('sex') == 'male')
										<svg width="16" imageHeight="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M11 1.3501H15V5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M15 1.3501L11 5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6.33333 14.3501C9.27885 14.3501 11.6667 11.8994 11.6667 8.8764C11.6667 5.85336 9.27885 3.40271 6.33333 3.40271C3.38781 3.40271 1 5.85336 1 8.8764C1 11.8994 3.38781 14.3501 6.33333 14.3501Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('Male') }}
									@elseif($animalValues->get('sex') == 'female')
										<svg width="10" imageHeight="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5 9.67006C7.20914 9.67006 9 7.80757 9 5.51008C9 3.21258 7.20914 1.3501 5 1.3501C2.79086 1.3501 1 3.21258 1 5.51008C1 7.80757 2.79086 9.67006 5 9.67006Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M5 9.67007L4.99924 14.3501" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M2.5 12.2701L7.5 12.2701" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('Female') }}
									@endif
								</span>
							@endif

							<span class="flex flex-row gap-x-1 px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit shrink-0">
								{{ __('Post checked') }}
							</span>

							<span class="text-breeder-greige">|</span>

							@if(
								($displayType == 'post' && $post->isPublished() && (
									($postType->getTranslation('slug', 'en') == 'litter' && $post->model->availableChildrenExists()) ||
									($postType->getTranslation('slug', 'en') == 'retired-breeder' && $post->model->lastLife->isAvailable()) ||
									($postType->getTranslation('slug', 'en') == 'stud')
								)) ||
								($displayType == 'animal' && $animal->lastLife->isAvailable())
							)
								<div class="flex flex-row items-center gap-2 font-bold text-sm text-breeder-deepblue">
									<span class="w-[12px] h-[12px] rounded-full bg-breeder-lightgreen"></span> {{ __('Available') }}
								</div>

								<span class="text-breeder-greige">|</span>
							@elseif(
								($displayType == 'post' && $post->isPublished() && $postType->getTranslation('slug', 'en') == 'retired-breeder' && $post->model->lastLife->isAvailable()) ||
								($displayType == 'animal' && $animal->lastLife->isReserved())
							)
								<div class="flex flex-row items-center gap-2 font-bold text-sm text-breeder-deepblue">
									<span class="w-[12px] h-[12px] rounded-full bg-breeder-coral"></span> {{ __('Reserved') }}
								</div>

								<span class="text-breeder-greige">|</span>
							@endif

							<div class="flex flex-row gap-2 items-center">
								<svg class="w-[16px] h-[18px] shrink-0" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M15 7.45455C15 12.1527 8 17.5 8 17.5C8 17.5 1 12.1527 1 7.45455C1 2.75636 4.13444 0.5 8 0.5C11.8656 0.5 15 2.75636 15 7.45455Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M7.99978 9.77362C9.718 9.77362 11.1109 8.38977 11.1109 6.68271C11.1109 4.97564 9.718 3.5918 7.99978 3.5918C6.28156 3.5918 4.88867 4.97564 4.88867 6.68271C4.88867 8.38977 6.28156 9.77362 7.99978 9.77362Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

								<span class="font-bold text-breeder-deepblue">
									{{ $company->displayPartOfAddress('department+country') }}
								</span>
							</div>
						</div>
					</div>

					@if($description)
						<div class="flex flex-row mt-4">
							<div class="whitespace-normal hyphens-auto w-full">
								{!! nl2br($description) !!}
							</div>
						</div>
					@endif
				</div>

				{{--
					Second section :
						- for animal : buttons
						- for post :
							- for litter : litter composition
							- for others : buttons
				--}}

				@if($displayType == 'animal')
					<div class="flex flex-row justify-start items-center gap-4 max-sm:flex-wrap">
						@if($animal->lastLife->isAvailable())
							@include('components.front.responses.application')
						@endif

						<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}">
							<x-front.secondary-button>
								{{ __('Show the company') }}
							</x-front.secondary-button>
						</a>

						@if($postType->getTranslation('slug', 'en') == 'litter')
							<a href="{{ route('post-search.post.show', ['company' => $post->model->company->slug, 'post' => $post->slug, 'breed' => $breed->slug]) }}">
								<x-front.secondary-button>
									{{ __('Show the litter') }}
								</x-front.secondary-button>
							</a>
						@endif
					</div>
				@elseif($displayType == 'post')
					@if(($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come') && $post->model->values->get('description'))
						<div class="flex flex-row hyphens-auto">
							<div class="whitespace-normal w-full">
								{!! nl2br($post->model->values->get('description')) !!}
							</div>
						</div>
					@endif

					@if($postType->getTranslation('slug', 'en') == 'litter')
						<div class="flex flex-row items-center gap-6 flex-wrap">
							@if($post->model->values->get('male_count') > 0)
								<div class="flex flex-col justify-center items-center w-full max-w-[420px] h-[210px] gap-y-1 p-8 bg-breeder-cream text-breeder-deepblue rounded-xl">
									<svg width="25" height="22" viewBox="0 0 25 22" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M16.9863 1H23.3021V7.31579" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M23.3021 1L16.9863 7.31579" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.61832 21.0001C14.2691 21.0001 18.0394 17.2298 18.0394 12.579C18.0394 7.92819 14.2691 4.15796 9.61832 4.15796C4.9675 4.15796 1.19727 7.92819 1.19727 12.579C1.19727 17.2298 4.9675 21.0001 9.61832 21.0001Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<span class="font-bold">
										{{ $post->model->values->get('male_count') > 1 ? __(':x males', ['x' => $post->model->values->get('male_count')]) : __(':x male', ['x' => $post->model->values->get('male_count')]) }}
									</span>

									@if($post->model->animals->count() > 0)
										<div class="flex flex-row justify-center items-center gap-4 p-2">
											<div class="flex flex-row items-center gap-2">
												<span class="w-[12px] h-[12px] rounded-full @if($post->model->countAvailableChildren('male') > 0) bg-breeder-lightgreen @else bg-red-400 @endif"></span> {{ __(':x available', ['x' => $post->model->countAvailableChildren('male')]) }}
											</div>
											|
											<div class="flex flex-row items-center gap-2">
												<span class="w-[12px] h-[12px] rounded-full bg-breeder-darkorange"></span> {{ __(':x reserved', ['x' => $post->model->countReservedChildren('male')]) }}
											</div>
										</div>
									@else
										<div class="flex flex-row justify-center items-center gap-4 p-2">
											<div class="flex flex-row items-center gap-2">
												<span class="w-[12px] h-[12px] rounded-full bg-breeder-lightgreen"></span> {{ __(':x available', ['x' => $post->model->values->get('male_available')]) }}
											</div>
										</div>
									@endif
								</div>
							@endif

							@if($post->model->values->get('female_count') > 0)
								<div class="flex flex-col justify-center items-center w-full max-w-[420px] h-[210px] gap-y-1 p-8 bg-breeder-cream text-breeder-deepblue rounded-xl">
									<svg width="15" height="22" viewBox="0 0 15 22" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.75 13.7999C11.3399 13.7999 14.25 10.9346 14.25 7.39997C14.25 3.86536 11.3399 1 7.75 1C4.16015 1 1.25 3.86536 1.25 7.39997C1.25 10.9346 4.16015 13.7999 7.75 13.7999Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M7.75 13.8L7.74876 21.0001" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M3.6875 17.7998L11.8125 17.7998" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<span class="font-bold">
										{{ $post->model->values->get('female_count') > 1 ? __(':x females', ['x' => $post->model->values->get('female_count')]) : __(':x female', ['x' => $post->model->values->get('female_count')]) }}
									</span>

									@if($post->model->animals->count() > 0)
										<div class="flex flex-row justify-center items-center gap-4 p-2">
											<div class="flex flex-row items-center gap-2">
												<span class="w-[12px] h-[12px] rounded-full @if($post->model->countAvailableChildren('female') > 0) bg-breeder-lightgreen @else bg-red-400 @endif"></span> {{ __(':x available', ['x' => $post->model->countAvailableChildren('female')]) }}
											</div>
											|
											<div class="flex flex-row items-center gap-2">
												<span class="w-[12px] h-[12px] rounded-full bg-breeder-darkorange"></span> {{ __(':x reserved', ['x' => $post->model->countReservedChildren('female')]) }}
											</div>
										</div>
									@else
										<div class="flex flex-row justify-center items-center gap-4 p-2">
											<div class="flex flex-row items-center gap-2">
												<span class="w-[12px] h-[12px] rounded-full bg-breeder-lightgreen"></span> {{ __(':x available', ['x' => $post->model->values->get('female_available')]) }}
											</div>
										</div>
									@endif
								</div>
							@endif
						</div>
					@elseif($postType->getTranslation('slug', 'en') == 'stud' || $postType->getTranslation('slug', 'en') == 'retired-breeder')
						@if($post->isPublished() &&
							($postType->getTranslation('slug', 'en') == 'retired-breeder' && $post->model->lastLife->isAvailable()) ||
							($postType->getTranslation('slug', 'en') == 'stud')
						)
							<div class="flex flex-row justify-start items-center gap-4 max-sm:flex-wrap">
								@include('components.front.responses.application')

								<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}">
									<x-front.secondary-button>
										{{ __('Show the company') }}
									</x-front.secondary-button>
								</a>
							</div>
						@endif
					@endif
				@endif

				{{--
					Third section :
						- parents only for litter and litter-yet-to-come
						- other litter animals for litter post only
				--}}
				@if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come')
					@if($postType->getTranslation('slug', 'en') == 'litter')
						<div class="flex flex-col gap-2">
							@php
								$litter = $post->model;
								$litterSize = $litter->animals()->count();
							@endphp

							@if($litterSize > 0)
								<div class="flex flex-row gap-1">
									<h2 class="font-normal text-[24px] md:text-[28px]">
										<b>
											@if($displayType == 'animal')
												{{ __('Other :child', ['child' => $species->getTranslation('slug', 'en') == 'cat' ? __('kittens') : __('puppies')]) }}
											@elseif($displayType == 'post')
												{{ $species->getTranslation('slug', 'en') == 'cat' ? __('The kittens') : __('The puppies') }}
											@endif
										</b>

										{{ __('of the litter') }}
									</h2>
								</div>

								<div class="flex flex-row gap-4 flex-wrap">
									@foreach($litter->getAvailableOrReservedChildren() as $litterAnimal)
										@if($displayType == 'post' || ($displayType == 'animal' && $litterAnimal->id != $animal->id))
											<livewire:front.animals.litter-animals.litter-animal
												:animal="$litterAnimal"
												:litter="$litter"
												:post="$post"
												:postDisplay="true"
												:withDetails="true"
												:key="'litter-animal-'.$litterAnimal->id" />
										@endif
									@endforeach
								</div>
							@endif
						</div>
					@endif

					@if($post->model->mother || $post->model->father || $post->model->secondFather)
						<div class="flex flex-col gap-4">
							<div class="flex flex-row">
								<h2 class="text-breeder-deepblue text-[24px] md:text-[28px] font-bold">
									{{ __('Parents') }}
								</h2>
							</div>

							<div class="flex s:flex-row flex-wrap gap-2 flex-col">
								@if($post->model->mother)
									<livewire:front.animals.breeders.breeder
										:animal="$post->model->mother"
										:company="$company"
										:post="$post"
										:key="'mother'" />
								@endif

								@if($post->model->father && (!$post->model->values->has('hide_first_male') || $post->model->values->get('hide_first_male') == 'no'))
									<livewire:front.animals.breeders.breeder
										:animal="$post->model->father"
										:company="$company"
										:post="$post"
										:key="'father'" />
								@endif

								@if($post->model->secondFather && (!$post->model->values->has('hide_second_male') || $post->model->values->get('hide_second_male') == 'no'))
									<livewire:front.animals.breeders.breeder
										:animal="$post->model->secondFather"
										:company="$company"
										:post="$post"
										:key="'second-father'" />
								@endif
							</div>
						</div>
					@endif
				@endif

				{{-- Forth section : caracteritics of the breed --}}
				@if(data_get($breed->values, 'caracteristics'))
					<div class="flex flex-col gap-2">
						<h2 class="font-bold text-lg">
							{{ __('Caracteristics of the :breed breed', ['breed' => $breed->name]) }}
						</h2>

						@include('components.front.breeds.caracteristics')

						@if(data_get($breed->values, 'informations.introduction'))
							<div class="flex flex-row mt-4">
								{!! nl2br(data_get($breed->values, 'informations.introduction')) !!}
							</div>
						@endif

						<a href="{{ route('breed-search.'.$species->getTranslation('slug', 'en').'-breeds.show', ['breed' => $breed->slug]) }}" class="mt-4">
							<x-front.secondary-button>
								{{ __('Show the breed sheet') }}
							</x-front.secondary-button>
						</a>
					</div>
				@endif

				{{-- Fifth section : company presentation card --}}
				<div class="flex flex-col gap-2">
					@include('components.front.companies.presentation-card', [
						'company' => $company,
						'addressInFrance' => $addressInFrance
					])
				</div>

				{{-- Sixth section : other litters available, only for litter post and for animal display --}}
				@if(($displayType == 'post' && ($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come')) || $displayType == 'animal')
					@php
						$littersAvailable = $company->littersAvailable()
							->whereHas('post', function($whereHas) use($post) {
								$whereHas->whereNot('id', $post->id);
							})
							->get();
					@endphp
					@if($littersAvailable->count() > 1)
						<div class="flex flex-col gap-2 mt-4">
							<h2 class="text-[28px] font-bold mt-6 mb-4 leading-none">
								<strong>
									@if($littersAvailable->count() == 1)
										{{ __('Other litter') }}
									@else
										{{ __('Other litters') }}
									@endif
								</strong> {{ __('of the company') }}
							</h2>

							@php
								$countAnimals = count($littersAvailable);
							@endphp

							@if($countAnimals > 3)
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
								}" class="flex flex-row justify-center items-center relative">

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

									<div id="recently-published-cards" class="s-30 w-full flex flex-row gap-x-4 items-stretch max-w-[1200px] overflow-x-scroll s:overflow-x-hidden scrollbar-none">
										@foreach($littersAvailable as $litterAvailable)
											<a href="{{ route('post-search.post.show', ['company' => $litterAvailable->post->model->company->slug, 'post' => $litterAvailable->post->slug, 'breed' => $breed->slug]) }}"  id="{{ $loop->index }}" class="visible-recently-published-animal">
												<article class="w-[220px] h-[220px] relative">
													<div class="absolute w-[220px] top-0 z-10">
														<div class="flex flex-row gap-2 p-2 items-center">
															<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-full grow-0">
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
														@php
															if($litterAvailable->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
															elseif($litterAvailable->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
														@endphp
														<img src="{{ $src }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
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
								</div>
							@else
								<div class="flex">
									<div class="flex items-stretch gap-2 flex-wrap">
										@foreach($littersAvailable as $litterAvailable)
											<a href="{{ route('post-search.post.show', ['company' => $litterAvailable->post->model->company->slug, 'post' => $litterAvailable->post->slug, 'breed' => $breed->slug]) }}"  id="{{ $loop->index }}" class="visible-recently-published-animal">
												<article class="w-[220px] h-[220px] relative">
													<div class="absolute w-[220px] top-0 z-10">
														<div class="flex flex-row gap-2 p-2 items-center">
															<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-full grow-0">
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
								</div>
							@endif
						</div>
					@endif
				@endif

				{{-- Seventh section : sensitive warning --}}
				@include('components.front.warning-sensitive-animal')

				@if($showWarningSensitiveAnimalModal)
					@include('components.front.warning-sensitive-animal-modal')
				@endif
			</div>
		</div>

		{{-- Column right --}}
		<div class="max-xlsm:mb-10 w-full max-xlsm:px-4 max-sm:mx-2 xlsm:w-[300px]">
			<div class="border border-breeder-greige rounded-xl text-breeder-deepblue w-full pb-6">
				@include('components.front.posts.details-column', [
					'type' => $displayType,
					'postType' => $postType->getTranslation('slug', 'en'),
					'animal' => $animal,
					'post' => $post,
					'addressInFrance' => $addressInFrance
				])

				@if(
					($displayType == 'post' && $post->isPublished() &&  (
						($postType->getTranslation('slug', 'en') == 'litter-yet-to-come') ||
						(($postType->getTranslation('slug', 'en') == 'litter') && ((!$post->values->has('identifiant') && $post->model->availableChildrenExists()) || ($post->values->has('identifiant')))) ||
						($postType->getTranslation('slug', 'en') == 'retired-breeder' && ($post->model->lastLife->isAvailable() || $post->model->lastLife->isReserved())) ||
						($postType->getTranslation('slug', 'en') == 'stud')
					)) ||
					($displayType == 'animal' && ($animal->lastLife->isAvailable() || $animal->lastLife->isReserved()))
				)
					<div class="px-6 flex flex-col w-full gap-4">
						@include('components.front.responses.application', [
							'post' => $post,
							'hasApplyied' => $hasApplyied,
							'response' => $response
						])

						@if($company->user->phone)
							@include('components.front.responses.call', [
								'post' => $post
							])
						@endif
					</div>
				@endif
			</div>

			<div class="w-full flex justify-center my-4">
				<x-front.ad-slot slotName="coeur_de_page" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'adoptant']" />
			</div>
		</div>

		@if(
			($displayType == 'post' && $post->isPublished() && (
				($postType->getTranslation('slug', 'en') == 'litter-yet-to-come') ||
				(($postType->getTranslation('slug', 'en') == 'litter') && ( (!$post->values->has('identifiant') && $post->model->availableChildrenExists()) || ($post->values->has('identifiant')))) ||
				($postType->getTranslation('slug', 'en') == 'retired-breeder' && ($post->model->lastLife->isAvailable() || $post->model->lastLife->isReserved())) ||
				($postType->getTranslation('slug', 'en') == 'stud')
			)) ||
			($displayType == 'animal' && ($animal->lastLife->isAvailable() || $animal->lastLife->isReserved()))
		)
			<livewire:front.application-modals
				:element="$displayType == 'animal' ? $animal : $post"
				:hasApplyied="$hasApplyied"
				:key="'application-modals-component'" />
		@endif
	</div>
</div>
