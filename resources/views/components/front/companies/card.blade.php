<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}">
	<article class="cursor-pointer rounded-xl w-[287px] h-[376px]">
		<div class="relative  sm:flex-none flex justify-end items-stretch w-full rounded-t-xl bg-[#F8F8F8] h-[220px]">
			@if($photo = $company->getFirstMedia('photos'))
				<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="object-cover w-full brightness-75 rounded-t-xl" />
			@else
				<img src="{{ asset('storage/litter-yet-to-come-for-dogs.png') }}" class="object-cover w-full brightness-75 rounded-t-xl" />
			@endif

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
			{{ $company->displayPartOfAddress('department+department_code') }}
		</div>
	</article>
</a>
