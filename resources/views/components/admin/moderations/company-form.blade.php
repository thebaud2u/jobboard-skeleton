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
					<div class="text-jobboard-green">
						{{ __('Validated') }}
					</div>
				@elseif($moderation->model->user->lastModeration->isDenied())
					<div class="text-jobboard-coralhover">
						{{ __('Denied') }}
					</div>
				@elseif($moderation->model->user->lastModeration->isWaiting())
					<div class="text-jobboard-yellow">
						{{ __('Waiting') }}
					</div>
				@endif
			@else
				<div class="text-jobboard-coralhover">
					{{ __('User\'s profil is not marked for moderation') }}
				</div>
			@endif
		</div>
	</div>
</div>

<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Company\'s offer') }}
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
						{{ __($moderation->model->lastPublication->subscription->offer->name) }}
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ __($moderation->model->offer()->name) }}
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
			{{ __('Company\'s informations') }}
		</x-front.space-title>

		<div class="flex justify-end gap-x-2">
			<a href="{{ route('company-search.company.show', ['company' => $moderation->model->slug]) }}" target="_blank">
				<x-front.primary-button>
					{{ __('Visualize the current company page') }}
				</x-front.primary-button>
			</a>

			@if($moderation->model->values->has('for_moderation'))
				<a href="{{ route('admin.moderations.preview-moderation', ['moderation' => $moderation]) }}" target="_blank">
					<x-front.primary-button>
						{{ __('Visualize the company page with the new data') }}
					</x-front.primary-button>
				</a>
			@endif
		</div>
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="logo" :value="__('Company\'s logo')" />
			</div>

			<p>
				@if($moderation->model->getMedia('logo')->isNotEmpty())
					<img src="{{ $moderation->model->getMedia('logo')->first()->getAvailableUrl(['optimized']) }}" alt="{{ __('Current logo') }}" class="inline-block object-cover w-[100px] h-[100px] rounded-full">
				@else
					{{ __('No logo uploaded yet') }}
				@endif
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="name" :value="__('Company\'s name')" />
			</div>

			@if(data_get($moderation->model->values, 'for_moderation.name'))
				<div class="flex flex-col">
					<div class="flex flex-row font-bold">
						{{ __('Previous value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ $moderation->model->name }}
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ data_get($moderation->model->values, 'for_moderation.name') }}
					</div>
				</div>
			@else
				<p>
					{{ $moderation->model->name }}
				</p>
			@endif
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="affix" :value="__('Affix')" />
			</div>

			@if(data_get($moderation->model->values, 'for_moderation.affix'))
				<div class="flex flex-col">
					<div class="flex flex-row font-bold">
						{{ __('Previous value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ __($moderation->model->values->get('affix')) }}
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ __(data_get($moderation->model->values, 'for_moderation.affix')) }}
					</div>
				</div>
			@else
				<p>
					{{ __($moderation->model->values->get('affix')) }}
				</p>
			@endif
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="affix_name" :value="__($moderation->model->values->get('affix') === 'suffix' ? 'Suffix name' : 'Prefix name')" />
			</div>

			@if(data_get($moderation->model->values, 'for_moderation.affix_name'))
				<div class="flex flex-col">
					<div class="flex flex-row font-bold">
						{{ __('Previous value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ $moderation->model->values->get('affix_name') }}
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ data_get($moderation->model->values, 'for_moderation.affix_name') }}
					</div>
				</div>
			@else
				<p>
					{{ $moderation->model->values->get('affix_name') }}
				</p>
			@endif
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="breeds" :value="__('Breeds')" />
			</div>

			@if(data_get($moderation->model->values, 'for_moderation.breeds'))
				<div class="flex flex-col">
					<div class="flex flex-row font-bold">
						{{ __('Previous value') }} :
					</div>

					<div class="flex flex-wrap gap-4 pl-4 my-4">
						@foreach($moderation->model->breeds as $breed)
							<span class="w-fit px-3 py-1 rounded-md font-medium bg-jobboard-cream text-jobboard-deepblue text-sm">
								{{ $breed->name }}
							</span>
						@endforeach
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-wrap gap-4 pl-4 my-4">
						@foreach($moderation->model->constructBreedsFromModeration() as $breed)
							<span class="w-fit px-3 py-1 rounded-md font-medium bg-jobboard-cream text-jobboard-deepblue text-sm">
								{{ $breed->name }}
							</span>
						@endforeach
					</div>
				</div>
			@else
				<div class="flex flex-wrap pl-4 my-4 gap-4">
					@foreach($moderation->model->breeds as $breed)
						<span class="w-fit px-3 py-1 rounded-md font-medium bg-jobboard-cream text-jobboard-deepblue text-sm">
							{{ $breed->name }}
						</span>
					@endforeach
				</div>
			@endif
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="address" :value="__('Address')" />
			</div>

			@if($moderation->model->addressForModeration)
				<div class="flex flex-col">
					<div class="flex flex-row font-bold">
						{{ __('Previous value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ $moderation->model->displayFullAddress() }}
					</div>

					<div class="flex flex-row font-bold">
						{{ __('New value') }} :
					</div>

					<div class="flex flex-row pl-4 my-4">
						{{ $moderation->model->displayFullAddressForModeration() }}
					</div>
				</div>
			@else
				<p>
					{{ $moderation->model->displayFullAddress() }}
				</p>
			@endif
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="description" :value="__('Description')" />
			</div>

			<p>
				{{ $moderation->model->description }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="photo" :value="__('Company\'s photos')" />
			</div>

			<p>
				@if($moderation->model->getMedia('photos')->isNotEmpty())
					@foreach($moderation->model->getMedia('photos') as $index => $photo)
						<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ __('Photo n°:number', ['number' => $index]) }}" class="inline-block object-cover w-[100px] h-[100px]">
					@endforeach
				@else
					{{ __('No photos uploaded yet') }}
				@endif
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="cat_facebook" :value="__('Facebook for cats')" />
			</div>

			<p>
				{{ $moderation->model->values->get('cat_facebook') }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="cat_instagram" :value="__('Instagram for cats')" />
			</div>

			<p>
				{{ $moderation->model->values->get('cat_instagram') }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="dog_facebook" :value="__('Facebook for dogs')" />
			</div>

			<p>
				{{ $moderation->model->values->get('dog_facebook') }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="dog_instagram" :value="__('Instagram for dogs')" />
			</div>

			<p>
				{{ $moderation->model->values->get('dog_instagram') }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="website" :value="__('Website')" />
			</div>

			<p>
				{{ $moderation->model->values->get('website') }}
			</p>
		</div>

		@if($moderation->model->values->has('videos') || data_get($moderation->model->values, 'for_moderation.videos'))
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="videos" :value="__('Videos')" />
				</div>

				@if(data_get($moderation->model->values, 'for_moderation.videos'))
					<div class="flex flex-col">
						<div class="flex flex-row font-bold">
							{{ __('Previous value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							@if($moderation->model->values->get('videos'))
								@foreach($moderation->model->values->get('videos') as $video)
									{{ $video }}
								@endforeach
							@else
								{{ __('No video(s)') }}
							@endif
						</div>

						<div class="flex flex-row font-bold">
							{{ __('New value') }} :
						</div>

						<div class="flex flex-row pl-4 my-4">
							@foreach(data_get($moderation->model->values, 'for_moderation.videos') as $video)
								{{ $video }}
							@endforeach
						</div>
					</div>
				@else
					<p>
						@foreach($moderation->model->values->get('videos') as $video)
							{{ $video }}
						@endforeach
					</p>
				@endif
			</div>
		@endif
	</div>
</div>

<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<livewire:front.animals.breeders.breeders
		:company="$moderation->model"
		:forModeration="true"
		:key="'breeder-component'" />
</div>
