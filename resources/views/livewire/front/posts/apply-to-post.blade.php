<div x-data="">
	<button wire:click="$dispatch('open-modal', 'apply');">
		{{ __('Apply to the post') }}
	</button>

	<x-front.modal name="apply" :class="'w-full max-w-2xl'" focusable>
		<section class="p-0">
			<header class="flex flex-col mb-4">
				@elseif($step == 1)
					<div class="font-bold text-[25px] md:text-[40px] text-left">
						{{ __('Application') }}
					</div>
				@else
					<div class="font-medium text-[28px] text-left">
						{!! __('<strong>Your message has been successfully sent !</strong>') !!}
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

					<div class="flex flex-row w-full">
						<x-front.input-label for="message" :value="__('Your message')" :class="'pl-4'" :required="true" />

						<textarea id="message" rows="5" wire:model="message" placeholder="{{ __('Your message') }}" maxlength="1000" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 block w-full"></textarea>

						@error('message')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
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
					<div class="flex text-bold w-full text-base">
						{{ __('Your message has been sent') }}
					</div>

					<div class="flex w-full font-medium text-base">
						{!! __('<strong>To track your messages, facilitate future contact</strong> with companies and <strong>benefit from many other advantages</strong> of :siteName, create your account !', ['siteName' => env('APP_NAME')]) !!}
					</div>

					@script
						<script>
							window.dataLayer = window.dataLayer || [];
							window.dataLayer.push({
								event: 'application_made',
								post_slug: {!! json_encode($post->slug) !!}
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
					<x-front.primary-button wire:click="apply" :class="'flex flex-row gap-x-1 justify-center items-center w-full'">
						{{ __('Apply') }}

						<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</x-front.primary-button>
				@endif
			</div>
		</section>
	</x-front.modal>
</div>