<div class="flex flex-col py-4">
	<span class="flex-1 font-semibold text-jobboard-deepblue">
		{{ __('Price range') }}
	</span>

	<div class="flex flex-row justify-start items-center gap-x-1">
		{{ __('From') }}
		<x-front.text-input type="number" name="minPrice" id="minPrice" wire:model="filters.min_price" wire:keyup.debounce.500="search" placeholder="{{ __('Minimum price €') }}" :class="'mt-1 block bg-white w-full'" />
	</div>

	<div class="flex flex-row justify-start items-center gap-x-1">
		{{ __('to') }}
		<x-front.text-input type="number" name="maxPrice" id="maxPrice" wire:model="filters.max_price" wire:keyup.debounce.500="search" placeholder="{{ __('Maximum price €') }}" :class="'mt-1 block bg-white w-full'" />
	</div>
</div>