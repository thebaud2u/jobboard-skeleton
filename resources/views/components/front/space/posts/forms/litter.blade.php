<div class="flex flex-col sm:flex-row justify-center items-center gap-6">
	<div class="flex flex-col w-full">
		<div class="flex flex-row pl-4">
			<x-front.input-label for="birthDate" :value="__('Date of birth')" :required="true" />
		</div>

		<x-front.text-input type="date" name="birthDate" id="birthDate" wire:model.live="birthDate" :disabled="!$allowUpdate" placeholder="{{ __('DD/MM/YYYY') }}" :class="'mt-1 block bg-white'" />

		@error('birthDate')
			<span class="error text-danger-700">
				{{ $message }}
			</span>
		@enderror
	</div>

	<div class="flex flex-col w-full">
		<div class="flex flex-row pl-4">
			<x-front.input-label for="availabilityDate" :value="__('Date of availability')" :required="true" />
		</div>

		<x-front.text-input type="date" name="availabilityDate" id="availabilityDate" wire:model="availabilityDate" :disabled="!$allowUpdate" min="{{ Carbon::parse($birthDate)->addWeeks($speciesSelected == 'dog' ? 8 : 12)->format('Y-m-d') }}" placeholder="{{ __('DD/MM/YYYY') }}" :class="'mt-1 block bg-white'" />

		@error('availabilityDate')
			<span class="error text-danger-700">
				{{ $message }}
			</span>
		@enderror
	</div>

	<div class="flex flex-col w-full">
		<div class="flex flex-row pl-4">
			<x-front.input-label for="litterNumber" :value="__('Litter number')" />
		</div>

		<x-front.text-input name="litterNumber" id="litterNumber" wire:model="litterNumber" placeholder="{{ __('Litter number') }}" :class="'mt-1 block bg-white'" />

		@error('litterNumber')
			<span class="error text-danger-700">
				{{ $message }}
			</span>
		@enderror
	</div>
</div>

<div class="flex flex-col sm:flex-row gap-6">
	<div class="flex flex-row gap-x-2 items-center mb-3 flex-wrap">
		<div class="flex flex-row pl-4">
			<x-front.input-label for="birthPlace" :value="__('Place of birth')" :required="true" />
		</div>

		<div class="flex flex-row gap-x-1">
			<label for="birthPlaceCompany" class="inline-flex items-center mr-2">
				<input type="radio" name="birthPlace" id="birthPlaceCompany" value="company" wire:model.live="birthPlace" class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

				<span class="ms-2">
					{{ __('In the company') }}
				</span>
			</label>

			<label for="birthPlaceOther" class="inline-flex items-center">
				<input type="radio" name="birthPlace" id="birthPlaceOther" value="other" wire:model.live="birthPlace" class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

				<span class="ms-2">
					{{ __('Somewhere else') }}
				</span>
			</label>
		</div>

		@error('birthPlace')
			<span class="error text-danger-700">
				{{ $message }}
			</span>
		@enderror
	</div>

	@if($birthPlace == 'other')
		<div class="flex flex-col w-full">
			<div class="flex flex-row pl-4">
				<x-front.input-label for="birthPlaceValue" :value="__('Specify where')" :required="true" />
			</div>

			<x-front.text-input name="birthPlaceValue" id="birthPlaceValue" wire:model.live="birthPlaceValue" placeholder="{{ __('Specify where') }}" :class="'mt-1 block bg-white'" />

			@error('birthPlaceValue')
				<span class="error text-danger-700">
					{{ $message }}
				</span>
			@enderror
		</div>
	@endif
</div>

<div class="text-breeder-deepblue font-bold text-lg">{{ __('Staff composition') }}</div>

<div class="flex flex-col sm:flex-row justify-center items-center gap-6">
	<div class="flex flex-col justify-center items-center w-full max-w-[420px] h-[210px] gap-y-2 p-8 bg-breeder-cream rounded-xl">
		<svg width="25" height="22" viewBox="0 0 25 22" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M16.9863 1H23.3021V7.31579" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M23.3021 1L16.9863 7.31579" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M9.61832 21.0001C14.2691 21.0001 18.0394 17.2298 18.0394 12.579C18.0394 7.92819 14.2691 4.15796 9.61832 4.15796C4.9675 4.15796 1.19727 7.92819 1.19727 12.579C1.19727 17.2298 4.9675 21.0001 9.61832 21.0001Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>

		<x-front.input-label for="maleNumber" :value="__('Male number')" :required="true" />

		<div class="flex flex-row justify-center items-center gap-x-4 bg-white rounded-xl p-2">
			@if($allowUpdate)
				<div class="cursor-pointer" wire:click="decrementLitterCount('male')">
					<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="1" y="1.25" width="25.5" height="25.5" rx="12.75" stroke="#0E1954" stroke-width="1.5"/>
						<line x1="19.25" y1="14.75" x2="8.25" y2="14.75" stroke="#0E1954" stroke-width="1.5"/>
					</svg>
				</div>
			@endif

			<div>
				{{ $maleCount }}
			</div>

			@if($allowUpdate)
				<div class="cursor-pointer" wire:click="incrementLitterCount('male')">
					<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="1" y="1.25" width="25.5" height="25.5" rx="12.75" stroke="#0E1954" stroke-width="1.5"/>
						<line x1="14" y1="8.5" x2="14" y2="19.5" stroke="#0E1954" stroke-width="1.5"/>
						<line x1="19.25" y1="14.25" x2="8.25" y2="14.25" stroke="#0E1954" stroke-width="1.5"/>
					</svg>
				</div>
			@endif
		</div>

		@error('maleCount')
			<span class="error text-danger-700">
				{{ $message }}
			</span>
		@enderror
	</div>

	<div class="flex flex-col justify-center items-center w-full max-w-[420px] h-[210px] gap-y-2 p-8 bg-breeder-cream rounded-xl">
		<svg width="15" height="22" viewBox="0 0 15 22" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M7.75 13.7999C11.3399 13.7999 14.25 10.9346 14.25 7.39997C14.25 3.86536 11.3399 1 7.75 1C4.16015 1 1.25 3.86536 1.25 7.39997C1.25 10.9346 4.16015 13.7999 7.75 13.7999Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M7.75 13.8L7.74876 21.0001" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M3.6875 17.7998L11.8125 17.7998" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>

		<x-front.input-label for="femaleNumber" :value="__('Female number')" :required="true" />

		<div class="flex flex-row justify-center items-center gap-x-4 bg-white rounded-xl p-2">
			@if($allowUpdate)
				<div class="cursor-pointer" wire:click="decrementLitterCount('female')">
					<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="1" y="1.25" width="25.5" height="25.5" rx="12.75" stroke="#0E1954" stroke-width="1.5"/>
						<line x1="19.25" y1="14.75" x2="8.25" y2="14.75" stroke="#0E1954" stroke-width="1.5"/>
					</svg>
				</div>
			@endif

			<div>
				{{ $femaleCount }}
			</div>

			@if($allowUpdate)
				<div class="cursor-pointer" wire:click="incrementLitterCount('female')">
					<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="1" y="1.25" width="25.5" height="25.5" rx="12.75" stroke="#0E1954" stroke-width="1.5"/>
						<line x1="14" y1="8.5" x2="14" y2="19.5" stroke="#0E1954" stroke-width="1.5"/>
						<line x1="19.25" y1="14.25" x2="8.25" y2="14.25" stroke="#0E1954" stroke-width="1.5"/>
					</svg>
				</div>
			@endif
		</div>

		@error('femaleCount')
			<span class="error text-danger-700">
				{{ $message }}
			</span>
		@enderror
	</div>
</div>
