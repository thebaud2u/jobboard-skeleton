<div>
	<div class="w-full bg-white mb-6">
		<div class="bg-breeder-cream w-full flex flex-col justify-center items-center gap-y-4 s:gap-y-12 h-[174px] s:h-[261px] text-breeder-deepblue">
			<h2 class="text-[25px] sm:text-[30px] lg:text-[40px] font-bold text-center mt-4 lg:mt-8">
				{{ __('My company page') }}
			</h2>

			<div id="anchor" class="flex justify-between items-center font-bold w-[323px] s:w-[570px]">
				@for($i = 1; $i <= $totalSteps; $i++)
					@if($i == 1)
						<div class="flex flex-col items-center gap-y-4 w-[200px] cursor-pointer" @if($active != 1) wire:click="goto(1)" @endif>
							@if($active == 1)
								<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
									<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2" />
									<path d="M28.0796 27.08V24.756H33.3436V45H30.7676V27.08H28.0796Z" fill="#0E1954" />
								</svg>
							@else
								<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2" />
									<path d="M36.2391 24.5814C34.6609 23.7822 32.8787 23.3333 31 23.3333C24.4725 23.3333 19.1904 28.7199 19.1904 35.3764C19.1904 42.0329 24.4725 47.4194 31 47.4194C37.5274 47.4194 42.8095 42.0329 42.8095 35.3764C42.8095 33.8327 42.5196 32.3547 42.0043 30.9971M25.632 35.3764L29.9264 39.7556L42.8095 23.3333" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							@endif

							{{ __('Introduction') }}
						</div>
					@elseif($i == 2)
						<div class="flex flex-col items-center gap-y-4 w-[200px] @if($active == 1) text-breeder-greige @else text-breeder-deepblue cursor-pointer @endif"
							@if($active == 3 && $offer->hasOption('display-breeders')) wire:click="goto(2)" @endif>
							@if($active != 3)
								<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
									<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="currentColor" stroke-width="2" />
									<path d="M24.8753 42.956C27.2459 41.052 29.1033 39.4933 30.4473 38.28C31.7913 37.048 32.9206 35.7693 33.8353 34.444C34.7686 33.1 35.2353 31.784 35.2353 30.496C35.2353 29.2827 34.9366 28.3307 34.3393 27.64C33.7606 26.9307 32.8179 26.576 31.5113 26.576C30.2419 26.576 29.2526 26.9773 28.5433 27.78C27.8526 28.564 27.4793 29.6187 27.4233 30.944H24.9593C25.0339 28.8533 25.6686 27.2387 26.8633 26.1C28.0579 24.9613 29.5979 24.392 31.4833 24.392C33.4059 24.392 34.9273 24.924 36.0473 25.988C37.1859 27.052 37.7553 28.5173 37.7553 30.384C37.7553 31.9333 37.2886 33.4453 36.3553 34.92C35.4406 36.376 34.3953 37.664 33.2193 38.784C32.0433 39.8853 30.5406 41.1733 28.7113 42.648H38.3433V44.776H24.8753V42.956Z" fill="currentColor" />
								</svg>
							@else
								<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2" />
									<path d="M36.2391 24.5814C34.6609 23.7822 32.8787 23.3333 31 23.3333C24.4725 23.3333 19.1904 28.7199 19.1904 35.3764C19.1904 42.0329 24.4725 47.4194 31 47.4194C37.5274 47.4194 42.8095 42.0329 42.8095 35.3764C42.8095 33.8327 42.5196 32.3547 42.0043 30.9971M25.632 35.3764L29.9264 39.7556L42.8095 23.3333" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							@endif

							{{ __('My animals') }}
						</div>
					@else
						<div class="flex flex-col items-center gap-y-4 w-[200px] @if($active != 3) text-breeder-greige @else text-breeder-deepblue cursor-pointer @endif">
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="currentColor" stroke-width="2" />
								<path d="M24.9359 29.852C25.0665 28.1347 25.7292 26.7907 26.9239 25.82C28.1185 24.8493 29.6679 24.364 31.5719 24.364C32.8412 24.364 33.9332 24.5973 34.8479 25.064C35.7812 25.512 36.4812 26.128 36.9479 26.912C37.4332 27.696 37.6759 28.5827 37.6759 29.572C37.6759 30.7293 37.3399 31.728 36.6679 32.568C36.0145 33.408 35.1559 33.9493 34.0919 34.192V34.332C35.3052 34.6307 36.2665 35.2187 36.9759 36.096C37.6852 36.9733 38.0399 38.1213 38.0399 39.54C38.0399 40.604 37.7972 41.5653 37.3119 42.424C36.8265 43.264 36.0985 43.9267 35.1279 44.412C34.1572 44.8973 32.9905 45.14 31.6279 45.14C29.6492 45.14 28.0252 44.6267 26.7559 43.6C25.4865 42.5547 24.7772 41.08 24.6279 39.176H27.0919C27.2225 40.296 27.6799 41.2107 28.4639 41.92C29.2479 42.6293 30.2932 42.984 31.5999 42.984C32.9065 42.984 33.8959 42.648 34.5679 41.976C35.2585 41.2853 35.6039 40.3987 35.6039 39.316C35.6039 37.916 35.1372 36.908 34.2039 36.292C33.2705 35.676 31.8612 35.368 29.9759 35.368H29.3319V33.24H30.0039C31.7212 33.2213 33.0185 32.9413 33.8959 32.4C34.7732 31.84 35.2119 30.9813 35.2119 29.824C35.2119 28.8347 34.8852 28.0413 34.2319 27.444C33.5972 26.8467 32.6825 26.548 31.4879 26.548C30.3305 26.548 29.3972 26.8467 28.6879 27.444C27.9785 28.0413 27.5585 28.844 27.4279 29.852H24.9359Z" fill="currentColor" />
							</svg>

							{{ __('Words of breeder') }}
						</div>
					@endif
				@endfor
			</div>

			<div class="relative">
				<div class="absolute w-[30px] s:w-[70px] border-t-2 @if($active < 2) border-breeder-greige @else border-breeder-deepblue @endif -top-[89px] s:-top-[124px] -left-[70px] s:-left-[131px]">
				</div>

				<div class="absolute w-[30px] s:w-[70px] border-t-2 @if($active != 3) border-breeder-greige @else border-breeder-deepblue @endif -top-[89px] s:-top-[124px] left-[38px] s:left-[59px]">
				</div>
			</div>
		</div>

		<div class="flex flex-col py-5 px-4 gap-y-4 max-w-[840px] mx-auto">
			@if($active == 1)
				<h3 class="text-lg text-breeder-deepblue font-bold">
					{{ __('My logo') }}
				</h3>

				<div class="flex flex-col gap-2">
					<div class="w-[250px]">
						<x-front.input-label for="logo" :value="__('Download my logo')" :class="'pl-4 mb-2'" />
							<livewire:uppy
								:maxMedias="1"
								:class="$mediableClassLogo"
								:modelId="$mediableIdLogo"
								:collection="$collectionLogo"
								:gridClass="'w-full max-w-[250px]'"
								:aspectRatio="'aspect-square'"
								:objectFit="'object-cover'"
								:type="'company-logo'"
								:key="'company-logo'" />
					</div>
				</div>

				<hr class="border-1.5 border-breeder-greige my-4">

				<div class="flex flex-col gap-4 w-full">
					<h3 class="text-lg text-breeder-deepblue font-bold">
						{{ __('My company') }}
					</h3>

					<div class="flex flex-col gap-2 w-full">
						<x-front.input-label for="name" :value="__('Company\'s name')" :required="true" :class="'pl-4'" />

						<x-front.text-input name="name" id="name" wire:model.live="name" placeholder="{{ __('Company\'s name') }}" :class="'mt-1 block bg-white'" />

						@error('name')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>

					@if($name)
						<div class="flex flex-row gap-1 text-sm text-gray-400">
							{{ __('The company displayed name will be :') }} <span class="font-bold">{{ __('Company :name', ['name' => $name]) }}</span>
						</div>
					@endif

					<div class="flex flex-row gap-4 max-s:flex-wrap">
						<div class="flex flex-col">
							<x-front.input-label for="affix" :value="__('Affix')" :class="'pl-4'" />

							<select id="affix" name="affix" wire:model.live="affix" class="text-gray-400 mt-1 block border border-gray-300 rounded-md focus:ring-breeder-deepblue focus:border-breeder-deepblue w-[181px]">
								@foreach($affixes as $index => $value)
									<option value="{{ $index }}" wire:key="affix-{{ $index }}">
										{{ __($value) }}
									</option>
								@endforeach
							</select>
						</div>

						<div class="flex flex-col w-full">
							<x-front.input-label for="affixName" :value="__($affix === 'suffix' ? 'Suffix name' : 'Prefix name')" :required="true" :class="'pl-4'" />

							<x-front.text-input name="affixName" id="affixName" wire:model="affixName" placeholder="{{ __($affix === 'suffix' ? 'Suffix name' : 'Prefix name') }}" :class="'mt-1 block bg-white'" />

							@error('affixName')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>
					</div>
				</div>

				<div class="flex flex-col">
					<x-front.input-label for="breeds" :value="__('Breeds')" :class="'pl-4'" />

					<div clas="flex flex-col w-full">
						@if($userInterestedIn == 'both' || $userInterestedIn == 'dogs')
							<div class="flex w-full mb-4">
								<div class="relative">
									<svg class="absolute top-[13px] left-[13px]" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.18441 0.298144C8.43373 -0.570295 6.8835 0.710043 6.12934 1.01237C4.0868 1.83009 1.89065 2.05531 0.637194 4.36844C-1.46295 8.24801 2.02158 16.833 5.37343 13.9314C7.16806 12.3772 5.48515 8.20337 6.86081 5.92068C7.41247 5.0076 8.43373 4.66063 8.97143 3.50406C9.30137 2.79592 9.70988 0.904833 9.18266 0.296114L9.18441 0.298144ZM24.1769 3.36406C22.9252 1.90922 21.3209 1.87675 19.7811 1.27006C18.3444 0.705985 15.6297 -1.67613 16.0505 2.15879C16.3333 4.7357 18.7284 5.07862 19.1003 7.13609C19.4791 9.23617 18.3339 13.6149 20.743 14.3555C22.5482 14.9094 23.6899 13.4079 24.4475 11.7502C25.6189 9.18747 26.113 5.61023 24.1787 3.36406H24.1769ZM8.83002 6.97985C7.49626 7.29841 7.89255 9.79416 9.10585 9.73329C10.7067 9.65212 10.6753 6.53954 8.83002 6.97985ZM15.3801 9.32747C16.4642 10.6545 18.2658 8.45295 17.0752 7.2558C15.8846 6.05865 14.4409 8.177 15.3801 9.32747ZM5.55848 14.6558V23.4822C5.55848 23.6121 5.9792 23.9672 6.17473 23.9915C7.71623 24.1863 6.83986 20.952 6.95682 19.9314C8.76543 21.6763 10.8464 22.3013 12.6532 20.1505C14.5212 22.1836 16.3612 21.7271 18.3025 20.1343V23.2793C18.3025 24.2553 19.8737 24.0869 19.8737 23.4822V14.6558C18.004 14.5746 18.4264 15.8428 17.99 17.2347C17.4471 18.9615 15.4796 20.7288 14.0376 19.1076C13.4702 18.4704 13.2206 16.6362 13.4126 15.8144C13.4964 15.4532 15.0362 14.95 14.7796 13.3897C14.392 11.038 10.5513 11.3545 10.6334 13.7265C10.6875 15.2807 11.9986 15.6724 12.0265 15.8063C12.6096 18.6348 10.4466 21.1427 8.34645 18.8235C6.92889 17.257 7.77558 14.4509 5.55848 14.6578V14.6558Z" fill="#FF7E71" />
										<path d="M9.18439 0.298202C9.71161 0.906921 9.30136 2.79801 8.97315 3.50615C8.43546 4.66272 7.41245 5.00969 6.86254 5.92276C5.48514 8.20343 7.16804 12.3792 5.37515 13.9335C2.02156 16.833 -1.46296 8.24807 0.637178 4.3685C1.89063 2.05537 4.08679 1.83014 6.12932 1.01243C6.88349 0.710101 8.43372 -0.572266 9.18439 0.298202Z" fill="#FF7E71" />
										<path d="M24.1779 3.36406C26.1122 5.61023 25.6181 9.18747 24.4467 11.7502C23.6891 13.4059 22.5473 14.9094 20.7422 14.3555C18.3313 13.6149 19.4783 9.23616 19.0995 7.13608C18.7276 5.07861 16.3325 4.7357 16.0496 2.15879C15.6289 -1.67614 18.3436 0.705983 19.7803 1.27006C21.3201 1.87675 22.9244 1.90922 24.1761 3.36406H24.1779Z" fill="#FF7E71" />
										<path d="M5.55859 14.6558C7.7757 14.4508 6.92901 17.255 8.34656 18.8214C10.445 21.1406 12.6079 18.6327 12.0266 15.8042C11.9987 15.6703 10.6876 15.2787 10.6335 13.7244C10.5515 11.3524 14.3921 11.0359 14.7797 13.3876C15.0363 14.9479 13.4965 15.4532 13.4127 15.8123C13.2225 16.6341 13.4721 18.4684 14.0377 19.1055C15.4797 20.7287 17.4472 18.9594 17.9901 17.2327C18.4283 15.8407 18.0041 14.5726 19.8738 14.6537V23.4801C19.8738 24.0848 18.3026 24.2532 18.3026 23.2772V20.1322C16.3613 21.725 14.5213 22.1815 12.6533 20.1484C10.8465 22.2992 8.76554 21.6743 6.95694 19.9293C6.83998 20.9499 7.71635 24.1863 6.17484 23.9894C5.97932 23.9651 5.55859 23.61 5.55859 23.4801V14.6537V14.6558Z" fill="#FF7E71" />
										<path d="M15.381 9.32746C14.4417 8.17698 15.8628 6.03835 17.0761 7.25579C18.2894 8.47323 16.4651 10.6545 15.381 9.32746Z" fill="#FF7E71" />
										<path d="M8.8297 6.97981C10.6767 6.53951 10.7064 9.65412 9.10553 9.73325C7.89223 9.79413 7.49594 7.29838 8.8297 6.97981Z" fill="#FF7E71" />
									</svg>
								</div>

								<livewire:breed-finder :dog="true" :key="'dog-species'" />
							</div>
						@endif

						@if($userInterestedIn == 'both' || $userInterestedIn == 'cats')
							<div class="flex w-full">
								<div class="relative">
									<svg class="absolute top-[13px] left-[13px]" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0_2617_8721)">
											<path d="M14.0616 13.8201C13.7625 13.6288 12.155 13.8974 11.6504 13.7916C11.333 14.6442 12.2832 15.0409 12.1855 15.6249C11.8925 17.3891 10.2973 16.7644 10.2138 17.5559C10.1141 18.5082 11.1315 18.3352 11.7684 18.0788C12.214 17.8998 12.625 17.2934 12.796 17.2629C12.9872 17.2283 14.9406 19.1939 15.6283 17.8632C16.0211 17.1062 13.9843 17.1083 13.6099 15.7816C13.382 14.9718 14.8409 14.3166 14.0616 13.8201Z" fill="#3DD8AC" />
											<path d="M17.8558 13.3867C16.4539 13.3867 14.9461 10.7863 14.4944 9.62646C14.1159 8.65588 13.7782 6.34846 13.4485 5.79094C11.894 4.20179 11.9327 8.15329 11.5054 9.06894C11.0089 10.8514 9.76156 12.935 7.88755 13.3867L2.48526 11.9542C2.38556 10.8921 3.87297 9.46978 4.08458 8.76372C4.343 7.90302 3.44363 4.25266 3.51281 3.00942C3.53113 2.67368 3.45177 0.36423 4.53019 0.0427376C5.36851 -0.207538 6.28212 0.702 6.56495 0.974658C10.4819 4.7349 9.04533 4.79187 12.9521 4.04715C15.4914 3.56287 16.0164 4.7939 16.4295 4.43579C17.8396 2.19755 21.9416 -3.07045 22.0291 2.80594C22.1634 4.37067 21.4452 7.86029 21.6608 8.75355C21.7382 9.07097 22.7515 10.4912 23.0221 11.0732C23.1462 11.3397 23.2256 11.9217 23.2602 11.9522M8.33926 9.35177C6.86813 9.775 7.40124 12.1597 8.85813 11.9298C10.6853 11.6429 10.1807 8.82069 8.33926 9.35177ZM17.8986 9.5817C16.5923 8.51955 14.7386 10.4668 16.3359 11.649C17.6727 12.6399 19.0787 10.5421 17.8986 9.5817Z" fill="#3DD8AC" />
											<path d="M6.55877 16.3127C7.44796 16.1479 7.93834 17.0839 7.32181 17.4054C6.79277 17.6801 4.12317 18.7768 4.04788 18.5998C3.97259 18.4228 5.3135 19.9895 5.56174 20.1869C10.1013 23.9471 18.3685 23.5565 21.6201 18.4757C20.9771 18.2844 18.9362 17.7696 18.5659 17.3565C18.2586 17.0147 18.2444 16.3778 18.6941 16.2496C19.4714 16.3249 22.672 17.5132 23.6528 17.8632C19.569 26.4316 6.38378 25.6523 1.88086 17.8632C1.88086 17.8632 5.79981 16.4531 6.55674 16.3127H6.55877Z" fill="#3DD8AC" />
											<path d="M14.0616 13.8201C14.8409 14.3186 13.382 14.9718 13.6099 15.7816C13.9843 17.1083 16.0211 17.1062 15.6283 17.8632C14.9406 19.1939 12.9872 17.2283 12.796 17.2629C12.625 17.2934 12.212 17.8978 11.7684 18.0788C11.1315 18.3352 10.1141 18.5102 10.2138 17.5559C10.2973 16.7664 11.8925 17.3891 12.1855 15.6249C12.2832 15.0409 11.333 14.6442 11.6504 13.7916C12.2344 13.3847 13.7645 13.6288 14.0616 13.8201Z" fill="#3DD8AC" />
											<path d="M6.3409 14.1032L0.5518 14.4431C0.228712 14.462 -0.017826 14.7393 0.00114263 15.0624C0.0201113 15.3855 0.297403 15.632 0.620492 15.6131L6.40959 15.2732C6.73268 15.2542 6.97922 14.9769 6.96025 14.6538C6.94128 14.3308 6.66399 14.0842 6.3409 14.1032Z" fill="#3DD8AC" />
											<path d="M19.0673 15.2726L24.8564 15.6125C25.1795 15.6315 25.4568 15.3849 25.4758 15.0618C25.4947 14.7388 25.2482 14.4615 24.9251 14.4425L19.136 14.1026C18.8129 14.0836 18.5356 14.3302 18.5166 14.6533C18.4977 14.9764 18.7442 15.2537 19.0673 15.2726Z" fill="#3DD8AC" />
											<path d="M18.1035 13.3859L24.8423 11.9817C25.1592 11.9157 25.3625 11.6053 25.2965 11.2885C25.2305 10.9717 24.9201 10.7683 24.6033 10.8343L17.8644 12.2385C17.5476 12.3045 17.3442 12.6149 17.4102 12.9317C17.4763 13.2485 17.7866 13.4519 18.1035 13.3859Z" fill="#3DD8AC" />
											<path d="M7.92193 12.2378L1.18306 10.8336C0.866225 10.7676 0.555857 10.971 0.489839 11.2878C0.42382 11.6046 0.627152 11.915 0.943992 11.981L7.68285 13.3852C7.99969 13.4512 8.31006 13.2479 8.37608 12.931C8.4421 12.6142 8.23877 12.3038 7.92193 12.2378Z" fill="#3DD8AC" />
										</g>

										<defs>
											<clipPath id="clip0_2617_8721">
												<rect width="25.4793" height="24" fill="white" />
											</clipPath>
										</defs>
									</svg>
								</div>

								<livewire:breed-finder :cat="true" :key="'cat-species'" />
							</div>
						@endif
					</div>

					<div class="flex flex-row">
						@error('breeds')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				</div>

				<div>
					@if($maxBreeds != 'unlimited')
						<div class="flex flex-row text-sm text-gray-400 mb-2">
							@if($breedCount >= 0)
								{{ __(':x :breedleft to chose from', ['x' => $breedCount, 'breedleft' => $breedCount > 1 ? __('breeds left') : __('breed left')]) }}
							@elseif($breedCount < 0)
								{{ __('You have too many breeds attached to your company') }}
							@endif
						</div>
					@endif

					@if(!empty($breeds))
						<div class="flex flex-row gap-2 flex-wrap">
							@foreach($breeds as $slug => $name)
								<span class="flex flex-row justify-center text-breeder-cream font-medium items-center gap-x-2 bg-breeder-deepblue py-2 px-4 rounded-full">
									{{ $name }}

									<span wire:click="removeBreed('{{ $slug }}')" class="cursor-pointer text-breeder-violet" title="{{ __('Remove the breed') }}">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
											<path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
										</svg>
									</span>
								</span>
							@endforeach
						</div>
					@endif
				</div>

				@if($userInterestedIn == 'both' || $userInterestedIn == 'dogs')
					<div>
						<div class="flex flex-row">
							<x-front.input-label for="numberActiveFemaleDogBreeder" :value="__('Number of active female dog breeder')" :required="true" :class="'pl-4'" />
						</div>

						<x-front.text-input type="number" name="numberActiveFemaleDogBreeder" id="numberActiveFemaleDogBreeder" wire:model="numberActiveFemaleDogBreeder" placeholder="{{ __('Number of active female dog breeder') }}" :class="'mt-1 block bg-white'" />

						@error('numberActiveFemaleDogBreeder')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				@endif

				@if($userInterestedIn == 'both' || $userInterestedIn == 'cats')
					<div>
						<div class="flex flex-row">
							<x-front.input-label for="numberActiveFemaleCatBreeder" :value="__('Number of active female cat breeder')" :required="true" :class="'pl-4'" />
						</div>

						<x-front.text-input type="number" name="numberActiveFemaleCatBreeder" id="numberActiveFemaleCatBreeder" wire:model="numberActiveFemaleCatBreeder" placeholder="{{ __('Number of active female cat breeder') }}" :class="'mt-1 block bg-white'" />

						@error('numberActiveFemaleCatBreeder')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				@endif

				<div class="w-full">
					<livewire:address
						:address="$address"
						:streetRequired="true"
						:zipCodeRequired="true"
						:showZipCode="true"
						:cityRequired="true"
						:additionnal_1="false"
						:additionnal_2="false"
						:key="'component-address'" />
				</div>

				<div>
					<div class="flex flex-row">
						<x-front.input-label for="description" :value="__('Your company\'s presentation')" :required="true" :class="'pl-4'" />
					</div>

					<textarea id="description" rows="5" wire:model="description" placeholder="{{ __('Tell us more about your company: company practice, breeds, values...') }}" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>

					@error('description')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>

				<div>
					<h3 class="text-lg text-breeder-deepblue font-bold mt-6 mb-4">
						{{ __('Upload photos and videos of your company') }}
					</h3>

					<div class="flex flex-row">
						<x-front.input-label for="photos" :value="$photoCount > 1 ? __('Your company\'s photos') : __('Your company\'s photo')" :class="'pl-4'" />
					</div>

					<livewire:uppy
						:maxMedias="$offer->getMaxPhoto()"
						:class="$mediableClassPhotos"
						:modelId="$mediableIdPhotos"
						:collection="$collectionPhotos"
						:gridClass="'sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-4'"
						:aspectRatio="'aspect-video'"
						:objectFit="'object-cover'"
						:type="'company-photos'"
						:key="'company-photos'"
					/>
				</div>

				<div class="text-sm text-gray-400">
					{{ __('You have :left :media left', ['left' => $mediasLeft, 'media' => $mediasLeft > 1 ? __('photos') : __('photo')]) }}
				</div>

				@if($offer->hasOption('4-video'))
					<div class="grid gap-4 sm:grid-cols-2 grid-cols-1 mb-2">
						@for($i = 0; $i <= 3; $i++)
							<div>
								<x-front.input-label for="videos-{{ $i }}" :value="__('Video n° :x', ['x' => $i+1])" :class="'pl-4'" />

								<x-front.text-input type="url" id="videos-{{ $i }}" name="videos-{{ $i }}" wire:model="videos.{{ $i }}" placeholder="{{ __('Youtube integration (see integration tutorial)') }}" :class="'mt-1 block w-full'" />

								@error('videos.'.$i)
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>
						@endfor
					</div>
				@endif

				<div class="flex flex-col gap-4 w-full max-s:flex-wrap">
					@if($userInterestedIn == 'both' || $userInterestedIn == 'cats')
						<div class="flex flex-row gap-4">
							<div class="flex flex-col gap-2 w-full">
								<x-front.input-label for="catFacebook" :value="__('Facebook for your cats')" :class="'pl-4'" />

								<x-front.text-input name="catFacebook" id="catFacebook" wire:model="catFacebook" placeholder="https://" :class="'mt-1 block bg-white'" />

								@error('catFacebook')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div class="flex flex-col gap-2 w-full">
								<x-front.input-label for="catInstagram" :value="__('Instagram for your cats')" :class="'pl-4'" />

								<x-front.text-input name="catInstagram" id="catInstagram" wire:model="catInstagram" placeholder="https://" :class="'mt-1 block bg-white'" />

								@error('catInstagram')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>
						</div>
					@endif

					@if($userInterestedIn == 'both' || $userInterestedIn == 'dogs')
						<div class="flex flex-row gap-4">
							<div class="flex flex-col gap-2 w-full">
								<x-front.input-label for="dogFacebook" :value="__('Facebook for your dogs')" :class="'pl-4'" />

								<x-front.text-input name="dogFacebook" id="dogFacebook" wire:model="dogFacebook" placeholder="https://" :class="'mt-1 block bg-white'" />

								@error('dogFacebook')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div class="flex flex-col gap-2 w-full">
								<x-front.input-label for="dogInstagram" :value="__('Instagram for your dogs')" :class="'pl-4'" />

								<x-front.text-input name="dogInstagram" id="dogInstagram" wire:model="dogInstagram" placeholder="https://" :class="'mt-1 block bg-white'" />

								@error('dogInstagram')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>
						</div>
					@endif

					<div>
						<div class="flex flex-row">
							<x-front.input-label for="website" :value="__('Link to your website')" :class="'pl-4'" />
						</div>

						<x-front.text-input name="website" id="website" wire:model="website" placeholder="https://" :class="'mt-1 block bg-white'" />

						@error('website')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				</div>
			@elseif($active == 2)
				@if($offer->hasOption('display-breeders'))
					<livewire:front.animals.breeders.breeders
						:company="$company"
						:create="true"
						:update="true"
						:key="'breeder-component-' . $subComponentKey" />
				@endif
			@elseif($active == 3)
				<livewire:front.comments.comments
					:case="'company-about-breed'"
					:target="data_get($company->values, 'for_moderation.breeds') ? $company->constructBreedsFromModeration() : $company->breeds"
					:source="$company"
					:create="true"
					:update="true"
					:key="'comments-component-' . $subComponentKey" />
			@endif

			<div class="flex flex-col max-s:items-center max-s:gap-4 s:flex-row s:justify-between items-center mt-6">
				@if($active > 1)
					<x-front.secondary-button wire:click="previous" class="mr-2">
						{{ __('Previous step') }}
					</x-front.secondary-button>
				@endif

				<div class="flex justify-end gap-2">
					@if($companyState == 'create' || $lastPublication->isDraft())
						<x-front.secondary-button wire:click="submitCompanyForm('draft')">
							{{ __('Save as draft') }}
						</x-front.secondary-button>
					@endif

					<x-front.primary-button wire:click="submitCompanyForm('publish')">
						@if($active < $totalSteps)
							{{ __('Next step') }}
						@else
							@if($companyState == 'create')
								{{ __('Publish my company') }}
							@elseif($companyState == 'update')
								@if($lastPublication->isDraft())
									{{ __('Publish my company') }}
								@else
									{{ __('Update my company') }}
								@endif
							@endif
						@endif
					</x-front.primary-button>
				</div>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('livewire:init', () => {
			// S'exécute après chaque traitement de message Livewire
			Livewire.hook('request', ({ respond }) => {
				respond(() => {
					// On attend que le DOM soit mis à jour, puis on scrolle
					const anchor = document.getElementById('anchor');
					if (anchor) {
						anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
					}
				});
			});
		});
	</script>
</div>
