<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}" target="_blank" class="w-full">
	<article class="cursor-pointer rounded-xl w-full min-h-[221px] flex justify-between border border-jobboard-greige text-jobboard-deepblue">
		<div class="py-8 px-6 flex flex-col @if($logo = $company->getFirstMedia('logo')) max-w-[80%] @endif">
			<div class="flex gap-x-2 flex-wrap items-center">
				<div class="font-bold text-[28px]">
					{{ __('Company :company', ['company' => $company->name]) }}
				</div>
			</div>

			<div class="flex gap-4 flex-wrap items-center">
				<div class="flex gap-2 items-center">

				</div>
			</div>

			<div class="flex items-center gap-x-2 font-bold text-sm mt-4">
				<svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15 7.95455C15 12.6527 8 18 8 18C8 18 1 12.6527 1 7.95455C1 3.25636 4.13444 1 8 1C11.8656 1 15 3.25636 15 7.95455Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M7.99978 10.2736C9.718 10.2736 11.1109 8.88977 11.1109 7.18271C11.1109 5.47564 9.718 4.0918 7.99978 4.0918C6.28156 4.0918 4.88867 5.47564 4.88867 7.18271C4.88867 8.88977 6.28156 10.2736 7.99978 10.2736Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				{{ $company->displayPartOfAddress('department+country') }}
			</div>

			<div class="mt-4 text-sm font-medium flex max-w-[810px]">
				{!! Str::limit($company->description, 150) !!}
			</div>
		</div>

		@if($logo = $company->getFirstMedia('logo'))
			<div class="flex w-[103px] h-[103px] max-sm:hidden flex-1 justify-end pt-2 pr-2">
				<img src="{{ $logo->getAvailableUrl(['optimized']) }}" class="object-cover w-[103px] h-[103px] rounded-full" />
			</div>
		@endif
	</article>
</a>
