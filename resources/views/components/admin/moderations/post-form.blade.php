<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Account moderation status') }}
		</x-front.space-title>

		<div class="flex justify-end gap-x-2">
			<a href="{{ route('admin.log-as-user', ['user' => $moderation->model->user->slug]) }}" class="text-white inline-block">
				<button type="button" title="{{ __('Log as the user') }}" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
					</svg>
				</button>
			</a>
		</div>
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="offer" :value="__('User profil moderation')" />
			</div>

			@if($moderation->model->user->lastModeration)
				@if($moderation->model->user->lastModeration->isValidated())
					<div class="text-breeder-green">
						{{ __('Validated') }}
					</div>
				@elseif($moderation->model->user->lastModeration->isDenied())
					<div class="text-breeder-coralhover">
						{{ __('Denied') }}
					</div>
				@elseif($moderation->model->user->lastModeration->isWaiting())
					<div class="text-breeder-yellow">
						{{ __('Waiting') }}
					</div>
				@endif
			@else
				<div class="text-breeder-coralhover">
					{{ __('User\'s profil is not marked for moderation') }}
				</div>
			@endif
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="offer" :value="__('Company status')" />
			</div>

			@if($moderation->model->user->company)
				<div class="flex flex-col">
					<div class="flex flex-row">
						{{ __('Company moderation') }} :
					</div>

					@if($moderation->model->user->company->lastModeration)
						@if($moderation->model->user->company->lastModeration->isValidated())
							<div class="text-breeder-green">
								{{ __('Validated') }}
							</div>
						@elseif($moderation->model->user->company->lastModeration->isDenied())
							<div class="text-breeder-coralhover">
								{{ __('Denied') }}
							</div>
						@elseif($moderation->model->user->company->lastModeration->isWaiting())
							<div class="text-breeder-yellow">
								{{ __('Waiting') }}
							</div>
						@endif
					@else
						<div class="text-breeder-coralhover">
							{{ __('The company is not marked for moderation') }}
						</div>
					@endif
					
					<div class="flex flex-row">
						{{ __('Company publication') }} :
					</div>

					@if($moderation->model->user->company->lastPublication)
						@if($moderation->model->user->company->lastPublication->isDraft())
							<div class="text-breeder-coralhover">
								{{ __('Draft') }}
							</div>
						@elseif($moderation->model->user->company->lastPublication->isDraftWaitingModerationForPublication())
							<div class="text-breeder-yellow">
								{{ __('Draft waiting moderation for publication') }}
							</div>
						@elseif($moderation->model->user->company->lastPublication->isPublished())
							<div class="text-breeder-green">
								{{ __('Published') }}
							</div>
						@elseif($moderation->model->user->company->lastPublication->isPublishedUpdatedWaitingModeration())
							<div class="text-breeder-yellow">
								{{ __('Published, updated and waiting moderation') }}
							</div>
						@elseif($moderation->model->user->company->lastPublication->isPublishedUpgradedWaitingModeration())
							<div class="text-breeder-yellow">
								{{ __('Published, upgraded and waiting moderation') }}
							</div>
						@elseif($moderation->model->user->company->lastPublication->isArchived())
							<div class="text-breeder-coralhover">
								{{ __('Archived') }}
							</div>
						@elseif($moderation->model->user->company->lastPublication->isDeleted())
							<div class="text-breeder-coralhover">
								{{ __('Deleted') }}
							</div>
						@endif
					@else
						<div class="text-breeder-coralhover">
							{{ __('The company has no publication') }}
						</div>
					@endif
				</div>
			@else
				<div class="text-breeder-coralhover">
					{{ __('User has no company') }}
				</div>
			@endif
		</div>
	</div>
</div>

<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Post\'s offer') }}
		</x-front.space-title>
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="offer" :value="__('Offer chosen')" />
			</div>

			@if($moderation->model->lastPublication->isPublishedUpgradedWaitingModeration())
				<div class="flex flex-col">
					<div class="flex flex-row font-bold">
						{{ __('Previous value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ __($moderation->model->offer()->name) }}
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ __($moderation->model->lastPublication->subscription->offer->name) }}
					</div>
				</div>
			@else
				<p>
					{{ __($moderation->model->offer()->name) }}
				</p>
			@endif
		</div>

		@php
			$lastPublication = $moderation->model->lastPublication;
			$subscription = $lastPublication->subscription;
			$offer = $subscription->offer;
		@endphp
		@if(!$offer->free)
			@if($subscription->synchronized_with_stripe)
				<div>
					<div class="flex flex-row">
						<x-front.input-label for="payment_methode" :value="__('Payment method')" />
					</div>

					<p>
						{{ __($subscription->values->get('payment_method')) }}
					</p>
				</div>

				<div>
					<div class="flex flex-row">
						<x-front.input-label for="payment_status" :value="__('Payment status')" />
					</div>

					<p>
						{{ __($subscription->values->get('payment_status')) }}
					</p>
				</div>

				<div>
					<div class="flex flex-row">
						<x-front.input-label for="transaction" :value="__('Transaction made')" />
					</div>

					<p>
						{{ Carbon::parse($subscription->values->get('created'))->format('d/m/Y H:i:s') }}
					</p>
				</div>

				@if($subscription->values->has('updated'))
					<div>
						<div class="flex flex-row">
							<x-front.input-label for="payment_received" :value="__('Payment received')" />
						</div>

						<p>
							{{ Carbon::parse($subscription->values->get('updated'))->format('d/m/Y H:i:s') }}
						</p>
					</div>
				@endif
			@endif

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="source" :value="__('Source')" />
				</div>

				<p>
					{{ __($subscription->from) }}
				</p>
			</div>
		@endif
	</div>
</div>

<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Author\'s info') }}
		</x-front.space-title>

		<div class="flex justify-end gap-x-2">
			<a href="{{ route('admin.log-as-user', ['user' => $moderation->model->user->slug]) }}" class="text-white inline-block">
				<button type="button" title="{{ __('Log as the user') }}" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
					</svg>
				</button>
			</a>
		</div>
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="offer" :value="__('Name')" />
			</div>

			<p>
				{{ $moderation->model->user->name }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="offer" :value="__('Email')" />
			</div>

			<p>
				{{ $moderation->model->user->email }}
			</p>
		</div>
	</div>
</div>

<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Post\'s informations') }}
		</x-front.space-title>

		<div class="flex justify-end gap-x-2">
			<a href="{{ route('post-search.post.show', ['company' => $moderation->model->model->company->slug, 'post' => $moderation->model->slug, 'breed' => $moderation->model->model->breed->slug]) }}" target="_blank">
				<x-front.primary-button>
					{{ __('Visualize the current post page') }}
				</x-front.primary-button>
			</a>
		</div>
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="post_type" :value="__('Post type')" />
			</div>

			<p>
				{{ ucfirst(__($moderation->model->type->name)) }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="name" :value="__('Post name')" />
			</div>

			<p>
				{{ $moderation->model->name }} - ({{ $moderation->model->slug }})
			</p>
		</div>
	</div>
</div>

<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Post of type : :type', ['type' => ucfirst(__($moderation->model->type->name))]) }}
		</x-front.space-title>

		@if($moderation->model->type->getTranslation('slug', 'en') == 'litter')
			<div class="flex justify-end gap-x-2">
				<a href="@if($moderation->model->model->species->getTranslation('slug', 'en') === 'cat') https://bis.loof.asso.fr/gp/numportee.php @elseif($moderation->model->model->species->getTranslation('slug', 'en') === 'dog') https://www.espaces.centrale-canine.fr/LofConnect/chien/verifPortee @endif" target="_blank">
					<x-front.primary-button>
						{{ __('Check the litter number') }}
					</x-front.primary-button>
				</a>
			</div>
		@endif
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="photos" :value="__('Post\'s photo')" />
			</div>

			<p>
				@if($moderation->model->getMedia('photos'.$moderation->model->id)->isNotEmpty())
					@foreach($moderation->model->getMedia('photos'.$moderation->model->id) as $index => $photo)
						<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ __('Photo n°:number', ['number' => $index]) }}" class="inline-block object-cover w-[100px] h-[100px]">
					@endforeach
				@else
					{{ __('No photos uploaded yet') }}
				@endif
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="company" :value="__('Company')" />
			</div>

			<p>
				{{ __($moderation->model->model->company->name) }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="species" :value="__('Species')" />
			</div>

			<p>
				{{ ucfirst(__($moderation->model->model->species->name)) }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="breed" :value="__('Breed')" />
			</div>

			<p>
				{{ $moderation->model->model->breed->name }}
			</p>
		</div>

		@if($moderation->model->type->getTranslation('slug', 'en') == 'litter')
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="birth_date" :value="__('Birth date')" />
				</div>

				<p>
					{{ Carbon::parse($moderation->model->model->values->get('birth_date'))->format('d/m/Y') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="availability" :value="__('Availability')" />
				</div>

				<p>
					{{ Carbon::parse($moderation->model->model->values->get('availability'))->format('d/m/Y') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="litter_number" :value="__('Litter number')" />
				</div>

				@if(data_get($moderation->model->model->values, 'for_moderation.litter_number'))
					<div class="flex flex-col">
						<div class="flex flex-row font-bold">
							{{ __('Previous value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ $moderation->model->model->values->get('litter_number') }}
						</div>

						<div class="flex flex-row font-bold">
							{{ __('New value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ data_get($moderation->model->model->values, 'for_moderation.litter_number') }}
						</div>
					</div>
				@else
					<p>
						{{ $moderation->model->model->values->get('litter_number') }}
					</p>
				@endif
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="male_count" :value="__('Male count')" />
				</div>

				<p>
					{{ $moderation->model->model->values->get('male_count') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="female_count" :value="__('Female count')" />
				</div>

				<p>
					{{ $moderation->model->model->values->get('female_count') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="birth_place" :value="__('Place of birth')" />
				</div>

				<p>{{ __($moderation->model->model->values->get('birth_place')) }}</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="birth_place_value" :value="__('Place of birth value')" />
				</div>

				<p>{{ $moderation->model->model->values->get('birth_place_value') }}</p>
			</div>
		@elseif($moderation->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come')
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="expected_birth_date" :value="__('Expected birth date')" />
				</div>

				@if(data_get($moderation->model->values, 'for_moderation.expected_birth_date'))
					<div class="flex flex-col">
						<div class="flex flex-row font-bold">
							{{ __('Previous value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							@php
								$value = $moderation->model->model->values->get('expected_birth_date');

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
							{{ $formatted }}
						</div>

						<div class="flex flex-row font-bold">
							{{ __('New value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							@php
								$value = data_get($moderation->model->values, 'for_moderation.expected_birth_date');

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
							{{ $formatted }}
						</div>
					</div>
				@else
					<p>
						@php
							$value = $moderation->model->model->values->get('expected_birth_date');

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
						{{ $formatted }}
					</p>
				@endif
			</div>
		@elseif($moderation->model->type->getTranslation('slug', 'en') == 'retired-breeder')
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="sterilized" :value="__('Sterilized')" />
				</div>

				<p>
					{{ __($moderation->model->values->get('sterilized') ? 'Yes' : 'No') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="price" :value="__('Selling price €')" />
				</div>

				@if(data_get($moderation->model->values, 'for_moderation.price'))
					<div class="flex flex-col">
						<div class="flex flex-row font-bold">
							{{ __('Previous value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ $moderation->model->values->get('price') }}
						</div>

						<div class="flex flex-row font-bold">
							{{ __('New value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ data_get($moderation->model->values, 'for_moderation.price') }}
						</div>
					</div>
				@else
					<p>
						{{ $moderation->model->values->get('price') }}
					</p>
				@endif
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="description" :value="__('Description')" />
				</div>

				@if(data_get($moderation->model->values, 'for_moderation.description'))
					<div class="flex flex-col">
						<div class="flex flex-row font-bold">
							{{ __('Previous value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ $moderation->model->values->get('description') }}
						</div>

						<div class="flex flex-row font-bold">
							{{ __('New value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ data_get($moderation->model->values, 'for_moderation.description') }}
						</div>
					</div>
				@else
					<p>
						{{ $moderation->model->values->get('description') }}
					</p>
				@endif
			</div>
		@elseif($moderation->model->type->getTranslation('slug', 'en') == 'stud')
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="quotation" :value="__('Quotation')" />
				</div>

				<p>
					{{ $moderation->model->values->get('quotation') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="mating_price" :value="__('Price of the mating €')" />
				</div>

				@if(data_get($moderation->model->values, 'for_moderation.price'))
					<div class="flex flex-col">
						<div class="flex flex-row font-bold">
							{{ __('Previous value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ $moderation->model->values->get('price') }}
						</div>

						<div class="flex flex-row font-bold">
							{{ __('New value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ data_get($moderation->model->values, 'for_moderation.price') }}
						</div>
					</div>
				@else
					<p>
						{{ $moderation->model->values->get('price') }}
					</p>
				@endif
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="protrusion_type" :value="__('Protrusion type')" />
				</div>

				@php
					$protrusionTypes = \App\Enums\ProtrusionTypes::asHumanArray();
					$protrusionArray = $moderation->model->values->get('protrusion_types', []);
				@endphp

				<p>
					@foreach($protrusionTypes as $index => $value)
						<div class="flex flex-row">
							<input type="checkbox" name="{{ $index }}" value="{{ $index }}" @checked(in_array($index, $protrusionArray)) disabled class="rounded border-gray-300 text-breeder-deepblue shadow-sm focus:ring-breeder-deepblue" />
							<span class="ms-2 text-sm text-breeder-deepblue">{{ __($value) }}</span>
						</div>
					@endforeach
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="average_litter_size" :value="__('Average litter size')" />
				</div>

				<p>
					{{ $moderation->model->values->get('average_litter_size') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="enhancer" :value="__('Enhancer/ Company characteristics')" />
				</div>

				<p>
					{{ $moderation->model->values->get('enhancer') }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="color_gen" :value="__('Color gene')" />
				</div>

				<p>
					{{ $moderation->model->values->get('gene_color') }}
				</p>
			</div>
		@endif

		@php
			if($moderation->model->type->getTranslation('slug', 'en') == 'retired-breeder' || $moderation->model->type->getTranslation('slug', 'en') == 'stud') {
				$description = $moderation->model->values->get('description');
				$descriptionModeration = data_get($moderation->model->values, 'for_moderation.description');
			}
			elseif($moderation->model->type->getTranslation('slug', 'en') == 'litter' || $moderation->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
				$description = $moderation->model->model->values->get('description');
				$descriptionModeration = data_get($moderation->model->model->values, 'for_moderation.description');
			}
		@endphp
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="description" :value="__('Description')" />
			</div>

			@if($descriptionModeration)
				<div class="flex flex-col">
					<div class="flex flex-row font-bold">
						{{ __('Previous value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ $description }}
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ $descriptionModeration }}
					</div>
				</div>
			@else
				<p>
					{{ $description }}
				</p>
			@endif
		</div>

		@if($moderation->model->offer()->hasOption('social-network-broadcasting'))
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="social" :value="__('Social network text')" />
				</div>

				@if(data_get($moderation->model->values, 'for_moderation.social_network_description'))
					<div class="flex flex-col">
						<div class="flex flex-row font-bold">
							{{ __('Previous value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ $moderation->model->values->get('social_network_description') }}
						</div>

						<div class="flex flex-row font-bold">
							{{ __('New value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							{{ data_get($moderation->model->values, 'for_moderation.social_network_description') }}
						</div>
					</div>
				@else
					<p>
						{{ $moderation->model->values->get('social_network_description') }}
					</p>
				@endif
			</div>
		@endif
	</div>
</div>

@if($moderation->model->type->getTranslation('slug', 'en') == 'litter' || $moderation->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come')
	<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
		<x-front.space-title>
			{{ __('Post\'s breeders') }}
		</x-front.space-title>

		<div class="flex flex-wrap gap-4 mt-4">
			@if($moderation->model->model->mother)
				<div class="flex flex-col gap-4">
					@if($moderation->model->model->mother->trashed())
						<div class="font-bold text-breeder-coralhover">
							{{ __('The associated animal has been deleted by the user') }}
						</div>
					@endif
				
					<livewire:front.animals.breeders.breeder
						:animal="$moderation->model->model->mother"
						:company="$moderation->model->model->company"
						:forModeration="$moderation->model->model->mother->trashed() ? false : true"
						:key="'female-animal-component-'.$moderation->model->model->mother->id" />
				</div>
			@else
				{{ __('No mother') }}
			@endif

			@if($moderation->model->model->father)
				<div class="flex flex-col gap-4">
					@if($moderation->model->model->father->trashed())
						<div class="font-bold text-breeder-coralhover">
							{{ __('The associated animal has been deleted by the user') }}
						</div>
					@endif
				
					<livewire:front.animals.breeders.breeder
						:animal="$moderation->model->model->father"
						:company="$moderation->model->model->company"
						:forModeration="$moderation->model->model->father->trashed() ? false : true"
						:key="'first-male-component-'.$moderation->model->model->father->id" />
				</div>
			@else
				{{ __('No father') }}
			@endif

			@if($moderation->model->model->secondFather)
				<div class="flex flex-col gap-4">
					@if($moderation->model->model->secondFather->trashed())
						<div class="font-bold text-breeder-coralhover">
							{{ __('The associated animal has been deleted by the user') }}
						</div>
					@endif

					<livewire:front.animals.breeders.breeder
						:animal="$moderation->model->model->secondFather"
						:company="$moderation->model->model->company"
						:forModeration="$moderation->model->model->secondFather->trashed() ? false : true"
						:key="'second-male-component-'.$moderation->model->model->secondFather->id" />
				</div>
			@else
				{{ __('No second father') }}
			@endif
		</div>
	</div>

	@if($moderation->model->type->getTranslation('slug', 'en') == 'litter')
		<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
			<livewire:front.animals.litter-animals.litter-animals
				:litter="$moderation->model->model"
				:post="$moderation->model"
				:forModeration="true"
				:key="'litter-children-component-'.$moderation->model->model->id" />
		</div>
	@endif
@elseif($moderation->model->type->getTranslation('slug', 'en') == 'retired-breeder' || $moderation->model->type->getTranslation('slug', 'en') == 'stud')
	<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
		<x-front.space-title>
			@if($moderation->model->type->getTranslation('slug', 'en') == 'retired-breeder')
				{{ __('Post\'s retired breeder') }}
			@elseif($moderation->model->type->getTranslation('slug', 'en') == 'stud')
				{{ __('Post\'s stud') }}
			@endif
		</x-front.space-title>

		<div class="flex flex-col flex-wrap gap-4 mt-4">
			@if($moderation->model->model)
				@if($moderation->model->model->trashed())
					<div class="font-bold text-breeder-coralhover">
						{{ __('The associated animal has been deleted by the user') }}
					</div>
				@endif

				<livewire:front.animals.breeders.breeder
					:animal="$moderation->model->model"
					:company="$moderation->model->model->company"
					:forModeration="$moderation->model->model->trashed() ? false : true"
					:key="'retired-breeder-component-'.$moderation->model->model->id" />
			@else
				{{ __('No breeder') }}
			@endif
		</div>
	</div>
@endif
