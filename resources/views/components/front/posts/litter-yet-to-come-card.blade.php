@php
	if(!isset($postType)) $postType = $post->type;

	if(!isset($isIndex)) $isIndex = false;

	$model = $post->model;
	$species = $model->species;
	$breed = $model->breed;
	$company = $model->company;
	$addressInFrance = $company->address?->country?->code == 'FRA';
	$class = '';
	$isPremium = false;
	$isMaster = false;
	$user = Auth::guard('web')->check() ? Auth::guard('web')->user() : null;

	if($model->mother) $isPureBreed = $model->mother->values->get('pure_breed');
	elseif($model->values->get('pure_breed')) $isPureBreed = $model->values->get('pure_breed');
	else $isPureBreed = false;

	if($isIndex) {
		$postOffer = $post->offer();

		if($postOffer->slug == 'annonce-premium') {
			$class = 'bg-jobboard-cream text-jobboard-deepblue';
			$isPremium = true;
		}
		elseif($postOffer->slug == 'annonce-master') {
			$class = 'bg-jobboard-deepblue text-white';
			$isMaster = true;
		}
	}
	
	$photo = $post->getFirstMedia('photos'.$post->id);

	$uniqueId = uniqid();
	// dd(get_defined_vars());
@endphp

<a href="{{ route('post-search.post.show', ['company' => $post->model->company->slug, 'post' => $post->slug, 'breed' => $breed->slug]) }}" class="h-full @if($isIndex && isset($postType) && $postType->exists != true)  w-full max-sm:max-w-[360px] sm:w-[287px] @elseif($postType->exists) w-full max-sm:max-w-[360px] sm:w-[275px] @endif block">
	<article class="cursor-pointer @if($isMaster) bg-jobboard-deepblue @else bg-jobboard-cream @endif text-jobboard-deepblue rounded-xl h-full flex flex-col flex-1 group" x-data 
    @mouseenter="
        let gif = $el.querySelector('.js-gif-stars'); 
        if(gif) {
            // On préserve le 'uid' et on met à jour le 't'
            let baseUrl = gif.src.split('&t=')[0];
            gif.src = baseUrl + '&t=' + Date.now();
        }
    ">
		@if($isPureBreed || $isPremium || $isMaster)
			<div class="relative w-full">
				@if($isPureBreed)
					<div class="absolute w-full top-0 right-0 bg-gradient-to-t from-transparent to-black/40 to-95% rounded-t-xl z-10">
						<div class="flex flex-row gap-2 @if($user?->hasFavorited($post)) justify-between @else justify-end @endif items-center flex-wrap p-4">
							@if($user?->hasFavorited($post))
								<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path opacity="0.4" d="M14 0C21.732 1.28851e-05 28 6.26802 28 14C28 21.732 21.732 28 14 28C6.26802 28 0 21.732 0 14C5.15405e-07 6.26801 6.26802 0 14 0ZM20.7754 8.31641C19.1528 6.56173 16.5269 6.56173 14.9043 8.31641L13.9961 9.29785L13.0879 8.31641C11.4653 6.56173 8.83941 6.56173 7.2168 8.31641C5.59446 10.0711 5.59428 12.9105 7.2168 14.665L14 22L20.7832 14.665C22.4057 12.9105 22.4055 10.0711 20.7832 8.31641H20.7754Z" fill="white"/>
								</svg>
							@endif
							<div class="flex flex-row gap-2 items-center">
								@if($addressInFrance)
									@if($species->getTranslation('slug', 'en') == 'cat')
										<span class="px-3 py-1 rounded-md font-medium bg-jobboard-green text-jobboard-deepblue text-sm w-fit">
											LOOF
										</span>
									@elseif($species->getTranslation('slug', 'en') == 'dog')
										<span class="px-3 py-1 rounded-md font-medium bg-jobboard-coral text-jobboard-deepblue text-sm w-fit">
											LOF
										</span>
									@endif
								@else
									<span class="px-3 py-1 rounded-md font-medium bg-jobboard-coral text-jobboard-deepblue text-sm w-fit">
										{{ __('Origin book') }}
									</span>
								@endif
							</div>
						</div>
					</div>
				@endif
			</div>
		@endif

		<div class="overflow-hidden sm:flex-none flex justify-end items-stretch w-full rounded-t-xl bg-[#F8F8F8] h-[220px] relative shrink-0">
			@if($photo)
				<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="object-cover w-full rounded-t-xl transition-all group-hover:scale-105" />
			@else
				@php
					if($model->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
					elseif($model->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
				@endphp
				<img src="{{ $src }}" class="object-cover w-full rounded-t-xl transition-all group-hover:scale-105" />
			@endif

			@if($isPremium || $isMaster)
				<div class="absolute w-full bottom-0 bg-gradient-to-t rounded-t-xl drop-shadow-[0_0_4px_rgba(0,0,0,0.25)]">
					<div class="flex flex-row gap-2 flex-wrap p-4">
						@if($isPremium)
							<span class="px-3 py-1 rounded-md font-medium bg-jobboard-cream text-jobboard-deepblue text-sm w-fit relative flex">
								<div class="relative w-[14px]">
									<svg class="absolute -top-[8px] -left-[17px]" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11 8.0001L7.11038 14.7873L3.05176e-05 18.5001L7.11038 22.213L11 29.0002L14.8885 22.213L22 18.5001L14.8885 14.7873L11 8.0001Z" fill="#FFA244"/>
										<path d="M22.4997 22.504L21.2622 24.7667L19 26.0041L21.2622 27.2414L22.4997 29.5041L23.7372 27.2414L26 26.0041L23.7372 24.7667L22.4997 22.504Z" fill="#FFA244"/>
										<path d="M23.0006 0.00012207L20.5248 4.52569L16 7.00014L20.5248 9.47576L23.0006 14.0002L25.4752 9.47576L30 7.00014L25.4752 4.52569L23.0006 0.00012207Z" fill="#FFA244"/>
									</svg>
								</div>

								{{ __('Top post') }}
							</span>
						@elseif($isMaster)
							<span class="px-3 py-1 rounded-md font-medium bg-jobboard-cream text-jobboard-deepblue text-sm w-fit relative flex">
								<div class="relative w-[14px] overflow-visible">
									<img class="js-gif-stars absolute -top-[30px] -left-[38px] w-[76px] h-[76px] shrink-0 max-w-none" src="{{ asset('storage/etoiles.webp') }}?uid={{ $uniqueId }}&t={{ time() }}" alt="" />
								</div>

								{{ __('Do not miss') }}
							</span>
						@endif
					</div>
				</div>
			@endif
		</div>

		<div class="flex flex-col p-4 {{ $class }} rounded-b-xl h-full">
			<div class="font-bold text-sm">
				{{ __('Litter yet to come') }}

				{{ $isPureBreed ? $breed->name : __('of appearance :breed', ['breed' => $breed->name]) }}
			</div>

			<div>
				{{ __('Company :company', ['company' => $company->name]) }} {{ $company->displayPartOfAddress('department_code') }}
			</div>
		</div>
	</article>
</a>
