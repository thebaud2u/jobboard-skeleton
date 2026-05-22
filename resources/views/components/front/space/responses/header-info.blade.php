<div class="flex flex-col max-sm:gap-4 sm:justify-between border-b border-jobboard-greige p-4">
	<div class="flex flex-row justify-between pt-4 px-3">
		<div class="flex flex-row gap-3 text-jobboard-deepblue items-center">
			<div class="flex flex-col w-[46px] h-[46px] bg-white rounded-full border border-jobboard-cream justify-center items-center">
				@if($response->type->value == 'self')
					<img src="{{ asset('storage/eleveurs_online.jpg') }}" alt="Eleveurs-Online" class="object-cover w-[46px] h-[46px] rounded-full" />
				@else
					@if($photoLeft)
						<img src="{{ $photoLeft->getAvailableUrl(['optimized']) }}" alt="{{ $name }}" class="object-cover w-[46px] h-[46px] rounded-full" />
					@else
						<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $name }}" class="object-cover w-[46px] h-[46px] rounded-full" />
					@endif
				@endif
			</div>

			<div class="flex flex-col gap-2">
				<div class="flex flex-col">
					<div class="font-bold flex flex-row leading-snug text-[28px]">
						@if($toUser->hasRole('adopter'))
							{{ $toUser->name }}
						@else
							{{ $name }}
						@endif
					</div>

					@if($response->type->value == 'self')
						<span>
							{{ __('Leader in SEO and networking between breeders and individuals') }}
						</span>
					@endif
				</div>

				@if($response->type->value == 'application')
					<div class="flex flex-col">
						<div class="flex flex-row text-xs font-medium gap-x-2 items-center">
							<span class="flex flex-row items-center gap-x-2 text-xs font-medium text-jobboard-deepblue">
								@if(__($response->state->inHuman()) == 'Non disponible')
									{{ __($response->state->inHuman()) }}
								@else
									<div class="w-3 h-3 bg-black rounded-full"></div> {{ __($response->state->inHuman()) }}
								@endif
							</span>
						</div>
					</div>
				@endif
			</div>
		</div>

		@if($response->type->value != 'self')
			<div class="flex flex-col text-jobboard-deepblue">
				<div class="flex flex-row">
					@if($goToRoute)
						<a href="{{ $goToRoute }}" target="_blank">
					@endif
						<div class="w-[69px] h-[69px] rounded-xl">
							@if($photoRight)
								<img src="{{ $photoRight->getAvailableUrl(['optimized']) }}" alt="{{ $model->name }}" class="object-cover w-[69px] h-[69px] rounded-xl" />
							@else
								<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $model->name }}" class="object-cover w-[69px] h-[69px] rounded-xl" />
							@endif
						</div>
					@if($goToRoute)
						</a>
					@endif
				</div>
			</div>
		@endif
	</div>
</div>
