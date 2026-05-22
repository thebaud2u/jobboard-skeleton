<x-space-layout>
	@push('seo')
		<title>{{ __('My space') }}</title>
		<meta name="description" content="{{ __(':siteName', ['siteName' => env('APP_NAME')]) }}">
		<meta name="keywords" content="{{ __(':siteName, ', ['siteName' => env('APP_NAME')]) }}" />
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
	@endpush

	<x-slot name="side_menu">
		@include('components.front.space.profile.side-menu')
	</x-slot>

	<div class="flex-1 py-5">
		<div class="w-full bg-white px-6 py-10 mb-6 rounded-md text-jobboard-deepblue">
			<div class="flex flex-row justify-between items-center mb-8">
				<x-front.form-part-title>
					{{ __('My posts') }}
				</x-front.form-part-title>

				<div class="cursor-pointer" x-data="" x-on:click.prevent="$dispatch('open-modal', 'show_offer_post');">
					<x-front.primary-button>
						{{ __('Purchase credits') }}
					</x-front.primary-button>
				</div>
			</div>

			@if(Auth::guard('web')->user()->countPostCreditAvailable() > 0)
				<div class="flex items-center gap-x-2 my-2 font-medium text-sm">
					<svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.9676 25.7002C18.5771 25.7002 23.9352 20.1038 23.9352 13.2002C23.9352 6.29664 18.5771 0.700195 11.9676 0.700195C5.35808 0.700195 0 6.29664 0 13.2002C0 20.1038 5.35808 25.7002 11.9676 25.7002Z" fill="#C68CFF"/>
						<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" fill="#0E1954"/>
						<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" stroke="#0E1954" stroke-miterlimit="10"/>
						<path d="M14.4872 7.54373C14.4872 8.69339 13.5949 9.62536 12.4946 9.62536C11.3943 9.62536 10.502 8.69339 10.502 7.54373C10.502 6.39407 11.3943 5.4621 12.4946 5.4621C13.5949 5.4621 14.4872 6.39407 14.4872 7.54373Z" fill="#0E1954" stroke="#0E1954" stroke-miterlimit="10"/>
					</svg>

					{{ __('Credits available') }} :

					@foreach(Auth::guard('web')->user()->getPostCreditAvailable() as $credit)
						@if($credit['count'] > 0)
							<span class="font-semibold">
								{{ $credit['count'] }}

								@if($credit['offer'] == 'Annonce Standard')
									{{ __('standard') }}
								@elseif($credit['offer'] == 'Annonce Master')
									{{ __('master') }}
								@elseif($credit['offer'] == 'Annonce Premium')
									{{ __('premium') }}
								@endif

								@if($loop->last)@else<span class="ml-1">|</span>@endif
							</span>
						@endif
					@endforeach
				</div>
			@endif

			<div class="flex flex-col px-6 py-10 placeholder-yellow-100 gap-y-6 justify-center items-center w-full bg-jobboard-cream rounded-xl">
				<svg width="82" height="83" viewBox="0 0 82 83" fill="none" xmlns="http://www.w3.org/2000/svg">
					<ellipse cx="48.897" cy="36.6446" rx="7.54035" ry="25.9087" transform="rotate(-28.2079 48.897 36.6446)" fill="#C68CFF"/>
					<path d="M56 15L62 6" stroke="#FFA244" stroke-width="3" stroke-linecap="round"/>
					<path d="M70 42H80" stroke="#FFA244" stroke-width="3" stroke-linecap="round"/>
					<path d="M65 27L73 22" stroke="#FFA244" stroke-width="3" stroke-linecap="round"/>
					<g clip-path="url(#clip0_2932_45779)">
						<path d="M64.1756 56.9504C64.1756 56.9504 41.5324 53.5432 28.7218 61.7976L18.7551 68.2135C13.2499 71.7576 6.21281 69.6535 3.03718 63.5157C-0.138459 57.3778 1.74381 49.526 7.249 45.9819L17.2157 39.566C30.0301 31.3158 38.7072 7.73966 38.7072 7.73966M24.1484 64.7399L36.1279 79.5305C37.7157 81.4893 40.2801 81.8794 42.2481 80.6095C42.5425 80.4186 42.8295 80.1904 43.0904 79.9248C45.1106 77.8871 45.2709 74.4094 43.4445 72.156L33.202 59.5109M24.4466 64.5449C21.3008 66.5701 16.1758 63.2335 13.0002 57.0956C9.82081 50.9578 9.79472 44.3385 12.9405 42.3133M44.0819 28.6764L47.9284 27.448C49.3784 26.9832 50.9252 27.6846 51.6781 29.1412L54.0449 33.7187C54.7978 35.1712 54.5704 37.0096 53.4895 38.1799L50.6121 41.3007M64.1943 24.5513L73.1621 18.7745M70.6014 39.4789L80.5085 38.819M55.8079 10.8978L61.2758 1.65991M58.5595 27.7728C65.8212 41.8053 69.156 54.8181 66.0079 56.8377C62.8598 58.8573 54.421 49.119 47.1592 35.0865C39.8975 21.054 36.5627 8.04125 39.7108 6.02163C42.8589 4.00201 51.2978 13.7404 58.5595 27.7728Z" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					</g>
					<defs>
						<clipPath id="clip0_2932_45779">
							<rect width="82" height="83" fill="white"/>
						</clipPath>
					</defs>
				</svg>

				<h2 class="font-bold text-[40px] text-center">
					@if($user->posts)
						@if($post->exists)
							@if($postState)
								{{ __('Create my post') }}
							@else
								{{ __('Extend my post') }}
							@endif
						@else
							{{ __('Create my post') }}
						@endif
					@else
						{{ __('Create my first post') }}
					@endif
				</h2>

				<p class="font-medium mb-10">
					{{ __('Choose the post type :') }}
				</p>

				<div class="flex flex-col gap-y-6 text-jobboard-deepblue w-full">
					@foreach($offers as $offer)
						@php
							$options = $offer->options;
							$dateEnd = null;

							$remaining = Auth::guard('web')->user()->countCreditAvailable($offer->slug);
							$subscription = Auth::guard('web')->user()->hasOfferSubscription($offer->slug);

							if(!(empty($subscription))) $dateEnd = $subscription->end_date->format('d/m/Y');

							$color = 'text-jobboard-deepblue';
							$bg_primary = 'bg-jobboard-deepblue';
							switch ($offer->slug) {
								case 'annonce-standard':
									$name = 'Standard';
									$color = 'text-white';
									$bg_primary = 'bg-jobboard-deepblue';
									break;
								case 'annonce-premium':
									$name = 'Premium';
									$color = 'text-jobboard-deepblue';
									$bg_primary = 'bg-jobboard-violet';
									break;
								case 'annonce-master':
									$name = 'Master';
									$color = 'text-jobboard-deepblue';
									$bg_primary = 'bg-jobboard-orange';
									break;
							}
						@endphp

						<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] rounded-xl flex flex-row max-sm:flex-col">
							<div class="w-full sm:w-[290px] xl:w-1/3 flex items-center gap-x-4 {{ $bg_primary }} rounded-l-xl max-sm:rounded-bl-none max-sm:rounded-t-xl  {{ $color }} p-6">
								@if ($offer->slug == 'annonce-standard')
									<svg class="shrink-0 max-s:hidden" width="60" height="77" viewBox="0 0 60 77" fill="none" xmlns="http://www.w3.org/2000/svg">
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
								@elseif ($offer->slug == 'annonce-premium')
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
								@elseif ($offer->slug == 'annonce-master')
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
								@endif
								<div class="font-bold text-[28px]">
									{{ $name }}
								</div>

								<div x-data="{showDetail: false}" class="relative" @mouseleave="showDetail = false">
									<svg class="shrink-0 cursor-pointer" @mouseenter="showDetail = true" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.9676 25.7002C18.5771 25.7002 23.9352 20.1038 23.9352 13.2002C23.9352 6.29664 18.5771 0.700195 11.9676 0.700195C5.35808 0.700195 0 6.29664 0 13.2002C0 20.1038 5.35808 25.7002 11.9676 25.7002Z" fill="#F7F6EF"/>
										<path d="M8.51367 11.7428H13.8628L12.6741 18.7972C12.6463 18.9656 12.7707 19.1203 12.9361 19.1203H13.8628V20.668C12.5382 21.6323 8.923 22.0965 9.36836 18.3227L10.467 11.9231" fill="#0E1954"/>
										<path d="M8.51367 11.7428H13.8628L12.6741 18.7972C12.6463 18.9656 12.7707 19.1203 12.9361 19.1203H13.8628V20.668C12.5382 21.6323 8.923 22.0965 9.36836 18.3227L10.467 11.9231" stroke="#0E1954" stroke-miterlimit="10"/>
										<path d="M14.4872 7.54379C14.4872 8.69345 13.5949 9.62542 12.4946 9.62542C11.3943 9.62542 10.502 8.69345 10.502 7.54379C10.502 6.39413 11.3943 5.46216 12.4946 5.46216C13.5949 5.46216 14.4872 6.39413 14.4872 7.54379Z" fill="#0E1954" stroke="#0E1954" stroke-miterlimit="10"/>
									</svg>

									<div class="absolute rounded-xl bg-white p-6 flex flex-col gap-2 font-medium text-jobboard-deepblue left-2 top-2 z-[20] @if($offer->slug == 'annonce-standard') w-[242px] @else w-[290px] @endif"
										x-show="showDetail"
										x-transition:enter.duration.100ms
										x-transition:leave.duration.100ms
										style="display: none;"
									>
										<div class="flex items-center gap-x-4">
											<svg class="shrink-0" width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.382584C12.9276 0.13448 13.2725 -0.00268272 13.6304 3.97663e-05C13.9883 0.00276225 14.3311 0.145157 14.5865 0.397177C14.842 0.649196 14.9901 0.991129 14.9995 1.35082C15.009 1.71052 14.8791 2.05984 14.6372 2.32508L7.29535 11.5565C7.16911 11.6933 7.01674 11.803 6.84735 11.8791C6.67797 11.9553 6.49505 11.9963 6.30954 11.9998C6.12402 12.0032 5.93972 11.969 5.76764 11.8992C5.59557 11.8294 5.43927 11.7255 5.30807 11.5935L0.439241 6.69846C0.303652 6.57144 0.194899 6.41826 0.119471 6.24806C0.0440431 6.07786 0.00348419 5.89413 0.000214773 5.70783C-0.00305464 5.52153 0.0310325 5.33648 0.100442 5.16371C0.169851 4.99094 0.273161 4.834 0.404209 4.70225C0.535257 4.57049 0.691357 4.46663 0.863198 4.39684C1.03504 4.32706 1.2191 4.29279 1.4044 4.29608C1.5897 4.29936 1.77245 4.34014 1.94173 4.41598C2.11102 4.49181 2.26337 4.60115 2.38972 4.73747L6.24283 8.60951L12.6334 0.423284C12.6449 0.409041 12.6554 0.395453 12.6684 0.382584Z" fill="#3DD8AC"/>
											</svg>

											{{ __('Crédit valable 1 an') }}
										</div>

										<div class="flex items-center gap-x-4">
											<svg class="shrink-0" width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.382584C12.9276 0.13448 13.2725 -0.00268272 13.6304 3.97663e-05C13.9883 0.00276225 14.3311 0.145157 14.5865 0.397177C14.842 0.649196 14.9901 0.991129 14.9995 1.35082C15.009 1.71052 14.8791 2.05984 14.6372 2.32508L7.29535 11.5565C7.16911 11.6933 7.01674 11.803 6.84735 11.8791C6.67797 11.9553 6.49505 11.9963 6.30954 11.9998C6.12402 12.0032 5.93972 11.969 5.76764 11.8992C5.59557 11.8294 5.43927 11.7255 5.30807 11.5935L0.439241 6.69846C0.303652 6.57144 0.194899 6.41826 0.119471 6.24806C0.0440431 6.07786 0.00348419 5.89413 0.000214773 5.70783C-0.00305464 5.52153 0.0310325 5.33648 0.100442 5.16371C0.169851 4.99094 0.273161 4.834 0.404209 4.70225C0.535257 4.57049 0.691357 4.46663 0.863198 4.39684C1.03504 4.32706 1.2191 4.29279 1.4044 4.29608C1.5897 4.29936 1.77245 4.34014 1.94173 4.41598C2.11102 4.49181 2.26337 4.60115 2.38972 4.73747L6.24283 8.60951L12.6334 0.423284C12.6449 0.409041 12.6554 0.395453 12.6684 0.382584Z" fill="#3DD8AC"/>
											</svg>

											{{ __('Diffusion 3 mois') }}
										</div>

										<div class="flex items-center gap-x-4">
											<svg class="shrink-0" width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12.6684 0.382584C12.9276 0.13448 13.2725 -0.00268272 13.6304 3.97663e-05C13.9883 0.00276225 14.3311 0.145157 14.5865 0.397177C14.842 0.649196 14.9901 0.991129 14.9995 1.35082C15.009 1.71052 14.8791 2.05984 14.6372 2.32508L7.29535 11.5565C7.16911 11.6933 7.01674 11.803 6.84735 11.8791C6.67797 11.9553 6.49505 11.9963 6.30954 11.9998C6.12402 12.0032 5.93972 11.969 5.76764 11.8992C5.59557 11.8294 5.43927 11.7255 5.30807 11.5935L0.439241 6.69846C0.303652 6.57144 0.194899 6.41826 0.119471 6.24806C0.0440431 6.07786 0.00348419 5.89413 0.000214773 5.70783C-0.00305464 5.52153 0.0310325 5.33648 0.100442 5.16371C0.169851 4.99094 0.273161 4.834 0.404209 4.70225C0.535257 4.57049 0.691357 4.46663 0.863198 4.39684C1.03504 4.32706 1.2191 4.29279 1.4044 4.29608C1.5897 4.29936 1.77245 4.34014 1.94173 4.41598C2.11102 4.49181 2.26337 4.60115 2.38972 4.73747L6.24283 8.60951L12.6334 0.423284C12.6449 0.409041 12.6554 0.395453 12.6684 0.382584Z" fill="#3DD8AC"/>
											</svg>
	
											@if ($offer->slug == 'annonce-standard')
												{{ __('1 photo / animal') }}
											@elseif ($offer->slug == 'annonce-premium')
												{{ __('3 photos / animal') }}
											@elseif ($offer->slug == 'annonce-master')
												{{ __('5 photos / animal') }}
											@endif
										</div>

										@if ($offer->slug == 'annonce-premium' || $offer->slug == 'annonce-master')
											<div class="flex items-center gap-x-4">
												<svg class="shrink-0" width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M12.6684 0.382584C12.9276 0.13448 13.2725 -0.00268272 13.6304 3.97663e-05C13.9883 0.00276225 14.3311 0.145157 14.5865 0.397177C14.842 0.649196 14.9901 0.991129 14.9995 1.35082C15.009 1.71052 14.8791 2.05984 14.6372 2.32508L7.29535 11.5565C7.16911 11.6933 7.01674 11.803 6.84735 11.8791C6.67797 11.9553 6.49505 11.9963 6.30954 11.9998C6.12402 12.0032 5.93972 11.969 5.76764 11.8992C5.59557 11.8294 5.43927 11.7255 5.30807 11.5935L0.439241 6.69846C0.303652 6.57144 0.194899 6.41826 0.119471 6.24806C0.0440431 6.07786 0.00348419 5.89413 0.000214773 5.70783C-0.00305464 5.52153 0.0310325 5.33648 0.100442 5.16371C0.169851 4.99094 0.273161 4.834 0.404209 4.70225C0.535257 4.57049 0.691357 4.46663 0.863198 4.39684C1.03504 4.32706 1.2191 4.29279 1.4044 4.29608C1.5897 4.29936 1.77245 4.34014 1.94173 4.41598C2.11102 4.49181 2.26337 4.60115 2.38972 4.73747L6.24283 8.60951L12.6334 0.423284C12.6449 0.409041 12.6554 0.395453 12.6684 0.382584Z" fill="#3DD8AC"/>
												</svg>

												{{ __('Remontée dans la liste d\'annonce: 1 fois / mois') }}
											</div>

											<div class="flex items-center gap-x-4">
												<svg class="shrink-0" width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M12.6684 0.382584C12.9276 0.13448 13.2725 -0.00268272 13.6304 3.97663e-05C13.9883 0.00276225 14.3311 0.145157 14.5865 0.397177C14.842 0.649196 14.9901 0.991129 14.9995 1.35082C15.009 1.71052 14.8791 2.05984 14.6372 2.32508L7.29535 11.5565C7.16911 11.6933 7.01674 11.803 6.84735 11.8791C6.67797 11.9553 6.49505 11.9963 6.30954 11.9998C6.12402 12.0032 5.93972 11.969 5.76764 11.8992C5.59557 11.8294 5.43927 11.7255 5.30807 11.5935L0.439241 6.69846C0.303652 6.57144 0.194899 6.41826 0.119471 6.24806C0.0440431 6.07786 0.00348419 5.89413 0.000214773 5.70783C-0.00305464 5.52153 0.0310325 5.33648 0.100442 5.16371C0.169851 4.99094 0.273161 4.834 0.404209 4.70225C0.535257 4.57049 0.691357 4.46663 0.863198 4.39684C1.03504 4.32706 1.2191 4.29279 1.4044 4.29608C1.5897 4.29936 1.77245 4.34014 1.94173 4.41598C2.11102 4.49181 2.26337 4.60115 2.38972 4.73747L6.24283 8.60951L12.6334 0.423284C12.6449 0.409041 12.6554 0.395453 12.6684 0.382584Z" fill="#3DD8AC"/>
												</svg>
												@if ($offer->slug == 'annonce-premium')
													{{ __('Visibilité renforcée: annonce en couleur') }}
												@else
													{{ __('Visibilité renforcée: annonce en couleur et 3 fois plus grande') }}
												@endif
											</div>
										@endif
									</div>
								</div>
							</div>

							<div class="w-full max-xl:flex-wrap xl:w-2/3 flex items-center justify-between gap-x-2 gap-y-4 p-6">
								<div class="flex flex-col sm:max-w-[394px] w-full p-4 rounded-xl bg-jobboard-cream">
									@if($remaining > 0)
										<span class="font-bold">
											{{ ($remaining > 1) ? __(':x credits available', ['x' => $remaining]) : __(':x credit available', ['x' => $remaining]) }}
										</span>

										<p class="text-xs">
											{{ ($remaining > 1) ? __('Availables until :date', ['date' => (isset($dateEnd)) ? __($dateEnd) : __('date unavailable')]) : __('Available until :date', ['date' => (isset($dateEnd)) ? __($dateEnd) : __('date unavailable')]) }}
										</p>
									@else
										<span class="font-bold">
											{{ __('0 crédit')}}
										</span>
									@endif
								</div>

								@if($remaining > 0)
									<form method="POST" action="{{ route('space.posts.submit-form') }}" class="max-sm:mx-auto">
										@csrf

										<input type="hidden" name="id_offer" value="{{ $offer->id }}" />

										<x-front.primary-button>
											{{ __('Create my post') }}
										</x-front.primary-button>
									</form>
								@else
									<div class="cursor-pointer max-sm:mx-auto" x-data="" x-on:click.prevent="$dispatch('open-modal', 'show_offer_post');">
										<x-front.secondary-button :class="'py-3 px-5 font-bold'">
											{{ __('Purchase credits') }}
										</x-front.secondary-button>
									</div>
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<x-front.modal name="show_offer_post" :class="'w-full max-w-screen-xl'" focusable>
		<livewire:front.space.posts.show-offers 
			:post="$post" 
			:postState="$postState" />
	</x-front.modal>
</x-space-layout>
