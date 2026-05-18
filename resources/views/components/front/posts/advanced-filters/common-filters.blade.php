<div class="flex flex-col py-4">
	<span class="flex-1 font-semibold text-breeder-deepblue">
		{{ $species->getTranslation('slug', 'en') == 'dog' ? __('LOF') : __('LOOF') }} / {{ __('Origin book') }}
	</span>

	<div class="flex flex-col" 
     x-data="{ 
        selection: @entangle('filters.pure_breed'),
        updateSelection(val) {
            this.selection = (this.selection === val || (val === 'true' && this.selection === true) || (val === 'false' && this.selection === false)) 
				? 'indif' 
				: val;
        }
     }">
    
    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" 
               :checked="selection === true || selection === 'true'"
               @click="updateSelection('true')"
               wire:change="search"
               class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
        <span class="ms-2 text-sm text-breeder-deepblue">{{ __('Yes') }}</span>
    </label>

    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" 
               :checked="selection === false || selection === 'false'"
               @click="updateSelection('false')"
               wire:change="search"
               class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
        <span class="ms-2 text-sm text-breeder-deepblue">{{ __('No') }}</span>
    </label>

    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" 
               :checked="selection === null || selection === 'indif'"
               @click="updateSelection('indif')"
               wire:change="search"
               class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
        <span class="ms-2 text-sm text-breeder-deepblue">{{ __('No preference') }}</span>
    </label>
</div>
</div>

<hr>

<div class="flex flex-col py-4">
	<span class="flex-1 font-semibold text-breeder-deepblue">
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