<x-front.modal name="pickup-confirmation-modal" :class="'w-full max-w-2xl'" focusable>
	<div class="space-y-8 text-breeder-deepblue">
		<div class="flex flex-row items-center gap-x-4">
			<div class="w-[50px] h-[50px] bg-white rounded-xl flex justify-center items-center shadow-[0_0_20px_0_rgba(0,44,106,0.2)]">
				@if($photo = $model->getFirstMedia('photos'.$model->id))
					<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $model->name }}" class="object-cover w-[50px] h-[50px] rounded-xl" />
				@else
					<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $model->name }}" class="object-cover w-[50px] h-[50px] rounded-xl" />
				@endif
			</div>

			<svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.49219 1L5.85582 5L1.49219 9" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>

			<div class="w-[50px] h-[50px] bg-white rounded-xl flex justify-center items-center shadow-[0_0_20px_0_rgba(0,44,106,0.2)]">
				@if($photo = $response->from->getFirstMedia('avatar'))
					<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $response->from->name }}" class="object-cover w-[50px] h-[50px] rounded-xl" />
				@else
					<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $response->from->name }}" class="object-cover w-[50px] h-[50px] rounded-xl" />
				@endif
			</div>
		</div>

		<div class="flex flex-col">
			<x-front.space-title :class="'mb-4'">
				{{ __('Pickup confirmation') }}
			</x-front.space-title>

			<span>
				{{ __('You are about to confirm the pickup of :') }}
			</span>

			@php
				if(!$animal) {
					if($model->type->getTranslation('slug', 'en') == 'litter' || $model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $name = __(ucfirst($model->type->name)).' '.$model->model->breed->name;
				}
				else $name = $animal->name;
			@endphp
			<div class="flex flex-row gap-x-1">
				<span class="font-bold">
					{{ $name }}
				</span>

				{{ __('by') }}

				<span class="font-bold">
					{{ $response->from->name }}
				</span>
			</div>
		</div>

		<div class="flex flex-row justify-between">
			<x-front.secondary-button x-on:click="$dispatch('close');" :class="'flex justify-center mt-4 s:mt-0'">
				<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.42547 12.0745L11.5745 6.92545M6.42547 6.92545L11.5745 12.0745M17 9.5C17 13.9183 13.4183 17.5 9 17.5C4.58172 17.5 1 13.9183 1 9.5C1 5.08172 4.58172 1.5 9 1.5C13.4183 1.5 17 5.08172 17 9.5Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				{{ __('Cancel') }}
			</x-front.secondary-button>

			<x-front.primary-button wire:click="confirmPickup" @pickup-validated.window="$dispatch('close');" :class="'flex justify-center mt-4 s:mt-0'">
				<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12.5491 2.32909C11.48 1.79818 10.2727 1.5 9 1.5C4.57818 1.5 1 5.07818 1 9.5C1 13.9218 4.57818 17.5 9 17.5C13.4218 17.5 17 13.9218 17 9.5C17 8.47455 16.8036 7.49273 16.4545 6.59091M5.36364 9.5L8.27273 12.4091L17 1.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				{{ __('Confirm pickup') }}
			</x-front.primary-button>
		</div>
	</div>
</x-front.modal>
