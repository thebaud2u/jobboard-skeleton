<div x-data="{}" class="w-full flex flex-col justify-center items-center">
	{{-- Header form --}}
	<div class="bg-breeder-cream w-full flex flex-col items-center gap-y-4 s:gap-y-12 h-[244px] s:h-[311px] text-breeder-deepblue">
		<h2 class="text-[25px] sm:text-[30px] lg:text-[40px] font-bold text-center mt-2">
			{{ __('Information to share with the breeder') }}
		</h2>

		<div id="anchor" class="flex justify-between items-center font-bold w-[323px] s:w-[438px] pb-10 max-sm:text-xs">
			@for ($i = 1; $i <= 3; $i++)
				@if($i == 1)
					<div class="flex flex-col items-center gap-y-4 w-[108px] cursor-pointer h-full" wire:click="goto(1)">
						@if($active == 1)
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2"/>
								<path d="M28.0796 27.08V24.756H33.3436V45H30.7676V27.08H28.0796Z" fill="#0E1954"/>
							</svg>
						@else
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2"/>
								<path d="M36.2391 24.5814C34.6609 23.7822 32.8787 23.3333 31 23.3333C24.4725 23.3333 19.1904 28.7199 19.1904 35.3764C19.1904 42.0329 24.4725 47.4194 31 47.4194C37.5274 47.4194 42.8095 42.0329 42.8095 35.3764C42.8095 33.8327 42.5196 32.3547 42.0043 30.9971M25.632 35.3764L29.9264 39.7556L42.8095 23.3333" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						@endif

						{{ __('Environment') }}
					</div>
				@elseif($i == 2)
					<div class="flex flex-col text-center items-center gap-y-4 w-[108px] h-full @if($active == 1) text-breeder-greige @else text-breeder-deepblue cursor-pointer @endif" @if($active == 3) wire:click="goto(2)" @endif>
						@if($active != 3)
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="currentColor" stroke-width="2"/>
								<path d="M24.8753 42.956C27.2459 41.052 29.1033 39.4933 30.4473 38.28C31.7913 37.048 32.9206 35.7693 33.8353 34.444C34.7686 33.1 35.2353 31.784 35.2353 30.496C35.2353 29.2827 34.9366 28.3307 34.3393 27.64C33.7606 26.9307 32.8179 26.576 31.5113 26.576C30.2419 26.576 29.2526 26.9773 28.5433 27.78C27.8526 28.564 27.4793 29.6187 27.4233 30.944H24.9593C25.0339 28.8533 25.6686 27.2387 26.8633 26.1C28.0579 24.9613 29.5979 24.392 31.4833 24.392C33.4059 24.392 34.9273 24.924 36.0473 25.988C37.1859 27.052 37.7553 28.5173 37.7553 30.384C37.7553 31.9333 37.2886 33.4453 36.3553 34.92C35.4406 36.376 34.3953 37.664 33.2193 38.784C32.0433 39.8853 30.5406 41.1733 28.7113 42.648H38.3433V44.776H24.8753V42.956Z" fill="currentColor"/>
							</svg>
						@else
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2"/>
								<path d="M36.2391 24.5814C34.6609 23.7822 32.8787 23.3333 31 23.3333C24.4725 23.3333 19.1904 28.7199 19.1904 35.3764C19.1904 42.0329 24.4725 47.4194 31 47.4194C37.5274 47.4194 42.8095 42.0329 42.8095 35.3764C42.8095 33.8327 42.5196 32.3547 42.0043 30.9971M25.632 35.3764L29.9264 39.7556L42.8095 23.3333" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						@endif

						{{ __('Animal management') }}
					</div>
				@else
					<div class="flex flex-col items-center gap-y-4 w-[108px] h-full @if($active != 3) text-breeder-greige @else text-breeder-deepblue cursor-pointer @endif">
						<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
							<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="currentColor" stroke-width="2"/>
							<path d="M24.9359 29.852C25.0665 28.1347 25.7292 26.7907 26.9239 25.82C28.1185 24.8493 29.6679 24.364 31.5719 24.364C32.8412 24.364 33.9332 24.5973 34.8479 25.064C35.7812 25.512 36.4812 26.128 36.9479 26.912C37.4332 27.696 37.6759 28.5827 37.6759 29.572C37.6759 30.7293 37.3399 31.728 36.6679 32.568C36.0145 33.408 35.1559 33.9493 34.0919 34.192V34.332C35.3052 34.6307 36.2665 35.2187 36.9759 36.096C37.6852 36.9733 38.0399 38.1213 38.0399 39.54C38.0399 40.604 37.7972 41.5653 37.3119 42.424C36.8265 43.264 36.0985 43.9267 35.1279 44.412C34.1572 44.8973 32.9905 45.14 31.6279 45.14C29.6492 45.14 28.0252 44.6267 26.7559 43.6C25.4865 42.5547 24.7772 41.08 24.6279 39.176H27.0919C27.2225 40.296 27.6799 41.2107 28.4639 41.92C29.2479 42.6293 30.2932 42.984 31.5999 42.984C32.9065 42.984 33.8959 42.648 34.5679 41.976C35.2585 41.2853 35.6039 40.3987 35.6039 39.316C35.6039 37.916 35.1372 36.908 34.2039 36.292C33.2705 35.676 31.8612 35.368 29.9759 35.368H29.3319V33.24H30.0039C31.7212 33.2213 33.0185 32.9413 33.8959 32.4C34.7732 31.84 35.2119 30.9813 35.2119 29.824C35.2119 28.8347 34.8852 28.0413 34.2319 27.444C33.5972 26.8467 32.6825 26.548 31.4879 26.548C30.3305 26.548 29.3972 26.8467 28.6879 27.444C27.9785 28.0413 27.5585 28.844 27.4279 29.852H24.9359Z" fill="currentColor"/>
						</svg>

						{{ __('Validation') }}
					</div>
				@endif
			@endfor
		</div>

		<div class="relative">
			<div class="absolute w-[30px] s:w-[70px] border-t-2 @if($active < 2) border-breeder-greige @else border-breeder-deepblue @endif -top-[136px] s:-top-[168px] sm:-top-[188px] -left-[70px] s:-left-[117px]">
			</div>

			<div class="absolute w-[30px] s:w-[70px] border-t-2 @if($active != 3) border-breeder-greige @else border-breeder-deepblue @endif -top-[136px] s:-top-[168px] sm:-top-[188px] left-[38px] s:left-[48px]">
			</div>
		</div>
	</div>
	{{-- End header form --}}

	<div class="grid grid-flow-col auto-cols-max gap-4 max-lg:flex max-lg:flex-col max-lg:items-center my-2 max-w-[1200px] w-full max-md:px-6 @if($active == 3) justify-center @endif">
		<div class="text-sm lg:text-base @if($active !=3) max-w-[870px] md:w-[870px]  @endif w-full">
			<div class="flex flex-col gap-8 px-4 max-sm:pl-4 pl-0 md:border-t md:border-transparent w-full">
				<div class="mt-4">
					@if($post->type->getTranslation('slug', 'en') == 'stud')
						@if($active == 1)
							<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between">
								<x-front.space-title>
									{{ __('My female description') }}
								</x-front.space-title>
							</div>

							<div class="flex flex-col mt-4 gap-y-6">
								<div class="flex flex-row gap-x-1">
									<label for="pureBreedFemale" class="inline-flex items-center mr-2">
										<input type="checkbox" name="pureBreedFemale" id="pureBreedFemale" wire:model.live="pureBreedFemale" class="cursor-pointer rounded border-gray-300 text-breeder-deepblue shadow-sm focus:ring-breeder-deepblue" />

										<span class="ms-2">
											{{ __('I confirm my femelle is :lof', ['lof' => $post->model->species->getTranslation('slug', 'en') == 'dog' ? 'LOF' : 'LOOF']) }}
										</span>
									</label>
								</div>

								<div class="flex flex-row">
									@error('pureBreedFemale')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div class="flex flex-col">
									<x-front.input-label for="photo" :value="__('My female\'s photo')" />

									<livewire:uppy
										:maxMedias="1"
										:class="$mediableClassPhoto"
										:modelId="$mediableIdPhoto"
										:collection="'photos'.$mediableIdPhoto"
										:gridClass="'sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-4 items-center'"
										:aspectRatio="'aspect-square'"
										:objectFit="'object-cover'"
										:key="'photo-female-'.$subComponentKey" />
								</div>

								<div class="flex flex-col gap-y-2">
									<x-front.input-label for="quotation" :value="__('Quotation')" />

									<div x-data="{ value: @entangle('quotation').live }" class="flex flex-col w-64 space-y-2">
										<div class="flex justify-between">
											<template x-for="n in 5" :key="n">
												<label class="flex flex-col items-center cursor-pointer">
													<input type="radio" :value="n" x-model="value" name="quotation" class="sr-only" />

													<div :class="{'bg-breeder-deepblue': value == n, 'bg-gray-100 text-breeder-deepblue': value != n}" class="w-5 h-5 rounded-full transition"></div>
												</label>
											</template>
										</div>

										<label class="flex justify-center text-sm text-breeder-deepblue">
											<span x-text="[value]"></span>
										</label>
									</div>
								</div>

								<div class="flex flex-col gap-y-2">
									<div class="flex flex-row">
										<x-front.input-label for='filePedigree' :value="__('Pedigree')" />
									</div>

									<div>
										<x-front.primary-button type="button" onclick="document.getElementById('filePedigree').click()">
											{{ __('Choose File') }}
										</x-front.primary-button>

										<input type="file" id="filePedigree" name="filePedigree" class="hidden" wire:model="pedigreeFile" />
									</div>
								</div>

								@error('filePedigree')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror

								@if($pedigreeFile)
									<div class="flex flex-row">
										<x-front.input-label for="filePedigree" :value="__('Selected file :')" />
									</div>

									<ul class="mt-2 pl-4 space-y-2 text-sm text-breeder-greige">
										<li class="flex items-center justify-between text-sm text-breeder-greige">
											<div class="flex items-center gap-x-2">
												•

												<div>
													<p class="font-medium truncate max-w-[200px]">
														{{ $pedigreeFile->getClientOriginalName() }}</p>
													<p class="text-xs text-breeder-greige">
														{{ number_format($pedigreeFile->getSize() / 1024, 2) }} KB
													</p>

													<button wire:click="removePedigree()" class="text-red-600 text-xs">
														{{ __('Delete') }}
													</button>
												</div>
											</div>
										</li>
									</ul>
								@endif
							</div>
						@elseif($active == 2)
							<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between">
								<x-front.space-title>
									{{ __('Out-company') }}
								</x-front.space-title>
							</div>

							<div class="flex flex-col mt-4 gap-y-6">
								<div class="flex flex-col mt-4 gap-y-2">
									<x-front.input-label for="outCompanyDate" :value="__('Out-company date wished')" :class="'pl-4'"/>

									<x-front.text-input type="date" name="outCompanyDate" id="outCompanyDate" wire:model="date" placeholder="{{ __('DD/MM/YYYY') }}" :class="'mt-1 block bg-white'" />

									@error('date')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div class="flex flex-col gap-y-2">
									<x-front.input-label for="outCompanyDate" :value="__('Write a message to the breeder')" :required="true" :class="'pl-4'"/>

									<textarea id="message" rows="5" wire:model="message" placeholder="{{ __('Write a message to the breeder') }}" maxlength="1000" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 block w-full"></textarea>

									@error('message')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>
						@endif
					@else
						@if($active == 1)
							<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between">
								<x-front.space-title>
									{{ __('My home') }}
								</x-front.space-title>
							</div>

							<div class="flex mt-4 gap-y-4 max-lmd:gap-x-4 flex-wrap justify-center lmd:justify-between text-breeder-deepblue">
								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="placeConfiguration" value="house_with_garden" id="houseWithGarden" wire:model="placeConfiguration" class="peer hidden" />
									<label for="houseWithGarden" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[144px]">
												<svg width="69" height="47" viewBox="0 0 69 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="8" cy="24" r="8" fill="#FFA244"/>
													<ellipse cx="43.5" cy="7" rx="4.5" ry="5" fill="#FFA244"/>
													<ellipse cx="23.5" cy="32" rx="4.5" ry="5" fill="#FFA244"/>
													<path d="M26.6302 20.7125C26.704 20.4 26.7285 20.0625 26.7285 19.725C26.7285 17.2 25.0692 15.0625 22.7706 14.3875C23.0042 13.8 23.1148 13.1625 23.1148 12.4875C23.1148 9.40002 20.6564 6.90002 17.645 6.90002C14.6089 6.90002 12.1506 9.40002 12.1506 12.4875C12.1506 13.1625 12.2612 13.7875 12.4702 14.375C10.1839 15.05 8.5 17.2 8.5 19.725C8.5 21.5 9.32354 23.1 10.6142 24.1125C9.32354 25.1375 8.5 26.725 8.5 28.5125C8.5 31.5875 10.9583 34.0875 13.9944 34.0875C15.3956 34.0875 16.6617 33.5625 17.6204 32.6875C18.5914 33.5625 19.8698 34.0875 21.2464 34.0875C21.9471 34.0875 22.6231 33.95 23.25 33.7M17.6246 32.687V46M30.1579 16.6375C29.6662 15.8125 29.3958 14.85 29.3958 13.825C29.3958 11.3 31.0798 9.15 33.366 8.475C33.1571 7.8875 33.0464 7.2625 33.0464 6.5875C33.0464 3.5 35.5048 1 38.5408 1C41.5523 1 44.0106 3.5 44.0106 6.5875C44.0106 7.2625 43.9 7.9 43.6664 8.4875C45.6823 9.075 47.1941 10.7875 47.5506 12.9M33.3906 12.901H57.3594L67.5 24.5305M33.3906 12.901L42.9167 23.9132L43.5312 24.5305H67.5M33.3906 12.901L23.25 24.6235V46H43.5312V27.25M67.5 24.5305L67.5 46H42.9167M29.7031 45.9999V37.2259C29.7031 35.1549 31.3541 33.4759 33.3906 33.4759C35.4271 33.4759 37.0781 35.1549 37.0781 37.2259V45.9999M50.2917 12.9V8.5H55.2083V12.9M35.5417 24.75C35.5417 26.1307 34.441 27.25 33.0833 27.25C31.7256 27.25 30.625 26.1307 30.625 24.75C30.625 23.3693 31.7256 22.25 33.0833 22.25C34.441 22.25 35.5417 23.3693 35.5417 24.75Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('A house with garden') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="placeConfiguration" value="house_without_garden" id="houseWithoutGarden" wire:model="placeConfiguration" class="peer hidden" />
									<label for="houseWithoutGarden" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[144px]">
												<svg width="60" height="50" viewBox="0 0 60 50" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="14" cy="34" r="8" fill="#FFA244"/>
													<ellipse cx="40.5" cy="5" rx="4.5" ry="5" fill="#FFA244"/>
													<path d="M56.1935 23.3687V48.0625C56.1935 48.5781 55.7725 49 55.258 49H26.258M26.258 49V24.625M26.258 49L26.258 23.3687M26.258 49H4.74193C4.22742 49 3.80645 48.5781 3.80645 48.0625V24.625M41.3659 4H17.6049C17.3675 4 17.139 4.09188 16.9665 4.25688L1.29173 19.2569C0.682547 19.8398 1.09098 20.875 1.9301 20.875H23.3562C23.597 20.875 23.8285 20.7805 24.0017 20.6112L40.7276 4.26231C41.0834 3.9145 41.6483 3.9145 42.0041 4.26231L59 20.8748M35.6129 45.25V31.1875C35.6129 30.6698 36.0318 30.25 36.5484 30.25H45.9032C46.4198 30.25 46.8387 30.6698 46.8387 31.1875V45.25M12.2258 30.25H17.8387C18.3553 30.25 18.7742 30.6698 18.7742 31.1875V36.8125C18.7742 37.3303 18.3553 37.75 17.8387 37.75H12.2258C11.7091 37.75 11.2903 37.3303 11.2903 36.8125V31.1875C11.2903 30.6698 11.7091 30.25 12.2258 30.25Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('A house without garden') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="placeConfiguration" value="flat" id="flat" wire:model="placeConfiguration" class="peer hidden" />
									<label for="flat" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[144px]">
												<svg width="47" height="48" viewBox="0 0 47 48" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="23.5" cy="40" r="8" fill="#FFA244"/>
													<ellipse cx="33" cy="18" rx="4.5" ry="5" fill="#FFA244"/>
													<path d="M26.4348 30.3478V32.3043M20.5652 30.3478V32.3043M20.5652 46V36.2174H26.4348V46M14.6957 30.3478V32.3043M32.3043 30.3478V32.3043M26.4348 22.5217V24.4783M20.5652 22.5217V24.4783M14.6957 22.5217V24.4783M32.3043 22.5217V24.4783M26.4348 14.6957V16.6522M20.5652 14.6957V16.6522M14.6957 14.6957V16.6522M32.3043 14.6957V16.6522M26.4348 6.86956V8.82609M20.5652 6.86956V8.82609M14.6957 6.86956V8.82609M32.3043 6.86956V8.82609M14.6957 38.1739V40.1304M32.3043 38.1739V40.1304M38.1739 46V1H8.82609V46M1 46H46" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('A flat') }}
											</h3>
										</div>
									</label>
								</div>
							</div>

							<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between mt-8">
								<x-front.space-title>
									{{ __('My household composition') }}
								</x-front.space-title>
							</div>

							<div class="flex mt-4 gap-y-4 max-lmd:gap-x-4 flex-wrap justify-center lmd:justify-between text-breeder-deepblue">
								<div class="w-full max-w-[360px] s:max-w-[200px]">
									<input type="checkbox" name="householdComposition" value="young_children" id="youngChildren" wire:model="householdComposition" class="peer hidden" />
									<label for="youngChildren" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[170px]">
												<svg width="40" height="47" viewBox="0 0 40 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="8.75" cy="37" r="8" fill="#FFA244"/>
													<ellipse cx="35.25" cy="8" rx="4.5" ry="5" fill="#FFA244"/>
													<path d="M28.0106 25.2646V21.0865L37.579 13.5013C38.6914 12.6204 38.9557 11.015 38.1825 9.81172C37.3343 8.49545 35.5792 8.16638 34.3297 9.09043L28.8164 13.1656C26.6078 14.7976 23.9457 15.6784 21.2152 15.6784H21.0357C18.3052 15.6784 15.6464 14.7976 13.4345 13.1656L7.9212 9.09043C6.67173 8.16638 4.91334 8.49545 4.0684 9.81172C3.29523 11.015 3.55621 12.6171 4.67193 13.5013L14.2403 21.0865V25.2646M28.0106 25.2646V29.7353M28.0106 25.2646H14.2436V29.7719M14.2436 29.7719L18.5498 33.6276M14.2436 29.7719L11.2129 34.8874C10.1755 36.6358 10.2244 38.8396 11.3369 40.5414L14.0707 44.7196C14.9352 46.0392 16.6871 46.3982 17.9822 45.5173C19.2806 44.6365 19.6297 42.8515 18.7652 41.5319L16.1944 37.6031L18.5498 33.6276M18.5498 33.6276H23.7239L28.0106 29.7353M28.0106 29.7353L31.0641 34.8841C32.1015 36.6325 32.0526 38.8362 30.9401 40.5381L28.2063 44.7163C27.3418 46.0359 25.5899 46.3948 24.2948 45.514C22.9964 44.6332 22.6473 42.8482 23.5118 41.5286L26.0825 37.5997L23.7271 33.6243M26.7644 7.00966C26.7644 10.3287 24.2405 13.0193 21.1271 13.0193C18.0137 13.0193 15.4898 10.3287 15.4898 7.00966C15.4898 3.69061 18.0137 1 21.1271 1C24.2405 1 26.7644 3.69061 26.7644 7.00966Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												<span class="s:hidden">{{ __('Young children (From 0 to 4 years old)') }}</span>
												<span class="max-s:hidden">{{ __('Young children') }}<br>{{ __('(from 0 to 4 years old)') }}</span>
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[198px]">
									<input type="checkbox" name="householdComposition" value="children" id="children" wire:model="householdComposition" class="peer hidden" />
									<label for="children" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[170px]">
												<svg width="43" height="47" viewBox="0 0 43 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="8" cy="8" r="8" transform="matrix(1 0 0 -1 12.75 19)" fill="#FFA244"/>
													<ellipse cx="4.5" cy="5" rx="4.5" ry="5" transform="matrix(1 0 0 -1 33.75 19)" fill="#FFA244"/>
													<path d="M13.3536 46L12.8785 34.1305V23.4802L2.36361 14.5386C1.23304 13.5779 1.04661 11.8905 1.93664 10.6987C2.81464 9.52206 4.44435 9.23627 5.66512 10.045L12.0517 14.2771C13.6904 15.3625 15.6057 15.9432 17.5662 15.9432H22.1156C24.061 15.9432 25.9673 15.3717 27.6 14.2984L34.0888 10.0328C35.3066 9.23019 36.9333 9.51902 37.8083 10.6926L37.8143 10.6987C38.7043 11.8905 38.5149 13.5779 37.3873 14.5386L26.8724 23.4802V34.1305L25.838 46M19.5868 35.7085V44.8325M24.6774 6.2689C24.6774 9.17883 22.5262 11.5378 19.8725 11.5378C17.2188 11.5378 15.0675 9.17883 15.0675 6.2689C15.0675 3.35897 17.2188 1 19.8725 1C22.5262 1 24.6774 3.35897 24.6774 6.2689Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												<span class="s:hidden">{{ __('Children (from 5 to 12 years old)') }}</span>
												<span class="max-s:hidden">{{ __('Children') }}<br>{{ __('(from 5 to 12 years old)') }}</span>
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[198px]">
									<input type="checkbox" name="householdComposition" value="teenagers" id="teenagers" wire:model="householdComposition" class="peer hidden" />
									<label for="teenagers" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[170px]">
												<svg width="26" height="48" viewBox="0 0 26 48" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="12" cy="8" r="8" fill="#FFA244"/>
													<ellipse cx="5.5" cy="32" rx="4.5" ry="5" fill="#FFA244"/>
													<path d="M6.00125 34.0752H5.18696C3.08113 34.0752 1.375 32.4121 1.375 30.3603V24.2925C1.375 20.2005 4.7813 16.8802 8.98102 16.8802H16.769C20.9687 16.8802 24.375 20.1976 24.375 24.2925V30.3632C24.375 32.415 22.6689 34.0781 20.563 34.0781H19.5012M6.29952 24.6549V37.0039L6.97064 47M19.4445 24.6549V37.0039L18.7764 47M12.8735 38.2286V47M18.1619 7.568C18.1619 10.6431 15.7942 13.136 12.8735 13.136C9.9528 13.136 7.58509 10.6431 7.58509 7.568C7.58509 4.49288 9.9528 2 12.8735 2C15.7942 2 18.1619 4.49288 18.1619 7.568Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												<span class="s:hidden">{{ __('Teenagers (+ than 12 years old)') }}</span>
												<span class="max-s:hidden">{{ __('Teenagers') }}<br>{{ __('(+ than 12 years old)') }}</span>
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[198px]">
									<input type="checkbox" name="householdComposition" value="adult" id="adult" wire:model="householdComposition" class="peer hidden" />
									<label for="adult" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row s:flex-col items-center max-s:pl-4 s:justify-center gap-4 text-base font-medium text-center h-[85px] s:h-[170px]">
												<svg width="62" height="47" viewBox="0 0 62 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="9.375" cy="16" r="8" fill="#FFA244"/>
													<ellipse cx="35.875" cy="11" rx="4.5" ry="5" fill="#FFA244"/>
													<ellipse cx="51.875" cy="16" rx="4.5" ry="5" fill="#FFA244"/>
													<path d="M10.9078 36.5647V46M5.24619 20.7554V33.4229L5.97268 46M16.5694 20.7554V33.4229L15.8429 46M33.246 36.5647V46M37.7578 46L38.2663 36.5647H41.28L37.2442 19.7601M28.7318 46L28.2257 36.5647H25.2121L29.2478 19.7601M4.98817 31.6836H4.28422C2.47051 31.6836 1 30.2183 1 28.4112V19.7776C1 16.289 3.81827 13.464 7.29539 13.464H14.678C17.5364 13.464 20.034 15.3943 20.7655 18.164L22.9524 26.4658L25.1244 18.2746C25.8759 15.437 28.4437 13.464 31.3822 13.464H34.932C37.9131 13.464 40.4959 15.5174 41.1547 18.4129L42.8081 25.6716C43.2816 27.7527 41.776 29.7332 39.6767 29.884M36.0192 11.2522H37.8955C38.136 11.2522 38.3014 11.0084 38.2062 10.7872C37.8204 9.89494 37.5974 8.93985 37.5473 7.96464C37.4972 6.9995 37.4371 5.93884 37.402 5.66488C37.124 3.46062 35.3704 1.76156 33.246 1.76156C31.1217 1.76156 29.3681 3.46062 29.09 5.66488C29.0549 5.93884 28.9948 6.9995 28.9447 7.96464C28.8946 8.93733 28.6692 9.89243 28.2859 10.7872C28.1907 11.0084 28.356 11.2522 28.5965 11.2522H30.4728M55.1709 44.2306L55.8223 37.462H58.1996L56.0051 21.155M50.6467 37.462V44.2306M44.0331 15.5149C44.2035 15.3716 44.3763 15.2359 44.5592 15.1052C45.6314 14.3412 46.8764 13.8737 48.1716 13.6952M57.4005 30.5627H58.3299C59.9607 30.5627 61.2108 29.1124 60.9703 27.4938C60.5645 24.7391 60.1261 21.7507 60.0033 20.871C59.6225 18.1138 58.41 16.3041 56.7241 15.1052C55.6544 14.3437 54.4144 13.8762 53.1192 13.6952M54.6774 9.75168C54.6949 9.90751 54.7025 10.0684 54.7025 10.2292C54.7025 12.6471 52.8862 14.6051 50.6467 14.6051C48.4071 14.6051 46.5883 12.6471 46.5883 10.2292C46.5883 10.0734 46.5959 9.91756 46.6134 9.76424M15.1014 6.28066C15.1014 8.77372 13.2238 10.7947 10.9078 10.7947C8.59173 10.7947 6.7142 8.77372 6.7142 6.28066C6.7142 3.78761 8.59173 1.76659 10.9078 1.76659C13.2238 1.76659 15.1014 3.78761 15.1014 6.28066ZM53.1292 4.44085H53.1493C53.237 4.18448 53.2846 3.9055 53.2846 3.61897C53.2846 2.17376 52.1046 1 50.6492 1C49.1937 1 48.0113 2.17376 48.0113 3.61897C48.0113 3.89796 48.0563 4.16689 48.139 4.41823H48.149C46.666 5.09685 45.8042 6.77329 46.2401 8.44219C46.438 9.20124 46.5883 9.78184 46.5883 9.78184L50.6441 7.04725L54.7 9.76424L55.0457 8.51005C55.5066 6.82859 54.6423 5.1245 53.1292 4.43834V4.44085Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												<span class="s:hidden">{{ __('Partner, spouse, adult') }}</span>
												<span class="max-s:hidden">{{ __('Partner,') }}<br>{{ __('spouse, adult') }}</span>
											</h3>
										</div>
									</label>
								</div>
							</div>

							<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between mt-8">
								<x-front.space-title>
									{{ __('Animals in my home') }}
								</x-front.space-title>
							</div>

							<div class="flex mt-4 gap-y-4 max-lmd:gap-x-4 flex-wrap justify-center lmd:justify-between text-breeder-deepblue">
								<div class="w-full max-w-[360px] s:max-w-[198px]">
									<input type="checkbox" name="homeAnimals" value="dogs" id="dogs" wire:model="homeAnimals" wire:change="homeAnimalsSelected" class="peer hidden" />
									<label for="dogs" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[184px]">
												<svg width="49" height="47" viewBox="0 0 49 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="9.1875" cy="38" r="8" fill="#FF7E71"/>
													<ellipse cx="35.6875" cy="9" rx="4.5" ry="5" fill="#FF7E71"/>
													<path d="M34.9842 4.15137C34.9842 4.15137 35.9635 6.63682 35.679 11.8384C35.63 12.7345 33.7792 12.5414 32.0473 12.0403C30.4254 11.5713 28.928 10.8672 28.5612 9.53282C28.071 7.74931 28.1999 4.78708 28.7857 3.34128M38.4458 18.5299C38.2112 15.8259 38.4458 15.0224 39.4096 14.6682C40.3734 14.3139 42.4354 15.0578 45.04 13.6407C46.5618 12.8129 47.0676 10.9963 47.4734 9.83854C47.749 9.05053 47.3655 8.18525 46.5963 7.84974L42.551 6.06071C42.551 6.06071 41.9263 4.68113 40.8525 3.32142C39.6741 1.82927 37.86 0.978346 35.9502 1.00042C30.5099 1.06333 28.7046 2.33254 27.3473 6.12361C26.6592 7.7758 26.0878 9.60236 25.6076 11.2843C25.1007 13.0601 24.7027 15.6703 23.2265 17.4295C19.5447 21.8133 8.85864 27.4408 8.50737 38.3627C8.50737 43.8898 12.3536 46 12.3536 46H27.852C28.32 46 28.669 45.5751 28.5801 45.1182C28.1766 43.0499 26.9293 41.5787 24.7672 41.5787H21.081C21.081 41.5787 25.5664 36.3308 24.6071 32.021C24.1736 30.0753 22.7185 28.9738 21.7124 28.7145M29.5561 26.7521C30.1175 30.5443 31.7093 41.2101 32.124 43.1857C32.6297 45.5972 34.2494 45.9989 34.2494 45.9989H39.5819C40.0265 45.9989 40.3678 45.6148 40.3189 45.1756C40.1777 43.9218 39.533 41.6781 36.7205 41.6781L35.9402 27.8845C35.9402 27.8845 36.8884 26.6892 37.7533 24.994C38.6937 23.1498 38.6915 21.3563 38.4469 18.5288M5.85502 37.2149C3.94968 35.2514 3.09262 32.2274 2.48789 30.498C2.25556 30.9063 2.02879 31.5354 1.84981 32.3102C0.333551 38.9001 5.01463 45.3201 11.2787 45.8996L12.3525 45.9989M30.8 35.0285C28.4067 37.8594 26.1701 40.9463 24.4248 41.5776" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('Dog(s)') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[198px]">
									<input type="checkbox" name="homeAnimals" value="cats" id="cats" wire:model="homeAnimals" wire:change="homeAnimalsSelected" class="peer hidden" />
									<label for="cats" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[184px]">
												<svg width="43" height="46" viewBox="0 0 43 46" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="8.47656" cy="38" r="8" fill="#3DD8AC"/>
													<ellipse cx="34.9766" cy="9" rx="4.5" ry="5" fill="#3DD8AC"/>
													<path d="M24.7045 40.6197C24.7045 40.6197 28.103 40.0409 28.8307 34.6554C29.1982 32.1248 27.7852 29.5423 27.7852 29.5423M13.7162 44.3372H30.4839C30.8462 44.3372 31.1402 44.042 31.1402 43.6783V43.2106C31.1402 41.7858 29.9787 40.6197 28.5595 40.6197H24.7056M28.7489 32.341L31.313 42.6712C31.5563 43.6502 32.4321 44.3372 33.4362 44.3372H37.3429C37.7052 44.3372 37.9992 44.042 37.9992 43.6783V42.902C37.9992 41.6413 36.9816 40.6197 35.726 40.6197L34.6349 30.489C34.6349 30.489 37.2508 27.3141 37.9205 23.6995C38.4588 20.7917 36.9309 18.7339 37.7311 16.3852C38.1638 15.1163 39.4091 15.1994 40.465 14.4927C41.5208 13.786 42.4152 11.4186 41.1585 10.6069C40.1016 9.92413 39.9836 6.72737 38.375 5.91986C36.7663 5.11236 36.1131 4.79122 36.1131 4.79122C36.1638 2.72206 35.404 1 35.404 1C35.404 1 32.2219 2.67321 29.4477 6.16097C28.7272 7.06617 28.0305 8.3403 27.7386 9.53025C27.2138 12.0079 27.9726 16.9527 24.8991 18.1686C10.9192 23.6975 10.0072 30.4308 11.3767 40.1645M11.3767 40.1635C14.4398 40.1635 17.3714 40.2841 18.5287 40.5553C19.9873 40.8972 20.4376 41.7068 20.4427 42.479C20.4469 43.2543 19.9986 43.9921 18.2689 44.1782C17.3486 44.2769 14.9874 44.3382 13.0899 44.3382C6.95553 44.3382 5.42969 43.6793 5.42969 42.0965C5.42969 40.5137 9.93888 39.3602 10.9782 36.4242" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('Cat(s)') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[198px]">
									<input type="checkbox" name="homeAnimals" value="others" id="others" wire:model="homeAnimals" wire:change="homeAnimalsSelected" class="peer hidden" />
									<label for="others" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[184px]">
												<svg width="119" height="48" viewBox="0 0 119 48" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="37.7726" cy="40" r="8" fill="#FFA244"/>
													<circle cx="12.7726" cy="11" r="8" fill="#FFA244"/>
													<circle cx="105.773" cy="32" r="8" fill="#FFA244"/>
													<ellipse cx="64.2726" cy="11" rx="4.5" ry="5" fill="#FFA244"/>
													<path d="M12.9964 20.4347C15.0519 22.8802 14.8486 27.3776 12.3814 31.6264C9.40285 36.7564 1.67126 37.046 1.67126 37.046C1.67126 37.046 6.44003 21.2941 7.30724 18.9097C8.17445 16.5253 10.7037 15.1521 13.088 15.8753M23.9403 16.1597C25.2673 14.6295 24.7386 10.6433 21.6816 9.86682C21.2244 6.32645 16.8448 5.67038 14.6122 6.69986C11.9399 7.93175 10.4559 5.31006 10.4559 5.31006M23.9403 16.1589C22.7861 14.0912 20.1339 15.3056 20.1339 15.3056C20.1339 15.3056 21.9119 21.4703 20.5675 26.3638C18.8322 32.6786 12.2749 31.8044 12.2749 31.8044M13.0148 35.8394V41.69M7.10658 35.8394H23.4867M13.259 31.8436C14.2196 34.0954 14.7143 35.8054 14.7143 35.8054M7.30811 18.9097C9.93067 10.8457 11.2646 7.94222 14.6131 6.69899M4.1996 36.7424L2.7688 40.7626C2.56377 41.3393 3.23206 41.8619 3.8864 41.6359L5.14009 41.2032C6.17743 40.8446 6.97397 40.11 7.31248 39.1983L8.5592 35.8386" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M64.9825 25.2439C66.6899 29.4968 66.4964 32.1169 64.8201 34.4478C63.1439 36.7777 62.2085 37.6194 62.9181 39.496C63.6277 41.3727 64.8083 40.5881 66.6899 41.8831C67.6017 42.5112 67.8823 43.45 67.9533 44.5647C68.0027 45.3417 67.3942 46 66.619 46H60.9838M60.9838 46H43.315M60.9838 46V45.6763C60.9838 43.5676 59.2807 41.8583 57.1797 41.8583H55.3745C57.3088 40.6291 58.4055 37.9755 57.6958 34.4802C57.0443 31.2676 53.3961 28.7662 49.1049 29.3381M43.315 46C36.6734 46 34.8294 43.1522 34.6359 40.1748C34.4424 37.1975 36.6541 36.809 36.6541 36.809C36.6541 36.809 38.5324 36.8791 39.1808 39.155M43.315 46C43.315 46 38.9303 43.4112 38.9303 36.3568C38.9303 29.3025 44.8192 23.7719 52.3424 22.1187M62.5515 24.5748C63.7955 25.3119 65.7609 25.4112 67.9275 24.6439C70.0876 23.8788 71.023 22.6129 71.4283 21.7022C71.6896 21.1151 71.6864 20.445 71.4348 19.8547C70.5768 17.8442 67.9834 12.4572 63.4385 11.814C62.1085 11.6263 60.9548 11.7881 59.9656 12.1421C59.7871 10.8849 58.5592 4.04856 49.4888 4.04856C49.4888 4.04856 46.7674 11.5356 55.7787 15.4647H55.7798C55.6895 16.2104 56.0411 21.3072 52.3413 22.1198M52.1553 4.26871C52.0671 3.70216 51.8768 2.00899 52.5531 1C53.3735 1 61.787 1 63.1514 11.2356" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M104.536 33.3973C101.206 34.0632 102.626 37.3381 102.626 37.3381C102.626 37.3381 109.289 38.9028 110.574 32.3033M94.5321 28.4801C95.8227 30.4614 99.0722 33.8985 105.882 33.3371C112.018 32.8315 115.398 29.6525 117.02 27.4725C117.897 26.2948 117.813 24.6473 116.807 23.5795C114.85 21.5023 110.912 18.38 104.915 18.38C98.2719 18.38 93.8216 22.0707 93.8216 22.0707C93.8216 22.0707 89.6855 13.951 81.8613 15.968C81.8613 15.968 80.9385 19.6352 82.7316 22.5388C84.5238 25.4423 80.2306 30.8345 82.5839 36.0001C82.5839 36.0001 90.27 36.0001 94.8058 28.8785M111.903 31.7236C107.254 30.1285 107.559 24.8313 109.644 22.8804M111.45 19.752C110.054 15.2053 108.157 9.15935 99.8112 9.51499C99.4098 9.53243 99.0135 9.64051 98.6656 9.84362C96.9744 10.833 98.9281 12.2956 97.1073 14.066C95.0907 16.0264 94.5675 18.5526 97.1073 20.1181M106.043 18.38C106.043 18.38 105.927 15.1975 103.422 13.0104M91.7229 26.7429C89.8556 27.3835 87.3028 30.091 81.9088 31.4525M83.0717 23.3206C83.0717 23.3206 84.0809 22.4324 89.6933 23.3206" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('Others') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[198px]">
									<input type="checkbox" name="homeAnimals" value="none" id="none" wire:model="homeAnimals" wire:change="homeAnimalsSelected" class="peer hidden" />
									<label for="none" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[184px]">
												<svg width="48" height="47" viewBox="0 0 48 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="24.499" cy="25" r="8" fill="#FFA244"/>
													<path d="M16.8832 30.7409L31.3649 16.2591M16.8832 16.2591L31.3649 30.7409M46.624 23.5C46.624 35.9264 36.5504 46 24.124 46C11.6976 46 1.62402 35.9264 1.62402 23.5C1.62402 11.0736 11.6976 1 24.124 1C36.5504 1 46.624 11.0736 46.624 23.5Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('None') }}
											</h3>
										</div>
									</label>
								</div>
							</div>
						@elseif($active == 2)
							<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between">
								<x-front.space-title>
									{{ __('Management of my pet') }}
								</x-front.space-title>
							</div>

							<div class="flex mt-4 gap-y-4 max-lmd:gap-x-4 flex-wrap justify-center lmd:justify-between text-breeder-deepblue">
								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="animalExperience" value="expert" id="expert" wire:model="animalExperience" class="peer hidden" />
									<label for="expert" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[184px]">
												<svg width="47" height="47" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="10.5" cy="13" r="8" transform="rotate(90 10.5 13)" fill="#FFA244"/>
													<ellipse cx="30.5" cy="41.5" rx="4.5" ry="5" transform="rotate(90 30.5 41.5)" fill="#FFA244"/>
													<path d="M23.5 28.3913C15.4 28.3913 8.82611 21.8174 8.82611 13.7174V4.91304C8.82611 2.76087 10.587 1 12.7392 1H34.2609C36.4131 1 38.1739 2.76087 38.1739 4.91304V13.7174C38.1739 21.8174 31.6 28.3913 23.5 28.3913Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M8.82609 6.86963H2.95652C1.88043 6.86963 1 7.75006 1 8.82615V12.7392C1 18.1392 5.38261 22.5218 10.7826 22.5218H11.8" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M38.1739 6.86963H44.0435C45.1196 6.86963 46 7.75006 46 8.82615V12.7392C46 18.1392 41.6174 22.5218 36.2174 22.5218H35.2" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M34.2609 45.9999H12.7391L13.9522 41.1282C14.3826 39.3869 15.9478 38.1738 17.7478 38.1738H29.2522C31.0522 38.1738 32.6174 39.3869 33.0478 41.1282L34.2609 45.9999Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M23.5 28.3911V38.1737" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('Expert') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="animalExperience" value="experienced" id="experienced" wire:model="animalExperience" class="peer hidden" />
									<label for="experienced" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[184px]">
												<svg width="49" height="50" viewBox="0 0 49 50" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="36.5" cy="8" r="8" transform="rotate(180 36.5 8)" fill="#FFA244"/>
													<ellipse cx="8" cy="28" rx="4.5" ry="5" transform="rotate(180 8 28)" fill="#FFA244"/>
													<path d="M38.892 4H10.1124C9.36381 4 8.67761 4.40047 8.3033 5.05386L1.27475 17.5316C0.858862 18.2693 0.921245 19.1756 1.42031 19.8501L22.8387 48.178C23.6704 49.274 25.3132 49.274 26.145 48.178L47.5633 19.8501C48.0624 19.1756 48.1248 18.2482 47.7089 17.5316L40.6803 5.05386C40.306 4.40047 39.6198 4 38.8712 4H38.892Z" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M9.15588 4.23193L24.5022 18.7331L39.8486 4.23193" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M48 18.7539H1.02527" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>

												{{ __('Experienced') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="animalExperience" value="beginner" id="beginner" wire:model="animalExperience" class="peer hidden" />
									<label for="beginner" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[184px]">
												<svg width="45" height="47" viewBox="0 0 45 47" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="33.5" cy="39" r="8" transform="rotate(-90 33.5 39)" fill="#FFA244"/>
													<ellipse cx="13.5" cy="10.5" rx="4.5" ry="5" transform="rotate(-90 13.5 10.5)" fill="#FFA244"/>
													<path d="M21.6504 3.25977C22.0172 2.6698 22.8451 2.63324 23.2695 3.14941L23.3496 3.25977L28.7598 11.9619C29.1211 12.543 29.6687 12.9801 30.3086 13.2061L30.5879 13.29L40.5361 15.7471C41.2107 15.9137 41.5017 16.6897 41.1416 17.2529L41.0605 17.3623L34.457 25.1973C34.016 25.7206 33.769 26.3763 33.752 27.0547L33.7588 27.3467L34.4961 37.5664C34.5461 38.2594 33.8979 38.7758 33.251 38.6074L33.1221 38.5645L23.6299 34.7051C22.996 34.4473 22.296 34.4151 21.6455 34.6084L21.3701 34.7051L11.8779 38.5645C11.2342 38.8262 10.5426 38.3695 10.5029 37.7021L10.5039 37.5664L11.2412 27.3467C11.2905 26.6639 11.1048 25.9877 10.7197 25.4287L10.543 25.1973L3.93945 17.3623C3.49175 16.8312 3.71201 16.0323 4.33398 15.7881L4.46387 15.7471L14.4121 13.29C15.0763 13.1259 15.6616 12.7407 16.0742 12.2021L16.2402 11.9619L21.6504 3.25977Z" stroke="#0E1954" stroke-width="2"/>
												</svg>

												{{ __('Beginner') }}
											</h3>
										</div>
									</label>
								</div>
							</div>

							<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between mt-8">
								<x-front.space-title :class="'!text-lg'">
									{{ __('My time dedication for my futur pet') }}
								</x-front.space-title>
							</div>

							<div class="flex mt-4 gap-y-4 max-lmd:gap-x-4 flex-wrap justify-center lmd:justify-between text-breeder-deepblue">
								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="timeDedication" value="few_time" id="fewTime" wire:model="timeDedication" class="peer hidden" />
									<label for="fewTime" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[208px]">
												<svg class="shrink-0" width="38" height="42" viewBox="0 0 38 42" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M35.1109 10.5312C35.3303 10.7503 35.618 10.8599 35.9057 10.8599C36.1934 10.8599 36.4811 10.7503 36.7005 10.5312C37.1393 10.0931 37.1393 9.38196 36.7005 8.94379L34.4231 6.66946L32.1456 4.39513C31.7069 3.95696 30.9948 3.95696 30.556 4.39513C30.1173 4.83329 30.1173 5.54441 30.556 5.98258L32.0386 7.46319L30.4104 9.08925C27.4442 6.46744 23.6221 4.7902 19.4215 4.5352V2.2447H21.5191C22.1395 2.2447 22.643 1.74189 22.643 1.12235C22.643 0.502813 22.1395 0 21.5191 0H15.0771C14.4567 0 13.9532 0.502813 13.9532 1.12235C13.9532 1.74189 14.4567 2.2447 15.0771 2.2447H17.1747V4.5352C7.60641 5.11613 0 13.0731 0 22.7712C0 32.4692 8.20791 41.0439 18.2976 41.0439C28.3874 41.0439 36.5953 32.8472 36.5953 22.7712C36.5953 18.1363 34.8573 13.9001 32 10.6758L33.6283 9.04974L35.1109 10.5303V10.5312ZM18.2976 38.7992C9.44777 38.7992 2.24776 31.609 2.24776 22.7712C2.24776 13.9333 9.44777 6.74398 18.2976 6.74398C27.1475 6.74398 34.3475 13.9342 34.3475 22.7721C34.3475 31.6099 27.1475 38.8001 18.2976 38.8001V38.7992Z" fill="#0E1954"/>
													<path d="M18.2978 9.27832L18.2969 22.7717L29.996 16.0268C27.6565 11.9962 23.2887 9.27832 18.2978 9.27832Z" fill="#FFA244"/>
												</svg>
												
												{{ __('I don\'t have much time; I want a dog that requires little or no maintenance.') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="timeDedication" value="medium_time" id="mediumTime" wire:model="timeDedication" class="peer hidden" />
									<label for="mediumTime" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[208px]">
												<svg class="shrink-0" width="38" height="42" viewBox="0 0 38 42" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M35.1109 10.5321C35.3302 10.7512 35.618 10.8608 35.9057 10.8608C36.1934 10.8608 36.4811 10.7512 36.7005 10.5321C37.1393 10.094 37.1393 9.38286 36.7005 8.94469L32.1447 4.39513C31.706 3.95696 30.9939 3.95696 30.5551 4.39513C30.1164 4.83329 30.1164 5.54442 30.5551 5.98258L32.0377 7.46319L30.4095 9.08925C27.4433 6.46744 23.6212 4.7902 19.4206 4.5352V2.2447H21.5182C22.1386 2.2447 22.6421 1.74189 22.6421 1.12235C22.6421 0.502814 22.1386 0 21.5182 0H15.0762C14.4558 0 13.9523 0.502814 13.9523 1.12235C13.9523 1.74189 14.4558 2.2447 15.0762 2.2447H17.1738V4.5352C7.60551 5.11702 0 13.0731 0 22.7721C0 32.471 8.20791 41.0448 18.2976 41.0448C28.3874 41.0448 36.5953 32.8481 36.5953 22.7721C36.5953 18.1372 34.8573 13.901 32 10.6767L33.6283 9.05064L35.1109 10.5312V10.5321ZM18.2976 38.8001C9.44777 38.8001 2.24776 31.6099 2.24776 22.7721C2.24776 13.9342 9.44777 6.74398 18.2976 6.74398C27.1475 6.74398 34.3475 13.9342 34.3475 22.7721C34.3475 31.6099 27.1475 38.8001 18.2976 38.8001Z" fill="#0E1954"/>
													<path d="M18.2978 9.2793C18.2978 9.2793 18.2978 9.2793 18.2969 9.2793V22.7727H18.2978V36.266C23.2905 36.266 27.6574 33.5481 29.9969 29.5175C31.1486 27.5323 31.8095 25.2284 31.8095 22.7736C31.8095 20.3187 31.1486 18.0139 29.9969 16.0287C27.6574 11.9981 23.2896 9.28109 18.2987 9.28109L18.2978 9.2793Z" fill="#FFA244"/>
												</svg>

												{{ __('I\'m willing to brush him or take him to the groomer regularly.') }}
											</h3>
										</div>
									</label>
								</div>

								<div class="w-full max-w-[360px] s:max-w-[270px]">
									<input type="radio" name="timeDedication" value="lot_time" id="lotTime" wire:model="timeDedication" class="peer hidden" />
									<label for="lotTime" class="block cursor-pointer border border-breeder-greige rounded-xl hover:bg-breeder-cream peer-checked:bg-breeder-cream peer-checked:border-breeder-cream">
										<div>
											<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-base font-medium text-center h-[85px] s:h-[208px]">
												<svg class="shrink-0" width="38" height="42" viewBox="0 0 38 42" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M35.1109 10.5321C35.3303 10.7512 35.618 10.8608 35.9057 10.8608C36.1934 10.8608 36.4811 10.7512 36.7005 10.5321C37.1392 10.094 37.1392 9.38286 36.7005 8.94469L32.1447 4.39513C31.706 3.95696 30.9939 3.95696 30.5551 4.39513C30.1163 4.83329 30.1163 5.54441 30.5551 5.98258L32.0377 7.46319L30.4095 9.08925C27.4433 6.46744 23.6212 4.7902 19.4206 4.5352V2.2447H21.5182C22.1386 2.2447 22.6421 1.74189 22.6421 1.12235C22.6421 0.502813 22.1386 0 21.5182 0H15.0762C14.4558 0 13.9523 0.502813 13.9523 1.12235C13.9523 1.74189 14.4558 2.2447 15.0762 2.2447H17.1738V4.5352C7.60551 5.11702 0 13.0731 0 22.7721C0 32.471 8.20791 41.0448 18.2976 41.0448C28.3874 41.0448 36.5953 32.8481 36.5953 22.7721C36.5953 18.1372 34.8573 13.901 32 10.6767L33.6283 9.05064L35.1109 10.5312V10.5321ZM18.2967 38.801C9.44687 38.801 2.24686 31.6108 2.24686 22.773C2.24686 13.9351 9.44687 6.74488 18.2967 6.74488C27.1466 6.74488 34.3466 13.9351 34.3466 22.773C34.3466 31.6108 27.1466 38.801 18.2967 38.801Z" fill="#0E1954"/>
													<path d="M18.2969 9.2793C18.2969 9.2793 18.2969 9.2793 18.296 9.2793V22.7727H18.2969L6.59775 16.0278C5.446 18.013 4.78516 20.3169 4.78516 22.7727C4.78516 25.2284 5.446 27.5323 6.59775 29.5175C8.93722 33.5481 13.3051 36.2651 18.296 36.2651C18.296 36.2651 18.296 36.2651 18.2969 36.2651C23.2878 36.2651 27.6556 33.5472 29.9951 29.5166C31.1468 27.5314 31.8077 25.2275 31.8077 22.7727C31.8077 20.3178 31.1468 18.013 29.9942 16.0278C27.6547 11.9972 23.2869 9.28019 18.296 9.28019L18.2969 9.2793Z" fill="#FFA244"/>
												</svg>

												{{ __('It takes a lot of time, but I don\'t mind if it requires a lot of maintenance.') }}
											</h3>
										</div>
									</label>
								</div>
							</div>
						@endif
					@endif

					@if($active == 3)
						<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row justify-center">
							<x-front.space-title>
								{{ __('Your message and your answers have been successfully sent !') }}
							</x-front.space-title>
						</div>

						<div class="flex flex-col items-center mt-4 gap-y-6 text-breeder-deepblue text-base">
							<p class="text-bold">
								{{ __('You can follow your inquire directly in your dashboard') }}
							</p>

							<p class="font-medium">
								{{ __('To maximize your chances to adopt the animal that belongs to you, contact other companies !') }}
							</p>
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

				{{-- Footer navigation buttons --}}
				@if($active != 3)
					<div class="flex s:flex-row flex-col items-center max-s:space-y-5 justify-between my-10">
						<div class="flex gap-x-4 text-sm font-bold">
							@if($active > 1)
								<div wire:click="previous" class="flex gap-x-2 items-center cursor-pointer text-breeder-deepblue">
									<svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M6.5166 1.5L2.15296 5.5L6.5166 9.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('Previous') }}
								</div>
							@endif

							<a href="{{ route('space.profile.dashboard') }}">
								<div class="flex gap-x-2 items-center cursor-pointer text-breeder-deepblue">
									<svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.00781 9.50184L1.00417 1.49817M9.00781 1.49817L1.00417 9.50184" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('Cancel') }}
								</div>
							</a>
						</div>

						<x-front.primary-button wire:click="submitForm">
							@if($active < $totalSteps)
								{{ __('Next') }}

								<svg class="ml-2" width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1.85938 1.5L7.31392 6.5L1.85938 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							@elseif($active == $totalSteps)
								{{ __('Send my inquire') }}
							@endif
						</x-front.primary-button>
					</div>
				@elseif($active == 3)
					<div class="flex s:flex-row flex-col items-center max-s:space-y-5 justify-end my-10 gap-x-2">
						<a href="{{ $responseRoute }}">
							<x-front.secondary-button>
								{{ __('Access my messaging') }}
							</x-front.secondary-button>
						</a>

						<a href="{{ $goToRoute }}">
							<x-front.primary-button>
								{{ $buttonText }}
							</x-front.primary-button>
						</a>
					</div>
				@endif
			</div>
		</div>

		{{-- Right column --}}
		@if($active != 3)
			@if($animal->id)
				<div class="max-lg:mb-10 w-full max-sm:mx-2 sm:w-[300px] mt-4 max-sm:px-6">
					<div class="font-bold text-lg mb-4 text-breeder-deepblue">
						{{ __('I am interested in:') }}
					</div>
					<article class="cursor-pointer bg-breeder-cream text-breeder-deepblue rounded-xl w-full flex-1 flex flex-col justify-between">
						<div class="relative w-full">
							<div class="absolute w-full top-0 right-0">
								<div class="flex flex-row gap-2 justify-end items-center flex-wrap p-4">
									@if($animal->values->has('pure_breed') && $animal->values->get('pure_breed') == true)
										@if($animal->company->address?->country?->code == 'FRA')
											@if($animal->species->getTranslation('slug', 'en') == 'cat')
												<span class="px-3 py-1 rounded-md font-medium bg-breeder-green text-breeder-deepblue text-sm w-fit">
													LOOF
												</span>
											@elseif($animal->species->getTranslation('slug', 'en') == 'dog')
												<span class="px-3 py-1 rounded-md font-medium bg-breeder-coral text-breeder-deepblue text-sm w-fit">
													LOF
												</span>
											@endif
										@else
											<span class="px-3 py-1 rounded-md font-medium bg-breeder-coral text-breeder-deepblue text-sm w-fit">
												{{ __('Origin book') }}
											</span>
										@endif
									@endif

									<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit">
										{{ $animal->values->get('pure_breed') ?  Str::limit($animal->breed->name, 10) : __('Of appearance :breed', ['breed' => Str::limit($breed->name, 6)]) }}
									</span>

									<span class="flex flex-row gap-x-1 px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit">
										@if($animal->values->get('sex') == 'male')
											<svg width="16" imageHeight="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M11 1.3501H15V5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M15 1.3501L11 5.45536" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M6.33333 14.3501C9.27885 14.3501 11.6667 11.8994 11.6667 8.8764C11.6667 5.85336 9.27885 3.40271 6.33333 3.40271C3.38781 3.40271 1 5.85336 1 8.8764C1 11.8994 3.38781 14.3501 6.33333 14.3501Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>

											{{ __('Male') }}
										@elseif($animal->values->get('sex') == 'female')
											<svg width="10" imageHeight="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M5 9.67006C7.20914 9.67006 9 7.80757 9 5.51008C9 3.21258 7.20914 1.3501 5 1.3501C2.79086 1.3501 1 3.21258 1 5.51008C1 7.80757 2.79086 9.67006 5 9.67006Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M5 9.67007L4.99924 14.3501" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M2.5 12.2701L7.5 12.2701" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>

											{{ __('Female') }}
										@endif
									</span>
								</div>
							</div>
						</div>

						<div class="overflow-hidden sm:flex-none flex justify-end items-stretch w-full rounded-t-xl bg-[#F8F8F8]">
							@if($photo = $animal->getFirstMedia('photos'.$animal->id))
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $animal->getConstructedName() }}" class="object-cover w-full rounded-t-xl max-h-[300px]" />
							@else
								@php
									if($animal->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
									elseif($animal->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
								@endphp
								<img src="{{ $src }}" alt="{{ $animal->getConstructedName() }}" class="object-none w-full rounded-t-xl h-[300px]" />
							@endif
						</div>

						<div class="flex flex-col p-4 text-sm">
							<div class="flex flex-row justify-start items-center gap-2 mb-2">
								<div>
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
										<svg width="31" height="25" viewBox="0 0 31 25" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M11.1744 0.310716C10.2611 -0.593908 8.37499 0.739778 7.45741 1.05471C4.97231 1.90649 2.3003 2.1411 0.775258 4.55061C-1.77993 8.59183 2.4596 17.5345 6.53771 14.512C8.7212 12.893 6.67365 8.54533 8.34738 6.16752C9.01857 5.2164 10.2611 4.85497 10.9153 3.65022C11.3168 2.91257 11.8138 0.942685 11.1723 0.308603L11.1744 0.310716ZM29.4155 3.50438C27.8926 1.98892 25.9406 1.9551 24.0672 1.32313C22.3192 0.735551 19.0163 -1.74582 19.5282 2.24889C19.8723 4.93318 22.7864 5.29037 23.2389 7.43357C23.6998 9.62116 22.3064 14.1823 25.2376 14.9538C27.4338 15.5308 28.8229 13.9667 29.7447 12.2399C31.1699 9.57043 31.771 5.84414 29.4176 3.50438H29.4155ZM10.7433 7.27083C9.12052 7.60266 9.60267 10.2024 11.0789 10.139C13.0266 10.0544 12.9884 6.81217 10.7433 7.27083ZM18.7126 9.71627C20.0316 11.0986 22.2236 8.8053 20.775 7.55828C19.3264 6.31125 17.5699 8.51785 18.7126 9.71627ZM6.76286 15.2666V24.4608C6.76286 24.5961 7.27475 24.9659 7.51264 24.9913C9.38814 25.1942 8.32189 21.8251 8.4642 20.762C10.6647 22.5797 13.1965 23.2307 15.3949 20.9902C17.6676 23.1081 19.9063 22.6325 22.2682 20.9733V24.2494C22.2682 25.2661 24.1798 25.0906 24.1798 24.4608V15.2666C21.905 15.1821 22.419 16.5031 21.888 17.953C21.2274 19.7517 18.8336 21.5926 17.0792 19.9039C16.3889 19.2402 16.0852 17.3295 16.3188 16.4735C16.4208 16.0972 18.2941 15.5731 17.9819 13.9477C17.5104 11.498 12.8375 11.8278 12.9374 14.2986C13.0032 15.9176 14.5984 16.3255 14.6323 16.465C15.3418 19.4114 12.7101 22.0238 10.1549 19.6079C8.43021 17.9762 9.46036 15.0531 6.76286 15.2687V15.2666Z" fill="#FF7E71"/>
											<path d="M11.1744 0.310627C11.8159 0.944709 11.3167 2.91459 10.9174 3.65224C10.2632 4.857 9.01854 5.21842 8.34948 6.16955C6.67363 8.54524 8.72118 12.895 6.53982 14.5141C2.45958 17.5344 -1.77995 8.59174 0.775238 4.55052C2.30028 2.14101 4.97229 1.9064 7.45739 1.05462C8.37497 0.739689 10.2611 -0.596111 11.1744 0.310627Z" fill="#FF7E71"/>
											<path d="M29.4153 3.5045C31.7688 5.84426 31.1677 9.57055 29.7424 12.24C28.8206 13.9647 27.4315 15.5309 25.2353 14.9539C22.302 14.1824 23.6975 9.62127 23.2366 7.43369C22.7842 5.29049 19.87 4.93329 19.5259 2.24901C19.014 -1.7457 22.3169 0.735671 24.0649 1.32325C25.9383 1.95522 27.8903 1.98904 29.4132 3.5045H29.4153Z" fill="#FF7E71"/>
											<path d="M6.7627 15.2662C9.4602 15.0527 8.43005 17.9737 10.1547 19.6054C12.7078 22.0212 15.3395 19.4088 14.6322 16.4625C14.5982 16.323 13.0031 15.915 12.9372 14.296C12.8374 11.8252 17.5102 11.4955 17.9817 13.9452C18.294 15.5705 16.4206 16.0968 16.3186 16.4709C16.0871 17.3269 16.3909 19.2376 17.079 19.9013C18.8335 21.5922 21.2272 19.7491 21.8878 17.9504C22.4209 16.5005 21.9048 15.1795 24.1796 15.264V24.4582C24.1796 25.0881 22.268 25.2635 22.268 24.2469V20.9708C19.9061 22.63 17.6674 23.1055 15.3947 20.9877C13.1963 23.2281 10.6645 22.5771 8.46403 20.7594C8.32172 21.8226 9.38798 25.1938 7.51247 24.9887C7.27458 24.9634 6.7627 24.5935 6.7627 24.4582V15.264V15.2662Z" fill="#FF7E71"/>
											<path d="M18.7126 9.71602C17.5699 8.51761 19.2988 6.28987 20.775 7.55803C22.2512 8.8262 20.0316 11.0983 18.7126 9.71602Z" fill="#FF7E71"/>
											<path d="M10.7437 7.27096C12.9909 6.81231 13.027 10.0567 11.0793 10.1391C9.60312 10.2025 9.12097 7.60279 10.7437 7.27096Z" fill="#FF7E71"/>
										</svg>
									@endif
								</div>

								<div class="font-bold">
									{!! $animal->getConstructedName(true) !!}
								</div>

							</div>

							<div class="flex gap-2 font-medium text-sm">
								{{ $animal->company->name }}
								@if($animal->company->address->department)
									({{ $animal->company->address->department->code }})
								@endif
							</div>
						</div>
					</article>
				</div>
			@else
				<div class="max-lg:mb-10 w-full max-sm:mx-2 sm:w-[300px]">
					<article class="cursor-pointer bg-breeder-cream text-breeder-deepblue rounded-xl w-full flex-1 flex flex-col justify-between">
						<div class="relative w-full">
							<div class="absolute w-full top-0 right-0">
								<div class="flex flex-row gap-2 justify-end items-center flex-wrap p-4">
									@if($post->model->values->has('pure_breed') && $post->model->values->get('pure_breed'))
										@if($post->model->company->address?->country?->code == 'FRA')
											@if($post->model->species->getTranslation('slug', 'en') == 'cat')
												<span class="px-3 py-1 rounded-md font-medium bg-breeder-green text-breeder-deepblue text-sm w-fit">
													LOOF
												</span>
											@elseif($post->model->species->getTranslation('slug', 'en') == 'dog')
												<span class="px-3 py-1 rounded-md font-medium bg-breeder-coral text-breeder-deepblue text-sm w-fit">
													LOF
												</span>
											@endif
										@else
											<span class="px-3 py-1 rounded-md font-medium bg-breeder-coral text-breeder-deepblue text-sm w-fit">
												{{ __('Origin book') }}
											</span>
										@endif
									@endif

									<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-sm w-fit">
										{{ $post->model->values->get('pure_breed') ?  Str::limit($post->model->breed->name, 10) : __('Of appearance :breed', ['breed' => Str::limit($breed->name, 6)]) }}
									</span>
								</div>
							</div>
						</div>

						<div class="overflow-hidden sm:flex-none flex justify-end items-stretch w-full rounded-t-xl bg-[#F8F8F8]">
							@if($photo = $post->getFirstMedia('photos'.$post->id))
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $post->name }}" class="object-cover w-full rounded-t-xl max-h-[300px]" />
							@else
								@php
									if($post->model->species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
									elseif($post->model->species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
								@endphp
								<img src="{{ $src }}" alt="{{ $post->name }}" class="object-none w-full rounded-t-xl h-[300px]" />
							@endif
						</div>

						<div class="flex flex-col p-4 text-sm">
							<div class="flex flex-row items-center gap-2 mb-2">
								<div>
									@if($post->model->species->getTranslation('slug', 'en') == 'cat')
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
									@elseif($post->model->species->getTranslation('slug', 'en') == 'dog')
										<svg width="31" height="25" viewBox="0 0 31 25" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M11.1744 0.310716C10.2611 -0.593908 8.37499 0.739778 7.45741 1.05471C4.97231 1.90649 2.3003 2.1411 0.775258 4.55061C-1.77993 8.59183 2.4596 17.5345 6.53771 14.512C8.7212 12.893 6.67365 8.54533 8.34738 6.16752C9.01857 5.2164 10.2611 4.85497 10.9153 3.65022C11.3168 2.91257 11.8138 0.942685 11.1723 0.308603L11.1744 0.310716ZM29.4155 3.50438C27.8926 1.98892 25.9406 1.9551 24.0672 1.32313C22.3192 0.735551 19.0163 -1.74582 19.5282 2.24889C19.8723 4.93318 22.7864 5.29037 23.2389 7.43357C23.6998 9.62116 22.3064 14.1823 25.2376 14.9538C27.4338 15.5308 28.8229 13.9667 29.7447 12.2399C31.1699 9.57043 31.771 5.84414 29.4176 3.50438H29.4155ZM10.7433 7.27083C9.12052 7.60266 9.60267 10.2024 11.0789 10.139C13.0266 10.0544 12.9884 6.81217 10.7433 7.27083ZM18.7126 9.71627C20.0316 11.0986 22.2236 8.8053 20.775 7.55828C19.3264 6.31125 17.5699 8.51785 18.7126 9.71627ZM6.76286 15.2666V24.4608C6.76286 24.5961 7.27475 24.9659 7.51264 24.9913C9.38814 25.1942 8.32189 21.8251 8.4642 20.762C10.6647 22.5797 13.1965 23.2307 15.3949 20.9902C17.6676 23.1081 19.9063 22.6325 22.2682 20.9733V24.2494C22.2682 25.2661 24.1798 25.0906 24.1798 24.4608V15.2666C21.905 15.1821 22.419 16.5031 21.888 17.953C21.2274 19.7517 18.8336 21.5926 17.0792 19.9039C16.3889 19.2402 16.0852 17.3295 16.3188 16.4735C16.4208 16.0972 18.2941 15.5731 17.9819 13.9477C17.5104 11.498 12.8375 11.8278 12.9374 14.2986C13.0032 15.9176 14.5984 16.3255 14.6323 16.465C15.3418 19.4114 12.7101 22.0238 10.1549 19.6079C8.43021 17.9762 9.46036 15.0531 6.76286 15.2687V15.2666Z" fill="#FF7E71"/>
											<path d="M11.1744 0.310627C11.8159 0.944709 11.3167 2.91459 10.9174 3.65224C10.2632 4.857 9.01854 5.21842 8.34948 6.16955C6.67363 8.54524 8.72118 12.895 6.53982 14.5141C2.45958 17.5344 -1.77995 8.59174 0.775238 4.55052C2.30028 2.14101 4.97229 1.9064 7.45739 1.05462C8.37497 0.739689 10.2611 -0.596111 11.1744 0.310627Z" fill="#FF7E71"/>
											<path d="M29.4153 3.5045C31.7688 5.84426 31.1677 9.57055 29.7424 12.24C28.8206 13.9647 27.4315 15.5309 25.2353 14.9539C22.302 14.1824 23.6975 9.62127 23.2366 7.43369C22.7842 5.29049 19.87 4.93329 19.5259 2.24901C19.014 -1.7457 22.3169 0.735671 24.0649 1.32325C25.9383 1.95522 27.8903 1.98904 29.4132 3.5045H29.4153Z" fill="#FF7E71"/>
											<path d="M6.7627 15.2662C9.4602 15.0527 8.43005 17.9737 10.1547 19.6054C12.7078 22.0212 15.3395 19.4088 14.6322 16.4625C14.5982 16.323 13.0031 15.915 12.9372 14.296C12.8374 11.8252 17.5102 11.4955 17.9817 13.9452C18.294 15.5705 16.4206 16.0968 16.3186 16.4709C16.0871 17.3269 16.3909 19.2376 17.079 19.9013C18.8335 21.5922 21.2272 19.7491 21.8878 17.9504C22.4209 16.5005 21.9048 15.1795 24.1796 15.264V24.4582C24.1796 25.0881 22.268 25.2635 22.268 24.2469V20.9708C19.9061 22.63 17.6674 23.1055 15.3947 20.9877C13.1963 23.2281 10.6645 22.5771 8.46403 20.7594C8.32172 21.8226 9.38798 25.1938 7.51247 24.9887C7.27458 24.9634 6.7627 24.5935 6.7627 24.4582V15.264V15.2662Z" fill="#FF7E71"/>
											<path d="M18.7126 9.71602C17.5699 8.51761 19.2988 6.28987 20.775 7.55803C22.2512 8.8262 20.0316 11.0983 18.7126 9.71602Z" fill="#FF7E71"/>
											<path d="M10.7437 7.27096C12.9909 6.81231 13.027 10.0567 11.0793 10.1391C9.60312 10.2025 9.12097 7.60279 10.7437 7.27096Z" fill="#FF7E71"/>
										</svg>
									@endif
								</div>

								<div class="flex flex-col gap-x-1">
									{{ __('Litter yet to come from company :') }}

									<span class="font-bold">
										{{ $post->model->company->name }}
									</span>
								</div>
							</div>
						</div>
					</article>
				</div>
			@endif
		@endif
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

	@if($post->type->getTranslation('slug', 'en') != 'stud')
		@include('components.front.figo-gift')
	@endif
</div>
