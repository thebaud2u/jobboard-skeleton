<div class="flex flex-row gap-4 text-xs s:text-sm sm:text-base justify-center">
	<div class="flex flex-col items-center w-full">
		@if(Auth::guard('web')->check())
			@if(
				(Auth::guard('web')->user()->hasRole('adopter') && ($post->type->getTranslation('slug', 'en') == 'litter' || $post->type->getTranslation('slug', 'en') == 'litter-yet-to-come' || $post->type->getTranslation('slug', 'en') == 'retired-breeder')) ||
				(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder']) && $post->type->getTranslation('slug', 'en') == 'stud')
			)
				@if(Auth::guard('web')->user()->id != $post->user->id)
					@if($hasApplyied)
						<div class="flex items-center text-sm font-semibold text-breeder-deepblue mb-3">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
							</svg>

							{{ __('You have already contacted') }}
						</div>
					@endif

					@if($hasApplyied)
						<a href="{{ route('space.responses.my-messages', ['response' => $response->id]) }}" class="w-full">
							<x-front.primary-button type="button" :class="'w-full justify-center'">
								{{ __('Show my inquire') }}
							</x-front.primary-button>
						</a>
					@else
						@if($post->type->getTranslation('slug', 'en') == 'stud')
							<a href="{{ route('space.responses.create', ['element' => $post->slug]) }}"
								x-on:click.prevent="
									const breed = 'non_renseignée';

									window.dataLayer = window.dataLayer || [];
									window.dataLayer.push({
										event: 'contact_initié',
										race: breed
									});
									window.location.href = $el.href;">
								<x-front.primary-button :class="'w-full justify-center'">
									{{ __('Contact the company') }}
								</x-front.primary-button>
							</a>
						@else
							<span x-on:click.prevent="$nextTick(() => {
								const breed = '{{ $breed->name ?? "non_renseignée" }}';

								window.dataLayer = window.dataLayer || [];
								window.dataLayer.push({
									event: 'contact_initié',
									race: breed // race l’animal en question, si inconnu mettre “non_renseignée”
								});
							});
							$dispatch('open-modal','contact');
								" class="w-full">
								<x-front.primary-button :class="'w-full justify-center'">
									{{ __('Contact the company') }}
								</x-front.primary-button>
							</span>
						@endif
					@endif
				@endif
			@endif
		@else
			@if($post->type->getTranslation('slug', 'en') == 'stud')
				<a href="{{ route('redirect.to.login', ['from' => url()->full()]) }}"
					x-on:click.prevent="
						const breed = '{{ $breed->name ?? "non_renseignée" }}';

						window.dataLayer = window.dataLayer || [];
						window.dataLayer.push({
							event: 'contact_initié',
							race: breed
						});
						window.location.href = $el.href;">
					<x-front.primary-button :class="'w-full justify-center'">
						{{ __('Contact the company') }}
					</x-front.primary-button>
				</a>
			@else
				<span x-on:click.prevent="$nextTick(() => {
						const breed = '{{ $breed->name ?? "non_renseignée" }}';

						window.dataLayer = window.dataLayer || [];
						window.dataLayer.push({
							event: 'contact_initié',
							race: breed // race l’animal en question, si inconnu mettre “non_renseignée”
						});
					});
					$dispatch('open-modal','contact');
						" class="w-full">
					<x-front.primary-button :class="'w-full justify-center'">
						{{ __('Contact the company') }}
					</x-front.primary-button>
				</span>
			@endif
		@endif
	</div>
</div>