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
			<div class="flex flex-col p-6 gap-y-6 justify-center items-center w-full bg-breeder-cream rounded-xl">
				<svg width="84" height="88" viewBox="0 0 84 88" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
					<path d="M16.8295 55.6387C15.0096 59.4317 12.8473 64.2723 10.2988 69.8074C11.0792 70.8176 12.5476 70.8436 13.3049 71.702C13.6389 71.7754 13.9499 71.94 14.1774 72.1983C14.8138 72.9275 15.5452 73.6542 16.4149 74.4214C17.2039 75.1177 18.0649 75.7862 18.9719 76.4141C20.907 77.7283 22.8277 78.6246 24.3107 78.9158C29.6236 77.0218 34.1388 75.3811 37.9744 73.9631C36.7361 73.4998 35.567 72.9376 34.5851 72.416C31.6565 70.8639 28.6013 68.7192 25.7505 66.215C22.9141 63.721 20.4751 61.0345 18.7041 58.4518" fill="#C68CFF"/>
					<path d="M65.7333 59.2877C65.755 60.259 65.5185 61.0164 65.0019 61.5359C62.037 64.5175 50.972 58.229 40.2933 47.49C29.6146 36.751 23.3615 25.6235 26.3264 22.6419C27.175 21.7884 28.6683 21.6902 30.6347 22.2424" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M60.6951 48.147C59.7922 46.8287 58.7721 45.4579 57.6543 44.0522" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M41.3242 28.1709C41.7323 28.4743 42.1512 28.7864 42.5701 29.1226L42.5809 29.1335" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M65.0043 61.5336C61.8854 64.6702 29.0723 78.0503 10.3173 85.5414C5.3187 87.5386 0.469879 82.6624 2.45586 77.6356C9.90489 58.7747 23.2098 25.7762 26.3288 22.6396" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M45.365 71.1071C43.2162 71.1944 40.2296 70.114 36.911 68.0928C33.881 66.2571 30.5841 63.6531 27.4022 60.4554C24.2225 57.2577 21.6439 53.9509 19.8164 50.9038" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M24.738 79.7268C22.7499 79.4343 20.1497 78.1378 17.5191 76.0969C16.5207 75.3089 15.4984 74.4118 14.5108 73.4165C13.5233 72.4212 12.642 71.4281 11.8672 70.4131" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M60.707 55.0512C60.707 55.0512 68.2277 49.6489 78.9715 53.9707" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M74.4043 36.11V33.0542" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M74.4043 48.3332V45.2773" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M78.9609 40.6938H81.9996" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M66.8066 40.6938H69.8453" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M72.3906 34.0861V31.0303" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M72.3906 46.3092V43.2534" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M76.9492 38.6699H79.9879" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M64.793 38.6699H67.8316" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M57.6914 7.07974V4.02393" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M57.6914 19.3029V16.2471" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M62.248 11.6636H65.2867" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M50.0938 11.6636H53.1324" stroke="#FFA244" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M55.6777 5.05582V2" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M55.6777 17.279V14.2231" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M60.2363 9.63965H63.275" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M48.082 9.63965H51.1207" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M68.2166 16.9409C67.4396 19.4598 66.3565 21.8717 64.9956 24.1046C63.3135 26.8658 61.091 29.4414 58.0957 30.6179C55.1005 31.7944 51.2197 31.2312 49.1425 28.6229C48.5543 27.8851 48.1202 26.964 48.1897 26.0363C48.3156 24.3556 50.1605 23.2446 51.8166 23.5044C53.4726 23.7641 54.8509 25.065 55.7039 26.5471C57.7289 30.0613 57.208 34.6581 54.9529 37.8733C52.6978 41.0862 48.9602 43.0005 45.0859 43.664" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M37.071 5.35254C37.071 5.35254 44.5916 17.2375 32.7734 29.1202" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				<h2 class="flex flex-col text-[40px] text-center">
					<span class="text-bold">
						{{ __('Congratulations for your order') }}
					</span>

					<span>
						{{ Auth::guard('web')->user()->name }} !
					</span>
				</h2>

				<a href="{{ $url }}">
					<x-front.primary-button>
						{{ $buttonLabel }}
					</x-front-primary-button>
				</a>

				<a href="{{ route('space.profile.dashboard') }}">
					<button type="button" class="text-sm font-bold">
						{{ __('Do it later') }}
					</button>
				</a>
			</div>
		</div>
	</div>

	<script>
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({
			event: 'purchase',
			product_type: '{{ $productType }}',
			ecommerce: {
				transaction_id: '{{ $transactionId }}',
				payment_type: '{{ $paymentType }}',
				value: {{ $price }},
				currency: 'EUR',
				items: [{
					item_name: '{{ $itemName }}',
					item_id: '{{ $itemId }}',
					item_category: '{{ $productType }}',
					price : {{ $price }},
					discount: {{ $discount }},
					quantity: {{ $quantity }}
				}]
			}
		});
	</script>
</x-space-layout>
