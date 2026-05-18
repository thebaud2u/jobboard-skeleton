<div class="flex flex-col max-sm:gap-4 sm:justify-between border-b border-breeder-greige p-4">
	<div class="flex flex-row justify-between pt-4 px-3">
		<div class="flex flex-row gap-3 text-breeder-deepblue items-center">
			<div class="flex flex-col w-[46px] h-[46px] bg-white rounded-full border border-breeder-cream justify-center items-center">
				@if($response->type->value != 'figo' && $response->type->value != 'eleveurs-online')
					@if($photoLeft)
						<img src="{{ $photoLeft->getAvailableUrl(['optimized']) }}" alt="{{ $name }}" class="object-cover w-[46px] h-[46px] rounded-full" />
					@else
						<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $name }}" class="object-cover w-[46px] h-[46px] rounded-full" />
					@endif
				@else
					@if($response->type->value == 'figo')
						<img src="{{ asset('storage/assuropoil-logo.png') }}" alt="Figo" class="object-cover w-[46px] h-[46px] rounded-full" />
					@elseif($response->type->value == 'eleveurs-online')
						<img src="{{ asset('storage/eleveurs_online.jpg') }}" alt="Eleveurs-Online" class="object-cover w-[46px] h-[46px] rounded-full" />
					@endif
				@endif
			</div>

			<div class="flex flex-col gap-2">
				<div class="flex flex-col">
					<div class="font-bold flex flex-row leading-snug text-[28px]">
						@if($toUser->hasRole('adopter'))
							{{ $toUser->name }}
						@else
							{{ $name }}
						@endif
					</div>

					@if($response->type->value == 'figo')
						<span>
							{{ __('The insurrance recommanded by Éleveurs Online') }}
						</span>
					@elseif($response->type->value == 'eleveurs-online')
						<span>
							{{ __('Leader in SEO and networking between breeders and individuals') }}
						</span>
					@endif
				</div>

				@if($response->type->value == 'application')
					<div class="flex flex-col">
						<div class="flex flex-row text-xs font-medium gap-x-2 items-center">
							@if($type == 'animal' || ($type == 'post' && ($model->type->getTranslation('slug', 'en') == 'retired-breeder' || $model->type->getTranslation('slug', 'en') == 'stud')))
								<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-xs w-fit" alt="{{ $animal->values?->get('pure_breed') ? $animal->breed->name : __('Of appearance :breed', ['breed' => $animal->breed->name]) }}" title="{{ $animal->values?->get('pure_breed') ? $animal->breed->name : __('Of appearance :breed', ['breed' => $animal->breed->name]) }}">
									{{ $animal->values?->get('pure_breed') ?  Str::limit($animal->breed->name, 22) : __('Of appearance :breed', ['breed' => Str::limit($animal->breed->name, 17)]) }}
								</span>

								<div class="border-l border-breeder-greige h-[26px]"></div>

								<span class="font-medium text-breeder-deepblue text-base w-fit">
									{{ $animal->name }}
								</span>

								<div class="border-l border-breeder-greige h-[26px] @if($response->isReceived()) hidden @endif"></div>
							@elseif($type == 'post' && ($model->type->getTranslation('slug', 'en') == 'litter' || $model->type->getTranslation('slug', 'en') == 'litter-yet-to-come'))
								<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit" alt="{{ $model->model->breed->name }}" title="{{ $model->model->breed->name }}">
									{{ Str::limit($model->model->breed->name, 22) }}
								</span>

								<div class="border-l border-breeder-greige h-[26px]"></div>

								<span class="px-3 py-1 rounded-md font-medium text-breeder-deepblue text-sm w-fit">
									{{ ucfirst(__($model->type->name)) }}
								</span>
								
								<div class="border-l border-breeder-greige h-[26px] @if($response->isReceived()) hidden @endif"></div>
							@endif

							<span class="flex flex-row items-center gap-x-2 text-xs font-medium text-breeder-deepblue">
								@if($response->isReceived())
									{{-- <div class="w-3 h-3 bg-breeder-blue rounded-full"></div> {{  __('Inquire ongoing') }} --}}
								@elseif(__($response->state->inHuman()) == 'Non disponible')
									{{ __($response->state->inHuman()) }}
								@else
									<div class="w-3 h-3 bg-black rounded-full"></div> {{ __($response->state->inHuman()) }}
								@endif
							</span>
						</div>
					</div>
				@endif
			</div>
		</div>

		@if($response->type->value != 'figo' && $response->type->value != 'eleveurs-online')
			<div class="flex flex-col text-breeder-deepblue">
				<div class="flex flex-row">
					@if($goToRoute)
						<a href="{{ $goToRoute }}" target="_blank">
					@endif
							<div class="w-[69px] h-[69px] rounded-xl">
								@if($photoRight)
									<img src="{{ $photoRight->getAvailableUrl(['optimized']) }}" alt="{{ $model->name }}" class="object-cover w-[69px] h-[69px] rounded-xl" />
								@else
									<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $model->name }}" class="object-cover w-[69px] h-[69px] rounded-xl" />
								@endif
							</div>
					@if($goToRoute)
						</a>
					@endif
				</div>
			</div>
		@endif
	</div>

	@if($response->type->value == 'application' && ($type == 'animal' || ($type == 'post' && $model->type->getTranslation('slug', 'en') == 'retired-breeder')))
		@include('components.front.space.responses.action-buttons')
	@endif
</div>
