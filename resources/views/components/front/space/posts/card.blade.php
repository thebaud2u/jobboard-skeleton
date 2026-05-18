@php
	$postType = $post->type;
	$lastPublication = $post->lastPublication;
	$animal = null;
	$src = null;

	$photo = $post->getFirstMedia('photos'.$post->id);

	if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
		$animal = $post->model->mother;
		
		if($animal && !$photo) $photo = $animal->getFirstMedia('photos'.$animal->id);
	}
	elseif($postType->getTranslation('slug', 'en') == 'retired-breeder' || $postType->getTranslation('slug', 'en') == 'stud') {
		$animal = $post->model;

		if($animal && !$photo) $photo = $animal->getFirstMedia('photos'.$animal->id);
	}

	$animalValues = null;
	$addressInFrance = false;
	$postValues = $post->values;
	$species = $post->model->species;
	$breed = $post->model->breed;

	if($animal) {
		$animalValues = $animal->values;
		$isPureBreed = $animalValues->get('pure_breed');

		if($animal->company->address->country->code == 'FRA') $addressInFrance = true;
	}
	else {
		$isPureBreed = $post->model->values->get('pure_breed');
		$addressInFrance = $post->user->company->address?->country?->code == 'FRA';
	}

	// If there is no photo of the litter
	if(is_null($photo)) {
		$photo = true;

		if($species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
		elseif($species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
	}

	if(is_null($src)) $src = $photo->getAvailableUrl(['optimized']);
@endphp

<article class="w-[250px] min-h-[250px] h-full rounded-xl pb-3 bg-breeder-cream">
	<div class="overflow-hidden sm:flex-none flex justify-end items-stretch w-full max-w-[250px] sm:max-w-[287px] h-[220px] rounded-t-xl bg-[#F8F8F8]">
		@if($photo)
			<img src="{{ $src }}" alt="{{ $post->name }}" class="object-cover w-full rounded-t-xl" />
		@endif

		<div class="absolute w-fit mt-2 pr-2">
			<div class="flex flex-row gap-2 items-center">
				@if($isPureBreed)
					<span class="px-3 py-1 rounded-md text-xs font-medium @if($species->getTranslation('slug', 'en') == 'cat') bg-breeder-green @elseif($species->getTranslation('slug', 'en') == 'dog') bg-breeder-coral @else bg-breeder-cream @endif text-breeder-deepblue w-fit">
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
			</div>
		</div>
	</div>

	<div class="flex flex-col gap-y-2 p-4 bg-breeder-cream rounded-b-xl">
		<div>
			@if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come')
				<div class="font-bold">
					{{ $postType->getTranslation('slug', 'en') == 'litter' ? __('Litter') : __('Upcoming litter') }} <span class="font-bold">{{ $isPureBreed ? $breed->name : __('Of appearance :breed', ['breed' => $breed->name]) }}</span>
				</div>
			@elseif($postType->getTranslation('slug', 'en') == 'retired-breeder' || $postType->getTranslation('slug', 'en') == 'stud')
				<span class="font-bold">
					{{ $animal->name }}
				</span>
			@endif
		</div>

		<div class="flex flex-row gap-x-2 text-breeder-deepblue text-sm font-medium">
			@if($postType->getTranslation('slug', 'en') == 'litter')
				@if($post->model->values->has('birth_date'))
					{{ __('Born on :date', ['date' => Carbon::parse($post->model->values->get('birth_date'))->format('d/m/Y')]) }}
				@endif
			@elseif($postType->getTranslation('slug', 'en') == 'litter-yet-to-come')
				@php
					$value = $post->model->values->get('expected_birth_date');

					if(preg_match('/^\d{4}-\d{2}$/', $value)) {
						try {
							$date = Carbon::createFromFormat('Y-m', $value);
							$formatted = $date->translatedFormat('F Y');
						} catch (\Exception $e) {
							$formatted = $value;
						}
					}
					else $formatted = $value;
				@endphp
				{{ __('Expected for :date', ['date' => $formatted]) }}
			@elseif($postType->getTranslation('slug', 'en') == 'retired-breeder')
				{{ __('Adult :breed', ['breed' => $breed->name]) }}
			@elseif($postType->getTranslation('slug', 'en') == 'stud')
				{{ __('Stud :breed', ['breed' => $breed->name]) }}
			@endif
		</div>

		<div class="flex flex-wrap gap-4">
			@if($postType->getTranslation('slug', 'en') == 'litter')
				@if($post->model->values->get('female_count') > 0)
					<span class="flex flex-row items-center gap-x-2 w-fit px-2 py-1 rounded-md font-medium bg-breeder-violet text-breeder-deepblue text-xs">
						<svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5 9.67006C7.20914 9.67006 9 7.80757 9 5.51008C9 3.21258 7.20914 1.3501 5 1.3501C2.79086 1.3501 1 3.21258 1 5.51008C1 7.80757 2.79086 9.67006 5 9.67006Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M5 9.67007L4.99924 14.3501" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2.5 12.2701L7.5 12.2701" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						{{ $post->model->values->get('female_count') > 1 ? __(':x females', ['x' => $post->model->values->get('female_count')]) : __(':x female', ['x' => $post->model->values->get('female_count')]) }}
					</span>
				@endif

				@if($post->model->values->get('male_count') > 0)
					<span class="flex flex-row items-center gap-x-2 w-fit px-2 py-1 rounded-md font-medium bg-breeder-violet text-breeder-deepblue text-xs">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11 1.3501H15V5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M15 1.3501L11 5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M6.33333 14.3501C9.27885 14.3501 11.6667 11.8994 11.6667 8.8764C11.6667 5.85336 9.27885 3.40271 6.33333 3.40271C3.38781 3.40271 1 5.85336 1 8.8764C1 11.8994 3.38781 14.3501 6.33333 14.3501Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						{{ $post->model->values->get('male_count') > 1 ? __(':x males', ['x' => $post->model->values->get('male_count')]) : __(':x male', ['x' => $post->model->values->get('male_count')]) }}
					</span>
				@endif
			@elseif($postType->getTranslation('slug', 'en') == 'retired-breeder' || $postType->getTranslation('slug', 'en') == 'stud')
				<span class="w-fit px-1 py-1 rounded-md font-medium bg-breeder-violet text-breeder-deepblue text-xs">
					<div class="flex flex-row gap-x-2">
						@if($animalValues->get('sex') == 'male')
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11 1.3501H15V5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M15 1.3501L11 5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M6.33333 14.3501C9.27885 14.3501 11.6667 11.8994 11.6667 8.8764C11.6667 5.85336 9.27885 3.40271 6.33333 3.40271C3.38781 3.40271 1 5.85336 1 8.8764C1 11.8994 3.38781 14.3501 6.33333 14.3501Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

							{{ __('Male') }}
						@elseif($animalValues->get('sex') == 'female')
							<svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5 9.67006C7.20914 9.67006 9 7.80757 9 5.51008C9 3.21258 7.20914 1.3501 5 1.3501C2.79086 1.3501 1 3.21258 1 5.51008C1 7.80757 2.79086 9.67006 5 9.67006Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M5 9.67007L4.99924 14.3501" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M2.5 12.2701L7.5 12.2701" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

							{{ __('Female') }}
						@endif
					</div>
				</span>
			@endif
		</div>

		<div class="text-sm">
			{{ $post->offer()->name }}
		</div>

		<div class="text-sm flex flex-row items-center gap-x-2 font-bold">
			@if($lastPublication->isArchived())
				<div class="w-2 h-2 bg-breeder-deepblue rounded-full"></div> {{ __('Archived') }}
			@elseif($lastPublication->isDraft())
				<div class="w-2 h-2 bg-breeder-violet rounded-full"></div> {{ __('Draft') }}
			@elseif($lastPublication->isDraftWaitingModerationForPublication())
				<div class="w-2 h-2 bg-breeder-orange rounded-full"></div> {{ __('Waiting moderation') }}
			@elseif($lastPublication->isWaitingToBePublished())
				@if($post->awaitingModeration())
					<div class="w-2 h-2 bg-breeder-orange rounded-full"></div> {{ __('Waiting validation') }}
				@elseif($post->lastModeration->isDenied())
					<div class="w-2 h-2 bg-breeder-red rounded-full"></div> {{ ucfirst(__('moderation denied, update your post infos and resubmit')) }}
				@endif
			@elseif($lastPublication->isPublished())
				<div class="w-2 h-2 bg-breeder-green rounded-full"></div> {{ __('Published until :date', ['date' => $post->archived_at->format('d/m/Y')]) }}
			@endif
		</div>
	</div>
</article>
