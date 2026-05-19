<x-space-layout>
	<x-slot name="side_menu">
		@include('components.front.space.profile.side-menu')
	</x-slot>

	{{-- <div class="w-full mt-8">
		<x-front.form-part-title>
			{{ __('My messages') }}
		</x-front.form-part-title>

		<hr class="h-px border border-breeder-deepblue w-full my-[30px]">
	</div> --}}

	@if($response->exists || $responses->isNotEmpty())
		<div class="flex flex-col lg:items-start lg:flex-row max-lg:space-y-4 lg:space-x-4 max-md:px-6 h-full my-8 max-xlsm:px-4">
			<div class="lg:flex-1 w-full lg:flex-none lg:w-full lg:max-w-[347px] bg-white max-md:py-3 md:h-full md:max-h-[938px] overflow-hidden">
				<livewire:front.space.responses.filters :key="'my-reponses-filters'" />

				<livewire:front.space.responses.my-messages
					:activeResponse="$response"
					:key="'my-messages'" />
			</div>

			<livewire:front.space.responses.my-message
				:response="$response"
				:key="'my-message'" />
		</div>
	@else
		<p class="text-breeder-deepblue font-medium mt-8">
			{{ __('You don\'t have any messages yet.') }}
		</p>
	@endif
</x-messaging-layout>
