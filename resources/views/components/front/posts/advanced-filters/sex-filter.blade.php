<div class="flex flex-col py-4">
	<span class="flex-1 font-semibold text-breeder-deepblue">
		{{ __('Sex') }}
	</span>

	@foreach($animalSexes as $key => $label)
		<label for="sex" class="inline-flex items-center">
			<input type="checkbox" id="sex" name="sex" value="{{ $key }}" wire:model="filters.sex" wire:change="search" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
			<span class="ms-2 text-sm text-breeder-deepblue">{{ __($label) }}</span>
		</label>
	@endforeach
</div>