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
		<div class="w-full bg-white px-6 py-10 mb-6 rounded-md text-breeder-deepblue">
			@if($company)
				<div class="flex flex-row justify-between items-center mb-8">
					<x-front.form-part-title>
						{{ __('My posts') }}
					</x-front.form-part-title>

					<a href="{{ route('space.posts.show-offers') }}">
						<x-front.primary-button>
							{{ __('Create a post') }}
						</x-front.primary-button>
					</a>
				</div>

				@if(Auth::guard('web')->user()->countPostCreditAvailable() > 0)
					<div class="flex flex-col md:flex-row my-2 gap-y-2 font-medium text-sm md:items-center">
						<div class="flex items-center">
							<svg class="mr-2 shrink-0" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11.9676 25.7002C18.5771 25.7002 23.9352 20.1038 23.9352 13.2002C23.9352 6.29664 18.5771 0.700195 11.9676 0.700195C5.35808 0.700195 0 6.29664 0 13.2002C0 20.1038 5.35808 25.7002 11.9676 25.7002Z" fill="#C68CFF"/>
								<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" fill="#0E1954"/>
								<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" stroke="#0E1954" stroke-miterlimit="10"/>
								<path d="M14.4872 7.54373C14.4872 8.69339 13.5949 9.62536 12.4946 9.62536C11.3943 9.62536 10.502 8.69339 10.502 7.54373C10.502 6.39407 11.3943 5.4621 12.4946 5.4621C13.5949 5.4621 14.4872 6.39407 14.4872 7.54373Z" fill="#0E1954" stroke="#0E1954" stroke-miterlimit="10"/>
							</svg>
	
							<p class="whitespace-nowrap">
								{{ __('Credits available') }} :
							</p>
						</div>

						<div class="flex flex-col md:flex-row md:flex-wrap md:ml-1">
							@foreach(Auth::guard('web')->user()->getPostCreditAvailable() as $credit)
								<div class="flex flex-nowrap xseol:flex-row flex-col">
									@if($credit['count'] > 0)
										<span class="font-semibold">
											&nbsp;{{ $credit['count'] }}&nbsp;
										</span>
	
										@if($credit['offer'] == 'Annonce Standard')
											<span class="font-semibold">
												{{ __('standard') }}&nbsp; 
											</span>
											
											({{ __('available until :date', ['date' => $credit['end_date']]) }})
										@elseif($credit['offer'] == 'Annonce Master')
											<span class="font-semibold">
												{{ __('master') }}&nbsp; 
											</span>
											
											({{ __('available until :date', ['date' => $credit['end_date']]) }})
										@elseif($credit['offer'] == 'Annonce Premium')
											<span class="font-semibold">
												{{ __('premium') }}&nbsp; 
											</span>
											
											({{ __('available until :date', ['date' => $credit['end_date']]) }})
										@endif
											
										@if($loop->last)@else<span class="ml-1 hidden md:inline-block">|&nbsp;</span>@endif
									@endif
								</div>
							@endforeach
						</div>
					</div>
				@endif

				@if($posts->isNotEmpty())
					<hr class="h-px my-8 bg-breeder-deepblue border-0">

					<livewire:front.space.posts.filters />

					<livewire:front.space.posts.my-posts />
				@else
					<div class="flex flex-col p-6 gap-y-6 justify-center items-center w-full bg-breeder-cream h-[361px] rounded-xl">
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
							{{ __('Create my first post') }}
						</h2>

						@if(!Auth::guard('web')->user()->countPostCreditAvailable() > 0)
							<p class="font-medium">
								{{ __('To create a post, you need to purchase credits.') }}
							</p>
						@endif

						<a href="{{ route('space.posts.show-offers') }}">
							<x-front.primary-button>
								{{ __('Create a post') }}
							</x-front.primary-button>
						</a>
					</div>
				@endif
			@else
				<div class="flex flex-col p-6 gap-y-6 justify-center items-center w-full bg-breeder-cream h-[337px] rounded-xl">
					<svg width="82" height="83" viewBox="0 0 82 83" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2149_45769)">
							<path d="M64.1756 56.9505C64.1756 56.9505 41.5324 53.5433 28.7218 61.7977L18.7551 68.2136C13.2499 71.7577 6.21281 69.6536 3.03718 63.5158C-0.138459 57.3779 1.74381 49.5261 7.249 45.982L17.2157 39.5661C30.0301 31.3159 38.7072 7.73978 38.7072 7.73978M24.1484 64.74L36.1279 79.5306C37.7157 81.4894 40.2801 81.8795 42.2481 80.6096C42.5425 80.4187 42.8295 80.1905 43.0904 79.9249C45.1106 77.8872 45.2709 74.4095 43.4445 72.1561L33.202 59.511M24.4466 64.545C21.3008 66.5702 16.1758 63.2336 13.0002 57.0957C9.82081 50.9579 9.79472 44.3386 12.9405 42.3134M44.0819 28.6765L47.9284 27.4481C49.3784 26.9833 50.9252 27.6847 51.6781 29.1413L54.0449 33.7188C54.7978 35.1713 54.5704 37.0097 53.4895 38.18L50.6121 41.3008M64.1943 24.5514L73.1621 18.7746M70.6014 39.479L80.5085 38.8191M55.8079 10.8979L61.2758 1.66003M58.5595 27.7729C65.8212 41.8054 69.156 54.8182 66.0079 56.8378C62.8598 58.8574 54.421 49.1191 47.1592 35.0866C39.8975 21.0542 36.5627 8.04137 39.7108 6.02175C42.8589 4.00214 51.2978 13.7405 58.5595 27.7729Z" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
						</g>
						<defs>
							<clipPath id="clip0_2149_45769">
								<rect width="82" height="83" fill="white" />
							</clipPath>
						</defs>
					</svg>

					<h2 class="font-bold text-[40px] text-center">
						{{ __('Create my company') }}
					</h2>

					<a href="{{ route('space.companies.show-offers') }}">
						<x-front.primary-button>
							{{ __('Create my company') }}
						</x-front-primary-button>
					</a>
				</div>
			@endif
		</div>
	</div>
</x-space-layout>
