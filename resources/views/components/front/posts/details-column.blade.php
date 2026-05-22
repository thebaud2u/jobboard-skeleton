@props([
	'type' => null,
	'postType' => null,
	'animal' => null,
	'post' => null,
	'addressInFrance' => false
])

@if($postType != 'litter')
	<div class="flex flex-col justify-center items-center mb-4 gap-2 p-4 bg-jobboard-cream text-jobboard-deepblue rounded-t-xl w-full">
		@if($animal->species->getTranslation('slug', 'en') == 'cat')
			<svg width="31" height="28" viewBox="0 0 31 28" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g clip-path="url(#clip0_787_15009)">
					<path d="M16.8051 16.1234C16.4529 15.9003 14.5602 16.2136 13.966 16.0902C13.5923 17.0848 14.7111 17.5477 14.5961 18.229C14.2511 20.2872 12.3729 19.5584 12.2746 20.4819C12.1572 21.5928 13.3551 21.3911 14.105 21.0919C14.6297 20.883 15.1136 20.1756 15.3149 20.14C15.5401 20.0997 17.84 22.3928 18.6498 20.8403C19.1122 19.9572 16.714 19.9596 16.2732 18.4118C16.0049 17.467 17.7226 16.7026 16.8051 16.1234Z" fill="#3DD8AC"/>
					<path d="M21.2733 15.6178C19.6226 15.6178 17.8473 12.5839 17.3155 11.2308C16.8699 10.0985 16.4722 7.40648 16.084 6.75603C14.2537 4.90202 14.2992 9.51211 13.7961 10.5804C13.2115 12.6599 11.7429 15.0907 9.53637 15.6178L3.17556 13.9465C3.05817 12.7074 4.80949 11.048 5.05865 10.2243C5.36291 9.22013 4.30398 4.96137 4.38543 3.51093C4.40699 3.11924 4.31356 0.424874 5.58332 0.0497995C6.57039 -0.242189 7.64609 0.818939 7.97911 1.13704C12.591 5.52398 10.8996 5.59045 15.4995 4.72161C18.4894 4.15662 19.1075 5.59283 19.5939 5.17502C21.2541 2.56375 26.084 -3.58225 26.1871 3.27354C26.3452 5.09906 25.4995 9.17027 25.7534 10.2124C25.8445 10.5827 27.0376 12.2397 27.3562 12.9186C27.5023 13.2296 27.5958 13.9086 27.6365 13.9442M10.0682 10.9103C8.33608 11.4041 8.96377 14.1863 10.6792 13.918C12.8306 13.5833 12.2364 10.2907 10.0682 10.9103ZM21.3236 11.1786C19.7855 9.93941 17.603 12.2112 19.4837 13.5905C21.0577 14.7465 22.7132 12.2991 21.3236 11.1786Z" fill="#3DD8AC"/>
					<path d="M7.97177 19.0314C9.01873 18.8391 9.59611 19.9311 8.87019 20.3061C8.24729 20.6266 5.10402 21.9061 5.01538 21.6996C4.92673 21.4931 6.50555 23.321 6.79784 23.5512C12.1428 27.9382 21.8769 27.4824 25.7054 21.5548C24.9483 21.3317 22.5453 20.7311 22.1093 20.2492C21.7475 19.8503 21.7308 19.1073 22.2602 18.9578C23.1754 19.0456 26.944 20.4319 28.0988 20.8403C23.2904 30.8367 7.76574 29.9275 2.46387 20.8403C2.46387 20.8403 7.07815 19.1952 7.96938 19.0314H7.97177Z" fill="#3DD8AC"/>
					<path d="M16.8051 16.1234C17.7226 16.705 16.0049 17.467 16.2732 18.4119C16.714 19.9596 19.1122 19.9573 18.6498 20.8403C17.84 22.3929 15.5401 20.0997 15.3149 20.14C15.1136 20.1757 14.6273 20.8807 14.105 21.092C13.3551 21.3911 12.1572 21.5952 12.2746 20.4819C12.3729 19.5608 14.2511 20.2872 14.5961 18.2291C14.7111 17.5478 13.5923 17.0849 13.966 16.0902C14.6536 15.6154 16.4553 15.9003 16.8051 16.1234Z" fill="#3DD8AC"/>
					<path d="M7.71696 16.4538L0.900714 16.8503C0.5203 16.8724 0.230019 17.1959 0.252354 17.5729C0.274688 17.9498 0.601179 18.2375 0.981593 18.2153L7.79784 17.8188C8.17825 17.7967 8.46853 17.4732 8.4462 17.0962C8.42386 16.7193 8.09737 16.4317 7.71696 16.4538Z" fill="#3DD8AC"/>
					<path d="M22.701 17.818L29.5173 18.2146C29.8977 18.2367 30.2242 17.9491 30.2465 17.5721C30.2688 17.1952 29.9785 16.8717 29.5981 16.8496L22.7819 16.453C22.4015 16.4309 22.075 16.7185 22.0526 17.0955C22.0303 17.4724 22.3206 17.7959 22.701 17.818Z" fill="#3DD8AC"/>
					<path d="M21.5653 15.617L29.4998 13.9788C29.8729 13.9018 30.1123 13.5397 30.0345 13.1701C29.9568 12.8004 29.5914 12.5632 29.2183 12.6402L21.2838 14.2784C20.9107 14.3554 20.6713 14.7175 20.7491 15.0871C20.8268 15.4568 21.1922 15.694 21.5653 15.617Z" fill="#3DD8AC"/>
					<path d="M9.57778 14.2774L1.64325 12.6392C1.2702 12.5622 0.90476 12.7994 0.827028 13.1691C0.749296 13.5387 0.988704 13.9008 1.36176 13.9778L9.29628 15.616C9.66934 15.693 10.0348 15.4558 10.1125 15.0861C10.1902 14.7165 9.95083 14.3544 9.57778 14.2774Z" fill="#3DD8AC"/>
				</g>

				<defs>
					<clipPath id="clip0_787_15009">
						<rect width="30" height="28" fill="white" transform="translate(0.25)"/>
					</clipPath>
				</defs>
			</svg>
		@elseif($animal->species->getTranslation('slug', 'en') == 'dog')
			<svg width="32" height="25" viewBox="0 0 32 25" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M11.6744 0.310716C10.7611 -0.593908 8.87499 0.739778 7.95741 1.05471C5.47231 1.90649 2.8003 2.1411 1.27526 4.55061C-1.27993 8.59183 2.9596 17.5345 7.03771 14.512C9.2212 12.893 7.17365 8.54533 8.84738 6.16752C9.51857 5.2164 10.7611 4.85497 11.4153 3.65022C11.8168 2.91257 12.3138 0.942685 11.6723 0.308603L11.6744 0.310716ZM29.9155 3.50438C28.3926 1.98892 26.4406 1.9551 24.5672 1.32313C22.8192 0.735551 19.5163 -1.74582 20.0282 2.24889C20.3723 4.93318 23.2864 5.29037 23.7389 7.43357C24.1998 9.62116 22.8064 14.1823 25.7376 14.9538C27.9338 15.5308 29.3229 13.9667 30.2447 12.2399C31.6699 9.57043 32.271 5.84414 29.9176 3.50438H29.9155ZM11.2433 7.27083C9.62052 7.60266 10.1027 10.2024 11.5789 10.139C13.5266 10.0544 13.4884 6.81217 11.2433 7.27083ZM19.2126 9.71627C20.5316 11.0986 22.7236 8.8053 21.275 7.55828C19.8264 6.31125 18.0699 8.51785 19.2126 9.71627ZM7.26286 15.2666V24.4608C7.26286 24.5961 7.77475 24.9659 8.01264 24.9913C9.88814 25.1942 8.82189 21.8251 8.9642 20.762C11.1647 22.5797 13.6965 23.2307 15.8949 20.9902C18.1676 23.1081 20.4063 22.6325 22.7682 20.9733V24.2494C22.7682 25.2661 24.6798 25.0906 24.6798 24.4608V15.2666C22.405 15.1821 22.919 16.5031 22.388 17.953C21.7274 19.7517 19.3336 21.5926 17.5792 19.9039C16.8889 19.2402 16.5852 17.3295 16.8188 16.4735C16.9208 16.0972 18.7941 15.5731 18.4819 13.9477C18.0104 11.498 13.3375 11.8278 13.4374 14.2986C13.5032 15.9176 15.0984 16.3255 15.1323 16.465C15.8418 19.4114 13.2101 22.0238 10.6549 19.6079C8.93021 17.9762 9.96036 15.0531 7.26286 15.2687V15.2666Z" fill="#FF7E71"/>
				<path d="M11.6744 0.310627C12.3159 0.944709 11.8167 2.91459 11.4174 3.65224C10.7632 4.857 9.51854 5.21842 8.84948 6.16955C7.17363 8.54524 9.22118 12.895 7.03982 14.5141C2.95958 17.5344 -1.27995 8.59174 1.27524 4.55052C2.80028 2.14101 5.47229 1.9064 7.95739 1.05462C8.87497 0.739689 10.7611 -0.596111 11.6744 0.310627Z" fill="#FF7E71"/>
				<path d="M29.9153 3.5045C32.2688 5.84426 31.6677 9.57055 30.2424 12.24C29.3206 13.9647 27.9315 15.5309 25.7353 14.9539C22.802 14.1824 24.1975 9.62127 23.7366 7.43369C23.2842 5.29049 20.37 4.93329 20.0259 2.24901C19.514 -1.7457 22.8169 0.735671 24.5649 1.32325C26.4383 1.95522 28.3903 1.98904 29.9132 3.5045H29.9153Z" fill="#FF7E71"/>
				<path d="M7.2627 15.2662C9.9602 15.0527 8.93005 17.9737 10.6547 19.6054C13.2078 22.0212 15.8395 19.4088 15.1322 16.4625C15.0982 16.323 13.5031 15.915 13.4372 14.296C13.3374 11.8252 18.0102 11.4955 18.4817 13.9452C18.794 15.5705 16.9206 16.0968 16.8186 16.4709C16.5871 17.3269 16.8909 19.2376 17.579 19.9013C19.3335 21.5922 21.7272 19.7491 22.3878 17.9504C22.9209 16.5005 22.4048 15.1795 24.6796 15.264V24.4582C24.6796 25.0881 22.768 25.2635 22.768 24.2469V20.9708C20.4061 22.63 18.1674 23.1055 15.8947 20.9877C13.6963 23.2281 11.1645 22.5771 8.96403 20.7594C8.82172 21.8226 9.88798 25.1938 8.01247 24.9887C7.77458 24.9634 7.2627 24.5935 7.2627 24.4582V15.264V15.2662Z" fill="#FF7E71"/>
				<path d="M19.2126 9.71602C18.0699 8.51761 19.7988 6.28987 21.275 7.55803C22.7512 8.8262 20.5316 11.0983 19.2126 9.71602Z" fill="#FF7E71"/>
				<path d="M11.2437 7.27096C13.4909 6.81231 13.527 10.0567 11.5793 10.1391C10.1031 10.2025 9.62097 7.60279 11.2437 7.27096Z" fill="#FF7E71"/>
			</svg>
		@endif

		<div class="text-center mx-auto">
			@if($postType == 'litter-yet-to-come')
				@php
					$value = $post->model->values->get('expected_birth_date');

					if(preg_match('/^\d{2}\/\d{4}$/', $value)) {
						// 10/2025
						$date = Carbon::createFromFormat('m/Y', $value);
						$formatted = $date->translatedFormat('F Y');
					}
					elseif(preg_match('/^\d{4}-\d{2}$/', $value)) {
						// 2025-10
						$date = Carbon::createFromFormat('Y-m', $value);
						$formatted = $date->translatedFormat('F Y');
					}
					else $formatted = $value;
				@endphp
				{!! __('Birth expected <strong>:date</strong>', ['date' => $formatted]) !!}
			@else
				{!! $animal->getConstructedName(true) !!}
			@endif
		</div>
	</div>
@endif

<div class="flex flex-col gap-y-4 mb-4 text-sm rounded-t-xl pb-6">
	@if($postType == 'litter')
		@if($type == 'animal')
			<div class="flex flex-col items-center p-4 gap-2 bg-jobboard-cream rounded-t-xl">
				@if($animal->species->getTranslation('slug', 'en') == 'cat')
					<svg width="31" height="28" viewBox="0 0 31 28" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_787_15009)">
							<path d="M16.8051 16.1234C16.4529 15.9003 14.5602 16.2136 13.966 16.0902C13.5923 17.0848 14.7111 17.5477 14.5961 18.229C14.2511 20.2872 12.3729 19.5584 12.2746 20.4819C12.1572 21.5928 13.3551 21.3911 14.105 21.0919C14.6297 20.883 15.1136 20.1756 15.3149 20.14C15.5401 20.0997 17.84 22.3928 18.6498 20.8403C19.1122 19.9572 16.714 19.9596 16.2732 18.4118C16.0049 17.467 17.7226 16.7026 16.8051 16.1234Z" fill="#3DD8AC"/>
							<path d="M21.2733 15.6178C19.6226 15.6178 17.8473 12.5839 17.3155 11.2308C16.8699 10.0985 16.4722 7.40648 16.084 6.75603C14.2537 4.90202 14.2992 9.51211 13.7961 10.5804C13.2115 12.6599 11.7429 15.0907 9.53637 15.6178L3.17556 13.9465C3.05817 12.7074 4.80949 11.048 5.05865 10.2243C5.36291 9.22013 4.30398 4.96137 4.38543 3.51093C4.40699 3.11924 4.31356 0.424874 5.58332 0.0497995C6.57039 -0.242189 7.64609 0.818939 7.97911 1.13704C12.591 5.52398 10.8996 5.59045 15.4995 4.72161C18.4894 4.15662 19.1075 5.59283 19.5939 5.17502C21.2541 2.56375 26.084 -3.58225 26.1871 3.27354C26.3452 5.09906 25.4995 9.17027 25.7534 10.2124C25.8445 10.5827 27.0376 12.2397 27.3562 12.9186C27.5023 13.2296 27.5958 13.9086 27.6365 13.9442M10.0682 10.9103C8.33608 11.4041 8.96377 14.1863 10.6792 13.918C12.8306 13.5833 12.2364 10.2907 10.0682 10.9103ZM21.3236 11.1786C19.7855 9.93941 17.603 12.2112 19.4837 13.5905C21.0577 14.7465 22.7132 12.2991 21.3236 11.1786Z" fill="#3DD8AC"/>
							<path d="M7.97177 19.0314C9.01873 18.8391 9.59611 19.9311 8.87019 20.3061C8.24729 20.6266 5.10402 21.9061 5.01538 21.6996C4.92673 21.4931 6.50555 23.321 6.79784 23.5512C12.1428 27.9382 21.8769 27.4824 25.7054 21.5548C24.9483 21.3317 22.5453 20.7311 22.1093 20.2492C21.7475 19.8503 21.7308 19.1073 22.2602 18.9578C23.1754 19.0456 26.944 20.4319 28.0988 20.8403C23.2904 30.8367 7.76574 29.9275 2.46387 20.8403C2.46387 20.8403 7.07815 19.1952 7.96938 19.0314H7.97177Z" fill="#3DD8AC"/>
							<path d="M16.8051 16.1234C17.7226 16.705 16.0049 17.467 16.2732 18.4119C16.714 19.9596 19.1122 19.9573 18.6498 20.8403C17.84 22.3929 15.5401 20.0997 15.3149 20.14C15.1136 20.1757 14.6273 20.8807 14.105 21.092C13.3551 21.3911 12.1572 21.5952 12.2746 20.4819C12.3729 19.5608 14.2511 20.2872 14.5961 18.2291C14.7111 17.5478 13.5923 17.0849 13.966 16.0902C14.6536 15.6154 16.4553 15.9003 16.8051 16.1234Z" fill="#3DD8AC"/>
							<path d="M7.71696 16.4538L0.900714 16.8503C0.5203 16.8724 0.230019 17.1959 0.252354 17.5729C0.274688 17.9498 0.601179 18.2375 0.981593 18.2153L7.79784 17.8188C8.17825 17.7967 8.46853 17.4732 8.4462 17.0962C8.42386 16.7193 8.09737 16.4317 7.71696 16.4538Z" fill="#3DD8AC"/>
							<path d="M22.701 17.818L29.5173 18.2146C29.8977 18.2367 30.2242 17.9491 30.2465 17.5721C30.2688 17.1952 29.9785 16.8717 29.5981 16.8496L22.7819 16.453C22.4015 16.4309 22.075 16.7185 22.0526 17.0955C22.0303 17.4724 22.3206 17.7959 22.701 17.818Z" fill="#3DD8AC"/>
							<path d="M21.5653 15.617L29.4998 13.9788C29.8729 13.9018 30.1123 13.5397 30.0345 13.1701C29.9568 12.8004 29.5914 12.5632 29.2183 12.6402L21.2838 14.2784C20.9107 14.3554 20.6713 14.7175 20.7491 15.0871C20.8268 15.4568 21.1922 15.694 21.5653 15.617Z" fill="#3DD8AC"/>
							<path d="M9.57778 14.2774L1.64325 12.6392C1.2702 12.5622 0.90476 12.7994 0.827028 13.1691C0.749296 13.5387 0.988704 13.9008 1.36176 13.9778L9.29628 15.616C9.66934 15.693 10.0348 15.4558 10.1125 15.0861C10.1902 14.7165 9.95083 14.3544 9.57778 14.2774Z" fill="#3DD8AC"/>
						</g>

						<defs>
							<clipPath id="clip0_787_15009">
								<rect width="30" height="28" fill="white" transform="translate(0.25)"/>
							</clipPath>
						</defs>
					</svg>
				@elseif($animal->species->getTranslation('slug', 'en') == 'dog')
					<svg width="32" height="25" viewBox="0 0 32 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6744 0.310716C10.7611 -0.593908 8.87499 0.739778 7.95741 1.05471C5.47231 1.90649 2.8003 2.1411 1.27526 4.55061C-1.27993 8.59183 2.9596 17.5345 7.03771 14.512C9.2212 12.893 7.17365 8.54533 8.84738 6.16752C9.51857 5.2164 10.7611 4.85497 11.4153 3.65022C11.8168 2.91257 12.3138 0.942685 11.6723 0.308603L11.6744 0.310716ZM29.9155 3.50438C28.3926 1.98892 26.4406 1.9551 24.5672 1.32313C22.8192 0.735551 19.5163 -1.74582 20.0282 2.24889C20.3723 4.93318 23.2864 5.29037 23.7389 7.43357C24.1998 9.62116 22.8064 14.1823 25.7376 14.9538C27.9338 15.5308 29.3229 13.9667 30.2447 12.2399C31.6699 9.57043 32.271 5.84414 29.9176 3.50438H29.9155ZM11.2433 7.27083C9.62052 7.60266 10.1027 10.2024 11.5789 10.139C13.5266 10.0544 13.4884 6.81217 11.2433 7.27083ZM19.2126 9.71627C20.5316 11.0986 22.7236 8.8053 21.275 7.55828C19.8264 6.31125 18.0699 8.51785 19.2126 9.71627ZM7.26286 15.2666V24.4608C7.26286 24.5961 7.77475 24.9659 8.01264 24.9913C9.88814 25.1942 8.82189 21.8251 8.9642 20.762C11.1647 22.5797 13.6965 23.2307 15.8949 20.9902C18.1676 23.1081 20.4063 22.6325 22.7682 20.9733V24.2494C22.7682 25.2661 24.6798 25.0906 24.6798 24.4608V15.2666C22.405 15.1821 22.919 16.5031 22.388 17.953C21.7274 19.7517 19.3336 21.5926 17.5792 19.9039C16.8889 19.2402 16.5852 17.3295 16.8188 16.4735C16.9208 16.0972 18.7941 15.5731 18.4819 13.9477C18.0104 11.498 13.3375 11.8278 13.4374 14.2986C13.5032 15.9176 15.0984 16.3255 15.1323 16.465C15.8418 19.4114 13.2101 22.0238 10.6549 19.6079C8.93021 17.9762 9.96036 15.0531 7.26286 15.2687V15.2666Z" fill="#FF7E71"/>
						<path d="M11.6744 0.310627C12.3159 0.944709 11.8167 2.91459 11.4174 3.65224C10.7632 4.857 9.51854 5.21842 8.84948 6.16955C7.17363 8.54524 9.22118 12.895 7.03982 14.5141C2.95958 17.5344 -1.27995 8.59174 1.27524 4.55052C2.80028 2.14101 5.47229 1.9064 7.95739 1.05462C8.87497 0.739689 10.7611 -0.596111 11.6744 0.310627Z" fill="#FF7E71"/>
						<path d="M29.9153 3.5045C32.2688 5.84426 31.6677 9.57055 30.2424 12.24C29.3206 13.9647 27.9315 15.5309 25.7353 14.9539C22.802 14.1824 24.1975 9.62127 23.7366 7.43369C23.2842 5.29049 20.37 4.93329 20.0259 2.24901C19.514 -1.7457 22.8169 0.735671 24.5649 1.32325C26.4383 1.95522 28.3903 1.98904 29.9132 3.5045H29.9153Z" fill="#FF7E71"/>
						<path d="M7.2627 15.2662C9.9602 15.0527 8.93005 17.9737 10.6547 19.6054C13.2078 22.0212 15.8395 19.4088 15.1322 16.4625C15.0982 16.323 13.5031 15.915 13.4372 14.296C13.3374 11.8252 18.0102 11.4955 18.4817 13.9452C18.794 15.5705 16.9206 16.0968 16.8186 16.4709C16.5871 17.3269 16.8909 19.2376 17.579 19.9013C19.3335 21.5922 21.7272 19.7491 22.3878 17.9504C22.9209 16.5005 22.4048 15.1795 24.6796 15.264V24.4582C24.6796 25.0881 22.768 25.2635 22.768 24.2469V20.9708C20.4061 22.63 18.1674 23.1055 15.8947 20.9877C13.6963 23.2281 11.1645 22.5771 8.96403 20.7594C8.82172 21.8226 9.88798 25.1938 8.01247 24.9887C7.77458 24.9634 7.2627 24.5935 7.2627 24.4582V15.264V15.2662Z" fill="#FF7E71"/>
						<path d="M19.2126 9.71602C18.0699 8.51761 19.7988 6.28987 21.275 7.55803C22.7512 8.8262 20.5316 11.0983 19.2126 9.71602Z" fill="#FF7E71"/>
						<path d="M11.2437 7.27096C13.4909 6.81231 13.527 10.0567 11.5793 10.1391C10.1031 10.2025 9.62097 7.60279 11.2437 7.27096Z" fill="#FF7E71"/>
					</svg>
				@endif

				@if($animal->name)
					<h4 class="text-center text-base">
						{!! $animal->getConstructedName(true) !!}
					</h4>
				@endif
			</div>

			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Temporary name') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $post->model->values->get('is_name_temporary') ? __('Yes') : __('No') }}
				</span>
			</div>
		@endif

		<div class="flex flex-row @if(is_null($post->model->values->get('is_name_temporary')) && $type != 'animal') pt-6 @endif px-6">
			<span class="w-1/2 font-medium">
				{{ __('Availability') }}
			</span>

			<span class="w-1/2 font-bold">
				{{ Carbon::parse($post->model->values->get('availability'))->format('d/m/Y') }}
			</span>
		</div>
	@endif

	@if($postType == 'litter' || $postType == 'stud' || $postType == 'retired-breeder')
		<div class="flex flex-row px-6 @if($postType == 'retired-breeder') pt-6 @endif">
			<span class="w-1/2 font-medium">
				{{ __('Birth date') }}
			</span>

			<span class="w-1/2 font-bold">
				@if($postType == 'litter')
					{{ Carbon::parse($post->model->values->get('birth_date'))->format('d/m/Y') }}
				@else
					{{ Carbon::parse($animal->values->get('birth_date'))->format('d/m/Y') }}
				@endif
			</span>
		</div>

		@if($postType == 'litter' || $postType == 'retired-breeder')
			@php
				if($postType == 'litter') $source = $post->model->values;
				else $source = $animal->post->values;
			@endphp

			@if($source->has('birth_place'))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Place of birth') }}
					</span>

					@php
						$birthPlace = $source->get('birth_place');

						if($birthPlace == 'other') $birthPlaceValue = $source->get('birth_place_value');
					@endphp

					<span class="w-1/2 font-bold">
						@if($birthPlace == 'other')
							{{ $birthPlaceValue }}
						@else
							{{ __('At the '.$birthPlace) }}
						@endif
					</span>
				</div>
			@endif
		@endif
	@endif

	@if($postType == 'litter' || $postType == 'stud' || $postType == 'retired-breeder')
		<div class="flex flex-row px-6">
			<span class="w-1/2 font-medium">
				{{ __('Price') }}
			</span>

			<span class="flex flex-col font-bold">
				@if($postType == 'stud' || $postType == 'retired-breeder')
					@if($post->values->has('price'))
						{{ $post->values->get('price') }}€
					@else
						{{ __('NC') }}
					@endif
				@else
					@if($type == 'post')
						@php
							$minPrice = $post->model->getLowestPrice();
							$maxPrice = $post->model->getHighestPrice();
						@endphp
						@if(!is_null($minPrice) && !is_null($maxPrice))
							@if($minPrice != $maxPrice)
								{{ __('From :x', ['x' => $minPrice]) }}
								{{ __('to :x €', ['x' => $maxPrice]) }}
							@else
								{{ __(':x €', ['x' => $maxPrice]) }}
							@endif
						@else
							{{ __('NC') }}
						@endif
					@elseif($type == 'animal')
						@if($post->model->values->has('price'))
							{{ $post->model->values->get('price') }}€
						@elseif($animal && $animal->values->has('price'))
							{{ $animal->values->get('price') }}€
						@else
							{{ __('NC') }}
						@endif
					@endif
				@endif
			</span>
		</div>

		@if($post->model->values->has('color') && $post->model->values->get('color') != '')
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Dress') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $post->model->values->get('color') }}
				</span>
			</div>
		@endif

		@if($post->model->values->has('litter_number') && $post->model->values->get('litter_number'))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Litter number') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $post->model->values->get('litter_number') }}
				</span>
			</div>
		@endif
	@endif

	@if($postType == 'litter' || $postType == 'litter-yet-to-come')
		<div class="flex flex-row px-6">
			<span class="w-1/2 font-medium">
				@if($addressInFrance)
					@if($animal->species->getTranslation('slug', 'en') == 'cat')
						LOOF
					@elseif($animal->species->getTranslation('slug', 'en') == 'dog')
						LOF
					@endif
				@else
					{{ __('Origin book') }}
				@endif
			</span>

			<span class="w-1/2 font-bold">
				@if($animal->values->get('pure_breed'))
					{{ __('Yes') }}
				@else
					{{ __('No') }}
				@endif
			</span>
		</div>

		@if($animal->values->has('tests') && $animal->values->get('tests'))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Tests') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $animal->getTestsInHuman() }}
				</span>
			</div>
		@endif

		@if($animal->values->has('vaccines') && $animal->values->get('vaccines'))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Vaccines') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $animal->getVaccinesInHuman() }}
				</span>
			</div>

			@if($animal->values->has('proof_files'))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Tests proofs') }}
					</span>

					<span class="w-1/2 font-bold">
						<div class="flex flex-row gap-2 hyphens-auto flex-wrap">
							@foreach($animal->values->get('proof_files') as $file)
								<div class="flex gap-x-2 items-end">
									<svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.28571 6.27777H11.7143M5.28574 10.5H11.7143M5.28574 14.7222H9.57145M11.8991 20H3.14286C1.95893 20 1 19.0553 1 17.8889V3.11111C1 1.94472 1.95893 1 3.14286 1H13.8571C15.0411 1 16 1.94472 16 3.11111V15.9599C16 16.5193 15.775 17.0576 15.3732 17.4535L13.4152 19.3825C13.0134 19.7783 12.4669 20 11.8991 20Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
	
									<a href="{{ route('documents.show', ['filename' => $file]) }}" download class="text-jobboard-deepblue underline">
										{{ __('File') }}
									</a>
								</div>
							@endforeach
						</div>
					</span>
				</div>
			@endif
		@endif

		@if($animal->values->has('is_sterilized'))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Sterilized') }}
				</span>

				<span class="w-1/2 font-bold">
					@if($animal->values->get('is_sterilized') == true)
						{{ __('Yes') }}
					@else
						{{ __('No') }}
					@endif
				</span>
			</div>
		@endif
	@endif

	@if($postType == 'stud' || $postType == 'retired-breeder')
		@if($animal->values->has('color') && $animal->values->get('color') != '')
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Dress') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $animal->values->get('color') }}
				</span>
			</div>
		@endif

		{{-- <div class="flex flex-col gap-1 px-6">
			<span class="w-1/2 font-medium">
				{{ __('Identification') }}
			</span>

			<span class="w-1/2 font-bold">
				{{ $animal->values->get('identification') }}
			</span>
		</div> --}}

		@if($animal->values->has('tests') && !empty($animal->values->get('tests')))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Tests') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $animal->getTestsInHuman() }}
				</span>
			</div>
		@endif

		@if($animal->values->has('vaccines') && !empty($animal->values->get('vaccines')))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Vaccines') }}
				</span>

				<span class="w-1/2 font-bold">
					{{ $animal->getVaccinesInHuman() }}
				</span>
			</div>

			@if($animal->values->has('proof_files'))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Tests proofs') }}
					</span>

					<span class="w-1/2 font-bold">
						<div class="flex flex-row gap-2 hyphens-auto flex-wrap">
							@foreach($animal->values->get('proof_files') as $file)
								<div class="flex gap-x-2 items-end">
									<svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.28571 6.27777H11.7143M5.28574 10.5H11.7143M5.28574 14.7222H9.57145M11.8991 20H3.14286C1.95893 20 1 19.0553 1 17.8889V3.11111C1 1.94472 1.95893 1 3.14286 1H13.8571C15.0411 1 16 1.94472 16 3.11111V15.9599C16 16.5193 15.775 17.0576 15.3732 17.4535L13.4152 19.3825C13.0134 19.7783 12.4669 20 11.8991 20Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<a href="{{ route('documents.show', ['filename' => $file]) }}" download class="text-jobboard-deepblue underline">
										{{ __('File') }}
									</a>
								</div>
							@endforeach
						</div>
					</span>
				</div>
			@endif
		@endif

		@if($animal->values->has('is_sterilized'))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Sterilized') }}
				</span>

				<span class="w-1/2 font-bold">
					@if($animal->values->get('is_sterilized') == true)
						{{ __('Yes') }}
					@else
						{{ __('No') }}
					@endif
				</span>
			</div>
		@endif

		@if($postType == 'stud')
			@if($post->values->has('average_litter_size') && !empty($post->values->get('average_litter_size')))
				<div class="flex flex-row px-6 gap-2">
					<span class="w-1/2 font-medium">
						{{ __('Average litter size') }}
					</span>

					<span class="w-1/2 font-bold">
						{{ $post->values->get('average_litter_size') }}
					</span>
				</div>
			@endif

			@if($post->values->has('quotation') && !empty($post->values->get('quotation')))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Quotation') }}
					</span>

					<span class="w-1/2 font-bold">
						{{ $post->values->get('quotation') }}
					</span>
				</div>
			@endif

			@if($post->values->has('enhancer') && !empty($post->values->get('enhancer')))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Enhancer') }}
					</span>

					<span class="w-1/2 font-bold">
						{{ $post->values->get('enhancer') }}
					</span>
				</div>
			@endif

			@if($post->values->has('gene_color') && !empty($post->values->get('gene_color')))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Color gene') }}
					</span>

					<span class="w-1/2 font-bold">
						{{ $post->values->get('gene_color') }}
					</span>
				</div>
			@endif

			@if($post->values->has('protrusion_types') && !empty($post->values->get('protrusion_types')))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Protrusion type') }}
					</span>

					<span class="w-1/2 font-bold">
						{{ $post->getProtrusionTypesInHuman() }}
					</span>
				</div>
			@endif
		@endif

		@if($postType == 'retired-breeder')
			@if($post->values->has('sterilized'))
				<div class="flex flex-row px-6">
					<span class="w-1/2 font-medium">
						{{ __('Sterilized') }}
					</span>

					<span class="w-1/2 font-bold">
						{{ $post->values->get('sterilized') ? __('Yes') : __('No') }}
					</span>
				</div>
			@endif
		@endif

		<div class="flex flex-row px-6">
			<span class="w-1/2 font-medium">
				@if($addressInFrance)
					@if($animal->species->getTranslation('slug', 'en') == 'cat')
						LOOF
					@elseif($animal->species->getTranslation('slug', 'en') == 'dog')
						LOF
					@endif
				@else
					{{ __('Origin book') }}
				@endif
			</span>

			<span class="w-1/2 font-bold">
				{{ $animal->values->get('pure_breed') ? __('Yes') : __('No') }}
			</span>
		</div>

		@if(($animal->values->has('pedigree') && $animal->values->get('pedigree')) || ($animal->values->has('pedigree_link') && $animal->values->get('pedigree_link')))
			<div class="flex flex-row px-6">
				<span class="w-1/2 font-medium">
					{{ __('Pedigree') }}
				</span>

				<span class="w-1/2 font-bold">
					<div class="flex flex-row gap-x-2">
						<svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.28571 6.27777H11.7143M5.28574 10.5H11.7143M5.28574 14.7222H9.57145M11.8991 20H3.14286C1.95893 20 1 19.0553 1 17.8889V3.11111C1 1.94472 1.95893 1 3.14286 1H13.8571C15.0411 1 16 1.94472 16 3.11111V15.9599C16 16.5193 15.775 17.0576 15.3732 17.4535L13.4152 19.3825C13.0134 19.7783 12.4669 20 11.8991 20Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						@if($animal->values->has('pedigree') && $animal->values->get('pedigree'))
							<a href="{{ route('documents.show', ['filename' => $animal->values->get('pedigree')]) }}" download class="text-jobboard-deepblue underline">
								{{ __('File') }}
							</a>
						@endif

						@if($animal->values->has('pedigree_link') && $animal->values->get('pedigree_link'))
							@if($animal->values->has('pedigree') && $animal->values->get('pedigree'))
								/
							@endif

							<a href="{{ $animal->values->get('pedigree_link') }}" target="_blank" class="text-jobboard-deepblue underline">
								{{ __('Link') }}
							</a>
						@endif
					</div>
				</span>
			</div>
		@endif
	@endif

	@if($type == 'post' && ($postType == 'litter' || $postType == 'stud' || $postType == 'retired-breeder'))
		<div class="flex flex-row w-full justify-center items-center">
			<a href="{{ route('company-search.company.show', ['company' => $post->model->company->slug]) }}">
				<x-front.secondary-button>
					{{ __('Show the company') }}
				</x-front.secondary-button>
			</a>
		</div>
	@endif
</div>
