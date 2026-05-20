<div x-data="">
	<button wire:click="$dispatch('open-modal', 'call');">
		{{ __('Show the company number') }}
	</button>

	<x-front.modal name="call" :class="'w-full max-w-2xl'" focusable>
		<section class="p-0">
			<header class="flex flex-col mb-4">
				@if($step == 1)
					<div class="text-base font-medium">
						{!! __('<strong>To show the company\'s phone number</strong>, please fill out the form :') !!}
					</div>
				@else
					<div class="font-bold text-[25px] md:text-[40px] text-left">
						{{ __('Company number') }}
					</div>
				@endif
			</header>

			<div class="flex flex-col gap-y-3">
				@if($step == 1)
					<!-- Email Address -->
					<div class="flex-row justify-between">
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="email" :value="__('Your email address')" :required="true" />
							</div>

							<x-front.text-input type="email" name="email" id="email" wire:model="email" required placeholder="{{ __('Your email address') }}" :class="'mt-1 block bg-white w-full'" />

							@error('email')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>

						<!-- Phone Number -->
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="phone" :value="__('Your phone number')" :required="true" />
							</div>

							<x-front.text-input type="phone" name="phone" id="phone" wire:model="phone" required placeholder="{{ __('Your phone number') }}" :class="'mt-1 block bg-white w-full'" />

							@error('phone')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>
					</div>

					<div class="flex-row justify-between">
						<!-- Firstname -->
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="firstname" :value="__('Your firstname')" :required="true" />
							</div>

							<x-front.text-input type="text" name="firstname" id="firstname" wire:model="firstname" required placeholder="{{ __('Your firstname') }}" :class="'mt-1 block bg-white w-full'" />

							@error('firstname')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>

						<!-- Lastname -->
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="lastname" :value="__('Your lastname')" :required="true" />
							</div>

							<x-front.text-input type="text" name="lastname" id="lastname" wire:model="lastname" required placeholder="{{ __('Your lastname') }}" :class="'mt-1 block bg-white w-full'" />

							@error('lastname')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>
					</div>

					<div>
						<div class="flex flex-row" x-data="{checked: false}">
							<input type="checkbox" name="consent" wire:model="consent" class="w-4 h-4 mt-2 text-breeder-deepblue bg-gray-100 border-breeder-greige rounded focus:ring-0 focus:ring-offset-0 focus:outline-none cursor-pointer" />
							<x-front.input-label for="consent" :value="__('By submitting this form, I accept that the information entered is used as part of the contact request')" :required="true" :class="'ml-2 cursor-pointer'"/>
						</div>

						<div class="flex flex-row">
							@error('consent')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>
					</div>

					<div class="mt-2">
						<x-front.input-label for="captcha" :value="__('Verification')" :required="true" />

						<div class="captcha my-2 flex flex-row items-end">
							<img src="{{ captcha_src() }}" alt="captcha" onclick="this.src='{{ captcha_src() }}'+Math.random()">
						</div>

						<div class="flex flex-row">
							<x-front.text-input type="text" name="captcha" wire:model="captcha" :class="'mt-1 block w-full s:w-1/2 lg:w-1/4'" required />
						</div>

						@error('captcha')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				@elseif($step == 2)
					<div class="flex flex-col text-lg font-bold w-[261px]">
						<x-front.primary-button :class="'flex flex-row gap-x-1 justify-center w-full items-center !mb-4'"  x-data="{ textToCopy: '{{ $companyNhoneNumber }}', copied: false }" @click="navigator.clipboard.writeText(textToCopy).then(() => { copied = true })">
							{{ $companyNhoneNumber }}

							<svg x-show="!copied" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M3.55 12.55H2.7C2.24913 12.55 1.81673 12.3709 1.49792 12.0521C1.17911 11.7333 1 11.3009 1 10.85V3.2C1 2.74913 1.17911 2.31673 1.49792 1.99792C1.81673 1.67911 2.24913 1.5 2.7 1.5H10.35C10.8009 1.5 11.2333 1.67911 11.5521 1.99792C11.8709 2.31673 12.05 2.74913 12.05 3.2V4.05M8.65 7.45H16.3C17.2389 7.45 18 8.21112 18 9.15V16.8C18 17.7389 17.2389 18.5 16.3 18.5H8.65C7.71112 18.5 6.95 17.7389 6.95 16.8V9.15C6.95 8.21112 7.71112 7.45 8.65 7.45Z" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>

							<svg x-show="copied" width="19" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="transition-opacity duration-200">
								<path d="M5 13L9 17L19 7" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</x-front.primary-button>
					</div>

					@script
						<script>
							window.dataLayer = window.dataLayer || [];
							window.dataLayer.push({
								event: 'company_number_showed',
								company_slug: {!! json_encode($company->slug) !!}
							});
						</script>
					@endscript
				@endif
			</div>

			<div class="flex flex-col mt-4 w-full">
				<x-front.primary-button x-on:click="$dispatch('close');" :class="'flex flex-row gap-x-1 justify-center'">
					{{ __('Close') }}

					<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</x-front.primary-button>

				@if($step == 1)
					<x-front.primary-button wire:click="call" :class="'flex flex-row gap-x-1 justify-center items-center w-full'">
						{{ __('Show the phone number') }}

						<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</x-front.primary-button>
				@endif
			</div>
		</section>
	</x-front.modal>
</div>