<div>
	<h3 class="text-breeder-deepblue font-bold text-lg mb-4">
		{{ __('The mother') }}
	</h3>

	<div class="flex flex-row flex-wrap gap-8">
		<div class="flex-1 w-full flex flex-col">
			<x-front.input-label for="femaleBreeders" :value="__('Select from my animals')" :required="true" :class="'pl-4 mt-2'" />

			<select id="femaleBreeders" name="femaleBreeders" wire:model.live="femaleSelected" wire:change="setFemale" @disabled(!$allowUpdate) class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 w-full">
				@if($femalesAvailable->isNotEmpty())
					<option value>{{ __('Select a female breeder') }}</option>
					@foreach($femalesAvailable as $femaleAvailable)
						<option value="{{ $femaleAvailable->slug }}" wire:key="female-breeder-{{ $femaleAvailable->slug }}">
							{{ __($femaleAvailable->getConstructedName()) }}
						</option>
					@endforeach
				@else
					<option value>{{ __('You have no female breeder available') }}</option>
				@endif
			</select>

			@error('female')
				<span class="error text-danger-700">
					{{ $message }}
				</span>
			@enderror

			@if($allowUpdate)
				<div class="flex flex-col sm:flex-row justify-start items-center mt-4 gap-x-4 w-full">
					<strong>{{ __('or') }}</strong>
					
					<livewire:front.animals.breeders.breeders
						:company="$user->company"
						:create="true"
						:showTitle="false"
						:displayBreeders="false"
						:displayAnimalCard="false"
						:specificSpeciesBreedToLoad="$speciesSelected"
						:createOnlyFemale="true"
						:onlyActiveBreeder="true"
						:onlyPureBreed="$onlyPureBreed"
						:buttonLabel="__('Add a female breeder to my company')"
						:uppyBreederCollection="'femaleOfCompany'"
						:eventKey="'female-breeders-event-key-'.$subComponentKey"
						:key="'new-female-breeder-component-'.$subComponentKey" />
				</div>
			@endif
		</div>

		<div class="sm:flex-1 w-full flex flex-col justify-center items-center">
			@if($femaleSelected)
				<livewire:front.animals.breeders.breeder
					:animal="$female"
					:company="$user->company"
					:simpleCard="true"
					:key="'female-animal-selected-component-'.$subComponentKey" />
			@endif
		</div>
	</div>
</div>

@if($femaleSelected)
	<hr>

	<div>
		<h3 class="text-breeder-deepblue font-bold text-lg mb-4">
			{{ __('The father') }}
		</h3>

		<div class="flex flex-row gap-x-2 items-center mb-3">
			<label class="flex gap-x-2 items-center font-bold text-breeder-deepblue mr-3" for="firstMaleOwnership">
				{{ __('Do you own the animal ?') }}
			</label>

			<div class="flex flex-row gap-x-1">
				<label for="firstMaleOwnerYes" class="inline-flex items-center mr-2">
					<input type="radio" name="firstMaleOwner" id="firstMaleOwnerYes" value="yes" wire:model.live="firstMaleOwnership" wire:change="firstMaleOwnsershipChecked" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

					<span class="ms-2">
						{{ __('Yes') }}
					</span>
				</label>

				<label for="firstMaleOwnerNo" class="inline-flex items-center">
					<input type="radio" name="firstMaleOwner" id="firstMaleOwnerNo" value="no" wire:model.live="firstMaleOwnership" wire:change="firstMaleOwnsershipChecked" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

					<span class="ms-2">
						{{ __('No') }}
					</span>
				</label>
			</div>
		</div>

		@if($firstMaleOwnership == 'yes')
			<div class="flex flex-col sm:flex-row flex-wrap gap-8 w-full">
				<div class="flex-1 w-full flex flex-col">
					<x-front.input-label for="firstBreedersOfUsersCompanyAvailable" :value="__('Select from my animals')" :required="true" :class="'pl-4 mt-2'" />

					<select id="firstBreedersOfUsersCompanyAvailable" name="firstBreedersOfUsersCompanyAvailable" wire:model.live="firstMaleSelected" @disabled(!$allowUpdate) wire:change="setFirstMale" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 w-full">
						@if($firstBreedersOfUsersCompanyAvailable->isNotEmpty())
							<option value>{{ __('Select a male breeder') }}</option>
							@foreach($firstBreedersOfUsersCompanyAvailable as $maleBreeder)
								<option value="{{ $maleBreeder->slug }}" wire:key="first-male-breeder-from-user-company-{{ $maleBreeder->slug }}">
									{{ __($maleBreeder->getConstructedName()) }}
								</option>
							@endforeach
						@else
							<option value>{{ __('You have no male breeder available') }}</option>
						@endif
					</select>

					@error('firstMale')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror

					@if($allowUpdate)
						<div class="flex flex-col sm:flex-row justify-start items-center mt-4 gap-x-4 w-full">
							<strong>{{ __('or') }}</strong>
							
							<livewire:front.animals.breeders.breeders
								:company="$user->company"
								:create="true"
								:showTitle="false"
								:displayBreeders="false"
								:displayAnimalCard="false"
								:buttonLabel="__('Add a male breeder to my company')"
								:specificBreedsToLoad="$breedsAvailableForFirstMale"
								:createOnlyMale="true"
								:onlyActiveBreeder="true"
								:uppyBreederCollection="'firstMaleOfCompany'"
								:eventKey="'new-first-male-of-company-event-key-'.$subComponentKey"
								:key="'new-first-male-of-company-component-'.$subComponentKey" />
						</div>
					@endif
				</div>

				<div class="flex-1 w-full flex flex-col justify-center items-center">
					@if($firstMaleSelected)
						<livewire:front.animals.breeders.breeder
							:animal="$firstMale"
							:company="$user->company"
							:simpleCard="true"
							:key="'first-male-selected-component-'.$subComponentKey" />
					@endif
				</div>
			</div>
		@elseif($firstMaleOwnership == 'no')
			<div class="flex flex-row flex-wrap gap-8">
				<div class="flex-1 w-full flex flex-col">
					<x-front.input-label for="firstMaleBreedersAvailable" :value="__('Select a male breeder among the following animals')" :required="true" :class="'pl-4 mt-2'" />

					<select id="firstMaleBreedersAvailable" name="firstMaleBreedersAvailable" wire:model.live="firstMaleSelected" wire:change="setFirstMale" @disabled(!$allowUpdate) class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 w-full">
						@if($firstMalesBreedersOfBreedAvailable->isNotEmpty())
							<option value>{{ __('Select a male breeder') }}</option>
							@foreach($firstMalesBreedersOfBreedAvailable as $maleBreederOfBreed)
								<option value="{{ $maleBreederOfBreed->slug }}" wire:key="first-male-breeder-{{ $maleBreederOfBreed->slug }}">
									{{ __($maleBreederOfBreed->getConstructedName()) }}
								</option>
							@endforeach
						@else
							<option value>{{ __('No male breeder available') }}</option>
						@endif
					</select>

					@error('firstMale')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror

					@if($allowUpdate)
						<div class="flex flex-col sm:flex-row justify-start items-center mt-4 gap-x-4 w-full">
							<strong>{{ __('or') }}</strong>
							
							<livewire:front.animals.breeders.breeder
								:animal="$animal"
								:company="$company"
								:create="true"
								:displayAnimalCard="false"
								:specificBreedsToLoad="$breedsAvailableForFirstMale"
								:createOnlyMale="true"
								:onlyActiveBreeder="true"
								:eventKey="'new-first-male-breeder-without-company-event-key'.$subComponentKey"
								:uppyBreederCollection="'firstMaleWithoutCompany'"
								:key="'new-first-male-breeder-without-company-component-'.$subComponentKey" />
						</div>
					@endif
				</div>

				<div class="flex-1 w-full flex flex-col justify-center items-center">
					@if($firstMaleSelected)
						<livewire:front.animals.breeders.breeder
							:animal="$firstMale"
							:company="$company"
							:simpleCard="true"
							:key="'first-male-of-other-company-selected-component-'.$subComponentKey" />
					@endif
				</div>
			</div>
		@endif

		<div class="flex flex-row gap-x-2 items-center mt-3">
			<label class="flex gap-x-2 items-center font-bold text-breeder-deepblue mr-3" for="hideFirstMale">
				{{ __('Do you wish to hide this male in the post display ?') }}
			</label>

			<div class="flex flex-row gap-x-1">
				<label for="hideFirstMaleYes" class="inline-flex items-center mr-2">
					<input type="radio" name="hideFirstMale" id="hideFirstMaleYes" value="yes" wire:model.live="hideFirstMale" class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

					<span class="ms-2">
						{{ __('Yes') }}
					</span>
				</label>

				<label for="hideFirstMaleNo" class="inline-flex items-center">
					<input type="radio" name="hideFirstMale" id="hideFirstMaleNo" value="no" wire:model.live="hideFirstMale" class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

					<span class="ms-2">
						{{ __('No') }}
					</span>
				</label>
			</div>
		</div>
	</div>
@endif

@if($firstMaleSelected)
	<hr>

	<div class="flex flex-row gap-x-2 items-center">
		<label class="flex gap-x-2 items-center font-bold text-breeder-deepblue mr-3" for="secondMaleToLitter">
			{{ __('Is there a second father to this litter ?') }}
		</label>

		<div class="flex flex-row gap-x-1">
			<label for="secondMaleToLitterYes" class="inline-flex items-center mr-2">
				<input type="radio" name="secondMaleToLitter" id="secondMaleToLitterYes" value="yes" wire:model.live="secondMaleToLitter" wire:change="secondMaleToLitterChecked" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

				<span class="ms-2">
					{{ __('Yes') }}
				</span>
			</label>

			<label for="secondMaleToLitterNo" class="inline-flex items-center">
				<input type="radio" name="secondMaleToLitter" id="secondMaleToLitterNo" value="no" wire:model.live="secondMaleToLitter" wire:change="secondMaleToLitterChecked" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

				<span class="ms-2">
					{{ __('No') }}
				</span>
			</label>
		</div>
	</div>

	@if($secondMaleToLitter == 'yes')
		<div>
			<h3 class="text-breeder-deepblue font-bold text-lg mb-4">
				{{ __('The second father') }}
			</h3>

			<div class="flex flex-row gap-x-2">
				<x-front.input-label for="secondMaleOwnership" :value="__('Do you own the animal ?')" />

				<div class="flex flex-row gap-x-1">
					<label for="secondMaleOwnerYes" class="inline-flex items-center">
						<input type="radio" name="secondMaleOwner" id="secondMaleOwnerYes" value="yes" wire:model="secondMaleOwnership" wire:change="secondMaleOwnsershipChecked" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('Yes') }}
						</span>
					</label>

					<label for="secondMaleOwnerNo" class="inline-flex items-center">
						<input type="radio" name="secondMaleOwner" id="secondMaleOwnerNo" value="no" wire:model="secondMaleOwnership" wire:change="secondMaleOwnsershipChecked" @disabled(!$allowUpdate) class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('No') }}
						</span>
					</label>
				</div>
			</div>

			@if($secondMaleOwnership == 'yes')
				<div class="flex flex-row flex-wrap gap-8">
					<div class="flex-1 w-full flex flex-col">
						<x-front.input-label for="secondBreedersOfUsersCompanyAvailable" :value="__('Select a male breeder among the following animals')" :required="true" :class="'pl-4 mt-2'" />

						<select id="secondBreedersOfUsersCompanyAvailable" name="secondBreedersOfUsersCompanyAvailable" wire:model.live="secondMaleSelected" wire:change="setSecondMale" @disabled(!$allowUpdate) class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 w-full">
							@if($secondBreedersOfUsersCompanyAvailable->isNotEmpty())
								<option value>{{ __('Select a male breeder') }}</option>
								@foreach($secondBreedersOfUsersCompanyAvailable as $maleBreeder)
									<option value="{{ $maleBreeder->slug }}" wire:key="second-male-breeder-from-user-company-{{ $maleBreeder->slug }}">
										{{ __($maleBreeder->getConstructedName()) }}
									</option>
								@endforeach
							@else
								<option value>{{ __('You have no male breeder available') }}</option>
							@endif
						</select>

						@error('secondMale')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror

						@if($allowUpdate)
							<div class="flex flex-col sm:flex-row justify-start items-center mt-4 gap-x-4 w-full">
								<strong>{{ __('or') }}</strong>
								
								<livewire:front.animals.breeders.breeders
									:company="$user->company"
									:create="true"
									:showTitle="false"
									:displayBreeders="false"
									:buttonLabel="__('Add a male breeder to my company')"
									:displayAnimalCard="false"
									:specificBreedsToLoad="$breedsAvailableForSecondMale"
									:createOnlyMale="true"
									:onlyActiveBreeder="true"
									:uppyBreederCollection="'secondMaleOfCompany'"
									:eventKey="'new-second-male-of-company-event-key-'.$subComponentKey"
									:key="'new-second-male-of-company-component-'.$subComponentKey" />
							</div>
						@endif
					</div>

					<div class="flex-1 flex flex-col justify-center items-center">
						@if($secondMaleSelected)
							<livewire:front.animals.breeders.breeder
								:animal="$secondMale"
								:company="$user->company"
								:simpleCard="true"
								:key="'second-male-selected-component-'.$subComponentKey" />
						@endif
					</div>
				</div>
			@elseif($secondMaleOwnership == 'no')
				<div class="flex flex-row flex-wrap gap-8">
					<div class="flex-1 flex flex-col">
						<x-front.input-label for="secondMaleBreedersAvailable" :value="__('Select a male breeder among the following animals')" :required="true" :class="'pl-4 mt-2'" />

						<select id="secondMaleBreedersAvailable" name="secondMaleBreedersAvailable" wire:model.live="secondMaleSelected" wire:change="setSecondMale" @disabled(!$allowUpdate) class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 w-full">
							@if($secondMalesBreedersOfBreedAvailable->isNotEmpty())
								<option value>{{ __('Select a male breeder') }}</option>
								@foreach($secondMalesBreedersOfBreedAvailable as $maleBreederOfBreed)
									<option value="{{ $maleBreederOfBreed->slug }}" wire:key="male-breeder-{{ $maleBreederOfBreed->slug }}">
										{{ __($maleBreederOfBreed->getConstructedName()) }}
									</option>
								@endforeach
							@else
								<option value>{{ __('No male breeder available') }}</option>
							@endif
						</select>

						@error('secondMale')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror

						@if($allowUpdate)
							<div class="flex flex-col sm:flex-row justify-start items-center mt-4 gap-x-4 w-full">
								<strong>{{ __('or') }}</strong>

								<livewire:front.animals.breeders.breeder
									:animal="$animal"
									:company="$company"
									:create="true"
									:displayAnimalCard="false"
									:specificBreedsToLoad="$breedsAvailableForSecondMale"
									:createOnlyMale="true"
									:onlyActiveBreeder="true"
									:uppyBreederCollection="'secondMaleWithoutCompany'"
									:eventKey="'new-second-male-without-company-event-key'.$subComponentKey"
									:key="'new-second-male-without-company-component-'.$subComponentKey" />
							</div>
						@endif
					</div>

					<div class="flex-1 flex flex-col justify-center items-center">
						@if($secondMaleSelected)
							<livewire:front.animals.breeders.breeder
								:animal="$secondMale"
								:company="$company"
								:simpleCard="true"
								:key="'second-male-without-company-selected-component-'.$subComponentKey" />
						@endif
					</div>
				</div>
			@endif

			<div class="flex flex-row gap-x-2 items-center mt-3">
				<label class="flex gap-x-2 items-center font-bold text-breeder-deepblue mr-3" for="hideSecondMale">
					{{ __('Do you wish to hide this male in the post display ?') }}
				</label>

				<div class="flex flex-row gap-x-1">
					<label for="hideSecondMaleYes" class="inline-flex items-center mr-2">
						<input type="radio" name="hideSecondMale" id="hideSecondMaleYes" value="yes" wire:model.live="hideSecondMale" class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('Yes') }}
						</span>
					</label>

					<label for="hideSecondMaleNo" class="inline-flex items-center">
						<input type="radio" name="hideSecondMale" id="hideSecondMaleNo" value="no" wire:model.live="hideSecondMale" class="border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('No') }}
						</span>
					</label>
				</div>
			</div>
		</div>
	@endif

	<hr>

	<div>
		<h3 class="text-breeder-deepblue font-bold text-lg mb-4">
			{{ __('The litter') }}
		</h3>

		<div class="flex flex-col gap-4 mt-4">
			<x-front.input-label for="photo" :value="$photoCount > 1 ? __('Post\'s photos') : __('Post\'s photo')" />

			<livewire:uppy
				:maxMedias="($postState == 'update' && $post->values->has('identifiant')) ? 20 : $offer->getMaxPhoto()"
				:class="$mediableClassPhoto"
				:modelId="$mediableIdPhoto"
				:collection="'photos'.$mediableIdPhoto"
				:gridClass="'sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-4 items-center'"
				:aspectRatio="'aspect-square'"
				:objectFit="'object-cover'"
				:type="$postType->getTranslation('slug', 'en')"
				:key="$subComponentKey.'photo-post-'.$mediableIdPhoto" />

			<div class="text-sm text-gray-400">
				{{ __('You have :left :media left', ['left' => $mediasLeft, 'media' => $mediasLeft > 1 ? __('medias') : __('media')]) }}
			</div>

			<div class="flex flex-row justify-center items-center gap-x-6">
				<div class="flex flex-col w-full">
					<div class="flex flex-row pl-4">
						<x-front.input-label for="description" :value="__('Description')" />
					</div>

					<textarea id="description" wire:model="description" rows="5" placeholder="{{ __('Describe your litter') }}" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>

					@error('description')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>
			</div>

			@include('components.front.space.posts.forms.'.$postType->getTranslation('slug', 'en'))
		</div>
	</div>
@endif
