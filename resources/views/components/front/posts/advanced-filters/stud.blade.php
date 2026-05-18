<div class="flex flex-col py-4">
	<span class="flex-1 font-semibold text-breeder-deepblue">
		{{ __('Quotation') }}
	</span>

	<div class="flex flex-row justify-between items-center gap-4">
		@for($i = 1; $i <= 6; $i++)
			<label for="quotation" class="flex flex-col justify-center items-center">
				<span class="text-sm text-breeder-deepblue">{{ $i }}</span>
				<input type="radio" id="quotation" name="quotation" value="{{ $i }}" wire:model="filters.quotation" wire:change="search" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
			</label>
		@endfor
	</div>
</div>

<div class="flex flex-col py-4">
	<span class="flex-1 font-semibold text-breeder-deepblue">
		{{ __('Protrusion type') }}
	</span>

	@foreach($protrusionTypes as $key => $label)
		<label for="protrusion_type" class="inline-flex items-center">
			<input type="checkbox" id="protrusion_type" name="protrusion_type" value="{{ $key }}" wire:model="filters.protrusion_type" wire:change="search" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
			<span class="ms-2 text-sm text-breeder-deepblue">{{ __($label) }}</span>
		</label>
	@endforeach
</div>