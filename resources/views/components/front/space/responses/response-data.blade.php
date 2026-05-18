<div>
	@if($type == 'animal' || ($type == 'post' && $response->model->type->getTranslation('slug', 'en') != 'stud'))
		<hr class="my-4">	

		<div class="flex flex-col gap-4">
			@if($response->from->phone)
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Phone') }} :
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
						{{ $response->from->phone }}
					</span>
				</div>
			@endif

			@if($response->values->has('animal_experience'))
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Experience :') }}
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
						{{ __(ucfirst($response->values->get('animal_experience'))) }}
					</span>
				</div>
			@endif

			@if($response->values->has('home_animals'))
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Other animals :') }}
					</span>

					<div class="flex flex-row gap-x-2">
						@foreach($response->values->get('home_animals') as $homeAnimal)
							<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
								{{ __(ucfirst($homeAnimal)) }}
							</span>
						@endforeach
					</div>
				</div>
			@endif

			@if($response->values->has('place_configuration'))
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Home :') }}
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
						@switch($response->values->get('place_configuration'))
							@case('house_with_garden')
								{{ __('House with a garden') }}
								@break

							@case('house_without_garden')
								{{ __('House without a garden') }}
								@break

							@default
								{{ __('Flat') }}
						@endswitch
					</span>
				</div>
			@endif

			@if($response->values->has('time_dedication'))
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Availability :') }}
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
						@switch($response->values->get('time_dedication'))
							@case('one_to_two_hours')
								{{ __('Between :x to :y', ['x' => 1, 'y' => '2h']) }}
								@break

							@case('two_to_three_hours')
								{{ __('Between :x to :y', ['x' => 2, 'y' => '3h']) }}
								@break

							@case('more_than_three_hours')
								{{ __('+ than 3h') }}
								@break

							@case('few_time')
								{{ __('I don\'t have much time; I want a dog that requires little or no maintenance.') }}
								@break

							@case('medium_time')
								{{ __('I\'m willing to brush him or take him to the groomer regularly.') }}
								@break

							@case('lot_time')
								{{ __('It takes a lot of time, but I don\'t mind if it requires a lot of maintenance.') }}
								@break

							@default
								{{ __('Mainly during the weekend') }}
						@endswitch
					</span>
				</div>
			@endif

			@if($response->values->has('household_composition'))
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Household :') }}
					</span>

					<div class="flex flex-col gap-1">
						@foreach($response->values->get('household_composition') as $householdComposition)
							<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
								@switch($householdComposition)
									@case('young_children')
										{{ __('Young children (From 0 to 4 years old)') }}
										@break
		
									@case('children')
										{{ __('Children (from 5 to 12 years old)') }}
										@break
		
									@case('teenagers')
										{{ __('Teenagers (+ than 12 years old)') }}
										@break
		
									@default
										{{ __('Partner, spouse, adult') }}
								@endswitch
							</span>
						@endforeach
					</div>
				</div>
			@endif

			@if($response->values->has('gender_preference'))
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Gender preference :') }}
					</span>

					@foreach($response->values->get('gender_preference') as $genderPreference)
						<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
							@switch($genderPreference)
								@case('male')
									{{ __('Male') }}
									@break

								@case('female')
									{{ __('Female') }}
									@break

								@default
									{{ __('None') }}
							@endswitch
						</span>
					@endforeach
				</div>
			@endif

			@if($response->values->has('interest_in_other_animal'))
				<div class="flex flex-row gap-x-1 text-sm">
					<span class="w-[126px] text-sm font-medium shrink-0">
						{{ __('Interested by other animal :') }}
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
						{{ __(ucfirst($response->values->get('interest_in_other_animal'))) }}
					</span>
				</div>
			@endif

			@if($response->values->has('message') && $message->body != $response->values->get('message'))
				<hr class="border border-breeder-greige">

				<div class="flex flex-col gap-y-3 text-sm">
					{{ __('Reminder of the request :') }}

					<p class="text-sm font-medium">
						{{ $response->values->get('message') }}
					</p>
				</div>
			@endif
		</div>
	@else
		<hr class="my-4">
		
		<div class="flex flex-col gap-4">
			@if($response->values->has('pure_breed'))
				<div class="flex flex-row items-center gap-x-1 text-sm">
					<span class="w-[238px] text-sm font-medium shrink-0">
						{{ __('The female is :lof :', ['lof' => $response->model->model->species->getTranslation('slug', 'en') == 'dog' ? 'LOF' : 'LOOF']) }}
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit border border-breeder-greige">
						{{ $response->values->get('pure_breed') ? __('Yes') : __('No') }}
					</span>
				</div>
			@endif

			@if($photo = $response->getFirstMedia('photos'.$response->id))
				<div class="flex flex-row items-center gap-x-1 text-sm">
					<span class="w-[238px] text-sm font-medium shrink-0">
						{{ __('The female\'s photo :') }}
					</span>

					<a href="{{ $photo->getAvailableUrl(['optimized']) }}" target="_blank">
						<div class="w-[74px] h-[74px] bg-white rounded-xl flex justify-center items-center">
							<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="object-cover w-[74px] h-[74px] rounded-xl">
						</div>
					</a>
				</div>
			@endif

			@if($response->values->has('quotation'))
				<div class="flex flex-row items-center gap-x-1 text-sm">
					<span class="w-[238px] text-sm font-medium shrink-0">
						{{ __('Quotation') }} :
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit border border-breeder-greige">
						{{ $response->values->get('quotation') }}
					</span>
				</div>
			@endif

			@if($response->values->has('pedigree'))
				<div class="flex flex-row items-center gap-x-1 text-sm">
					<span class="w-[238px] text-sm font-medium shrink-0">
						{{ __('Pedigree') }} :
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit">
						<a href="{{ route('documents.show', ['filename' => $response->values->get('pedigree')]) }}" download class="text-breeder-deepblue underline">
							<svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.28571 6.27777H11.7143M5.28574 10.5H11.7143M5.28574 14.7222H9.57145M11.8991 20H3.14286C1.95893 20 1 19.0553 1 17.8889V3.11111C1 1.94472 1.95893 1 3.14286 1H13.8571C15.0411 1 16 1.94472 16 3.11111V15.9599C16 16.5193 15.775 17.0576 15.3732 17.4535L13.4152 19.3825C13.0134 19.7783 12.4669 20 11.8991 20Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</a>
					</span>
				</div>
			@endif

			@if($response->values->has('date'))
				<div class="flex flex-row items-center gap-x-1 text-sm">
					<span class="w-[238px] text-sm font-medium shrink-0">
						{{ __('Desired company date :') }}
					</span>

					<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit border border-breeder-greige">
						{{ __(Carbon::parse($response->values->get('date'))->format('d/m/Y')) }}
					</span>
				</div>
			@endif

			@if($response->values->has('message') && $message->body != $response->values->get('message'))
				<hr class="border border-breeder-greige">

				<div class="flex flex-col gap-y-3 text-sm">
					{{ __('Reminder of the request :') }}

					<p class="text-sm font-medium">
						{{ $response->values->get('message') }}
					</p>
				</div>
			@endif
		</div>
	@endif
</div>