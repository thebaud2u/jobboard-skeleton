<div>
	@if($button)
		@if(Auth::guard('web')->check())
			<x-front.primary-button type="button" wire:click="saveSearch" :class="'flex justify-center gap-2 lg:w-full px-4 py-1 bg-breeder-orange text-breeder-deepblue hover:!bg-breeder-darkorange hover:!text-breeder-deepbluehover text-sm'">
				<svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5.91322 16.643C5.88515 17.8437 6.81017 18.8201 7.97577 18.8201C9.14138 18.8201 10.1121 17.8437 10.1401 16.643M15.2208 15.4555L14.3 14.0238C13.7376 13.153 13.448 12.1172 13.4728 11.055L13.5256 8.79875C13.5845 6.27857 11.9818 4.15422 9.74883 3.51428L9.77922 2.21461C9.7982 1.40314 9.17943 0.749999 8.39169 0.749999C7.60394 0.749999 6.95463 1.40314 6.93566 2.21461L6.90527 3.51428C4.64236 4.15423 2.94035 6.27857 2.88142 8.79875L2.82867 11.055C2.80383 12.1172 2.4658 13.153 1.86263 14.0238L0.8749 15.4555C0.563403 15.9041 0.862874 16.5176 1.39444 16.5176L14.6516 16.5176C15.1831 16.5176 15.5049 15.9041 15.2208 15.4555Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"/>
				</svg>

				<span>
					{{ __('Save my search') }}
				</span>
			</x-front.primary-button>
		@else
			<a href="{{ route('login') }}">
				<x-front.primary-button type="button" :class="'flex justify-center gap-2 lg:w-full px-4 py-1 bg-breeder-orange text-breeder-deepblue hover:!bg-breeder-darkorange hover:!text-breeder-deepbluehover text-sm'">
					<svg class="size-5 xl:size-6" viewBox="0 0 19 18" stroke="currentColor" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M15.4978 17H3.50136C2.39669 17 1.50195 16.105 1.50195 15V3C1.50195 1.895 2.39669 1 3.50136 1H12.6712C13.201 1 13.7109 1.21001 14.0858 1.58501L16.9124 4.41251C17.2873 4.78751 17.4972 5.2975 17.4972 5.8275V15C17.4972 16.105 16.6025 17 15.4978 17Z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M13.4976 1.17999V6C13.4976 7.105 12.6029 8 11.4982 8H7.49941C6.39474 8 5.5 7.105 5.5 6V1" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M5.5 17V15C5.5 13.895 6.39474 13 7.49941 13H11.4982C12.6029 13 13.4976 13.895 13.4976 15V17" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					<span>
						{{ __('Save my search') }}
					</span>
				</x-front.primary-button>
			</a>
		@endif
	@elseif($banner)
		@if(Auth::guard('web')->check())
			<div class="rounded-xl flex flex-col items-center bg-breeder-orange p-6">
				<svg width="58" height="53" viewBox="0 0 58 53" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M31.4877 44.5228C32.8855 47.3155 36.2898 48.4516 39.0784 47.0559C41.8671 45.6603 42.9981 42.2542 41.6004 39.4615M52.3067 30.6491L48.3572 28.4618C45.9491 27.1342 43.9925 25.1008 42.7561 22.6302L40.1295 17.3822C37.1957 11.5205 30.7697 8.55789 24.6466 9.76111L23.1336 6.73816C22.189 4.85073 19.9118 4.09077 18.0271 5.03401C16.1425 5.97725 15.3859 8.25559 16.3306 10.143L17.8435 13.166C13.2104 17.3461 11.7302 24.2657 14.664 30.1275L17.2906 35.3755C18.527 37.846 18.982 40.6309 18.6014 43.3543L17.985 47.8268C17.7871 49.2307 19.2521 50.282 20.5239 49.6455L52.2408 33.7714C53.5126 33.135 53.5338 31.3398 52.3067 30.6491Z" stroke="#0E1954" stroke-width="3.5" stroke-miterlimit="10"/>
				</svg>

				<div class="font-bold sm:text-[28px] text-center max-sm:mb-4 max-sm:mt-2">
					{{ __('Aucun chien ne correspond à votre recherche ?') }}
				</div>

				<div class="text-xl mb-6 max-sm:hidden">
					{{ __('Créez une alerte pour ne rien louper !') }}
				</div>

				<div>
					<x-front.primary-button type="button" wire:click="saveSearch" :class="'flex justify-center gap-2 lg:w-full px-4 py-1 bg-breeder-deepblue text-white hover:bg-breeder-deepblue hover:text-white xl:text-sm'">
						<span>
							{{ __('Create an alert') }}
						</span>

						<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.86328 0.75L7.31783 5.75L1.86328 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</x-front.primary-button>
				</div>
			</div>
		@else
			<a href="{{ route('login') }}" class="rounded-xl flex flex-col items-center bg-breeder-orange p-6">
				<svg width="58" height="53" viewBox="0 0 58 53" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M31.4877 44.5228C32.8855 47.3155 36.2898 48.4516 39.0784 47.0559C41.8671 45.6603 42.9981 42.2542 41.6004 39.4615M52.3067 30.6491L48.3572 28.4618C45.9491 27.1342 43.9925 25.1008 42.7561 22.6302L40.1295 17.3822C37.1957 11.5205 30.7697 8.55789 24.6466 9.76111L23.1336 6.73816C22.189 4.85073 19.9118 4.09077 18.0271 5.03401C16.1425 5.97725 15.3859 8.25559 16.3306 10.143L17.8435 13.166C13.2104 17.3461 11.7302 24.2657 14.664 30.1275L17.2906 35.3755C18.527 37.846 18.982 40.6309 18.6014 43.3543L17.985 47.8268C17.7871 49.2307 19.2521 50.282 20.5239 49.6455L52.2408 33.7714C53.5126 33.135 53.5338 31.3398 52.3067 30.6491Z" stroke="#0E1954" stroke-width="3.5" stroke-miterlimit="10"/>
				</svg>
				<div class="font-bold sm:text-[28px] text-center max-sm:mb-4 max-sm:mt-2">
					{{ __('Aucun chien ne correspond à votre recherche ?') }}
				</div>
				<div class="text-xl mb-6 max-sm:hidden">
					{{ __('Créez une alerte pour ne rien louper !') }}
				</div>
				<div>
					<x-front.primary-button type="button" :class="'flex justify-center gap-2 lg:w-full px-4 py-1 bg-breeder-deepblue text-white hover:bg-breeder-deepblue hover:text-white text-sm'">
						<span>
							{{ __('Create an alert') }}
						</span>

						<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.86328 0.75L7.31783 5.75L1.86328 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</x-front.primary-button>
				</div>
			</a>
		@endif
	@endif
</div>