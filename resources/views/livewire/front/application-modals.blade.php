<div x-data="{ verifiedForContact: @entangle('hasJustVerifiedEmailForContact'), reloadedForContact: @entangle('loginReloadForContact'), verifiedForCall: @entangle('hasJustVerifiedEmailForCall'), reloadedForCall: @entangle('loginReloadForCall'), }" x-init="$nextTick(()=>{ if(verifiedForContact || reloadedForContact) { $dispatch('open-modal', 'contact'); } if(verifiedForCall || reloadedForCall) $dispatch('open-modal', 'call'); })">
	@if($showModal)
		<x-front.modal name="contact" :class="'w-full max-w-2xl'" focusable>
			<section class="p-0">
				<header class="flex flex-col mb-4">
					@if($stepContact == 1 || $stepContact == 2 || $stepContact == 3 || $stepContact == 5)
						<div class="font-bold @if($stepContact == 4 || $stepContact == 6) text-[28px] @else text-[25px] md:text-[40px] @endif text-left">
							@if($stepContact == 1 || $stepContact == 2 || $stepContact == 3)
								{{ __('Contact the company') }}
							@elseif($stepContact == 5 && $hasJustVerifiedEmailForContact)
								{{ __('Thank you,') }}
							@endif
						</div>
					@elseif($stepContact == 4 || $stepContact == 6)
						<div class="font-medium text-[28px] text-left">
							@if($stepContact == 4)
								{!! __('<strong>To confirm the sending of your message</strong>, confirm your email adress by clicking the link in the email sent to the adresse : :address', ['address' => $contactEmail]) !!}
							@elseif($stepContact == 6)
								{!! __('<strong>Your message has been successfully sent !</strong>') !!}
							@endif
						</div>
					@endif

					@if($stepContact == 3)
						<div class="text-base font-medium">
							{!! __('<strong>To track your messages, facilitate future contact</strong> with breeders and <strong>benefit from all the advantages</strong> of Breeders Online, create your account!') !!}
						</div>
					@endif

					@if($stepContact == 5 && $hasJustVerifiedEmailForContact)
						<h2 class="text-[25px] md:text-[28px] font-bold">
							{{ __('your email adress email is validated !') }}
						</h2>
					@endif
				</header>

				<div class="flex flex-col gap-y-3">
					@if($stepContact == 1 || $stepContact == 2)
						<div class="flex flex-col w-full">
							<x-front.input-label for="message" :value="__('Tell us more about you and why you want to adopt an animal ?')" :class="'pl-4'" :required="true" />

							<textarea id="message" rows="5" wire:model="message" placeholder="{{ __('Your message') }}" maxlength="1000" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 block w-full"></textarea>

							@error('message')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>

						@if(!$user->exists)
							<div class="flex flex-col w-full">
								<x-front.input-label for="contactEmail" :value="__('Your email address')" :class="'pl-4'" :required="true" />

								<x-front.text-input type="email" name="contactEmail" id="contactEmail" wire:model="contactEmail" :disabled="$stepContact > 1" placeholder="{{ __('Email') }}" :class="'mt-1 block bg-white'" />

								@error('contactEmail')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>
						@endif

						@if($stepContact == 2)
							<div class="flex flex-col w-full">
								<x-front.input-label for="contactPassword" :value="__('Password')" :class="'pl-4'" :required="true" />

								<x-front.text-input type="password" name="contactPassword" wire:model="contactPassword" placeholder="{{ __('Your password') }}" :class="'mt-1 block bg-white w-full'" />

								@error('contactPassword')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>
						@endif
					@elseif($stepContact == 3)
						<!-- Gender -->
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="contactGender" :value="__('Gender')" :required="true" />
							</div>

							<div class="flex flex-row my-2">
								<div class="pr-5">
									<input type="radio" name="contactGender" wire:model="contactGender" value="Mrs" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
									<label for="gender_mrs" class="text-base inline-block">
										{{ __('Miss') }}
									</label>
								</div>

								<div class="pr-5">
									<input type="radio" name="contactGender" wire:model="contactGender" value="Mr" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
									<label for="gender_mr" class="text-base inline-block">
										{{ __('Mister') }}
									</label>
								</div>
							</div>

							@error('contactGender')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>
						
						<div class="flex gap-x-4">
							<!-- Firstname -->
							<div class="flex-1">
								<div class="flex flex-row pl-4">
									<x-front.input-label for="contactFirstname" :value="__('Firstname')" :required="true" />
								</div>
	
								<x-front.text-input name="contactFirstname" id="contactFirstname" wire:model="contactFirstname" required placeholder="{{ __('Firstname') }}" :class="'mt-1 block bg-white w-full'" />
	
								@error('contactFirstname')
									<span class="error text-danger-700 text-sm">
										{{ $message }}
									</span>
								@enderror
							</div>
	
							<!-- Lastname -->
							<div class="flex-1">
								<div class="flex flex-row pl-4">
									<x-front.input-label for="contactLastname" :value="__('Lastname')" :required="true" />
								</div>
	
								<x-front.text-input name="lastname" id="contactLastname" wire:model="contactLastname" required placeholder="{{ __('Lastname') }}" :class="'mt-1 block bg-white w-full'" />
	
								@error('contactLastname')
									<span class="error text-danger-700 text-sm">
										{{ $message }}
									</span>
								@enderror
							</div>
						</div>

						<!-- Email Address -->
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="contactEmail" :value="__('Email')" :required="true" />
							</div>

							<x-front.text-input type="email" name="contactEmail" id="contactEmail" wire:model="contactEmail" required placeholder="{{ __('Account\'s email address') }}" :class="'mt-1 block bg-white w-full'" />

							@error('contactEmail')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>

						<!-- Password -->
						<div x-data="{
							password: '',
							isTyping: false,
							hasUppercase: false,
							hasLowercase: false,
							hasSpecialChar: false,
							hasNumber: false,
							hasValidLength: false,
							validatePassword() {
								this.isTyping = this.password.length > 0;
								if (this.isTyping) {
									this.hasUppercase = /[A-Z]/.test(this.password);
									this.hasLowercase = /[a-z]/.test(this.password);
									this.hasSpecialChar = /[!@#$%^&*(),.?]/.test(this.password);
									this.hasNumber = /[0-9]/.test(this.password);
									this.hasValidLength = this.password.length >= 8 && this.password.length <= 16;
								} else {
									this.hasUppercase = false;
									this.hasLowercase = false;
									this.hasSpecialChar = false;
									this.hasNumber = false;
									this.hasValidLength = false;
								}
							}
						}" @input.debounce="validatePassword()">
							<div>
								<div class="flex flex-row pl-4">
									<x-front.input-label for="contactPassword" :value="__('Password')" :required="true" />
								</div>

								<x-front.text-input type="password" name="contactPassword" id="contactPassword" wire:model="contactPassword" required placeholder="{{ __('Account\'s password') }}" :class="'mt-1 block bg-white w-full'" x-model="password" />

								@error('contactPassword')
									<span class="error text-danger-700 text-sm">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div class="pl-4 mt-2">
								<div class="grid grid-cols-2 md:grid-cols-3 gap-y-4">
									<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasUppercase, 'text-red-500': isTyping && !hasUppercase }">
										<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasUppercase || !isTyping">
											<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasUppercase">
											<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('1 uppercase') }}
									</div>

									<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasLowercase, 'text-red-500': isTyping && !hasLowercase }">
										<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasLowercase || !isTyping">
											<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasLowercase">
											<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('1 lowercase') }}
									</div>

									<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasSpecialChar, 'text-red-500': isTyping && !hasSpecialChar }">
										<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasSpecialChar || !isTyping">
											<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasSpecialChar">
											<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('1 special character') }}
									</div>

									<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasNumber, 'text-red-500': isTyping && !hasNumber }">
										<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasNumber || !isTyping">
											<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasNumber">
											<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('1 digit') }}
									</div>

									<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasValidLength, 'text-red-500': isTyping && !hasValidLength }">
										<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasValidLength || !isTyping">
											<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasValidLength">
											<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('Between 8 to 16 character') }}
									</div>
								</div>
							</div>
						</div>

						<!-- Confirmation password -->
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="contactPasswordConfirmation" :value="__('Confirm password')" :required="true" />
							</div>

							<x-front.text-input type="password" name="contactPasswordConfirmation" id="contactPasswordConfirmation" wire:model="contactPasswordConfirmation" required placeholder="{{ __('Confirm password') }}" :class="'mt-1 block bg-white w-full'" />

							@error('contactPasswordConfirmation')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>

						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="contactCountry" :value="__('Country')" :required="true" />
							</div>

							<div class="flex flex-row mt-2">
								<div class="pr-5">
									<input type="radio" name="contactCountry" wire:model="contactCountry" value="FR" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
									<label for="country_fr" class="text-base inline-block">
										{{ __('France') }}
									</label>
								</div>

								<div class="pr-5">
									<input type="radio" name="contactCountry" wire:model="contactCountry" value="BE" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
									<label for="country_be" class="text-base inline-block">
										{{ __('Belgium') }}
									</label>
								</div>
							</div>

							@error('contactCountry')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>

						<hr class="bg-breeder-greige border-0 my-6 h-[2px] w-full">

						{{-- CGU --}}
						<label class="flex flex-row items-center gap-x-2 cursor-pointer font-medium text-sm" for="contactCgu">
							<input type="checkbox" name="contactCgu" id="contactCgu" wire:model="contactCgu" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
							{{ __('I accept the general conditions of use of the site.') }}
							<span class="text-breeder-violet">*</span>
						</label>

						@error('contactCgu')
							<span class="error text-danger-700 text-sm">
								{{ $message }}
							</span>
						@enderror

						<!-- Opt in -->
						<h3 class="font-bold text-breeder-deepblue">
							{{ __('Newsletter inscription') }}
						</h3>

						<x-front.input-label for="contactOptinNewsletter" :class="'cursor-pointer'">
							<input type="checkbox" name="contactOptinNewsletter" id="contactOptinNewsletter" wire:model="contactOptinNewsletter" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

							{{ __('I subscribe to the monthly newsletter of Eleveurs Online') }}
						</x-front.input-label>

						<x-front.input-label for="contactOptinReceiveInfo" :class="'cursor-pointer'">
							<input type="checkbox" name="contactOptinReceiveInfo" id="contactOptinReceiveInfo" wire:model="contactOptinReceiveInfo" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

							{{ __('I would like to receive information from Eleveurs Online and their publishers') }}
						</x-front.input-label>

						<x-front.input-label for="optinReceiveDeals" :class="'cursor-pointer'">
							<input type="checkbox" name="optinReceiveDeals" id="optinReceiveDeals" wire:model="optinReceiveDeals" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

							{{ __('I would like to receive good deals from Eleveurs Online partners') }}
						</x-front.input-label>

						<div class="w-full rounded-xl bg-breeder-cream flex justify-between p-6">
							<div class="flex flex-row items-center">
								<div class="flex flex-col gap-y-2">
									<x-front.input-label for="contactOptinFigo" :class="'cursor-pointer'">
										<input type="checkbox" name="contactOptinFigo" id="contactOptinFigo" wire:model="contactOptinFigo" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

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
												<rect width="28" height="40" fill="white" transformContact="translate(0 0.5)"/>
											</clipPath>
										</defs>
									</svg>
								</div>
							</div>
						</div>
					@elseif($stepContact == 5)
						<div class="flex flex-col text-lg font-bold w-full">
							{{ __(':user, improve your first contact with the breeder :', ['user' => $user->name]) }}
						</div>

						<div class="w-full font-medium text-base">
							{{ __('The more he knows about you, the more he\'ll be able to guide you to the animal that truely belongs to you.') }}&nbsp;
							{!! __('Answer a few questions to <strong>finalize your profil</strong> and maximize your chances of answers.') !!}
						</div>

						
						<div class="flex flex-col gap-y-4 p-6 bg-breeder-lightcream rounded-xl">
							@if(!$phone)
								<div>
									{!! __('<strong>Your phone number is missing on your profile</strong>, please fill it out to be easily contacted by the breeder :') !!}
								</div>
							@endif

							<div>
								<div class="flex flex-row pl-4">
									<x-front.input-label for="phone" :value="__('Phone number')" :required="true" />
								</div>

								<x-front.text-input name="phone" id="phone" wire:model="phone" required placeholder="{{ __('Your phone number') }}" :class="'mt-1 block bg-white w-full'" />

								@error('phone')
									<span class="error text-danger-700 text-sm">
										{{ $message }}
									</span>
								@enderror
							</div>
						</div>

						<div class="flex text-base px-3 py-2 bg-breeder-green w-fit">
							{!! __('Time estimation :&nbsp;<strong>:x min</strong>', ['x' => 2]) !!}
						</div>
					@elseif($stepContact == 6)
						<div class="flex text-bold w-full text-base">
							{{ __('You can follow your inquire directly in your dashboard') }}
						</div>

						<div class="flex w-full font-medium text-base">
							{{ __('To maximize your chances to adopt the :species that belongs to you, contact other companies !', ['species' => __($speciesText)]) }}
						</div>

						@script
						<script>
							window.dataLayer = window.dataLayer || [];
							window.dataLayer.push({
								event: 'contact_réalisé',
								race: {!! json_encode($breed?->name ?? 'non_renseignée') !!}
							});
						</script>
						@endscript
					@endif
				</div>

				@if($stepContact != 6)
					<div class="flex flex-col mt-4 w-full">
						@if($stepContact == 5)
							<x-front.primary-button wire:click="continueToForm" :class="'flex flex-row gap-x-1 justify-center w-full items-center'">
								{{ __('Complete my adoption project') }}

								<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</x-front.primary-button>

							<div wire:click="formContact"
								x-data 
								@click="pushContactEvent({{ json_encode($breed?->name ?? 'non_renseignee') }})"
								class="flex flex-row items-center text-bold justify-center cursor-pointer gap-x-1 mt-4 text-breeder-deepblue">
								{{ __('Send my message without completing my profile') }}

								<svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1.49219 0.75L5.85582 4.75L1.49219 8.75" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
						@else
							@if($stepContact == 4)
								<x-front.primary-button x-on:click="$dispatch('close');" :class="'flex flex-row gap-x-1 justify-center'">
									{{ __('Close') }}

									<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</x-front.primary-button>
							@else
								<x-front.primary-button wire:click="formContact" :class="'flex flex-row gap-x-1 justify-center'">
									{{ __('Continue') }}

									<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</x-front.primary-button>
							@endif
						@endif
					</div>
				@else
					<div class="flex flex-col max-md:items-center md:flex-row mt-4 w-full justify-center md:justify-between gap-4">
						<a href="{{ route('space.responses.my-messages', ['response' => $response->id]) }}" class="flex-1">
							<x-front.secondary-button :class="'flex flex-row gap-x-1 justify-center'">
								{{ __('Access my messages') }}

								<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</x-front.secondary-button>
						</a>

						<x-front.primary-button x-on:click="$dispatch('close');" :class="'flex flex-row gap-x-1 justify-center flex-1'">
							{{ __('Come back to the post') }}

							<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</x-front.primary-button>
					</div>
				@endif
			</section>
		</x-front.modal>

		@if(Auth::guard('web')->check())
			@include('components.front.figo-gift')
		@endif
	@endif

	<x-front.modal name="call" :class="'w-full max-w-2xl'" focusable>
		<section class="p-0">
			<header class="flex flex-col mb-4">
				@if($stepCall != 4)
					<div class="font-bold text-[25px] md:text-[40px] text-left">
						{{ __('Call the company') }}
					</div>
				@elseif($stepCall == 4)
					<div class="font-medium text-[28px] text-left">
						{!! __('<strong>To receive the company\'s phone number</strong>, confirm your email adress by clicking the link in the email sent to the adresse : :address', ['address' => $callEmail]) !!}
					</div>
				@endif

				@if($stepCall == 1)
					<div class="text-base font-medium">
						{!! __('<strong>To show the company\'s phone number</strong>, login or create your account :') !!}
					</div>
				@endif

				@if($stepCall == 5 && $hasJustVerifiedEmailForCall)
					<h2 class="text-lg font-bold my-4">
						{{ __('Your account has been successfully created.') }}
					</h2>
				@endif
			</header>

			<div class="flex flex-col gap-y-3">
				@if($stepCall == 1 || $stepCall == 2)
					<div class="flex flex-col w-full">
						<x-front.input-label for="callEmail" :value="__('Your email address')" :class="'pl-4'" :required="true" />

						<x-front.text-input type="email" name="callEmail" id="callEmail" wire:model="callEmail" :disabled="$stepCall > 1" placeholder="{{ __('Email') }}" :class="'mt-1 block bg-white'" />

						@error('callEmail')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>

					@if($stepCall == 2)
						<div class="flex flex-col w-full">
							<x-front.input-label for="callPassword" :value="__('Password')" :class="'pl-4'" :required="true" />

							<x-front.text-input type="password" name="callPassword" id="callPassword" wire:model="callPassword" placeholder="{{ __('Your password') }}" :class="'mt-1 block bg-white w-full'" />

							@error('callPassword')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>
					@endif
				@elseif($stepCall == 3)
					<!-- Gender -->
					<div>
						<div class="flex flex-row pl-4">
							<x-front.input-label for="callGender" :value="__('Gender')" :required="true" />
						</div>

						<div class="flex flex-row my-2">
							<div class="pr-5">
								<input type="radio" name="callGender" wire:model="callGender" value="Mrs" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
								<label for="gender_mrs" class="text-base inline-block">
									{{ __('Miss') }}
								</label>
							</div>

							<div class="pr-5">
								<input type="radio" name="callGender" wire:model="callGender" value="Mr" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
								<label for="gender_mr" class="text-base inline-block">
									{{ __('Mister') }}
								</label>
							</div>
						</div>

						@error('callGender')
							<span class="error text-danger-700 text-sm">
								{{ $message }}
							</span>
						@enderror
					</div>
					
					<div class="flex gap-x-4">
						<!-- Firstname -->
						<div class="flex-1">
							<div class="flex flex-row pl-4">
								<x-front.input-label for="callFirstname" :value="__('Firstname')" :required="true" />
							</div>

							<x-front.text-input name="callFirstname" id="callFirstname" wire:model="callFirstname" required placeholder="{{ __('Firstname') }}" :class="'mt-1 block bg-white w-full'" />

							@error('callFirstname')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>

						<!-- Lastname -->
						<div class="flex-1">
							<div class="flex flex-row pl-4">
								<x-front.input-label for="callLastname" :value="__('Lastname')" :required="true" />
							</div>

							<x-front.text-input name="lastname" id="callLastname" wire:model="callLastname" required placeholder="{{ __('Lastname') }}" :class="'mt-1 block bg-white w-full'" />

							@error('callLastname')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>
					</div>

					<!-- Email Address -->
					<div>
						<div class="flex flex-row pl-4">
							<x-front.input-label for="callEmail" :value="__('Email')" :required="true" />
						</div>

						<x-front.text-input type="email" name="callEmail" id="callEmail" wire:model="callEmail" required placeholder="{{ __('Account\'s email address') }}" :class="'mt-1 block bg-white w-full'" />

						@error('callEmail')
							<span class="error text-danger-700 text-sm">
								{{ $message }}
							</span>
						@enderror
					</div>

					<!-- Password -->
					<div x-data="{
						password: '',
						isTyping: false,
						hasUppercase: false,
						hasLowercase: false,
						hasSpecialChar: false,
						hasNumber: false,
						hasValidLength: false,
						validatePassword() {
							this.isTyping = this.password.length > 0;
							if (this.isTyping) {
								this.hasUppercase = /[A-Z]/.test(this.password);
								this.hasLowercase = /[a-z]/.test(this.password);
								this.hasSpecialChar = /[!@#$%^&*(),.?]/.test(this.password);
								this.hasNumber = /[0-9]/.test(this.password);
								this.hasValidLength = this.password.length >= 8 && this.password.length <= 16;
							} else {
								this.hasUppercase = false;
								this.hasLowercase = false;
								this.hasSpecialChar = false;
								this.hasNumber = false;
								this.hasValidLength = false;
							}
						}
					}" @input.debounce="validatePassword()">
						<div>
							<div class="flex flex-row pl-4">
								<x-front.input-label for="callPassword" :value="__('Password')" :required="true" />
							</div>

							<x-front.text-input type="password" name="callPassword" id="callPassword" wire:model="callPassword" required placeholder="{{ __('Account\'s password') }}" :class="'mt-1 block bg-white w-full'" x-model="password" />

							@error('callPassword')
								<span class="error text-danger-700 text-sm">
									{{ $message }}
								</span>
							@enderror
						</div>

						<div class="pl-4 mt-2">
							<div class="grid grid-cols-2 md:grid-cols-3 gap-y-4">
								<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasUppercase, 'text-red-500': isTyping && !hasUppercase }">
									<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasUppercase || !isTyping">
										<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasUppercase">
										<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('1 uppercase') }}
								</div>

								<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasLowercase, 'text-red-500': isTyping && !hasLowercase }">
									<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasLowercase || !isTyping">
										<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasLowercase">
										<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('1 lowercase') }}
								</div>

								<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasSpecialChar, 'text-red-500': isTyping && !hasSpecialChar }">
									<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasSpecialChar || !isTyping">
										<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasSpecialChar">
										<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('1 special character') }}
								</div>

								<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasNumber, 'text-red-500': isTyping && !hasNumber }">
									<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasNumber || !isTyping">
										<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasNumber">
										<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('1 digit') }}
								</div>

								<div class="flex items-center gap-x-2 text-sm font-medium w-fit" :class="{ 'text-breeder-deepblue': !isTyping, 'text-green-500': isTyping && hasValidLength, 'text-red-500': isTyping && !hasValidLength }">
									<svg class="shrink-0" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="hasValidLength || !isTyping">
										<path d="M4.81818 6.82728L6.06726 8.13636L9.18182 4.86364M13 6.5C13 9.81371 10.3137 12.5 7 12.5C3.68629 12.5 1 9.81371 1 6.5C1 3.18629 3.68629 0.5 7 0.5C10.3137 0.5 13 3.18629 13 6.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<svg class="shrink-0" width="14" height="13" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="isTyping && !hasValidLength">
										<path d="M14 26.2125C20.9036 26.2125 26.5 20.6161 26.5 13.7125C26.5 6.80896 20.9036 1.21252 14 1.21252C7.09644 1.21252 1.5 6.80896 1.5 13.7125C1.5 20.6161 7.09644 26.2125 14 26.2125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 17.7352L18.0227 9.68979" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.97729 9.68979L18.0227 17.7352" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('Between 8 to 16 character') }}
								</div>
							</div>
						</div>
					</div>

					<!-- Confirmation password -->
					<div>
						<div class="flex flex-row pl-4">
							<x-front.input-label for="callPasswordConfirmation" :value="__('Confirm password')" :required="true" />
						</div>

						<x-front.text-input type="password" name="callPasswordConfirmation" id="callPasswordConfirmation" wire:model="callPasswordConfirmation" required placeholder="{{ __('Confirm password') }}" :class="'mt-1 block bg-white w-full'" />

						@error('callPasswordConfirmation')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>

					<div>
						<div class="flex flex-row pl-4">
							<x-front.input-label for="callCountry" :value="__('Country')" :required="true" />
						</div>

						<div class="flex flex-row mt-2">
							<div class="pr-5">
								<input type="radio" name="callCountry" wire:model="callCountry" value="FR" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
								<label for="country_fr" class="text-base inline-block">
									{{ __('France') }}
								</label>
							</div>

							<div class="pr-5">
								<input type="radio" name="callCountry" wire:model="callCountry" value="BE" class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
								<label for="country_be" class="text-base inline-block">
									{{ __('Belgium') }}
								</label>
							</div>
						</div>

						@error('callCountry')
							<span class="error text-danger-700 text-sm">
								{{ $message }}
							</span>
						@enderror
					</div>

					<hr class="bg-breeder-greige border-0 my-6 h-[2px] w-full">

					{{-- CGU --}}
					<label class="flex flex-row items-center gap-x-2 cursor-pointer font-medium text-sm" for="callCgu">
						<input type="checkbox" name="callCgu" id="callCgu" wire:model="callCgu" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
						{{ __('I accept the general conditions of use of the site.') }}
						<span class="text-breeder-violet">*</span>
					</label>

					@error('callCgu')
						<span class="error text-danger-700 text-sm">
							{{ $message }}
						</span>
					@enderror

					<!-- Opt in -->
					<h3 class="font-bold text-breeder-deepblue">
						{{ __('Newsletter inscription') }}
					</h3>

					<x-front.input-label for="callOptinNewsletter" :class="'cursor-pointer'">
						<input type="checkbox" name="callOptinNewsletter" id="callOptinNewsletter" wire:model="callOptinNewsletter" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

						{{ __('I subscribe to the monthly newsletter of Eleveurs Online') }}
					</x-front.input-label>

					<x-front.input-label for="callOptinReceiveInfo" :class="'cursor-pointer'">
						<input type="checkbox" name="callOptinReceiveInfo" id="callOptinReceiveInfo" wire:model="callOptinReceiveInfo" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

						{{ __('I would like to receive information from Eleveurs Online and their publishers') }}
					</x-front.input-label>

					<x-front.input-label for="optinReceiveDeals" :class="'cursor-pointer'">
						<input type="checkbox" name="optinReceiveDeals" id="optinReceiveDeals" wire:model="optinReceiveDeals" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

						{{ __('I would like to receive good deals from Eleveurs Online partners') }}
					</x-front.input-label>

					<div class="w-full rounded-xl bg-breeder-cream flex justify-between p-6">
						<div class="flex flex-row items-center">
							<div class="flex flex-col gap-y-2">
								<x-front.input-label for="callOptinFigo" :class="'cursor-pointer'">
									<input type="checkbox" name="callOptinFigo" id="callOptinFigo" wire:model="callOptinFigo" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

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
											<rect width="28" height="40" fill="white" transformcall="translate(0 0.5)"/>
										</clipPath>
									</defs>
								</svg>
							</div>
						</div>
					</div>
				@elseif($stepCall == 5)
					<div class="flex flex-col text-lg font-bold w-[261px]">
						<x-front.primary-button :class="'flex flex-row gap-x-1 justify-center w-full items-center !mb-4'"  x-data="{ textToCopy: '{{ $phoneNumber }}', copied: false }" @click="navigator.clipboard.writeText(textToCopy).then(() => { copied = true })">
							{{ $phoneNumber }}

							<svg x-show="!copied" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M3.55 12.55H2.7C2.24913 12.55 1.81673 12.3709 1.49792 12.0521C1.17911 11.7333 1 11.3009 1 10.85V3.2C1 2.74913 1.17911 2.31673 1.49792 1.99792C1.81673 1.67911 2.24913 1.5 2.7 1.5H10.35C10.8009 1.5 11.2333 1.67911 11.5521 1.99792C11.8709 2.31673 12.05 2.74913 12.05 3.2V4.05M8.65 7.45H16.3C17.2389 7.45 18 8.21112 18 9.15V16.8C18 17.7389 17.2389 18.5 16.3 18.5H8.65C7.71112 18.5 6.95 17.7389 6.95 16.8V9.15C6.95 8.21112 7.71112 7.45 8.65 7.45Z" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>

							<svg x-show="copied" width="19" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="transition-opacity duration-200">
								<path d="M5 13L9 17L19 7" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</x-front.primary-button>
					</div>

					<div class="text-lg">
						{!! __('You can find the company\'s phone number <u><a href=":url">in your Eleveurs Online messages</a></u>.', ['url' => route('space.responses.my-messages')]) !!}
					</div>
				@elseif($stepCall == 6)
					<div class="text-lg mt-4">
						{!! __('The company\'s phone number has been successfully sent to the email adress : <strong>[:email]</strong>', ['email' => $callEmail]) !!}
					</div>
				@endif
			</div>

			<div class="flex flex-col mt-4 w-full">
				@if($stepCall == 5 || $stepCall == 6)
					<div x-on:click.prevent="$dispatch('close');" class="flex flex-row text-bold items-center cursor-pointer gap-x-1 mt-4 text-breeder-deepblue font-bold text-sm">
						<svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.51172 0.75L2.14808 4.75L6.51172 8.75" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						{{ __('Go back to the post') }}
					</div>
				@elseif($stepCall == 4)
					<x-front.primary-button x-on:click="$dispatch('close');" :class="'flex flex-row gap-x-1 justify-center'">
						{{ __('Close') }}

						<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</x-front.primary-button>
				@else
					<x-front.primary-button wire:click="formCall" :class="'flex flex-row gap-x-1 justify-center items-center w-full'">
						@if($stepCall == 2)
							{{ __('Show the phone number') }}
						@else
							{{ __('Continue') }}
						@endif

						<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.86524 0.75L7.31978 5.75L1.86523 10.75" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</x-front.primary-button>

					@if($stepCall == 3)
						<div wire:click="sendNumberByEmail" class="flex flex-row items-center text-bold justify-center cursor-pointer gap-x-1 mt-4 text-breeder-deepblue w-full">
							{{ __('Receive the phone number without creating an account') }}

							<svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.49219 0.75L5.85582 4.75L1.49219 8.75" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
					@endif
				@endif
			</div>
		</section>
	</x-front.modal>
</div>