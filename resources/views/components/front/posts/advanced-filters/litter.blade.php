<div class="flex flex-col py-4">
	<span class="flex-1 font-semibold text-breeder-deepblue">
		{{ __('Litter type') }}
	</span>

	@foreach($litterTypes as $litterType)
		<label for="litter_type" class="inline-flex items-center">
			<input type="checkbox" id="litter_type" name="litter_type" value="{{ $litterType->getTranslation('slug', 'en') }}" wire:model="filters.litter_type" wire:change="search" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
			<span class="ms-2 text-sm text-breeder-deepblue">
				@if($litterType->name == 'litter')
					{{ __('Born') }}
				@elseif($litterType->name == 'litter yet to come')
					{{ __('Yet to come') }}
				@endif
			</span>
		</label>
	@endforeach
</div>