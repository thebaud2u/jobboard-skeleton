<div>
	<div class="w-full bg-white py-10 mb-6 max-sm:px-4">
		<div x-data="{isSelected: ''}" class="py-5 px-4 lg:px-6">
			@if($offers->isNotEmpty())
				<div class="flex flex-row justify-around flex-wrap mb-5">
					@foreach($offers as $offer)
						@php
							$options = $offer->options;
							$dateEnd = null;

							$prices = $offer->getPrices();

							$remaining = Auth::guard('web')->user()->countCreditAvailable($offer->slug);
							$subscription = Auth::guard('web')->user()->hasOfferSubscription($offer->slug);

							if(!(empty($subscription))) $dateEnd = $subscription->end_date->format('d/m/Y');

							$color = 'text-breeder-deepblue';
							$bg_primary = 'bg-breeder-deepblue';
							$border = 'border-breeder-deepblue';
							$bg_secondary = '';
							switch($offer->slug) {
								case 'annonce-standard':
									$color = 'text-white';
									$bg_primary = 'bg-breeder-deepblue';
									$border = 'border-breeder-deepblue';
									break;
								case 'annonce-premium':
									$color = 'text-breeder-deepblue';
									$bg_primary = 'bg-breeder-violet';
									break;
								case 'annonce-master':
									$color = 'text-breeder-deepblue';
									$bg_primary = 'bg-breeder-orange';
									break;
								default:
									$color = 'text-breeder-deepblue';
									$bg_primary = 'bg-breeder-deepblue';
									$border = 'border-breeder-deepblue';
									break;
							}
						@endphp

						<div class="flex flex-col w-[348px] shadow-md rounded-xl mb-4 text-breeder-deepblue">
							<div class="flex flex-col {{ $bg_primary }} items-center w-full py-4 rounded-t-xl">
								<h2 class="text-lg font-bold {{$color}} flex justify-center items-center gap-x-2">
									{{ __($offer->name) }}

									@switch($offer->slug)
										@case('annonce-standard')
											<svg width="60" height="77" viewBox="0 0 60 77" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect y="0.200195" width="60" height="76" rx="2" fill="white"/>
												<rect x="5" y="5.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.334" y="5.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.666" y="5.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="22.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.334" y="22.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.666" y="22.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="39.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.334" y="39.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.666" y="39.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="56.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.334" y="56.2002" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.666" y="56.2002" width="15" height="15" fill="#DDDBD2"/>
											</svg>
											@break
										@case('annonce-premium')
											<svg width="60" height="76" viewBox="0 0 60 76" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect width="60" height="76" rx="2" fill="white"/>
												<rect x="5" y="5" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.332" y="5" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.668" y="5" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="22" width="15" height="15" fill="#DDDBD2"/>
												<path d="M22.332 22H37.332V37H22.332V22Z" fill="#DDDBD2"/>
												<rect x="39.668" y="22" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="39" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.332" y="39" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.668" y="39" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="56" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.332" y="56" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.668" y="56" width="15" height="15" fill="#DDDBD2"/>
												<path d="M27.7109 42.6511L25.3378 46.7917L20.9998 49.0567L25.3378 51.3218L27.7109 55.4624L30.0832 51.3218L34.4219 49.0567L30.0832 46.7917L27.7109 42.6511Z" fill="#FFA244"/>
												<path d="M34.7277 51.4991L33.9728 52.8794L32.5926 53.6343L33.9728 54.3892L34.7277 55.7695L35.4827 54.3892L36.8633 53.6343L35.4827 52.8794L34.7277 51.4991Z" fill="#FFA244"/>
												<path d="M35.0305 37.7707L33.52 40.5315L30.7595 42.0411L33.52 43.5514L35.0305 46.3115L36.5403 43.5514L39.3008 42.0411L36.5403 40.5315L35.0305 37.7707Z" fill="#FFA244"/>
											</svg>
											@break
										@case('annonce-master')
											<svg width="60" height="76" viewBox="0 0 60 76" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect width="60" height="76" rx="2" fill="white"/>
												<rect x="5" y="5" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.332" y="5" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.668" y="5" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="22" width="15" height="15" fill="#DDDBD2"/>
												<path d="M22.332 22H37.332V37H22.332V22Z" fill="#0E1954"/>
												<rect x="39.668" y="22" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="39" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.332" y="39" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.668" y="39" width="15" height="15" fill="#DDDBD2"/>
												<rect x="5" y="56" width="15" height="15" fill="#DDDBD2"/>
												<rect x="22.332" y="56" width="15" height="15" fill="#DDDBD2"/>
												<rect x="39.668" y="56" width="15" height="15" fill="#DDDBD2"/>
												<path d="M26.2109 24.6501L23.8378 28.7907L19.4998 31.0558L23.8378 33.3208L26.2109 37.4614L28.5832 33.3208L32.9219 31.0558L28.5832 28.7907L26.2109 24.6501Z" fill="#FFA244"/>
												<path d="M33.2277 33.4981L32.4728 34.8785L31.0926 35.6333L32.4728 36.3882L33.2277 37.7686L33.9827 36.3882L35.3633 35.6333L33.9827 34.8785L33.2277 33.4981Z" fill="#FFA244"/>
												<path d="M33.5305 19.7697L32.02 22.5305L29.2595 24.0401L32.02 25.5504L33.5305 28.3105L35.0403 25.5504L37.8008 24.0401L35.0403 22.5305L33.5305 19.7697Z" fill="#FFA244"/>
											</svg>
											@break
										@default

									@endswitch
								</h2>
							</div>

							<div class="p-4 flex flex-col items-center justify-between min-h-[486px]">
								<div class="w-full flex flex-col gap-y-2 p-4">
									<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
										<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
										</svg>

										{{ __('Crédit valable 1 an') }}
									</p>

									<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
										<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
										</svg>

										{{ __('Diffusion 3 mois') }}
									</p>

									<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
										<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
										</svg>
										@switch($offer->slug)
											@case('annonce-standard')
												{{ __('1 photo / animal') }}
												@break
											@case('annonce-premium')
												{{ __('3 photos / animal') }}
												@break
											@case('annonce-master')
												{{ __('5 photos / animal') }}
												@break
											@default
										@endswitch
									</p>

									@if($offer->slug == 'annonce-standard')
										<p class="flex gap-x-2 shrink-0 items-center text-base font-medium text-breeder-greige">
											<svg class="shrink-0" width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.5 12.2307L11.5 2.23071M1.5 2.23071L11.5 12.2307" stroke="#DDDBD2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>

											{{ __('Remontée dans la liste d\'annonce') }}
										</p>

										<p class="flex gap-x-2 shrink-0 items-center text-base font-medium text-breeder-greige">
											<svg class="shrink-0" width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.5 12.2307L11.5 2.23071M1.5 2.23071L11.5 12.2307" stroke="#DDDBD2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>

											{{ __('Visibilité renforcée') }}
										</p>

										{{--<p class="flex gap-x-2 shrink-0 items-center text-base font-medium text-breeder-greige">
											<svg class="shrink-0" width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.5 12.2307L11.5 2.23071M1.5 2.23071L11.5 12.2307" stroke="#DDDBD2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>

											 {{ __('Relais sur nos réseaux sociaux') }}
										</p>--}}
									@elseif($offer->slug == 'annonce-premium')
										<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
											<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
											</svg>

											{{ __('Remontée dans la liste d\' annonce: 1 fois / mois') }}
										</p>

										<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
											<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
											</svg>

											{{ __('Visibilité renforcée') }}
										</p>

										{{-- <p class="flex gap-x-2 shrink-0 items-center text-base font-medium text-breeder-greige">
											<svg class="shrink-0" width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.5 12.2307L11.5 2.23071M1.5 2.23071L11.5 12.2307" stroke="#DDDBD2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>

											{{ __('Relais sur nos réseaux sociaux') }}
										</p>--}}
									@elseif($offer->slug == 'annonce-master')
										<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
											<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
											</svg>

											{{ __('Remontée dans la liste d\' annonce: 1 fois / semaine') }}
										</p>

										<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
											<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
											</svg>

											{{ __('Visibilité renforcée : annonce en couleur') }}
										</p>

										{{--<p class="flex gap-x-2 shrink-0 items-center text-base font-medium">
											<svg class="shrink-0" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.613297C12.9276 0.365192 13.2725 0.22803 13.6304 0.230753C13.9883 0.233475 14.3311 0.37587 14.5865 0.627889C14.842 0.879909 14.9901 1.22184 14.9995 1.58154C15.009 1.94123 14.8791 2.29055 14.6372 2.55579L7.29535 11.7873C7.16911 11.924 7.01674 12.0337 6.84735 12.1098C6.67797 12.186 6.49505 12.227 6.30954 12.2305C6.12402 12.2339 5.93972 12.1997 5.76764 12.1299C5.59557 12.0601 5.43927 11.9562 5.30807 11.8243L0.439241 6.92918C0.303652 6.80215 0.194899 6.64897 0.119471 6.47877C0.0440431 6.30857 0.00348419 6.12485 0.000214773 5.93855C-0.00305464 5.75225 0.0310325 5.56719 0.100442 5.39443C0.169851 5.22166 0.273161 5.06472 0.404209 4.93296C0.535257 4.80121 0.691357 4.69734 0.863198 4.62756C1.03504 4.55777 1.2191 4.5235 1.4044 4.52679C1.5897 4.53008 1.77245 4.57085 1.94173 4.64669C2.11102 4.72252 2.26337 4.83186 2.38972 4.96818L6.24283 8.84022L12.6334 0.653997C12.6449 0.639754 12.6554 0.626166 12.6684 0.613297Z" fill="#3DD8AC"/>
											</svg>

											 {{ __('Relais sur nos réseaux sociaux') }}
										</p>--}}
									@endif
								</div>

								<hr class="w-full border border-breeder-deepblue my-4">
								<div class="w-full flex flex-col justify-between">
									@if($remaining > 0)
										<div class="w-full">
											<div class="my-2 border w-full flex justify-center items-center rounded-xl h-[60px] p-2" x-bind:class="{'{{ $border }} {{ $bg_secondary }}':isSelected=={{ $offer->id }}, 'border-gray-300 bg-gray-200':isSelected!={{ $offer->id }}}">
												<div class="flex flex-col">
													<span class="font-bold">
														{{ ($remaining > 1) ? __(':x credits available', ['x' => $remaining]) : __(':x credit available', ['x' => $remaining]) }}
													</span>

													<p class="text-xs">
														{{ ($remaining > 1) ? __('Availables until :date', ['date' => (isset($dateEnd)) ? __($dateEnd) : __('date unavailable')]) : __('Available until :date', ['date' => (isset($dateEnd)) ? __($dateEnd) : __('date unavailable')]) }}
													</p>
												</div>
											</div>
										</div>

										<x-front.primary-button :class="'mt-4 w-full justify-center'" wire:click="submitForm({{ $offer->id }})">
											{{ __('Use a credit') }}
										</x-front.primary-button>
									@else
										<form method="POST" action="{{ route('space.posts.offer-chosen') }}">
											@csrf

											<input type="hidden" name="offer" value="{{ $offer->slug }}" />
											<input type="hidden" name="type" value="{{ $postState }}" />

											@if($post->exists)
												<input type="hidden" name="post" value="{{ $post->slug }}" />
											@endif

											<div class="w-full">
												<div x-data="{ selectedIndex: 0 }" class="w-full flex flex-col justify-center items-center gap-2">
													<select name="price" x-model="selectedIndex" class="w-full text-breeder-deepblue mt-1 block border border-breeder-greige rounded-xl focus:ring-abreeder-deepblue focus:border-breeder-deepblue">
														@foreach($prices as $index => $price)
															<option value="{{ $index }}">
																{{ $price['label'] }}
															</option>
														@endforeach
													</select>

													@foreach($prices as $index => $price)
														<div x-show="selectedIndex == {{ $index }}"
															x-transition:enter="transition ease-out duration-300"
															x-transition:enter-start="opacity-0 scale-95"
															x-transition:enter-end="opacity-100 scale-100"
															x-cloak
															class="flex flex-row justify-center items-center gap-1"
														>
															<span class="text-[28px] font-bold current-price">
																{{ $price['price'] }}€
															</span>

															@if(isset($price['instead_of']))
																<span class="text-base">
																	{{ __('instead of') }}

																	<span class="line-through">
																		{{ $price['instead_of'] }}€
																	</span>
																</span>
															@endif
														</div>
													@endforeach
												</div>
											</div>

											<div class="w-full">
												<x-front.primary-button :class="'mt-4 w-full justify-center'"
													x-on:click.prevent="
													 	$nextTick(() => {
															const allPrices = [...$el.closest('form').querySelectorAll('.current-price')];
															const priceEl = allPrices.find(el => {
																// visible si l'élément a une boîte de rendu (aucun parent en display:none)
																return el.getClientRects().length > 0 && el.offsetWidth > 0 && el.offsetHeight > 0;
															});

															const priceText = priceEl ? priceEl.innerText : '0€';
															const priceValue = parseFloat(priceText.replace('€', '').trim()) || 0;

															const select = $el.closest('form').querySelector(`select[name='price']`);
															const selectedOption = select ? select.options[select.selectedIndex] : null;
															const itemName = `{{ __($offer->name) }}`;

															const insteadAll = [...$el.closest('form').querySelectorAll('.line-through')];
															const insteadEl = insteadAll.find(el => el.getClientRects().length > 0 && el.offsetWidth > 0 && el.offsetHeight > 0);
															const insteadText = insteadEl ? insteadEl.innerText : '';
															const insteadValue = insteadText ? parseFloat(insteadText.replace('€', '').trim()) : 0;
															const discount = insteadValue > priceValue ? (insteadValue - priceValue) : 0;
															let offerType = {{ $offer->slug}};
															let quantity;
															switch(offerType) {
																case 'annonce-standard':
																	switch(priceValue) {
																		case 60:
																			quantity = 10;
																			break;
																		case 45:
																			quantity = 5;
																			break;
																		case 30:
																			quantity = 3;
																			break;
																		default:
																			quantity = 1;
																	}
																	break;
																case 'annonce-premium':
																	switch(priceValue) {
																		case 100:
																			quantity = 10;
																			break;
																		case 60:
																			quantity = 5;
																			break;
																		case 45:
																			quantity = 3;
																			break;
																		default:
																			quantity = 1;
																	}
																	break;
																case 'annonce-master':
																	switch(priceValue) {
																		case 150:
																			quantity = 10;
																			break;
																		case 100:
																			quantity = 5;
																			break;
																		case 70:
																			quantity = 3;
																			break;
																		default:
																			quantity = 1;
																	}
																	break;
															}

															window.dataLayer = window.dataLayer || [];
															window.dataLayer.push({
																event: 'begin_checkout',
																product_type: 'credit',
																ecommerce: {
																	value: priceValue,
																	currency: 'EUR',
																	items: [{
																		item_name: itemName,
																		item_id: `{{ $offer->id }}`,
																		item_category: 'credit',
																		price: priceValue,
																		discount: discount,
																		quantity: quantity
																	}]
																}
															});
														});
														$el.closest('form').submit();
													"
												>
													{{ __('Order') }}
												</x-front.primary-button>
											</div>
										</form>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>
	</div>
</div>
