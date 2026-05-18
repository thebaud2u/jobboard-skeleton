<div class="flex flex-row justify-center gap-4 text-xs s:text-sm sm:text-base">
	<div class="flex flex-col items-center">
		@if(Auth::guard('web')->check())
			@if(Auth::guard('web')->user()->id != $target->user->id)
				@if($hasContacted)
					<a href="{{ route('space.responses.my-messages', ['response' => $response->id]) }}">
						<x-front.primary-button type="button">
							{{ __('Go to conversation') }}
						</x-front.primary-button>
					</a>
				@else
					<form method="POST" action="{{ route('space.responses.create-conversation') }}"
						x-data
						x-on:submit.prevent="
							@if($type == 'company')
								window.dataLayer = window.dataLayer || [];
								window.dataLayer.push({
									event: 'contact_initié',
									{{-- On utilise le nom de la race si dispo, sinon 'non_renseignée' --}}
									race: {{ json_encode($breed->name ?? 'non_renseignée') }}
								});
							@endif

							{{-- Soumission manuelle du formulaire après le push --}}
							$el.submit();
						">
						@csrf

						<input type="hidden" name="target" value="{{ $target->id }}" />
						<input type="hidden" name="type" value="{{ $type }}" />

						<x-front.primary-button>
							{{ __('Start conversation') }}

							<svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.86231 1.5L7.31685 6.5L1.8623 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</x-front.primary-button>
					</form>
				@endif
			@endif
		@else
			<a href="{{ route('redirect.to.login', ['from' => url()->full()]) }}"
				x-on:click.prevent="
					@if($type == 'company')
						const breed = 'non_renseignée';

						window.dataLayer = window.dataLayer || [];
						window.dataLayer.push({
							event: 'contact_initié',
							race: breed
						});
					@endif
				window.location.href = $el.href;">
				<x-front.primary-button>
					@if(isset($title))
						{{ __('Contact us') }}
					@else
						{{ __('Start conversation') }}
					@endif

					<svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.86231 1.5L7.31685 6.5L1.8623 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</x-front.primary-button>
			</a>
		@endif
	</div>
</div>
