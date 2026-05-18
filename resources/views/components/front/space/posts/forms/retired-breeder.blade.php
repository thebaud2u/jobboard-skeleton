<div>
	<x-front.space-title>
		{{ __('The retired breeder') }}
	</x-front.space-title>

	<div class="flex flex-row flex-wrap gap-x-8 gap-y-4 mb-4 w-full">
		<div class="flex-1 flex flex-col w-full">
			<x-front.input-label for="animalAvailable" :value="__('Select a retired breeder among the following animals')" :required="true" :class="'pl-4 mt-2'" />

			<select id="animalAvailable" name="animalAvailable" wire:model.live="animalSelected" wire:change="setRetiredBreeder" @disabled(!$allowUpdate) class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-greige mt-1 w-full max-w-full">
				@if($breedersAvailable->isNotEmpty())
					<option value>{{ __('Select a retired breeder') }}</option>
					@foreach($breedersAvailable as $breederAvailable)
						<option value="{{ $breederAvailable->slug }}" wire:key="available-breeder-{{ $breederAvailable->slug }}">
							{{ __($breederAvailable->getConstructedName()) }}
						</option>
					@endforeach
				@else
					<option value>{{ __('You have no breeder') }}</option>
				@endif
			</select>

			@error('retiredBreeder')
				<span class="error text-danger-700">
					{{ $message }}
				</span>
			@enderror

			@if($allowUpdate)
				<div class="flex flex-col sm:flex-row justify-start items-center mt-4 gap-x-4 w-full mb-8">
					<strong>{{ __('or') }}</strong>
					<div class="w-full flex justify-center">
						<livewire:front.animals.breeders.breeders
							:company="$user->company"
							:create="true"
							:showTitle="false"
							:displayBreeders="false"
							:displayAnimalCard="false"
							:specificSpeciesBreedToLoad="$speciesSelected"
							:key="'new-breeder-component-'.$subComponentKey" />
					</div>
				</div>
			@endif
		</div>

		@if($animalSelected)
			<div class="w-full flex-1 flex flex-col justify-center items-center">
				<livewire:front.animals.breeders.breeder
					:animal="$retiredBreeder"
					:company="$user->company"
					:simpleCard="true"
					:key="'retired-breeder-selected-component-'.$subComponentKey" />
			</div>
		@endif
	</div>

	@if($animalSelected)
		<hr>

		<div>
			<div class="flex flex-col gap-4 mt-4">
				<x-front.input-label for="photo" :value="$photoCount > 1 ? __('Animal\'s photos') : __('Animal\'s photo')" />

				<livewire:uppy
					:maxMedias="($postState == 'update' && $post->values->has('identifiant')) ? 20 : $offer->getMaxPhoto()"
					:class="$mediableClassPhoto"
					:modelId="$mediableIdPhoto"
					:collection="'photos'.$mediableIdPhoto"
					:gridClass="'sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-4 items-center'"
					:aspectRatio="'aspect-square'"
					:objectFit="'object-cover'"
					:type="$postType->getTranslation('slug', 'en')"
					:key="'photo-retired-breeder-'.$mediableIdPhoto" />

				<div class="text-sm text-gray-400">
					{{ __('You have :left :media left', ['left' => $mediasLeft, 'media' => $mediasLeft > 1 ? __('medias') : __('media')]) }}
				</div>

				<div class="flex flex-row gap-x-2 items-center mb-3">
					<label class="flex gap-x-2 items-center font-bold text-breeder-deepblue mr-3" for="birthPlace">
						{{ __('Where did the birth happened ?') }}
					</label>

					<div class="flex flex-row gap-x-1">
						<label for="birthPlaceCompany" class="inline-flex items-center mr-2">
							<input type="radio" name="birthPlace" id="birthPlaceCompany" value="company" wire:model.live="birthPlace" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

							<span class="ms-2">
								{{ __('At the company') }}
							</span>
						</label>

						<label for="birthPlaceOther" class="inline-flex items-center">
							<input type="radio" name="birthPlace" id="birthPlaceOther" value="other" wire:model.live="birthPlace" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

							<span class="ms-2">
								{{ __('Somewhere else') }}
							</span>
						</label>
					</div>
				</div>

				@if($birthPlace == 'other')
					<div class="flex flex-col w-full">
						<div class="flex flex-row pl-4">
							<x-front.input-label for="birthPlaceValue" :value="__('Specify where')" :required="true" />
						</div>

						<x-front.text-input name="birthPlaceValue" id="birthPlaceValue" wire:model.live="birthPlaceValue" :disabled="!$allowUpdate" placeholder="{{ __('Specify where') }}" :class="'mt-1 block bg-white'" />

						@error('birthPlaceValue')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				@endif

				<div class="flex flex-wrap justify-bewteen items-center gap-6">
					<div class="flex flex-col">
						<div class="flex flex-row mb-2">
							<x-front.input-label for="is-sterilized" :value="__('Is the animal sterilized ?')" />
						</div>

						<div class="flex flex-row jusityf-center items-center">
							<input type="checkbox" id="is-sterilized" wire:model.live="isSterilized" @disabled(!$allowUpdate) class="rounded border-gray-300 text-breeder-deepblue shadow-sm focus:ring-breeder-deepblue" />
							<span class="ms-2 text-sm text-breeder-deepblue">{{ __('Yes') }}</span>
						</div>
					</div>

					<div class="flex flex-col">
						<div class="flex flex-row pl-4">
							<x-front.input-label for="price" :value="__('Selling price €')" :required="true" />
						</div>

						<x-front.text-input type="number" name="price" id="price" wire:model="price" placeholder="{{ __('Selling price €') }}" :class="'mt-1 block bg-white'" />

						@error('price')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				</div>

				<div class="flex flex-col">
					<div class="flex flex-row">
						<x-front.input-label for="description" :value="__('Post\'s description')" :required="true" :class="'pl-4'"/>
					</div>

					<textarea id="description" wire:model="description" rows="5" placeholder="{{ __('Tell us more about your animal') }}" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 block w-full"></textarea>

					@error('description')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>
			</div>
		</div>
	@endif
</div>
