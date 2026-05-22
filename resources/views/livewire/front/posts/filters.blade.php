<div class="w-full max-md:h-full max-md:mt-12">
	<div class="max-w-[1200px] {{ $displayPost }} max-md:h-full max-md:mx-0">
		<div class="md:p-3 lg:bg-white rounded-xl max-sm:w-full max-md:h-full">
			<div class="flex flex-col gap-8 md:gap-4 md:w-[680px] sm:mx-auto lg:mx-0 lg:max-w-none lg:flex-row w-full lg:w-full lg:items-center max-md:justify-between">
				<div class="bg-white lg:flex-1 rounded-full lg:rounded-none px-2 py-1 max-md:py-2 lg:p-0 text-jobboard-deepblue w-full lg:border-r lg:pr-4 border-jobboard-greige max-md:border max-md:rounded-md max-md:focus-within:border-jobboard-deepblue">
					<div x-data="{ open: false }" x-on:click.outside="open=false" x-on:close.stop="open=false" class="flex items-center">
						<svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 2.25C5.74594 2.25 2.5 5.49594 2.5 9.5C2.5 13.5041 5.74594 16.75 9.75 16.75C13.7541 16.75 17 13.5041 17 9.5C17 5.49594 13.7541 2.25 9.75 2.25ZM1 9.5C1 4.66751 4.91751 0.75 9.75 0.75C14.5825 0.75 18.5 4.66751 18.5 9.5C18.5 14.3325 14.5825 18.25 9.75 18.25C4.91751 18.25 1 14.3325 1 9.5Z" fill="#0E1954"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.2197 14.9697C15.5126 14.6768 15.9874 14.6768 16.2803 14.9697L22.2803 20.9697C22.5732 21.2626 22.5732 21.7374 22.2803 22.0303C21.9874 22.3232 21.5126 22.3232 21.2197 22.0303L15.2197 16.0303C14.9268 15.7374 14.9268 15.2626 15.2197 14.9697Z" fill="#0E1954"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 2.25C5.74594 2.25 2.5 5.49594 2.5 9.5C2.5 13.5041 5.74594 16.75 9.75 16.75C13.7541 16.75 17 13.5041 17 9.5C17 5.49594 13.7541 2.25 9.75 2.25ZM1 9.5C1 4.66751 4.91751 0.75 9.75 0.75C14.5825 0.75 18.5 4.66751 18.5 9.5C18.5 14.3325 14.5825 18.25 9.75 18.25C4.91751 18.25 1 14.3325 1 9.5Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.2197 14.9697C15.5126 14.6768 15.9874 14.6768 16.2803 14.9697L22.2803 20.9697C22.5732 21.2626 22.5732 21.7374 22.2803 22.0303C21.9874 22.3232 21.5126 22.3232 21.2197 22.0303L15.2197 16.0303C14.9268 15.7374 14.9268 15.2626 15.2197 14.9697Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						<input type="text" name="keyword" wire:model="filters.post_keyword" @if(!$withRedirect) wire:keydown.debounce.500ms="search" @endif wire:keydown.enter="search" placeholder="{{ __('Keywords') }}" x-on:click="open=!open" class="block w-full p-2 text-jobboard-deepblue placeholder:text-jobboard-deepblue text-sm bg-transparent border-none focus:ring-0 focus:outline-none cursor-pointer" />

						<div class="absolute z-50 mt-1 w-48 min-w-full rounded-b-md origin-top-right left-0" style="display:none" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"></div>
					</div>
				</div>

				<div class="relative inline-flex items-center bg-white rounded-full flex-1 px-2 py-2 md:py-1 lg:p-0 lg:rounded-none text-jobboard-deepblue lg:border-r lg:pl-4 border-jobboard-greige lg:max-w-[175px] w-full max-md:border max-md:rounded-md max-md:focus-within:border-jobboard-deepblue">
					<select name="filters.post_type" wire:model="filters.post_type" wire:change="postTypeSelected" class="text-jobboard-deepblue text-sm block border-0 focus:border-0 focus:ring-0 rounded-md w-full">
						<option value="">{{ __('Category') }}</option>

						@foreach($postTypesList as $postTypeList)
							<option value="{{ $postTypeList->getTranslation('slug', 'en') }}" wire:key="filter-post-type-{{ $postTypeList->getTranslation('slug', 'en') }}">
								@if($postTypeList->getTranslation('slug', 'en') == 'litter')
									@if($species->getTranslation('slug', 'en') == 'dog')
										{{ __('Puppy') }}
									@else
										{{ __('Kitty') }}
									@endif
								@elseif($postTypeList->getTranslation('slug', 'en') == 'retired-breeder')
									{{ __('Adult') }}
								@else
									{{ __(ucfirst($postTypeList->name)) }}
								@endif
							</option>
						@endforeach
					</select>
				</div>

				<div class="bg-white rounded-full flex-1 px-2 py-2 md:py-1 lg:p-0 lg:shadow-none lg:rounded-none text-jobboard-deepblue w-full max-md:border max-md:rounded-md max-md:focus-within:border-jobboard-deepblue">
					<div class="relative" x-data="{
							open: false,
							loc: ''
						}" x-on:click.outside="open=false" x-on:close.stop="open=false">
						<div class="absolute inset-y-0 flex items-center pointer-events-none text-jobboard-deepblue">
							<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M16.3864 19.25C22.1477 19.5455 26.5 20.9318 26.5 22.5909C26.5 24.4773 20.9091 26 14 26C7.09091 26 1.5 24.4773 1.5 22.5909C1.5 20.9318 5.85227 19.5455 11.6136 19.25M21.9545 9.36364C21.9545 15.0114 14 21.4545 14 21.4545C14 21.4545 6.04545 15.0114 6.04545 9.36364C6.04545 3.71591 9.60227 1 14 1C18.3977 1 21.9545 3.71591 21.9545 9.36364ZM17.9773 8.38636C17.9773 10.583 16.1966 12.3636 14 12.3636C11.8034 12.3636 10.0227 10.583 10.0227 8.38636C10.0227 6.18978 11.8034 4.40909 14 4.40909C16.1966 4.40909 17.9773 6.18978 17.9773 8.38636Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>

						<input type="text" id="loc" x-bind:value="loc" x-on:click="open=!open" readonly placeholder="{{ __('Location') }}" class="block w-full p-1.5 pl-8 text-jobboard-deepblue placeholder:text-jobboard-deepblue text-sm bg-transparent border border-transparent focus:border-transparent focus:ring-0 rounded-md"/>

						<div x-show="loc !== ''" wire:click="removeLocalisation" x-on:click="loc = '';" class="absolute inset-y-0 right-0 flex items-center cursor-pointer text-red-400">
							<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.97729 17.7352L18.0227 9.68979" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.97729 9.68979L18.0227 17.7352" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>

						<div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" style="display:none" class="absolute z-50 mt-1 w-48 min-w-full rounded-b-md shadow-lg origin-top-right left-0">
							<livewire:localisation-search-engine :hideDistance="false" :key="'localisation-search-engine'" />
						</div>
					</div>
				</div>

				@if($withRedirect)
					<div class="w-full lg:max-w-[163px] inline-flex items-center">
						<x-front.primary-button wire:click="search" @click="searchVisible = false" :class="'justify-center rounded-full w-full lg:max-w-[195px] px-4'">
							{{ __('Search') }}
						</x-front.primary-button>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
