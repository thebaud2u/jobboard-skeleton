<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Account informations') }}
		</x-front.space-title>

		<div class="flex justify-end gap-x-2">
			<a href="{{ route('admin.log-as-user', ['user' => $moderation->model->slug]) }}" class="text-white inline-block">
				<button type="button" title="{{ __('Log as the user') }}" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
					</svg>
				</button>
			</a>
		</div>
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="name" :value="__('Firstname')" />
			</div>

			<p>
				{{ $moderation->model->firstname }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="name" :value="__('Lastname')" />
			</div>

			<p>
				{{ $moderation->model->lastname }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="email" :value="__('Email')" />
			</div>

			<p>
				{{ $moderation->model->email }}
			</p>
		</div>
	</div>
</div>

<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Profile informations') }}
		</x-front.space-title>

		@if($moderation->model->hasRole(['professionnal', 'professionnal_breeder']))
			<div class="flex justify-end gap-x-2">
				<a href="https://www.pappers.fr" target="_blank">
					<x-front.primary-button>
						Pappers.fr
					</x-front.primary-button>
				</a>

				<a href="https://api-avis-situation-sirene.insee.fr/identification/pdf/{{ $moderation->model->values->get('siret') }}" target="_blank">
					<x-front.primary-button>
						{{ __('Check the current SIRET') }}
					</x-front.primary-button>
				</a>

				@if(data_get($moderation->model->values, 'for_moderation.siret'))
					<a href="https://api-avis-situation-sirene.insee.fr/identification/pdf/{{ $moderation->model->values->get('for_moderation.siret') }}" target="_blank">
						<x-front.primary-button>
							{{ __('Check the new SIRET') }}
						</x-front.primary-button>
					</a>
				@endif
			</div>
		@endif
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="role" :value="__('Role')" />
			</div>

			<p>{{ ucfirst(__($moderation->model->roles()->first()->name)) }}</p>
		</div>

		@if($moderation->model->hasRole(['adopter', 'breeder', 'professionnal_breeder', 'individual_breeder']))
			<div>
				<div class="flex flex-row">
					@php
						if($moderation->model->hasRole('applicant')) $interest = __('Interested in');
						elseif($moderation->model->hasRole('recruiter')) $interest = __('Company');
					@endphp

					<x-front.input-label for="name" :value="$interest" />
				</div>

				<p>
					@if($moderation->model->hasRole('applicant'))
						@if($moderation->model->values->get('interested_in') === 'both')
							{{ __('the dogs and the cats') }}
						@else
							{{ __('the '.$moderation->model->values->get('interested_in')) }}
						@endif
					@elseif($moderation->model->hasRole('recruiter'))
						@if($moderation->model->values->get('interested_in') === 'both')
							{{ __('breeder the dogs and the cats') }}
						@else
							{{ __('breeder '.$moderation->model->values->get('interested_in')) }}
						@endif
					@endif
				</p>
			</div>
		@endif

		@if($moderation->model->hasRole(['professionnal_breeder', 'individual_breeder', 'professionnal']))
			@if($moderation->model->hasRole(['professionnal', 'professionnal_breeder']))
				<div>
					<div class="flex flex-row">
						<x-front.input-label for="siret" :value="__('Siret')" />
					</div>

					@if(data_get($moderation->model->values, 'for_moderation.siret'))
						<div class="flex flex-row">
							{{ __('Previous value') }} : {{ $moderation->model->values->get('siret') }}
						</div>

						<div class="flex flex-row">
							{{ __('New value') }} : {{ data_get($moderation->model->values, 'for_moderation.siret') }}
						</div>
					@else
						<p>
							{{ $moderation->model->values->get('siret') }}
						</p>
					@endif
				</div>

				<div>
					<div class="flex flex-row">
						<x-front.input-label for="company_name" :value="__('Company name or business name')" />
					</div>

					@if(data_get($moderation->model->values, 'for_moderation.company_name'))
						<div class="flex flex-row">
							{{ __('Previous value') }} : {{ $moderation->model->values->get('company_name') }}
						</div>

						<div class="flex flex-row">
							{{ __('New value') }} : {{ data_get($moderation->model->values, 'for_moderation.company_name') }}
						</div>
					@else
						<p>
							{{ $moderation->model->values->get('company_name') }}
						</p>
					@endif
				</div>
			@endif

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="phone" :value="__('Phone')" />
				</div>

				<p>
					{{ $moderation->model->phone }}
				</p>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="address" :value="__('Address')" />
				</div>

				<p>
					{{ $moderation->model->displayFullAddress() }}
				</p>
			</div>

			@if($moderation->model->values->has('identity_card') && filled($moderation->model->values->get('identity_card')))
				<div>
					<div class="flex flex-row">
						<x-front.input-label for="identity_card" :value="__('Identity card')" />
					</div>

					<p>
						@if(($path = $moderation->model->values->get('identity_card')) && Storage::disk('private')->exists($path))
							<a href="{{ route('admin.documents.show', ['filename' => $moderation->model->values->get('identity_card')]) }}" target="_blank" class="text-jobboard-deepblue underline">
								{{ __('Show the identity card') }}
							</a>
						@else
							{{ __('The document has already been checked in a previous moderation') }}
						@endif
					</p>
				</div>
			@endif

			@if($moderation->model->hasRole(['professionnal_breeder', 'individual_breeder', 'professionnal']))
				@if($moderation->model->hasRole(['professionnal', 'professionnal_breeder']))
					@if($moderation->model->values->has('siren_document') && filled($moderation->model->values->get('siren_document')))
						<div>
							<div class="flex flex-row">
								<x-front.input-label for="siren_document" :value="__('Siren document or Kbis')" />
							</div>

							<p>
								@if(($path = $moderation->model->values->get('siren_document')) && Storage::disk('private')->exists($path))
									<a href="{{ route('admin.documents.show', ['filename' => $moderation->model->values->get('siren_document')]) }}" target="_blank" class="text-jobboard-deepblue underline">
										{{ __('Show the Siren document or Kbis') }}
									</a>
								@else
									{{ __('The document has already been checked in a previous moderation') }}
								@endif
							</p>
						</div>
					@endif
				@endif

				@if($moderation->model->values->has('home_document') && filled($moderation->model->values->get('home_document')))
					<div>
						<div class="flex flex-row">
							<x-front.input-label for="home_document" :value="__('Home document')" />
						</div>

						<p>
							@if(($path = $moderation->model->values->get('home_document')) && Storage::disk('private')->exists($path))
								<a href="{{ route('admin.documents.show', ['filename' => $moderation->model->values->get('home_document')]) }}" target="_blank" class="text-jobboard-deepblue underline">
									{{ __('Show the home document') }}
								</a>
							@else
								{{ __('The document has already been checked in a previous moderation') }}
							@endif
						</p>
					</div>
				@endif

				@if($moderation->model->hasRole('professionnal_breeder'))
					@if($moderation->model->values->get('interested_in') == 'both' || $moderation->model->values->get('interested_in') == 'dogs')
						@if(data_get($moderation->model->values, 'acaced_certificates.dogs'))
							<div>
								<div class="flex flex-row">
									<x-front.input-label for="acaced_certificates_dogs" :value="__('Dog training certificate')" />
								</div>

								<p>
									@if(($path = data_get($moderation->model->values, 'acaced_certificates.dogs')) && Storage::disk('private')->exists($path))
										<a href="{{ route('admin.documents.show', ['filename' => data_get($moderation->model->values, 'acaced_certificates.dogs')]) }}" target="_blank" class="text-jobboard-deepblue underline">
											{{ __('Show the dog training certificate') }}
										</a>
									@else
										{{ __('The document has already been checked in a previous moderation') }}
									@endif
								</p>
							</div>
						@endif

						@if(data_get($moderation->model->values, 'end_dates_acaced.dogs'))
							<div>
								<div class="flex flex-row">
									<x-front.input-label for="end_dates_acaced_dogs" :value="__('Dog training certificate end date')" />
								</div>

								<p>
									{{ Carbon::parse(data_get($moderation->model->values, 'end_dates_acaced.dogs'))->format('d/m/Y') }}
								</p>
							</div>
						@endif
					@endif

					@if($moderation->model->values->get('interested_in') == 'both' || $moderation->model->values->get('interested_in') == 'cats')
						@if(data_get($moderation->model->values, 'acaced_certificates.cats'))
							<div>
								<div class="flex flex-row">
									<x-front.input-label for="acaced_certificates_cats" :value="__('Cat ACACED certificate')" />
								</div>

								<p>
									@if(($path = data_get($moderation->model->values, 'acaced_certificates.cats')) && Storage::disk('private')->exists($path))
										<a href="{{ route('admin.documents.show', ['filename' => data_get($moderation->model->values, 'acaced_certificates.cats')]) }}" target="_blank" class="text-jobboard-deepblue underline">
											{{ __('Show the cat training certificate') }}
										</a>
									@else
										{{ __('The document has already been checked in a previous moderation') }}
									@endif
								</p>
							</div>
						@endif

						@if(data_get($moderation->model->values, 'end_dates_acaced.cats'))
							<div>
								<div class="flex flex-row">
									<x-front.input-label for="end_dates_acaced_cats" :value="__('Cat ACACED certificate end date')" />
								</div>

								<p>
									{{ Carbon::parse(data_get($moderation->model->values, 'end_dates_acaced.cats'))->format('d/m/Y') }}
								</p>
							</div>
						@endif
					@endif
				@endif

				@if($moderation->model->hasRole('recruiter'))
					@foreach($moderation->model->values->get('agreement_EOL') as $key => $agreement)
						@if($moderation->model->values->get('interested_in') == 'both' || $moderation->model->values->get('interested_in') == $key)
							<div>
								<div class="flex flex-row">
									<x-front.input-label for="{{ $key.'_agreement' }}" :value="__('Eleveur Online '.$key.' agreement')" />
								</div>

								<p>
									@if($agreement)
										{{ __('Agreement signed') }}
									@else
										{{ __('Agreement not signed') }}
									@endif
								</p>
							</div>
						@endif
					@endforeach
				@endif
			@endif
		@endif
	</div>
</div>
