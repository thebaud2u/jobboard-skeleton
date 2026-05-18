<div class="flex flex-row justify-center items-center gap-x-6">
	<div class="flex flex-col w-full">
		<div class="flex flex-row pl-4">
			<x-front.input-label for="expectedBirthDate" :value="__('Expected birth date')" :required="true" />
		</div>

		<x-front.text-input type="month" name="expectedBirthDate" id="expectedBirthDate" wire:model="expectedBirthDate" placeholder="{{ __('MM/YYYY') }}" :class="'mt-1 block bg-white'" />

		@error('expectedBirthDate')
			<span class="error text-danger-700">
				{{ $message }}
			</span>
		@enderror
	</div>
</div>
