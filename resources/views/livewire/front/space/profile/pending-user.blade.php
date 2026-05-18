<div>
	<div x-data="{}" x-init="$nextTick(() => { $dispatch('open-modal', 'pending_user') })">
		<x-front.modal name="pending_user" :class="'w-full max-w-[600px]'" :noClose="true" focusable>
			<x-front.form-part-title :class="'mb-6'">
				{{ __('Hello') }} !
			</x-front.form-part-title>

			<div class="flex flex-col max-sm:items-start max-sm:space-y-4 sm:justify-between">
				<div class="flex flex-col gap-y-4">
					<div>
						<div>
							<div class="flex flex-row">
								<div class="pr-2">
									<input type="checkbox" name="pending_done" id="pending_done" wire:model="pending" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
									<x-front.input-label for="pending_done" :value="__('By checking this box, you confirm the creation of your account and accept the general terms of use of Eleveurs-Online.')" :required="true" />
								</div>
							</div>

							@error('pending')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>

						<div class="mt-4">
							<div>
								<div class="flex flex-row">
									<x-front.input-label for="" :value="__('I subscribe to the monthly newsletter of Eleveurs Online')" />
								</div>

								<div class="flex flex-row">
									<div class="pr-2">
										<input type="radio" name="optin_newsletter" value="1" id="optin_newsletter" wire:model="optinNewsletter" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
										<label for="optin_newsletter">
											{{ __('yes') }}
										</label>
									</div>

									<div class="pr-2">
										<input type="radio" name="optin_newsletter" value="0" id="optin_newsletter" wire:model="optinNewsletter" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
										<label for="optin_newsletter">
											{{ __('no') }}
										</label>
									</div>
								</div>
							</div>

							<div>
								<div class="flex flex-row">
									<x-front.input-label for="" :value="__('I would like to receive information from Eleveurs Online and their publishers')" />
								</div>

								<div class="flex flex-row">
									<div class="pr-2">
										<input type="radio" name="optin_receive_info" value="1" id="optin_receive_info" wire:model="optinReceiveInfo" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3"/>
										<label for="optin_receive_info">
											{{ __('yes') }}
										</label>
									</div>

									<div class="pr-2">
										<input type="radio" name="optin_receive_info" value="2" id="optin_receive_info" wire:model="optinReceiveInfo" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3"/>
										<label for="optin_receive_info">
											{{ __('no') }}
										</label>
									</div>
								</div>
							</div>

							<div>
								<div class="flex flex-row">
									<x-front.input-label for="" :value="__('I would like to receive good deals from Eleveurs Online partners')" />
								</div>

								<div class="flex flex-row">
									<div class="pr-2">
										<input type="radio" name="optin_receive_deals" value="1" id="optin_receive_deals" wire:model="optinReceiveDeals" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
										<label for="optin_receive_deals">
											{{ __('yes') }}
										</label>
									</div>

									<div class="pr-2">
										<input type="radio" name="optin_receive_deals" value="2" id="optin_receive_deals" wire:model="optinReceiveDeals" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
										<label for="optin_receive_deals">
											{{ __('no') }}
										</label>
									</div>
								</div>
							</div>

							<div class="mt-4 w-full rounded-xl bg-breeder-cream flex justify-between p-6">
								<div class="flex flex-row items-center">
									<div class="flex flex-col gap-y-2">
										<x-front.input-label for="optin_figo" :class="'cursor-pointer'">
											<input type="checkbox" name="optin_figo" id="optin_figo" checked class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

											<span class="font-bold">
												{{ __('I agree to receive tips, advice, and exclusive offers from Assur O’Poil, the pet health insurance recommended by Éleveurs Online.') }}
											</span>
										</x-front.input-label>

										<span class="text-xs">
											{{ __('The communicated elements will be used only to send me adapted content. I can unsubscribe at any time, with ease.') }}
										</span>
									</div>

									<div class="flex flex-col">
										<svg class="shrink-0" width="28" height="41" viewBox="0 0 28 41" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_6043_57025)">
											<path d="M17.3959 8.97265C15.7287 8.75665 14.6927 6.14545 14.9948 3.81305C15.2963 1.48045 16.8222 0.309653 18.4889 0.525253C20.1561 0.740453 21.3334 2.26085 21.0311 4.59405C20.7291 6.92645 19.0628 9.18825 17.3961 8.97285M5.40795 7.44825C4.44633 5.66385 2.78919 5.22925 1.42959 5.96185C0.0701907 6.69385 -0.476451 8.31685 0.485575 10.1009C1.448 11.8849 3.55533 13.1549 4.91454 12.4225C6.27374 11.6899 6.37058 9.23225 5.40775 7.44825M10.6443 8.97285C12.311 8.75685 13.3475 6.14565 13.0449 3.81325C12.7436 1.48045 11.2177 0.309653 9.55059 0.525253C7.88385 0.740453 6.70653 2.26085 7.00846 4.59405C7.3104 6.92645 8.97713 9.18825 10.6443 8.97285Z" fill="#0E1954"/>
											<path d="M24.1722 15.6906C23.881 15.3628 23.4507 15.1942 23.0143 15.2398C21.8321 15.3636 20.1478 15.4144 19.7226 14.7766C19.4405 14.3536 19.5279 13.894 19.7246 13.5026C19.9449 13.0642 19.7462 12.5282 19.2852 12.3598C17.888 11.8498 16.3313 11.5684 14.6249 11.5684C5.69479 11.5684 0.921875 18.2374 0.921875 26.548C0.921875 33.884 5.69479 40.5016 14.0091 40.5016C22.9392 40.5016 27.7123 33.884 27.7123 25.5734C27.7123 21.8436 26.4782 18.2866 24.1724 15.6906H24.1722ZM14.312 36.276C7.62124 36.2662 5.13614 32.2164 5.14615 25.4528C5.15435 19.827 8.47722 15.7858 14.266 15.7944C20.8817 15.8042 23.4977 19.854 23.4877 26.6808C23.4795 32.2434 20.1758 36.2848 14.312 36.2762V36.276Z" fill="#0E1954"/>
											<path d="M27.3145 11.3811C28.4953 9.13209 28.0997 7.37409 26.5186 6.54509C25.1506 5.82729 23.6207 6.30389 22.9664 7.54989C22.4718 8.49209 22.6455 9.04808 22.8618 9.74328C23.0208 10.2531 22.9336 10.7885 22.6307 11.3657C22.4342 11.7397 22.0764 12.1685 21.6364 12.5635C21.0272 13.1103 21.4351 14.1177 22.2531 14.0819C24.0103 14.0049 26.1916 13.4009 27.3145 11.3811Z" fill="#0E1954"/>
											</g>
											<defs>
											<clipPath id="clip0_6043_57025">
											<rect width="28" height="40" fill="white" transform="translate(0 0.5)"/>
											</clipPath>
											</defs>
										</svg>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="flex s:flex-row flex-col items-center max-s:space-y-5 justify-end mt-10">
				<x-front.primary-button type="button" :class="'ml-4'" wire:click="pendingDone" x-data="" x-on:pending-done.window="$dispatch('close');">
					{{ __('Confirm') }}

					<svg class="ml-4" width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.86035 1.5L7.3149 6.5L1.86035 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</x-front.primary-button>
			</div>
		</x-front.modal>
	</div>
</div>
