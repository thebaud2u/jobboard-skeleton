<div class="w-full @if(!$withNav && $benefitsAvailable->isNotEmpty()) rounded-xl bg-breeder-cream min-h-[342px] flex items-center p-6 mt-8 @endif">
	<div class="w-full">
		@if(!$withNav)
			@if($benefitsAvailable->isNotEmpty())
				<div class="flex flex-row w-full mb-4">
					<x-front.space-title>
						{{ __('Right now') }}
					</x-front.space-title>
				</div>
			@endif
		@endif

		@if($benefitsAvailable->isNotEmpty())
			<div class="w-full flex justify-between"
				@if($withNav) x-data="{
						benefitTypeSlug: '{{ $type }}',
						checkResponsive:function(type) {
							if(this.width < 768) {
								let visibleResponsiveElements = document.getElementsByClassName('visible-benefits-available-cards-'+type);
								let hiddenResponsiveElements = document.getElementsByClassName('hidden-benefits-available-cards-'+type);
								
								Array.from(hiddenResponsiveElements).forEach(element => {
									element.classList.remove('hidden', 'hidden-benefits-available-cards-'+type);
								});
								
								Array.from(visibleResponsiveElements).forEach(element => {
									element.classList.remove('visible-benefits-available-cards-'+type);
								});
							}
						},
						previousElement:function(benefitTypeSlug) {
						let visibleElements = document.getElementsByClassName('visible-benefits-available-cards-'+benefitTypeSlug);
						let firstVisibleElement = visibleElements[0];

						let hiddenElements = document.getElementsByClassName('hidden-benefits-available-cards-'+benefitTypeSlug);
						let firstHiddenElement = hiddenElements[0];

						firstVisibleElement.classList.remove('visible-benefits-available-cards-'+benefitTypeSlug);
						firstVisibleElement.classList.add('hidden', 'hidden-benefits-available-cards-'+benefitTypeSlug);

						firstHiddenElement.classList.remove('hidden', 'hidden-benefits-available-cards-'+benefitTypeSlug);
						firstHiddenElement.classList.add('visible-benefits-available-cards-'+benefitTypeSlug);

						document.getElementById('benefits-available-cards-'+benefitTypeSlug).appendChild(firstVisibleElement);
						},
						nextElement:function(benefitTypeSlug) {
							let visibleElements = document.getElementsByClassName('visible-benefits-available-cards-'+benefitTypeSlug);
							let lastVisibleElement = visibleElements[visibleElements.length - 1];

							let hiddenElements = document.getElementsByClassName('hidden-benefits-available-cards-'+benefitTypeSlug);
							let lastHiddenElement = hiddenElements[hiddenElements.length - 1];

							lastVisibleElement.classList.remove('visible-benefits-available-cards-'+benefitTypeSlug);
							lastVisibleElement.classList.add('hidden', 'hidden-benefits-available-cards-'+benefitTypeSlug);

							lastHiddenElement.classList.remove('hidden', 'hidden-benefits-available-cards-'+benefitTypeSlug);
							lastHiddenElement.classList.add('visible-benefits-available-cards-'+benefitTypeSlug);

							document.getElementById('benefits-available-cards-'+benefitTypeSlug).prepend(lastHiddenElement);
						}
					}" @endif>
				@if($withNav)
					@php
						$count = count($benefitsAvailable);
					@endphp
				@endif

				<div class="w-full relative flex flex-row @if(!$withNav) items-stretch @else items-center @endif">
					@if($withNav)
						{{-- Previous button --}}
						@if($count > 3)
							<div x-on:click="nextElement(benefitTypeSlug);" class="mr-3 cursor-pointer hidden md:block absolute left-2">
								<svg width="80" height="80" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.7">
										<g filter="url(#filter0_d_2188_51306)">
											<path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF" />
										</g>

										<path d="M56.0454 36.6364L42.1818 50.5L56.0454 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									</g>

									<defs>
										<filter id="filter0_d_2188_51306" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
											<feFlood flood-opacity="0" result="BackgroundImageFix" />
											<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
											<feOffset />
											<feGaussianBlur stdDeviation="10" />
											<feComposite in2="hardAlpha" operator="out" />
											<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
											<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2188_51306" />
											<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2188_51306" result="shape" />
										</filter>
									</defs>
								</svg>
							</div>
						@endif
					@endif

					@php
						if($type == 'package-special') $maxWidthMobile = 'w-[316px] md:w-full max-w-[316px]';
						elseif(!$withNav) $maxWidthMobile = 'w-[328px] max-h-[227px]';
						else $maxWidthMobile = 'w-[350px] md:w-full max-w-[350px]';
					@endphp
					<div class="flex items-stretch w-full flex-1">
						<div id="benefits-available-cards-{{ $type }}" x-init="$nextTick(() => checkResponsive('{{ $type }}'))" class="@if(!$withNav) md:flex-wrap lg:flex-no-wrap justify-between @endif flex flex-row items-stretch gap-5 max-md:flex-nowrap max-md:overflow-x-scroll max-md:scrollbar-none  max-md:w-full max-md:max-w-full">
							@foreach($benefitsAvailable as $index => $benefitAvailable)
								<div id="{{ $index . $type }}" class="flex {{ $maxWidthMobile }} h-full @if($withNav && $index > 2) hidden hidden-benefits-available-cards-{{ $type }} @else visible-benefits-available-cards-{{ $type }} @endif">
									@include('components.front.benefits.card')
								</div>
							@endforeach

							@if(!$withNav)
								<div class="flex-1 flex w-full">
									<a href="{{ route('space.benefits.my-benefits') }}" class="flex w-full items-stretch h-full">
										<div class="flex flex-col justify-center p-4 gap-y-4 w-[328px] h-[227px] border border-1 bg-breeder-orange rounded-xl cursor-pointer items-center">
											<div class="text-lg font-bold flex flex-col items-center gap-y-2">
												<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M10.0581 17.1749L17.1709 1.42505C18.5858 1.42505 19.9427 1.97817 20.9431 2.96273C21.9435 3.94729 22.5056 5.28264 22.5056 6.67502V13.675H32.5703C33.0858 13.6692 33.5964 13.7739 34.0668 13.9816C34.5371 14.1893 34.956 14.4952 35.2943 14.8781C35.6326 15.261 35.8822 15.7116 36.026 16.1989C36.1697 16.6861 36.2041 17.1983 36.1267 17.6999L33.6728 33.4498C33.5442 34.2844 33.1134 35.0451 32.4599 35.5918C31.8063 36.1385 30.974 36.4344 30.1163 36.4248H10.0581M10.0581 17.1749V36.4248M10.0581 17.1749H4.72342C3.7802 17.1749 2.87561 17.5437 2.20865 18.2001C1.54169 18.8564 1.16699 19.7467 1.16699 20.6749V32.9248C1.16699 33.8531 1.54169 34.7433 2.20865 35.3997C2.87561 36.0561 3.7802 36.4248 4.72342 36.4248H10.0581" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('+ more advantages') }}
											</div>

											<x-front.primary-button :class="'text-center'">
												{{ __('Discover the offers') }}
											</x-front.primary-button>
										</div>
									</a>
								</div>
							@endif
						</div>
					</div>

					@if($withNav)
						{{-- Next button --}}
						@if($count > 3)
							<div x-on:click="previousElement(benefitTypeSlug);" class="ml-3 cursor-pointer hidden md:block absolute right-2">
								<svg width="80" height="80" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g filter="url(#filter0_d_323_7220)">
										<path d="M50.5 81C67.3447 81 81 67.3447 81 50.5C81 33.6553 67.3447 20 50.5 20C33.6553 20 20 33.6553 20 50.5C20 67.3447 33.6553 81 50.5 81Z" fill="#F7F6EF" />
									</g>
									
									<path d="M44.9546 36.6364L58.8182 50.5L44.9546 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									
									<defs>
										<filter id="filter0_d_323_7220" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
											<feFlood flood-opacity="0" result="BackgroundImageFix" />
											<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
											<feOffset />
											<feGaussianBlur stdDeviation="10" />
											<feComposite in2="hardAlpha" operator="out" />
											<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
											<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_323_7220" />
											<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_323_7220" result="shape" />
										</filter>
									</defs>
								</svg>
							</div>
						@endif
					@endif
				</div>
			</div>
		@endif
	</div>
</div>
