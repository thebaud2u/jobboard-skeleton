<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}">
	<article class="cursor-pointer rounded-xl w-[287px] h-[376px]">
		<div class="relative  sm:flex-none flex justify-end items-stretch w-full rounded-t-xl bg-[#F8F8F8] h-[220px]">
			@if($photo = $company->getFirstMedia('photos'))
				<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="object-cover w-full brightness-75 rounded-t-xl" />
			@else
				<img src="{{ asset('storage/litter-yet-to-come-for-dogs.png') }}" class="object-cover w-full brightness-75 rounded-t-xl" />
			@endif

			<div class="absolute w-fit mt-2 pr-2">
				<div class="flex flex-row gap-2 items-center">
					@if($company->hasPureBreedBreeders())
						@if($company->address->country->code == 'FRA')
							@php
								$pureBreedTypes = $company->getTypeOfPureBreedBreeders();
							@endphp

							@if($pureBreedTypes['LOOF'])
								<span class="px-3 py-1 rounded-md font-medium bg-breeder-green text-breeder-deepblue text-sm w-fit">
									LOOF
								</span>
							@endif

							@if($pureBreedTypes['LOF'])
								<span class="px-3 py-1 rounded-md font-medium bg-breeder-coral text-breeder-deepblue text-sm w-fit">
									LOF
								</span>
							@endif
						@else
							{{ __('Origin book') }}
						@endif
					@endif
				</div>
			</div>

			<div class="absolute left-0 bottom-[10px] text-white font-bold">
				<div class="flex flex-row w-[190px] pl-4">
					{{ __('Company :company', ['company' => $company->name]) }}
				</div>
			</div>

			@if($company->getFirstMedia('logo'))
				<img src="{{ $company->getFirstMedia('logo')->getAvailableUrl(['optimized']) }}" class="absolute right-0 -bottom-4 -mt-4 object-cover w-[100px] h-[100px] rounded-full mr-2" />
			@endif
		</div>

		<div class="flex flex-col gap-4 p-4 bg-breeder-cream rounded-b-xl text-breeder-deepblue text-sm font-medium h-[156px]">
			<div class="flex flex-col">
				<div class="mb-2">

				</div>
				{{ __('Breeders of:')}}
				@php
					$breeds = $company->breeds;
					$count = $breeds->count();
				@endphp
				@foreach ($breeds as $breed)
					@if($loop->iteration < 3)
						<span class="font-bold">
							{{ Str::limit($breed->name, 28) }}
						</span>
					@else
						<span class="font-bold">...</span>
						@break
					@endif
				@endforeach
			</div>

			{{ $company->displayPartOfAddress('department+department_code') }}
		</div>
	</article>
</a>
