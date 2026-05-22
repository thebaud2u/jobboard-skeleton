<div>
	<div class="w-full bg-white mb-6">
		<div class="bg-jobboard-cream w-full flex flex-col justify-center items-center gap-y-4 s:gap-y-12 h-[174px] s:h-[261px] text-jobboard-deepblue">
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

							{{ __('My company') }}
						</div>
					@endif
				@endfor
			</div>
		</div>

		<div class="flex flex-col py-5 px-4 gap-y-4 max-w-[840px] mx-auto">
			@if($active == 1)
				<h3 class="text-lg text-jobboard-deepblue font-bold">
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

				<hr class="border-1.5 border-jobboard-greige my-4">

				<div class="flex flex-col gap-4 w-full">
					<h3 class="text-lg text-jobboard-deepblue font-bold">
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
				</div>

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

					<textarea id="description" rows="5" wire:model="description" placeholder="{{ __('Tell us more about your company: company practice, breeds, values...') }}" class="border-jobboard-greige focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md text-jobboard-deepblue placeholder:text-jobboard-greige mt-1 block w-full"></textarea>

					@error('description')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>

				<div>
					<h3 class="text-lg text-jobboard-deepblue font-bold mt-6 mb-4">
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
					<div class="flex flex-row gap-4">
						<div class="flex flex-col gap-2 w-full">
							<x-front.input-label for="facebook" :value="__('Facebook for your cats')" :class="'pl-4'" />

							<x-front.text-input name="facebook" id="facebook" wire:model="facebook" placeholder="https://" :class="'mt-1 block bg-white'" />

							@error('facebook')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>

						<div class="flex flex-col gap-2 w-full">
							<x-front.input-label for="instagram" :value="__('Instagram for your cats')" :class="'pl-4'" />

							<x-front.text-input name="instagram" id="instagram" wire:model="instagram" placeholder="https://" :class="'mt-1 block bg-white'" />

							@error('instagram')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>
					</div>

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
