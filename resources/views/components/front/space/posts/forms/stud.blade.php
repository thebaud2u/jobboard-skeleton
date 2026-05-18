<div>
	<x-front.space-title>
		{{ __('The breeder') }}
	</x-front.space-title>

	<div class="flex flex-row flex-wrap gap-x-8 gap-y-4 mb-4 w-full">
		<div class="flex-1 flex flex-col w-full">
			<x-front.input-label for="animalAvailable" :value="__('Select a breeder among the following animals')" :required="true" :class="'pl-4 mt-2'" />

			<select id="animalAvailable" name="animalAvailable" wire:model.live="animalSelected" wire:change="setStud" @disabled(!$allowUpdate) class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-greige mt-1 w-full max-w-full">
				@if($breedersAvailable->isNotEmpty())
					<option value>{{ __('Select a breeder') }}</option>
					@foreach($breedersAvailable as $breederAvailable)
						<option value="{{ $breederAvailable->slug }}" wire:key="available-breeder-{{ $breederAvailable->slug }}">
							{{ __($breederAvailable->getConstructedName()) }}
						</option>
					@endforeach
				@else
					<option value>{{ __('You have no breeder') }}</option>
				@endif
			</select>

			@error('stud')
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
							:onlyActiveBreeder="true"
							:displayBreeders="false"
							:displayAnimalCard="false"
							:specificSpeciesBreedToLoad="$speciesSelected"
							:key="'new-breeder-component-'.$subComponentKey" />
					</div>
				</div>
			@endif
		</div>

		<div class="w-full flex-1 flex flex-col justify-center items-center">
			@if($animalSelected)
				<livewire:front.animals.breeders.breeder
					:animal="$stud"
					:company="$user->company"
					:simpleCard="true"
					:key="'stud-selected-component-'.$subComponentKey" />
			@endif
		</div>
	</div>

	@if($animalSelected)
		<hr>

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
				:key="'photo-stud-'.$mediableIdPhoto" />

			<div class="text-sm text-gray-400">
				{{ __('You have :left :media left', ['left' => $mediasLeft, 'media' => $mediasLeft > 1 ? __('medias') : __('media')]) }}
			</div>

			<div class="flex flex-wrap justify-bewteen items-center gap-6">
				<div class="flex flex-col">
					<div class="flex flex-row pl-4">
						<x-front.input-label for="quotation" :value="__('Quotation')"/>
					</div>

					<x-front.text-input type="number" name="quotation" id="quotation" wire:model="quotation" :disabled="!$allowUpdate" min=1 max=6 placeholder="{{ __('Quotation') }}" :class="'mt-1 block bg-white'" />

					@error('quotation')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>

				<div class="flex flex-col">
					<div class="flex flex-row pl-4">
						<x-front.input-label for="price" :value="__('Price of the mating €')" :required="true" />
					</div>

					<x-front.text-input type="number" name="price" id="price" wire:model="price" placeholder="{{ __('Price of the mating €') }}" :class="'mt-1 block bg-white'" />

					@error('price')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>

				<div class="flex flex-col">
					<div class="flex flex-row pl-4">
						<x-front.input-label for="protrusionTypes" :value="__('Protrusion type')" />
					</div>

					@foreach($protrusionTypes as $index => $value)
						<div class="flex flex-row items-center mb-1" wire:key="protrusion-type-{{ $index }}">
							<input type="checkbox" name="protrusionTypes" value="{{ $index }}" wire:model="protrusionType" :disabled="!$allowUpdate" class="rounded border-gray-300 text-breeder-deepblue shadow-sm focus:ring-breeder-deepblue" />
							<span class="ms-2 text-sm text-breeder-deepblue">{{ __($value) }}</span>
						</div>
					@endforeach

					@error('protrusionType')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>

				<div class="flex flex-col">
					<div class="flex flex-row pl-4">
						<x-front.input-label for="averageLitterSize" :value="__('Average litter size')" />
					</div>

					<x-front.text-input type="number" name="averageLitterSize" id="averageLitterSize" wire:model="averageLitterSize" :disabled="!$allowUpdate" placeholder="{{ __('Average litter size') }}" :class="'mt-1 block bg-white'" />

					@error('averageLitterSize')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>
			</div>

			<div class="flex flex-col">
				<div class="flex flex-row pl-4">
					<x-front.input-label for="enhancer" :value="__('Enhancer/ Company characteristics')" />
				</div>

				<textarea id="enhancer" wire:model="enhancer" rows="5" placeholder="{{ __('Enhancer/ Company characteristics') }}" :disabled="!$allowUpdate" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>

				@error('enhancer')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div class="flex flex-col">
				<div class="flex flex-row pl-4">
					<x-front.input-label for="geneColor" :value="__('Color gene')" />
				</div>

				<textarea id="geneColor" wire:model="geneColor" rows="5" placeholder="{{ __('Colour gene') }}" :disabled="!$allowUpdate" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>

				@error('geneColor')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div class="flex flex-col">
				<div class="flex flex-row pl-4">
					<x-front.input-label for="description" :value="__('Post\'s description')" :required="true" />
				</div>

				<textarea id="description" wire:model="description" rows="5" placeholder="{{ __('Tell us more about your animal') }}" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>

				@error('description')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>
		</div>
	@endif
</div>
