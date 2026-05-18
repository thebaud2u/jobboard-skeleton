@if($situation == 'answerer')
	@if($response->isReceived())
		<div class="flex flex-row w-full pt-4 gap-4 max-s:flex-wrap px-3">
			@if($appointment)
				@if($appointmentPassed)
					<a href="{{ route('space.appointments.my-appointments', ['element' => $response->id]) }}">
						<x-front.secondary-button :class="'w-full justify-center'">
							{{ __('Set a rendez-vous') }}
						</x-front.secondary-button>
					</a>
				@endif
			@else
				<a href="{{ route('space.appointments.my-appointments', ['element' => $response->id]) }}">
					<x-front.secondary-button :class="'w-full justify-center'">
						{{ __('Set a rendez-vous') }}
					</x-front.secondary-button>
				</a>
			@endif

			@if($animal->exists)
				@if($lastLife->isAvailable())
					<x-front.secondary-button wire:click="markAsReserved" :class="'w-full justify-center'">
						{{ __('Reserve the animal') }}
					</x-front.secondary-button>
				@elseif($lastLife->isReserved() && $response->from->slug == $lastLife->model->slug)
					<x-front.secondary-button wire:click="cancelReservation" :class="'w-full justify-center'">
						{{ __('Cancel the reservation') }}
					</x-front.secondary-button>
				@endif

				@if(!$response->values->has('part_confirmation') || ($response->values->has('part_confirmation') && data_get($response->values, 'part_confirmation.answerer') === false))
					<x-front.secondary-button type="button" x-on:click.prevent="$dispatch('open-modal', 'pickup-confirmation-modal');">
						{{ __('Validate the adoption') }}
					</x-front.secondary-button>

					@include('components.front.space.responses.pickup-confirmation-modal')
				@endif
			@endif
		</div>
	@endif
@elseif($situation == 'asking')
	@if($response->isReceived())
		@if($response->values->has('part_confirmation') && data_get($response->values, 'part_confirmation.asking') === false && data_get($response->values, 'part_confirmation.answerer') === true)
			<div class="mt-4 px-3">
				<x-front.secondary-button type="button" :class="'px-3'" x-on:click.prevent="$dispatch('open-modal', 'pickup-confirmation-modal');">
					{{ __('Validate the adoption') }}
				</x-front.secondary-button>
			</div>

			@include('components.front.space.responses.pickup-confirmation-modal')
		@endif
	@endif
@endif