<div class="w-full flex justify-center max-md:mt-12">
	<div class="max-w-[1200px] {{ $displayCompany }} max-md:w-full max-md:mx-0">
		<div class="md:p-3 lg:bg-white rounded-xl max-sm:w-full">
			<div class="flex flex-col gap-8 md:gap-4 sm:max-w-[60%] sm:mx-auto lg:mx-0 lg:max-w-none lg:flex-row max-lg:w-full lg:items-center max-md:justify-between">
				<div class="bg-white lg:flex-1 rounded-full lg:rounded-none px-2 py-1 max-md:py-2 lg:p-0 text-breeder-deepblue w-full lg:border-r lg:pr-4 border-breeder-greige max-md:border max-md:rounded-md max-md:focus-within:border-breeder-deepblue">
					<div x-data="{ open: false }" x-on:click.outside="open=false" x-on:close.stop="open=false" class="flex items-center">
						<svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 2.25C5.74594 2.25 2.5 5.49594 2.5 9.5C2.5 13.5041 5.74594 16.75 9.75 16.75C13.7541 16.75 17 13.5041 17 9.5C17 5.49594 13.7541 2.25 9.75 2.25ZM1 9.5C1 4.66751 4.91751 0.75 9.75 0.75C14.5825 0.75 18.5 4.66751 18.5 9.5C18.5 14.3325 14.5825 18.25 9.75 18.25C4.91751 18.25 1 14.3325 1 9.5Z" fill="#0E1954"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.2197 14.9697C15.5126 14.6768 15.9874 14.6768 16.2803 14.9697L22.2803 20.9697C22.5732 21.2626 22.5732 21.7374 22.2803 22.0303C21.9874 22.3232 21.5126 22.3232 21.2197 22.0303L15.2197 16.0303C14.9268 15.7374 14.9268 15.2626 15.2197 14.9697Z" fill="#0E1954"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 2.25C5.74594 2.25 2.5 5.49594 2.5 9.5C2.5 13.5041 5.74594 16.75 9.75 16.75C13.7541 16.75 17 13.5041 17 9.5C17 5.49594 13.7541 2.25 9.75 2.25ZM1 9.5C1 4.66751 4.91751 0.75 9.75 0.75C14.5825 0.75 18.5 4.66751 18.5 9.5C18.5 14.3325 14.5825 18.25 9.75 18.25C4.91751 18.25 1 14.3325 1 9.5Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.2197 14.9697C15.5126 14.6768 15.9874 14.6768 16.2803 14.9697L22.2803 20.9697C22.5732 21.2626 22.5732 21.7374 22.2803 22.0303C21.9874 22.3232 21.5126 22.3232 21.2197 22.0303L15.2197 16.0303C14.9268 15.7374 14.9268 15.2626 15.2197 14.9697Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						<input type="text" name="keyword" wire:model="filters.company_keyword" @if(!$withRedirect) wire:keydown.debounce.500ms="search" @endif wire:keydown.enter="search" placeholder="{{ __('Keywords') }}" x-on:click="open=!open" class="block w-full p-2 text-breeder-deepblue placeholder:text-breeder-deepblue text-sm bg-transparent border-none focus:ring-0 focus:outline-none cursor-pointer" />

						<div class="absolute z-50 mt-1 w-48 min-w-full rounded-b-md origin-top-right left-0" style="display:none" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"></div>
					</div>
				</div>

				<div class="relative inline-flex items-center bg-white rounded-full lg:flex-2 px-2 py-1 max-md:py-2 lg:p-0 lg:rounded-none text-breeder-deepblue lg:border-r lg:pl-4 border-breeder-greige lg:w-[298px] max-md:border max-md:rounded-md max-md:focus-within:border-breeder-deepblue" x-data="{autocomplete:@entangle('autocomplete').live}">
					<div class="flex justify-between items-center min-w-[250px] pr-4 w-full cursor-pointer" @click="autocomplete = !autocomplete">
						<div class="flex gap-x-2 items-center text-sm">
							<svg class="shrink-0" width="30" height="27" viewBox="0 0 30 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.9629 9.90039C14.9613 9.90036 14.939 9.90081 14.9043 9.90137C14.8672 9.90196 14.8144 9.90277 14.748 9.90625C14.6152 9.91321 14.4271 9.92883 14.1992 9.96094C13.7441 10.0251 13.1257 10.1577 12.4688 10.4336C11.149 10.9879 9.67365 12.1206 9.05664 14.4062C8.47873 16.547 7.37119 17.7135 6.36328 18.7725C5.81276 19.3509 5.26718 19.9216 4.91992 20.5889C4.56505 21.2709 4.41947 22.0473 4.63867 23.0312C4.87599 24.0948 5.42417 24.9097 6.28125 25.4531C7.1311 25.9919 8.26295 26.25 9.64941 26.25C10.2595 26.25 10.9215 26.2 11.6348 26.1006C13.8494 25.7932 16.0949 25.7933 18.3096 26.1006C20.2851 26.3751 21.8811 26.2739 23.0635 25.7676C24.2615 25.2544 25.0162 24.333 25.3066 23.0312C25.5272 22.0412 25.3823 21.2597 25.0283 20.5723C24.6816 19.8991 24.1357 19.3223 23.585 18.7373C22.5894 17.6804 21.4943 16.5145 20.8857 14.3975C20.2309 12.1175 18.7569 10.9879 17.4443 10.4346C16.7911 10.1592 16.1784 10.0262 15.7266 9.96191C15.313 9.90308 15.0024 9.90004 14.9834 9.90137L14.9736 9.90039H14.9629ZM14.9639 11.0986L14.9707 11.0977C15.0407 11.0954 15.9689 11.0832 17.0068 11.5332C18.0348 11.9789 19.1752 12.879 19.7041 14.7207C20.3935 17.1204 21.6776 18.4811 22.6826 19.5479C23.2188 20.1173 23.6486 20.576 23.9111 21.0732C24.1649 21.5538 24.2634 22.076 24.1074 22.7764C23.8959 23.7248 23.3547 24.3626 22.4531 24.7188C21.5324 25.0823 20.2213 25.1566 18.4814 24.915L18.0439 24.8584C17.2261 24.7592 16.4047 24.7003 15.583 24.6807L15.5928 24.6719H14.9727C13.7999 24.6719 12.6276 24.7532 11.4629 24.915C9.72242 25.1569 8.41171 25.0815 7.49121 24.7178C6.58959 24.3615 6.04847 23.7238 5.83691 22.7754L5.79102 22.5244C5.71017 21.9558 5.81365 21.5098 6.03516 21.0947C6.29732 20.6036 6.72561 20.1502 7.26074 19.5879C8.27978 18.5168 9.58286 17.1497 10.2412 14.7119C10.7368 12.8757 11.8767 11.9782 12.9111 11.5332C13.9549 11.0843 14.8945 11.096 14.9561 11.0977L14.9639 11.0986ZM25.8877 9.01465C24.9356 9.01478 24.0899 9.52218 23.4902 10.3057C22.8906 11.0891 22.5264 12.1601 22.5264 13.3311C22.5264 14.5019 22.8907 15.5728 23.4902 16.3564C24.0899 17.1401 24.9356 17.6473 25.8877 17.6475C26.8402 17.6475 27.6865 17.141 28.2861 16.3574C28.8857 15.5739 29.25 14.5023 29.25 13.3311C29.25 12.1599 28.8856 11.089 28.2861 10.3057C27.6864 9.52214 26.8399 9.01465 25.8877 9.01465ZM4.1123 9.01465C3.16006 9.01465 2.3136 9.52208 1.71387 10.3057C1.11431 11.0891 0.75 12.1601 0.75 13.3311C0.750017 14.5019 1.11438 15.5729 1.71387 16.3564C2.31358 17.1402 3.16002 17.6475 4.1123 17.6475C5.06458 17.6473 5.9102 17.1408 6.50977 16.3574C7.1093 15.5739 7.47362 14.5023 7.47363 13.3311C7.47363 12.1598 7.10931 11.089 6.50977 10.3057C5.91009 9.52225 5.06437 9.01478 4.1123 9.01465ZM25.8877 10.2119C26.4426 10.2119 26.9716 10.5309 27.3711 11.0947C27.77 11.6578 28.0244 12.4482 28.0244 13.3311C28.0244 14.214 27.77 15.0043 27.3711 15.5674C26.9717 16.1312 26.443 16.4492 25.8877 16.4492C25.3326 16.4491 24.8046 16.131 24.4053 15.5674C24.0064 15.0043 23.751 14.214 23.751 13.3311C23.751 12.4481 24.0064 11.6578 24.4053 11.0947C24.8046 10.5311 25.3325 10.2121 25.8877 10.2119ZM4.1123 10.2119C4.66707 10.2121 5.19528 10.531 5.59473 11.0947C5.99369 11.6578 6.24902 12.4482 6.24902 13.3311C6.24901 14.214 5.99363 15.0043 5.59473 15.5674C5.1954 16.131 4.66743 16.4491 4.1123 16.4492C3.55701 16.4492 3.02833 16.1312 2.62891 15.5674C2.23 15.0043 1.9756 14.214 1.97559 13.3311C1.97559 12.4482 2.23004 11.6578 2.62891 11.0947C3.02833 10.5309 3.55701 10.2119 4.1123 10.2119ZM19.9111 0.75C18.9591 0.750172 18.1133 1.25746 17.5137 2.04102C16.9142 2.8245 16.5498 3.8953 16.5498 5.06641C16.5498 6.23775 16.914 7.30922 17.5137 8.09277C18.1133 8.87629 18.9591 9.38264 19.9111 9.38281H20.1611V9.36914C21.0115 9.2892 21.7636 8.80632 22.3105 8.0918C22.9102 7.30826 23.2744 6.23663 23.2744 5.06543C23.2743 3.89422 22.9093 2.82332 22.3096 2.04004C21.7096 1.25663 20.8633 0.75 19.9111 0.75ZM10.0889 0.75C9.13627 0.75 8.2901 1.2573 7.69043 2.04102C7.091 2.82453 6.7266 3.89526 6.72656 5.06641C6.72656 6.23775 7.09079 7.30922 7.69043 8.09277C8.29016 8.87642 9.13664 9.38281 10.0889 9.38281H10.3389V9.36914C11.1888 9.28892 11.9398 8.80604 12.4863 8.0918C13.0859 7.30823 13.4502 6.23674 13.4502 5.06543C13.4501 3.89428 13.0858 2.82335 12.4863 2.04004C11.8868 1.25671 11.0412 0.750172 10.0889 0.75ZM19.9111 1.94824C20.4664 1.94824 20.9951 2.26634 21.3945 2.83008C21.7934 3.39313 22.0478 4.18351 22.0479 5.06641C22.0479 5.94931 21.7934 6.73966 21.3945 7.30273C20.9951 7.86653 20.4664 8.18555 19.9111 8.18555C19.356 8.18536 18.828 7.86637 18.4287 7.30273C18.0298 6.73966 17.7754 5.94931 17.7754 5.06641C17.7754 4.18351 18.0298 3.39313 18.4287 2.83008C18.828 2.26651 19.356 1.94843 19.9111 1.94824ZM10.0889 1.94824C10.6436 1.94843 11.1719 2.2664 11.5713 2.83008C11.9703 3.39314 12.2246 4.18355 12.2246 5.06641C12.2246 5.94931 11.9702 6.73966 11.5713 7.30273C11.172 7.86637 10.644 8.18536 10.0889 8.18555C9.53357 8.18555 9.00489 7.86653 8.60547 7.30273C8.2066 6.73966 7.95215 5.94931 7.95215 5.06641C7.95218 4.18351 8.20658 3.39313 8.60547 2.83008C9.00489 2.26634 9.5336 1.94824 10.0889 1.94824Z" fill="#0E1954" stroke="#0E1954" stroke-width="0.5"/>
							</svg>
						</div>

						<svg class="cursor-pointer shrink-0" x-show="autocomplete == false"  width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1.5L9 9.5L17 1.5" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						<svg class="cursor-pointer shrink-0 transform rotate-180" x-show="autocomplete == true" width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1.5L9 9.5L17 1.5" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>

					{{--
					<livewire:autocomplete
						:type="''"
						:model="$filters['']"
						:searchValue="$->exists ? $->name.' '.__('or of appearance') : ''"
						:placeholder="__('Search among breeds')"
						:fieldId="'.id'"
						:fieldValue="'.name'"
						:key="'-autocomplete'" />
					--}}
				</div>

				<div class="bg-white rounded-full lg:flex-1 px-2 py-1 max-md:py-2 lg:p-0 lg:shadow-none lg:rounded-none text-breeder-deepblue max-md:border max-md:rounded-md max-md:focus-within:border-breeder-deepblue">
					<div class="relative" x-data="{
							open: false,
							loc: ''
						}" x-on:click.outside="open=false" x-on:close.stop="open=false">
						<div class="absolute inset-y-0 flex items-center pointer-events-none text-breeder-deepblue">
							<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M16.3864 19.25C22.1477 19.5455 26.5 20.9318 26.5 22.5909C26.5 24.4773 20.9091 26 14 26C7.09091 26 1.5 24.4773 1.5 22.5909C1.5 20.9318 5.85227 19.5455 11.6136 19.25M21.9545 9.36364C21.9545 15.0114 14 21.4545 14 21.4545C14 21.4545 6.04545 15.0114 6.04545 9.36364C6.04545 3.71591 9.60227 1 14 1C18.3977 1 21.9545 3.71591 21.9545 9.36364ZM17.9773 8.38636C17.9773 10.583 16.1966 12.3636 14 12.3636C11.8034 12.3636 10.0227 10.583 10.0227 8.38636C10.0227 6.18978 11.8034 4.40909 14 4.40909C16.1966 4.40909 17.9773 6.18978 17.9773 8.38636Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>

						<input type="text" id="loc" x-bind:value="loc" x-on:click="open=!open" readonly placeholder="{{ __('Location') }}" class="block w-full p-1.5 pl-8 text-breeder-deepblue placeholder:text-breeder-deepblue text-sm bg-transparent border border-transparent focus:border-transparent focus:ring-0 rounded-md"/>

						<div x-show="loc !== ''" wire:click="removeLocalisation" x-on:click="loc = '';" class="absolute inset-y-0 right-0 flex items-center cursor-pointer text-red-400">
							<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.97729 17.7352L18.0227 9.68979" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.97729 9.68979L18.0227 17.7352" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>

						<div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" style="display:none" class="absolute z-50 mt-1 w-48 min-w-full rounded-b-md shadow-lg origin-top-right left-0">
							<livewire:localisation-search-engine :hideDistance="false" :savedSearch="$savedSearch" :wire:key="'localisation-search-engine'" />
						</div>
					</div>
				</div>

				@if($withRedirect)
					<div class="inline-flex items-center">
						<x-front.primary-button wire:click="search" :class="'justify-center rounded-full w-full lg:max-w-[195px] px-4'">
							{{ __('Search') }}
						</x-front.primary-button>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
