<x-app-layout>
	@push('seo')
		<title>Se créer un compte sur Eleveurs-online.com</title>

		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
	@endpush

	<div class="w-full bg-breeder-cream">
		<div class="flex xlsm:flex-row flex-col max-xlsm:items-center gap-y-10 justify-between max-w-[1200px] flex-wrap xlsm:mx-auto mb-10">
			<div class="flex flex-col w-full md:w-[750px]">
				<div class="flex flex-col bg-white rounded-xl px-8 py-10 text-breeder-deepblue">
						@switch($role)
							@case('eleveur')
								<h1 class="mb-1 text-2xl lg:text-[40px] font-bold text-breeder-deepblue leading-none">
									{{ __('Register as a breeder') }}
								</h1>

								<p class="font-bold text-base mt-2">{{ __('Are you a dog or cat breeder or a stud dog owner?') }}</p>
								<p class="font-medium text-base">{{ __('Inscrivez vous gratuitement, rejoignez la communauté :') }}</p>

								@break
							@case('adoptant')
								<h1 class="mb-1 text-2xl lg:text-[40px] font-bold text-breeder-deepblue leading-none">
									{{ __('Register as an adopter') }}
								</h1>

								<p class="font-bold text-base mt-2">{{ __('Vous êtes propriétaire de chiens ou chats ou vous souhaitez devenir propriétaire ?') }}</p>
								<p class="font-medium text-base">{{ __('Inscrivez vous gratuitement, rejoignez la communauté :') }}</p>

								@break
							@case('professionnel')
								<h1 class="mb-1 text-2xl lg:text-[40px] font-bold text-breeder-deepblue leading-none">
									{{ __('Register as a professional') }}
								</h1>

								<p class="font-bold text-base mt-2">{{ __('Are you a groomer, pet sitter, salesperson, trainer, boarder, or wellness professional?') }}</p>
								<p class="font-medium text-base">{{ __('List your business in our product & service directory and be visible to the entire community:') }}</p>

								@break

							@default
								<h1 class="mb-1 text-2xl lg:text-[40px] font-bold text-breeder-deepblue leading-none">
									{{ __('Register') }}
								</h1>

								<p class="font-bold text-base mt-2">{{ __('Vous êtes propriétaire de chiens ou chats ou vous souhaitez devenir propriétaire ?') }}</p>
								<p class="font-medium text-base">{{ __('Inscrivez vous gratuitement, rejoignez la communauté :') }}</p>
						@endswitch

					{{-- Register with google, facebook etc
					<div class="flex items-center mt-8 gap-x-6">
						{{ __('I register with :') }}
						<div class="flex gap-x-4">
							<svg width="43" height="43" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="0.5" y="0.5" width="42" height="42" rx="21" stroke="#DDDBD2"/>
								<path d="M30.738 21.728C30.7388 21.0466 30.6808 20.3664 30.5646 19.6948H21.0688V23.546H26.5075C26.3962 24.1611 26.1607 24.7474 25.8151 25.2697C25.4694 25.7919 25.0209 26.2393 24.4965 26.5847V29.0846H27.7424C29.643 27.3444 30.738 24.7709 30.738 21.728Z" fill="#4285F4"/>
								<path d="M21.0688 31.5C23.786 31.5 26.074 30.6139 27.7424 29.0862L24.4965 26.5864C23.5931 27.1947 22.4295 27.5419 21.0688 27.5419C18.4424 27.5419 16.2132 25.7836 15.416 23.4143H12.0722V25.9906C12.9103 27.6467 14.1954 29.0389 15.784 30.0118C17.3727 30.9847 19.2023 31.4999 21.0688 31.5Z" fill="#34A853"/>
								<path d="M15.416 23.4143C14.9946 22.1728 14.9946 20.8279 15.416 19.5864V17.0101H12.0722C11.3672 18.4033 11 19.9409 11 21.5002C11 23.0594 11.3672 24.5974 12.0722 25.9906L15.416 23.4143Z" fill="#FBBC04"/>
								<path d="M21.0688 15.4588C22.5047 15.4355 23.8922 15.9743 24.9314 16.9587L27.8053 14.1047C25.983 12.4049 23.5687 11.4717 21.0688 11.5007C19.2023 11.5007 17.3727 12.016 15.784 12.9889C14.1954 13.9617 12.9103 15.354 12.0722 17.0101L15.416 19.5864C16.2131 17.2171 18.4424 15.4588 21.0688 15.4588Z" fill="#EA4335"/>
							</svg>
							<svg width="43" height="43" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="0.5" y="0.5" width="42" height="42" rx="21" stroke="#DDDBD2"/>
								<path d="M31.5 21.5C31.5 15.9766 27.0234 11.5 21.5 11.5C15.9766 11.5 11.5 15.9766 11.5 21.5C11.5 26.4922 15.1562 30.6289 19.9375 31.3789V24.3906H17.3984V21.5H19.9375V19.2969C19.9375 16.791 21.4297 15.4063 23.7148 15.4063C24.8086 15.4063 25.9531 15.6016 25.9531 15.6016V18.0625H24.6914C23.4492 18.0625 23.0625 18.834 23.0625 19.625V21.5H25.8359L25.3926 24.3906H23.0625V31.3789C27.8438 30.6289 31.5 26.4922 31.5 21.5Z" fill="#1877F2"/>
								<path d="M25.3926 24.3906L25.8359 21.5H23.0625V19.625C23.0625 18.834 23.4492 18.0625 24.6914 18.0625H25.9531V15.6016C25.9531 15.6016 24.8086 15.4063 23.7148 15.4063C21.4297 15.4063 19.9375 16.791 19.9375 19.2969V21.5H17.3984V24.3906H19.9375V31.3789C20.4473 31.459 20.9687 31.5 21.5 31.5C22.0312 31.5 22.5527 31.459 23.0625 31.3789V24.3906H25.3926Z" fill="white"/>
							</svg>
							<svg width="43" height="43" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="0.5" y="0.5" width="42" height="42" rx="21" stroke="#DDDBD2"/>
								<path d="M21.369 16.3389C22.5847 16.3389 23.6511 15.9075 24.5684 15.0449C25.4857 14.1822 25.9443 13.179 25.9443 12.0354C25.9443 11.9098 25.9333 11.7314 25.9115 11.5C25.7513 11.5198 25.6312 11.5363 25.5511 11.5496C24.4301 11.695 23.4437 12.1942 22.5919 13.0469C21.7402 13.8996 21.3143 14.8119 21.3143 15.7836C21.3143 15.8959 21.3325 16.081 21.3689 16.3389H21.369ZM25.7258 31.5C26.5921 31.5 27.5494 30.9613 28.5977 29.8838C29.646 28.8062 30.4467 27.5403 31 26.086C28.9398 25.1209 27.9098 23.736 27.9098 21.9313C27.9098 20.4241 28.7433 19.135 30.4103 18.0642C29.2529 16.7486 27.7242 16.0909 25.8242 16.0909C25.0234 16.0909 24.2918 16.1999 23.6294 16.4181L23.2144 16.5569L22.6575 16.7552C22.2935 16.8808 21.9623 16.9436 21.6638 16.9436C21.4308 16.9436 21.1251 16.8709 20.7466 16.7254L20.3207 16.5668L19.9167 16.4181C19.327 16.1934 18.6937 16.081 18.0167 16.081C16.2041 16.081 14.7482 16.6362 13.6489 17.7468C12.5496 18.8574 12 20.3217 12 22.1395C12 24.6978 12.8808 27.061 14.6425 29.2293C15.8655 30.743 16.9829 31.5 17.9948 31.5C18.4243 31.5 18.8502 31.424 19.2724 31.2719L19.8074 31.0736L20.2333 30.9348C20.8302 30.7431 21.3799 30.6473 21.8821 30.6473C22.4136 30.6473 23.0251 30.7696 23.7166 31.0142L24.0551 31.1331C24.7611 31.3777 25.3181 31.5 25.7257 31.5H25.7258Z" fill="#08103A"/>
							</svg>

						</div>
					</div>
					<div class="w-full relative mt-10">
						<div class="absolute w-full border-t border-breeder-greige top-0 left-0 z-10">
						</div>
						<div class="absolute text-center font-medium text-base text-breeder-greige w-[180px] bg-white -top-[11px] z-20 left-[50%] transform translate-x-[-50%]">ou avec mon email</div>
					</div> --}}
					<div class="mt-8">
						<form method="POST" action="{{ route('register.store') }}">
							@csrf

							<input type="hidden" name="role" value="{{ $role }}">

							<div class="grid gap-x-20 gap-y-4 grid-cols-1 mt-5">
							@switch($role)
								@case('eleveur')
									<div class="flex items-center gap-x-2 font-medium text-sm">
										<input type="checkbox" name="check-role" id="check-role" checked class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
										<label for="check-role">
											Je confirme m'inscrire en tant qu'éleveur professionnel ou particulier.
										</label>
									</div>

									@error('check-role')
										<span class="error text-danger-700 text-sm">
											{{ $message }}
										</span>
									@enderror

									<div class="flex gap-x-8 gap-y-4 flex-wrap text-xs font-medium">
										<div>
											{{ __('You are professional') }} ? <a href="{{ route('register', ['role' => 'professionnel']) }}" class="font-bold underline">Inscrivez-vous ici</a>
										</div>
										<div>
											{{ __('You are adopter') }} ? <a href="{{ route('register', ['role' => 'adoptant']) }}" class="font-bold underline">Inscrivez-vous ici</a>
										</div>
									</div>
									@break
								@case('adoptant')
									<div class="flex items-center gap-x-2 font-medium text-sm">
										<input type="checkbox" name="check-role" id="check-role" checked class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
										<label for="check-role">
											Je confirme m'inscrire en tant qu'adoptant ou propriétaire d'animaux.
										</label>
									</div>

									@error('check-role')
										<span class="error text-danger-700 text-sm">
											{{ $message }}
										</span>
									@enderror

									<div class="flex gap-x-8 gap-y-4 flex-wrap text-xs font-medium">
										<div>
											{{ __('You are breeder') }} ? <a href="{{ route('register', ['role' => 'eleveur']) }}" class="font-bold underline">Inscrivez-vous ici</a>
										</div>
										<div>
											{{ __('You are professional') }} ? <a href="{{ route('register', ['role' => 'professionnel']) }}" class="font-bold underline">Inscrivez-vous ici</a>
										</div>
									</div>
									@break
								@case('professionnel')
									<div class="flex items-center gap-x-2 font-medium text-sm">
										<input type="checkbox" name="check-role" id="check-role" checked class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
										<label for="check-role">
											Je confirme m'inscrire en tant que professionnel.
										</label>
									</div>

									@error('check-role')
										<span class="error text-danger-700 text-sm">
											{{ $message }}
										</span>
									@enderror
									
									<div class="flex gap-x-8 gap-y-4 flex-wrap text-xs font-medium">
										<div>
											{{ __('You are breeder') }} ? <a href="{{ route('register', ['role' => 'eleveur']) }}" class="font-bold underline">Inscrivez-vous ici</a>
										</div>
										<div>
											{{ __('You are adopter') }} ? <a href="{{ route('register', ['role' => 'adoptant']) }}" class="font-bold underline">Inscrivez-vous ici</a>
										</div>
									</div>
									@break
								@endswitch

								<hr class="w-full border border-breeder-greige">

								<!-- Gender -->
								<div>
									<div class="flex flex-row pl-4">
										<x-front.input-label for="gender" :value="__('Gender')" :required="true" />
									</div>

									<div class="flex flex-row my-2">
										<div class="pr-5">
											<input type="radio" id="gender_mrs" name="gender" value="Mrs" {{ old('gender') === 'Mrs' ? 'checked' : '' }} class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
											<label for="gender_mrs" class="text-base inline-block">
												{{ __('Miss') }}
											</label>
										</div>

										<div class="pr-5">
											<input type="radio" id="gender_mr" name="gender" value="Mr" {{ old('gender') === 'Mr' ? 'checked' : '' }} class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
											<label for="gender_mr" class="text-base inline-block">
												{{ __('Mister') }}
											</label>
										</div>
									</div>

									@error('gender')
										<span class="error text-danger-700 text-sm">
											{{ $message }}
										</span>
									@enderror
								</div>

								<!-- Firstname -->
								<div>
									<div class="flex flex-row pl-4">
										<x-front.input-label for="firstname" :value="__('Firstname')" :required="true" />
									</div>

									<x-front.text-input name="firstname" id="firstname" :value="old('firstname')" required placeholder="{{ __('Firstname') }}" :class="'mt-1 block bg-white w-full'" />

									@error('firstname')
										<span class="error text-danger-700 text-sm">
											{{ $message }}
										</span>
									@enderror
								</div>

								<!-- Lastname -->
								<div>
									<div class="flex flex-row pl-4">
										<x-front.input-label for="lastname" :value="__('Lastname')" :required="true" />
									</div>

									<x-front.text-input name="lastname" id="lastname" :value="old('lastname')" required placeholder="{{ __('Lastname') }}" :class="'mt-1 block bg-white w-full'" />

									@error('lastname')
										<span class="error text-danger-700 text-sm">
											{{ $message }}
										</span>
									@enderror
								</div>

								<!-- Email Address -->
								<div>
									<div class="flex flex-row pl-4">
										<x-front.input-label for="email" :value="__('Email')" :required="true" />
									</div>

									<x-front.text-input type="email" name="email" id="email" :value="old('email')" required placeholder="{{ __('Account\'s email address') }}" :class="'mt-1 block bg-white w-full'" />

									@error('email')
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
											<x-front.input-label for="password" :value="__('Password')" :required="true" />
										</div>

										<x-front.text-input type="password" name="password" id="password" required placeholder="{{ __('Account\'s password') }}" :class="'mt-1 block bg-white w-full'" x-model="password" />

										@error('password')
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
										<x-front.input-label for="password_confirmation" :value="__('Confirm password')" :required="true" />
									</div>

									<x-front.text-input type="password" name="password_confirmation" id="password_confirmation" required placeholder="{{ __('Confirm password') }}" :class="'mt-1 block bg-white w-full'" />

									@error('password_confirmation')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div>
									<div class="flex flex-row pl-4">
										<x-front.input-label for="country" :value="__('Country')" :required="true" />
									</div>

									<div class="flex flex-row my-2">
										<div class="pr-5">
											<input type="radio" id="country_fr" name="country" value="FR" {{ old('country') === 'FR' ? 'checked' : '' }} class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
											<label for="country_fr" class="text-base inline-block">
												{{ __('France') }}
											</label>
										</div>

										<div class="pr-5">
											<input type="radio" id="country_be" name="country" value="BE" {{ old('country') === 'BE' ? 'checked' : '' }} class="mr-1 disabled:bg-breeder-greige my-1 checked:bg-breeder-deepblue checked:hover:bg-breeder-deepblue checked:active:bg-breeder-deepblue checked:focus:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none focus:ring-1 focus:ring-breeder-deepblue w-3 h-3" />
											<label for="country_be" class="text-base inline-block">
												{{ __('Belgium') }}
											</label>
										</div>
									</div>

									@error('country')
										<span class="error text-danger-700 text-sm">
											{{ $message }}
										</span>
									@enderror
								</div>

								<hr class="bg-breeder-greige border-0 my-6 h-[2px] w-full">

								{{-- CGU --}}
								<label class="flex flex-row items-center gap-x-2 cursor-pointer font-medium text-sm" for="cgu">
									<input type="checkbox" name="cgu" id="cgu" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">
									{{ __('I accept the general conditions of use of the site.') }}
									<span class="text-breeder-violet">*</span>
								</label>

								@error('cgu')
									<span class="error text-danger-700 text-sm">
										{{ $message }}
									</span>
								@enderror

								<!-- Opt in -->
								<h3 class="font-bold text-breeder-deepblue">
									{{ __('Newsletter inscription') }}
								</h3>

								<x-front.input-label for="optin_newsletter" :class="'cursor-pointer'">
									<input type="checkbox" name="optin_newsletter" id="optin_newsletter" @checked(is_null(old('optin_newsletter')) ? true : old('optin_newsletter')) class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

									{{ __('I subscribe to the monthly newsletter of Eleveurs Online') }}
								</x-front.input-label>

								<x-front.input-label for="optin_receive_info" :class="'cursor-pointer'">
									<input type="checkbox" name="optin_receive_info" id="optin_receive_info" @checked(is_null(old('optin_receive_info')) ? true : old('optin_receive_info')) class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

									{{ __('I would like to receive information from Eleveurs Online and their publishers') }}
								</x-front.input-label>

								<x-front.input-label for="optin_receive_deals" :class="'cursor-pointer'">
									<input type="checkbox" name="optin_receive_deals" id="optin_receive_deals" @checked(is_null(old('optin_receive_deals')) ? true : old('optin_receive_deals')) class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

									{{ __('I would like to receive good deals from Eleveurs Online partners') }}
								</x-front.input-label>

								<div class="w-full rounded-xl bg-breeder-cream flex justify-between p-6">
									<div class="flex flex-row items-center">
										<div class="flex flex-col gap-y-2">
											<x-front.input-label for="optin_figo" :class="'cursor-pointer'">
												<input type="checkbox" name="optin_figo" id="optin_figo" @checked(is_null(old('optin_figo')) ? true : old('optin_figo')) class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

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

							<div class="flex flex-col items-center gap-y-3 mt-6 w-full">
								<x-front.primary-button :class="'w-full justify-center'">
									{{ __('I register') }}

									<svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</x-front.primary-button>

								<a href="{{ route('login') }}" class="underline text-sm text-breeder-deepblue hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
									{{ __('Already registered') }} ?
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="flex flex-col gap-y-10 mb-10 px-4">
				@if($role != 'adoptant')
					<div class="flex flex-col justify-between w-full md:w-[750px] xlsm:w-[400px] bg-white text-breeder-deepblue rounded-xl p-6">
						<h3 class= "font-bold text-[28px]">
							{{ __('You are adopter') }} ?
						</h3>
						<p class="text-base font-medium mt-2">
							{{ __('Do you own dogs or cats or do you want to become one?') }}
						</p>
						<div class="w-full mt-4 flex justify-center">
							<a href="{{ route('register', ['role' => 'adoptant']) }}" class="w-fit flex justify-center items-center gap-x-2 bg-breeder-deepblue hover:bg-breeder-deepbluehover border border-breeder-cream hover:border-breeder-deepbluehover rounded-full text-breeder-cream text-sm p-3 max-s:w-full font-bold">
								{{ __('I register') }}

								<svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
				@endif
				@if($role != 'eleveur')
					<div class="flex flex-col justify-between w-full md:w-[750px] xlsm:w-[400px] bg-breeder-violet text-breeder-deepblue rounded-xl p-6">
						<h3 class="font-bold text-[28px]">
							{{ __('You are breeder') }} ?
						</h3>
						<p class="text-base font-medium mt-2">Portées, étalons ou adultes retraités, diffusez vos annonces !</p>
						<div class="w-full mt-4 flex justify-center">
							<a href="{{ route('register', ['role' => 'eleveur']) }}" class="w-fit flex justify-center items-center gap-x-2 bg-breeder-deepblue hover:bg-breeder-deepbluehover border border-breeder-deepblue hover:border-breeder-deepbluehover rounded-full text-breeder-cream hover:text-breeder-cream text-sm p-3 max-s:w-full font-bold">
								{{ __('I register') }}

								<svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
				@endif
				@if($role != 'professionnel')
					<div class="flex flex-col justify-between w-full md:w-[750px] xlsm:w-[400px] bg-breeder-orange text-breeder-deepblue rounded-xl p-6">
						<h3 class= "font-bold text-[28px]">
							{{ __('You are professional') }} ?
						</h3>
						<p class="text-base font-medium mt-2">
							{{ __('Groomers, trainers, pet sitters, trainers, boarding, well-being...') }}
						</p>
						<div class="w-full mt-4 flex justify-center">
							<a href="{{ route('register', ['role' => 'professionnel']) }}" class="w-fit flex justify-center items-center gap-x-2 bg-breeder-deepblue hover:bg-breeder-deepbluehover border border-breeder-deepblue hover:border-breeder-deepbluehover rounded-full text-breeder-cream text-sm p-3 max-s:w-full font-bold">
								{{ __('I register') }}

								<svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</a>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="w-full bg-breeder-orange px-2 py-8">
		<div class="flex flex-col items-center">
			<h3 class="text-breeder-deepblue font-semibold text-center text-[25px] md:text-[28px] mb-8">
				{{ __('Be part of our community') }}
			</h3>

			<div class="flex flex-row justify-center flex-wrap gap-x-10 gap-y-8">
				<div class="flex flex-row md:flex-col items-center max-md:gap-x-4 md:gap-y-4 w-[282px]">
					<svg class="w-[35px] md:w-[84px]" viewBox="0 0 84 93" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path
							d="M37.5156 2.19238C40.201 0.651727 43.4991 0.603485 46.2227 2.04785L46.4844 2.19238L46.4854 2.19336L78.0137 20.2178V20.2295L78.5186 20.5176C81.2967 22.0983 82.9998 25.0313 83 28.1953V64.8135C83 67.9742 81.291 70.9013 78.5176 72.4932L46.4854 90.8066L46.4844 90.8076C43.799 92.3483 40.5009 92.3965 37.7773 90.9521L37.5156 90.8076L37.5146 90.8066L5.48242 72.4932L5.48145 72.4922L5.22363 72.3398C2.59794 70.7276 1 67.8788 1 64.8135V28.1865C1 25.0252 2.71011 22.0975 5.48438 20.5059L5.4834 20.5049L37.5146 2.19336L37.5156 2.19238Z"
							stroke="currentColor" stroke-width="2" />
						<path
							d="M33.637 44.7499L40.5467 29C41.9211 29 43.2392 29.5531 44.2111 30.5377C45.1829 31.5222 45.7289 32.8576 45.7289 34.25V41.2499H55.5061C56.0068 41.2442 56.5029 41.3488 56.9598 41.5566C57.4167 41.7643 57.8236 42.0702 58.1522 42.4531C58.4808 42.8359 58.7234 43.2866 58.863 43.7738C59.0026 44.2611 59.036 44.7733 58.9609 45.2749L56.5771 61.0248C56.4521 61.8594 56.0337 62.6201 55.3988 63.1668C54.7639 63.7135 53.9554 64.0093 53.1222 63.9998H33.637M33.637 44.7499V63.9998M33.637 44.7499H28.4548C27.5385 44.7499 26.6598 45.1186 26.0119 45.775C25.364 46.4314 25 47.3216 25 48.2499V60.4998C25 61.4281 25.364 62.3183 26.0119 62.9747C26.6598 63.631 27.5385 63.9998 28.4548 63.9998H33.637"
							stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>

					<div class="flex flex-row md:flex-col text-breeder-deepblue text-md">
						<p class="md:text-center max-w-[255px]"><strong>Identité & SIRET</strong> vérifiés des éleveurs</p>
					</div>
				</div>

				<div class="flex flex-row md:flex-col items-center max-md:gap-x-4 md:gap-y-4 w-[282px]">
					<svg class="w-[35px] md:w-[84px]" viewBox="0 0 84 93" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path
							d="M37.5156 2.19238C40.201 0.651727 43.4991 0.603485 46.2227 2.04785L46.4844 2.19238L46.4854 2.19336L78.0137 20.2178V20.2295L78.5186 20.5176C81.2967 22.0983 82.9998 25.0313 83 28.1953V64.8135C83 67.9742 81.291 70.9013 78.5176 72.4932L46.4854 90.8066L46.4844 90.8076C43.799 92.3483 40.5009 92.3965 37.7773 90.9521L37.5156 90.8076L37.5146 90.8066L5.48242 72.4932L5.48145 72.4922L5.22363 72.3398C2.59794 70.7276 1 67.8788 1 64.8135V28.1865C1 25.0252 2.71011 22.0975 5.48438 20.5059L5.4834 20.5049L37.5146 2.19336L37.5156 2.19238Z"
							stroke="currentColor" stroke-width="2" />
						<path
							d="M37.9559 59.9036C37.9559 62.1628 39.7765 64 42.0153 64C44.2542 64 46.0748 62.1628 46.0748 59.9036M55.7802 57.6692L53.9473 54.9755C52.8279 53.337 52.2251 51.3881 52.2251 49.3896V45.1442C52.2251 40.4023 49.0514 36.4053 44.7336 35.2012V32.7558C44.7336 31.2289 43.5157 30 42.0026 30C40.4896 30 39.2717 31.2289 39.2717 32.7558V35.2012C34.9539 36.4053 31.7802 40.4023 31.7802 45.1442V49.3896C31.7802 51.3881 31.1774 53.337 30.058 54.9755L28.2251 57.6692C27.6469 58.5133 28.2497 59.6678 29.2707 59.6678H54.7346C55.7556 59.6678 56.3461 58.5133 55.7802 57.6692Z"
							stroke="currentColor" stroke-width="2" stroke-miterlimit="10" />
					</svg>

					<div class="flex flex-row md:flex-col text-breeder-deepblue text-md">
						<p class="md:text-center max-w-[255px]"><strong>Numéro de portée LOF/LOOF</strong> vérifié</p>
					</div>
				</div>

				<div class="flex flex-row md:flex-col items-center max-md:gap-x-4 md:gap-y-4 w-[282px]">
					<svg class="w-[35px] md:w-[84px]" viewBox="0 0 84 93" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path
							d="M37.5156 2.19238C40.201 0.651727 43.4991 0.603485 46.2227 2.04785L46.4844 2.19238L46.4854 2.19336L78.0137 20.2178V20.2295L78.5186 20.5176C81.2967 22.0983 82.9998 25.0313 83 28.1953V64.8135C83 67.9742 81.291 70.9013 78.5176 72.4932L46.4854 90.8066L46.4844 90.8076C43.799 92.3483 40.5009 92.3965 37.7773 90.9521L37.5156 90.8076L37.5146 90.8066L5.48242 72.4932L5.48145 72.4922L5.22363 72.3398C2.59794 70.7276 1 67.8788 1 64.8135V28.1865C1 25.0252 2.71011 22.0975 5.48438 20.5059L5.4834 20.5049L37.5146 2.19336L37.5156 2.19238Z"
							stroke="currentColor" stroke-width="2" />
						<path
							d="M35.3917 49.628H32.3946L26.472 55.3594H25.7295V49.6305H23.9228C22.8796 49.6272 21.8803 49.2097 21.1447 48.4697C20.4091 47.7297 19.9974 46.7277 20 45.6842V32.9464C19.9987 32.4294 20.0992 31.9173 20.2958 31.4392C20.4923 30.9611 20.7811 30.5264 21.1456 30.16C21.5101 29.7935 21.9432 29.5025 22.4201 29.3034C22.8971 29.1044 23.4085 29.0013 23.9253 29H40.7896C41.8328 29.0033 42.8321 29.4208 43.5677 30.1608C44.3033 30.9009 44.715 31.9028 44.7124 32.9464V35.7365M50.6029 59.2711H42.2178C41.7002 59.2708 41.1877 59.1683 40.7098 58.9696C40.2318 58.7708 39.7978 58.4797 39.4324 58.1129C39.0671 57.7461 38.7777 57.3108 38.5809 56.8319C38.384 56.353 38.2835 55.84 38.2851 55.3222V42.5869C38.2838 42.07 38.3843 41.5579 38.5809 41.0798C38.7774 40.6017 39.0662 40.167 39.4307 39.8005C39.7952 39.4341 40.2283 39.143 40.7052 38.944C41.1822 38.745 41.6936 38.6419 42.2104 38.6406H59.0747C59.5915 38.6419 60.1029 38.745 60.5799 38.944C61.0568 39.143 61.4899 39.4341 61.8544 39.8005C62.2189 40.167 62.5077 40.6017 62.7042 41.0798C62.9008 41.5579 63.0013 42.07 63 42.5869V55.3222C63.0016 55.8394 62.9013 56.3518 62.7049 56.8302C62.5085 57.3086 62.2198 57.7435 61.8553 58.1103C61.4907 58.477 61.0576 58.7682 60.5805 58.9674C60.1033 59.1666 59.5917 59.2698 59.0747 59.2711H57.2581V65H56.5156L50.6029 59.2711Z"
							stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linejoin="round" />
					</svg>

					<div class="flex flex-row md:flex-col text-breeder-deepblue text-md">
						<p class="md:text-center max-w-[255px]"><strong>Numéros de puces iCad</strong> vérifié</p>
					</div>
				</div>

				<div class="flex flex-row md:flex-col items-center max-md:gap-x-4 md:gap-y-4 w-[282px]">
					<svg class="w-[35px] md:w-[84px]" viewBox="0 0 84 93" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path
							d="M37.5156 2.19238C40.201 0.651727 43.4991 0.603485 46.2227 2.04785L46.4844 2.19238L46.4854 2.19336L78.0137 20.2178V20.2295L78.5186 20.5176C81.2967 22.0983 82.9998 25.0313 83 28.1953V64.8135C83 67.9742 81.291 70.9013 78.5176 72.4932L46.4854 90.8066L46.4844 90.8076C43.799 92.3483 40.5009 92.3965 37.7773 90.9521L37.5156 90.8076L37.5146 90.8066L5.48242 72.4932L5.48145 72.4922L5.22363 72.3398C2.59794 70.7276 1 67.8788 1 64.8135V28.1865C1 25.0252 2.71011 22.0975 5.48438 20.5059L5.4834 20.5049L37.5146 2.19336L37.5156 2.19238Z"
							stroke="currentColor" stroke-width="2" />
						<path
							d="M52.7059 31.3043H56V66H28V31.3043H31.2941M34.5882 42.8696H49.4118M34.5882 51.1304H49.4118M37.8824 28H46.1176C47.9294 28 49.4118 29.487 49.4118 31.3043V34.6087H34.5882V31.3043C34.5882 29.487 36.0706 28 37.8824 28Z"
							stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>

					<div class="flex flex-row md:flex-col text-breeder-deepblue text-md">
						<p class="md:text-center max-w-[255px]"><strong>Certificat de formation</strong> vérifié</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>

