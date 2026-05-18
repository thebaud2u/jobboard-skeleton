@php
	$company = $animal->company;
	$hasDisplayBreedersOption = $company->offer()->hasOption('display-breeders');
	$protrusionTypes = \App\Enums\ProtrusionTypes::asHumanArray();

	if(data_get($postValues, 'for_moderation.quotation')) $quotation = data_get($postValues, 'for_moderation.quotation');
	else $quotation = $postValues->get('quotation');

	if(data_get($postValues, 'for_moderation.price')) $price = data_get($postValues, 'for_moderation.price');
	else $price = $postValues->get('price');

	if(data_get($postValues, 'for_moderation.protrusion_types')) $protrusionType = data_get($postValues, 'for_moderation.protrusion_types');
	else $protrusionType = $postValues->get('protrusion_types');

	if(data_get($postValues, 'for_moderation.average_litter_size')) $averageLitterSize = data_get($postValues, 'for_moderation.average_litter_size');
	else $averageLitterSize = $postValues->get('average_litter_size');

	if(data_get($postValues, 'for_moderation.enhancer')) $enhancer = data_get($postValues, 'for_moderation.enhancer');
	else $enhancer = $postValues->get('enhancer');

	if(data_get($postValues, 'for_moderation.gene_color')) $geneColor = data_get($postValues, 'for_moderation.gene_color');
	else $geneColor = $postValues->get('gene_color');

	if(data_get($postValues, 'for_moderation.description')) $description = data_get($postValues, 'for_moderation.description');
	else $description = $postValues->get('description');

	if($animal->values) $animal->values = $animal->values;

	if($animal->species->getTranslation('slug', 'en') == 'cat') {
		$tests = \App\Enums\CatTests::asHumanArray();
		$vaccines = \App\Enums\CatVaccines::asHumanArray();
	}
	elseif($animal->species->getTranslation('slug', 'en') == 'dog') {
		$tests = \App\Enums\DogTests::asHumanArray();
		$vaccines = \App\Enums\DogVaccines::asHumanArray();
	}

	$photo = $post->getFirstMedia('photos'.$post->id);

	if(!$photo) $photo = $post->model->getFirstMedia('photos'.$post->model->id);
@endphp

<div class="flex flex-col gap-y-4 w-full bg-white border border-breeder-greige p-6 mb-6 rounded-xl">
	<div class="flex flex-row justify-between">
		<h2 class="flex gap-x-2 text-[24px] md:text-[28px]">
			<strong>
				@if($animal->species->getTranslation('slug', 'en') === 'cat')
					{{ $animal->values->get('sex') == "male" ? __('Male cat') : __('Female cat')}}
				@elseif($animal->species->getTranslation('slug', 'en') === 'dog')
					{{ $animal->values->get('sex') == "male" ? __('Male dog') : __('Female dog')}}
				@endif
			</strong>

			{{ $animal->name }}
		</h2>

		<a href="{{ route('space.posts.update', ['post' => $post->slug]) }}" class="flex flex-row justify-center items-center gap-x-2 px-2 font-bold text-sm hover:underline hover:underline-offset-4">
			<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M7.7093 2.5814H2.49096C2.09553 2.5814 1.7163 2.73848 1.43669 3.01809C1.15708 3.2977 1 3.67693 1 4.07235V14.509C1 14.9045 1.15708 15.2837 1.43669 15.5633C1.7163 15.8429 2.09553 16 2.49096 16H12.9276C13.3231 16 13.7023 15.8429 13.9819 15.5633C14.2615 15.2837 14.4186 14.9045 14.4186 14.509V9.2907M13.3004 1.46318C13.597 1.16661 13.9992 1 14.4186 1C14.838 1 15.2402 1.16661 15.5368 1.46318C15.8334 1.75975 16 2.16198 16 2.5814C16 3.00081 15.8334 3.40304 15.5368 3.69961L8.45478 10.7817L5.47287 11.5271L6.21835 8.54522L13.3004 1.46318Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>

			{{ __('Update') }}
		</a>
	</div>

	<hr>

	<div class="flex flex-col lg:flex-row gap-4 w-full">
		<div class="flex flex-col gap-4 w-full lg:w-[368px]">
			<div class="w-full h-[278px] rounded-xl">
				@if($photo)
					<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="" class="rounded-xl object-cover w-full h-full">
				@else
					@php
						if($animal->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
						elseif($animal->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
					@endphp
					<img src="{{ $src }}" alt="" class="rounded-xl object-cover w-full h-full">
				@endif
			</div>

			@if($post->getFirstMedia('photos'.$post->id))
				<div class="flex flex-wrap gap-4 w-full flex-wrap">
					@foreach($post->getMedia('photos'.$post->id) as $index => $media)
						@if(!$loop->first)
							<img src="{{ $media->getAvailableUrl(['optimized']) }}" alt="" class="rounded-xl object-cover w-[76px] h-[76px]">
						@endif
					@endforeach
				</div>
			@endif
		</div>

		<div class="flex flex-col gap-4 w-full flex-1">
			@if($description)
				<div class="w-full flex text-base font-medium">
					{{ $description }}
				</div>
			@endif

			<div class="w-full bg-white min-h-[195px] flex flex-col gap-6 py-6 px-4">
				@if($animal->values->has('birth_date'))
					<div class="flex w-full text-sm">
						<div class="w-[160px] font-medium">
							{{ __('Birth date') }}
						</div>

						<div class="font-bold">
							{{ Carbon::parse($animal->values->get('birth_date'))->format('d/m/Y') }}
						</div>
					</div>
				@endif

				@if($animal->values->has('color'))
					<div class="flex w-full text-sm">
						<div class="w-[160px] font-medium">
							{{ __('Dress') }}
						</div>

						<div class="font-bold">
							{{ $animal->values->get('color') }}
						</div>
					</div>
				@endif

				<div class="flex w-full text-sm">
					<div class="w-[160px] font-medium">
						{{ __('Quotation') }}
					</div>

					<div class="font-bold">
						{{ $quotation }}
					</div>
				</div>

				<div class="flex w-full text-sm">
					<div class="w-[160px] font-medium">
						{{ __('Price of the mating €') }}
					</div>

					<div class="font-bold">
						{{ $price ? $price : 'No' }}
					</div>
				</div>

				<div class="flex w-full text-sm">
					<div class="w-[160px] font-medium">
						{{ __('Protrusion type') }}
					</div>

					<div class="font-bold hyphens-auto">
						@foreach($protrusionTypes as $index => $value)
							{{ __($value) }}<br>
						@endforeach
					</div>
				</div>

				<div class="flex w-full text-sm">
					<div class="w-[160px] font-medium hyphens-auto">
						{{ __('Average litter size') }}
					</div>

					<div class="font-bold">
						{{ $averageLitterSize }}
					</div>
				</div>

				<div class="flex w-full text-sm">
					<div class="w-[160px] shrink-0 font-medium">
						{{ __('Enhancer/ Company characteristics') }}
					</div>

					<div class="font-bold">
						{{ $enhancer }}
					</div>
				</div>

				<div class="flex w-full text-sm">
					<div class="w-[160px] font-medium">
						{{ __('Color gene') }}
					</div>

					<div class="font-bold">
						{{ $geneColor }}
					</div>
				</div>

				@if($animal->values->has('tests') && $animal->values->get('tests'))
					<div class="flex w-full text-sm">
						<div class="w-[160px] shrink-0 font-medium">
							{{ __('Tests') }}
						</div>

						<strong class="max-s:hyphens-auto">
							<strong>
								{{ collect($animal->values->get('tests'))->map(fn($v) => $tests[$v] ?? $v)->implode(' + ') }}
							</strong>
						</strong>
					</div>
				@endif

				@if($animal->values->has('vaccines') && $animal->values->get('vaccines'))
					<div class="flex w-full text-sm">
						<div class="w-[160px] shrink-0 font-medium">
							{{ __('Vaccines') }}
						</div>

						<strong>
							<strong>
								{{ collect($animal->values->get('vaccines'))->map(fn($v) => $vaccines[$v] ?? $v)->implode(' + ') }}
							</strong>
						</strong>
					</div>
				@endif

				<div class="flex w-full text-sm">
					<div class="w-[160px] font-medium">
						@if($address->country->code == 'FRA')
							@if($species->getTranslation('slug', 'en') === 'cat')
								LOOF
							@elseif($species->getTranslation('slug', 'en') === 'dog')
								LOF
							@endif
						@else
							{{ __('Origin book') }}
						@endif
					</div>

					<div class="font-bold">
						{{ $isPureBreed ? __('Yes') : __('No') }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
