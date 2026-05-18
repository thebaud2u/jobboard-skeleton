@php
	$litter = $post->model;
	$company = $animal->company;
	$hasDisplayBreedersOption = $company->offer()->hasOption('display-breeders');
@endphp

<div class="flex flex-col gap-y-4 w-full bg-breeder-cream p-6 mb-6 rounded-xl">
	<div class="flex flex-row justify-between">
		<h2 class="text-[28px] font-bold">
			{{ __('The litter') }}
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
				@if($photo = $post->getFirstMedia('photos'.$post->id))
					<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="" class="rounded-xl object-cover w-full h-full">
				@else
					@php
						if($litter->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
						elseif($litter->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
					@endphp
					<img src="{{ $src }}" alt="" class="rounded-xl object-cover w-full h-full">
				@endif
			</div>

			@if($photo)
				<div class="flex gap-4 w-full flex-wrap">
					@foreach($post->getMedia('photos'.$post->id) as $index => $media)
						@if(!$loop->first)
							<img src="{{ $media->getAvailableUrl(['optimized']) }}" alt="" class="rounded-xl object-cover w-[76px] h-[76px]">
						@endif
					@endforeach
				</div>
			@endif
		</div>

		<div class="flex flex-col gap-4 w-full flex-1">
			<div class="w-full bg-white min-h-[195px] flex flex-col gap-6 py-6 px-4">
				<div class="flex w-full text-sm">
					@php
						$date = $post->model->values->get('expected_birth_date');

						if(preg_match('/^\d{4}-\d{2}$/', $date)) {
							$date = Carbon::createFromFormat('Y-m', $date);
							$expectedBirthDate = $date->translatedFormat('F Y');
						}
						else $expectedBirthDate = $date;
					@endphp

					<div class="w-[150px] font-medium">
						{{ __('Expected birth date') }}
					</div>

					<div class="font-bold">
						{{ $expectedBirthDate }}
					</div>
				</div>

				<div class="flex w-full text-sm">
					<div class="w-[150px] font-medium">
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

<div class="flex flex-col gap-4 flex-wrap lg:flex-nowrap">
	@if($litter->mother)
		<livewire:front.animals.breeders.breeder
			:animal="$litter->mother"
			:company="$company"
			:update="$litter->mother->trashed() ? false : true"
			:bigCard="true"
			:hideFromDisplayPage="$hasDisplayBreedersOption ? true : false"
			:key="'mother'" />
	@endif

	@if($litter->father)
		<livewire:front.animals.breeders.breeder
		:animal="$litter->father"
		:company="$company"
		:update="$litter->father->trashed() ? false : true"
		:bigCard="true"
		:hideFromDisplayPage="$hasDisplayBreedersOption ? true : false"
		:key="'father'" />
	@endif

	@if($litter->secondFather)
		<livewire:front.animals.breeders.breeder
			:animal="$litter->secondFather"
			:company="$company"
			:update="$litter->secondFather->trashed() ? false : true"
			:bigCard="true"
			:hideFromDisplayPage="$hasDisplayBreedersOption ? true : false"
			:key="'second-father'" />
	@endif
</div>
