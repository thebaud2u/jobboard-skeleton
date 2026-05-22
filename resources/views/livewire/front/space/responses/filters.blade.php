<div class="w-full">
	<div class="max-w-[1200px]">
		<div class="text-jobboard-deepblue font-bold text-[28px] mb-4">
			{{ __('Messages') }}
		</div>

		<div class="lg:bg-white rounded-xl max-sm:w-full">
			<div class="flex flex-col gap-4 md:w-[680px] sm:mx-auto lg:mx-0 lg:max-w-none w-full lg:w-full">
				<div class="relative flex flex-col bg-white rounded-full flex-1 px-2 py-1 lg:p-0 lg:rounded-none text-jobboard-deepblue border-jobboard-greige lg:max-w-[350px] w-full">
					<select name="filters.type" wire:model="filters.type" wire:change="search" class="py-3 border-jobboard-greige focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-xl text-jobboard-deepblue placeholder:text-gray-400 w-full">
						<option value="">{{ __('Select a state') }}</option>

						@if(!empty($types))
							@foreach($types as $typeEntry)
								<option value="{{ $typeEntry['value'] }}">{{ $typeEntry['label'] }}</option>
							@endforeach
						@endif
					</select>
				</div>

				<div class="flex flex-row">
					<input type="checkbox" name="not-read-only" wire:model="filters.not-read-only" wire:change="search" class="rounded border-gray-300 text-jobboard-deepblue shadow-sm focus:ring-jobboard-deepblue" />

					<span class="ms-2 text-sm text-jobboard-deepblue">
						{{ __('Not read only') }}
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
