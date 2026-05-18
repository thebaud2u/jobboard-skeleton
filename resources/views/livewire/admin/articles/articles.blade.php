<div>
	{{-- Flash message --}}
	<div class="py-5 px-4 lg:px-6" x-data="{}" x-ref="alert">
		@include('components.front.alerts')
	</div>

	<div class="mb-5 text-sm sm:text-base lg:text-xl">
		<div class="flex flex-wrap items-center gap-4">
			<select id="author" wire:model.live="author" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400">
				<option value="">{{ __('Select :element', ['element' => __('the author')]) }}</option>
				@foreach($authors as $author)
					<option value="{{ $author->slug }}">
						{{ $author->name }}
					</option>
				@endforeach
			</select>

			<select id="section" wire:model.live="section" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400">
				<option value="">{{ __('Select :element', ['element' => __('a section')]) }}</option>
				@foreach($sections as $sectionFilter)
					<option value="{{ $sectionFilter->id }}">
						{{ $sectionFilter->name }}
					</option>
				@endforeach
			</select>

			<label for="inSelection" class="inline-flex items-center">
				<input type="checkbox" name="inSelection" id="inSelection" wire:model.live="inSelection" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

				<span class="ms-2 text-sm text-gray-400">
					{{ __('In selection') }}
				</span>
			</label>

			<div class="bg-white border-b border-gray-400 shadow-md px-2 py-1 lg:p-0 min-w-[250px]">
				<div class="relative mt-1 border-b-4 border-transparent">
					<div class="absolute inset-y-0 left-1 lg:left-2 flex items-center pointer-events-none">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
						</svg>
					</div>

					<input type="text" wire:model.live="keyword" name="keyword" id="keyword" placeholder="{{ __('Keyword(s)') }}" class="block w-full p-1.5 pl-8 lg:pl-9 text-gray-500 text-sm xl:text-base bg-white border border-transparent focus:border-transparent focus:ring-0 rounded-md" />
				</div>
			</div>

			<div wire:click="fresh" x-on:click.prevent="$dispatch('open-modal', 'set-article');" class="text-white inline-block">
				<button type="button" title="{{ __('Create :element', ['element' => __('an article')]) }}" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
				</button>
			</div>
		</div>
	</div>

	<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
		<div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
			<table class="min-w-full">
				<thead>
					<tr>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Name') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Author') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('In selection') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('State') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Created at') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Updated at') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Action') }}</th>
					</tr>
				</thead>

				<tbody class="bg-white">
					@if($articles->isNotEmpty())
						@foreach($articles as $articleEntry)
							<tr>
								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ $articleEntry->title }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ $articleEntry->author->name }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ $articleEntry->in_selection ? __('Yes') : __('No') }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ __($articleEntry->state->inHuman()) }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ $articleEntry->created_at->format('d/m/Y H:i:s') }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ $articleEntry->updated_at->format('d/m/Y H:i:s') }}
										</div>
									</div>
								</td>

								<td class="border-b border-gray-200">
									<a href="{{ route('article.show', ['article' => $articleEntry->slug]) }}" class="text-white inline-block">
										<button type="button" title="{{ __('View :element', ['element' => __('the company')]) }}" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
												<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
											</svg>
										</button>
									</a>

									<div wire:click="getArticle({{ $articleEntry->id }}, 'set-article')" title="{{ __('Update :element', ['element' => __('the article')]) }}" class="text-white inline-block">
										<button type="button" title="{{ __('Update :element', ['element' => __('the article')]) }}" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
											</svg>
										</button>
									</div>

									<div wire:click="getArticle({{ $articleEntry->id }}, 'delete-article')" title="{{ __('Delete :element', ['element' => __('the article')]) }}" class="text-white inline-block">
										<button type="button" title="{{ __('Delete :element', ['element' => __('the article')]) }}" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
											</svg>
										</button>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="7" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
								{{ __('No result for this search') }}
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>

	<div class="mt-8 px-5 py-6 bg-white shadow-sm rounded-md">
		{{ $articles->links() }}
	</div>

	<x-front.modal name="set-article" class="w-[900px]" focusable>
		<div class="space-y-8" x-data="{}">
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="title" :value="__('Article\'s title')" :required="true" />
				</div>

				<x-front.text-input id="title" wire:model="title" placeholder="{{ __('Article\'s title') }}" :class="'mt-1 block w-full'" />

				@error('title')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="mainSectionSelected" :value="__('Article\'s main section')" :required="true" />
				</div>

				<div class="flex flex-row gap-x-2">
					<select id="mainSectionSelected" wire:model.live="mainSectionSelected" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400">
						<option value="">{{ __('Select :element', ['element' => __('the main section')]) }}</option>
						@foreach($sections as $sectionList)
							<option value="{{ $sectionList->id }}">
								{{ $sectionList->name }}
							</option>
						@endforeach
					</select>
				</div>

				<div class="flex flex-row">
					@error('mainSectionSelected')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="sectionsSelected" :value="__('Article\'s secondary sections')" />
				</div>

				<div class="flex flex-col gap-2">
					@foreach($sections->reject(fn($section) => $section->id == $mainSectionSelected) as $sectionList)
						<label for="section_{{ $sectionList->id }}" class="inline-flex items-center">
							<input type="checkbox" name="{{ $sectionList->name }}" value="{{ $sectionList->id }}" id="section_{{ $sectionList->id }}" wire:model="sectionsSelected" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

							<span class="ms-2">
								{{ $sectionList->name }}
							</span>
						</label>
					@endforeach
				</div>

				<div class="flex flex-row">
					@error('sectionsSelected')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="targetsSelected" :value="__('Article\'s target')" :required="true" />
				</div>

				<div class="flex flex-row gap-x-2">
					@foreach($targets as $targetList)
						<label for="target_{{ $targetList->id }}" class="inline-flex items-center">
							<input type="checkbox" name="{{ $targetList->name }}" value="{{ $targetList->id }}" id="target_{{ $targetList->id }}" wire:model="targetsSelected" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

							<span class="ms-2">
								{{ $targetList->name }}
							</span>
						</label>
					@endforeach
				</div>

				<div class="flex flex-row">
					@error('targetsSelected')
						<span class="error text-danger-700">
							{{ $message }}
						</span>
					@enderror
				</div>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="speciesSelected" :value="__('Species')" :required="true" />
				</div>

				<div class="flex flex-row gap-x-2">
					@foreach($species as $speciesList)
						<label for="species_{{ $speciesList->id }}" class="inline-flex items-center">
							<input type="checkbox" name="{{ $speciesList->name }}" value="{{ $speciesList->id }}" id="species_{{ $speciesList->id }}" wire:model="speciesSelected" wire:change="selectSpecies" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

							<span class="ms-2">
								{{ ucfirst(__($speciesList->name)) }}
							</span>
						</label>
					@endforeach
				</div>

				@error('speciesSelected')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			@if($speciesSelected)
				<div>
					<div class="flex flex-row">
						<x-front.input-label for="choiceBreed" :value="__('Breeds')" />
					</div>

					<select id="choiceBreed" wire:model="choiceBreed" wire:change="selectBreed" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400 ">
						<option value="">{{ __('Select :element', ['element' => __('a breed to add it to the article')]) }}</option>
						@foreach($breedsList as $breedList)
							<option value="{{ $breedList->slug }}">
								{{ $breedList->name }}
							</option>
						@endforeach
					</select>

					@if($breedsSelected->count() > 0)
						<div class="flex flex-row pt-4">
							<x-front.input-label for="breedSelected" :value="__($breedsSelected->count() > 1 ? 'Selected breeds' : 'Selected breed')" />
						</div>

						<div class="flex flex-wrap justify-start items-center pt-2 gap-2">
							@foreach($breedsSelected as $breedSelected)
								<span class="cursor-pointer inline-block p-2 border" title="{{ __('Forget this breed') }}" wire:click="forgetBreed('{{ $breedSelected->slug }}')">
									{{ $breedSelected->name }}
								</span>
							@endforeach
						</div>
					@endif
				</div>
			@endif

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="choiceDepartment" :value="__('Departments')" />
				</div>

				<select id="choiceDepartment" wire:model="choiceDepartment" wire:change="selectDepartment" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400 ">
					<option value="">{{ __('Select :element', ['element' => __('a department to add it to the article')]) }}</option>
					@foreach($departments as $department)
						<option value="{{ $department->slug }}">
							{{ $department->name }}
						</option>
					@endforeach
				</select>

				@if($departmentsSelected->count() > 0)
					<div class="flex flex-row pt-4">
						<x-front.input-label for="departmentSelected" :value="__($departmentsSelected->count() > 1 ? 'Selected departments' : 'Selected department')" />
					</div>

					<div class="flex flex-wrap justify-start items-center pt-2 gap-2">
						@foreach($departmentsSelected as $departmentSelected)
							<span class="cursor-pointer inline-block p-2 border" title="{{ __('Forget this department') }}" wire:click="forgetDepartment('{{ $departmentSelected->slug }}')">
								{{ $departmentSelected->name }}
							</span>
						@endforeach
					</div>
				@endif
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="publish" :value="__('Infomercial')" />
				</div>

				<div class="flex flex-row">
					<label for="isInfomercial" class="inline-flex items-center">
						<input type="checkbox" name="isInfomercial" id="isInfomercial" wire:model="isInfomercial" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('Yes') }}
						</span>
					</label>
				</div>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="figo" :value="__('Figo')" />
				</div>

				<div class="flex flex-row gap-x-2">
					<label for="isFigoAdopter" class="inline-flex items-center">
						<input type="checkbox" name="isFigoAdopter" id="isFigoAdopter" wire:model="isFigoAdopter" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('Adopter') }}
						</span>
					</label>

					<label for="isFigoBreeder" class="inline-flex items-center">
						<input type="checkbox" name="isFigoBreeder" id="isFigoBreeder" wire:model="isFigoBreeder" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('Breeder') }}
						</span>
					</label>
				</div>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="tagSearch" :value="__('Article\'s tags')" :required="true" />
				</div>

				<x-front.text-input id="tagSearch" wire:model.live="tagSearch" wire:keyup.debounce="autocomplete" placeholder="{{ __('Write a tag name') }}" :class="'mt-1 block w-full'" />

				@if($tagsFound)
					<div class="flex flex-wrap justify-start items-center py-4 gap-2">
						@if($tagsFound->isNotEmpty())
							@foreach($tagsFound as $tagFound)
								<span class="cursor-pointer inline-block p-2 border" wire:click="selectTag('{{ $tagFound->slug }}')">
									{{ $tagFound->name }}
								</span>
							@endforeach
						@else
							<span class="cursor-pointer inline-block p-2 border rounded-xl" wire:click="addTag">
								{{ __('Create new tag') }}
							</span>
						@endif
					</div>
				@endif

				@if($tagsSelected->count() > 0)
					<div class="flex flex-row pt-4">
						<x-front.input-label for="tagsSelected" :value="__($tagsSelected->count() > 1 ? 'Selected tags' : 'Selected tag')" />
					</div>

					<div class="flex flex-wrap justify-start items-center pt-2 gap-2">
						@foreach($tagsSelected as $tagSelected)
							<span class="cursor-pointer inline-block p-2 border" title="{{ __('Forget this tag') }}" wire:click="forgetTag('{{ $tagSelected->slug }}')">
								{{ $tagSelected->name }}
							</span>
						@endforeach
					</div>
				@endif

				@error('tagsSelected')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div class="w-[250px]">
				<div class="flex flex-row">
					<x-front.input-label for="photo" :value="__('Article\'s photo')" />
				</div>

				<livewire:uppy
					:maxMedias="1"
					:class="$mediableClassPhoto"
					:modelId="$mediableIdPhoto"
					:collection="'photo'"
					:gridClass="'w-full max-w-[250px]'"
					:aspectRatio="'aspect-square'"
					:objectFit="'object-cover'"
					:key="'article-photo-'.$subComponentKey" />
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="photoCredit" :value="__('Article\'s photo credit')" :required="true" />
				</div>

				<x-front.text-input id="photoCredit" wire:model="photoCredit" placeholder="{{ __('Article\'s photo credit') }}" :class="'mt-1 block w-full'" />

				@error('photoCredit')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="header" :value="__('Article\'s header')" />
				</div>

				<div
					wire:ignore
					wire:key="ckeditor-header-{{ $subComponentKey }}"
					x-data="{ 
						h_content: @entangle('header')
					}"
					x-init="
						ClassicEditor
							.create($refs.editorHeader)
							.then(editor => {
								// FORCE le chargement de la donnée existante au démarrage
								// On vérifie d'abord Alpine, puis Livewire directement en secours
								let initialData = h_content || @this.get('header') || '';
								editor.setData(initialData);

								// On synchronise Alpine quand l'éditeur change
								editor.model.document.on('change:data', () => {
									h_content = editor.getData();
								});

								// Écouteur pour le chargement d'un article (si vous changez d'article sans recharger la page)
								window.addEventListener('article-loaded', () => {
									editor.setData(@this.get('header') || '');
								});

								// Watcher pour la réactivité descendante
								$watch('h_content', value => {
									if (value !== editor.getData()) {
										editor.setData(value || '');
									}
								});
							})
					"
				>
					<textarea x-ref="editorHeader" placeholder="{{ __('Article\'s header') }}"></textarea>
				</div>

				@error('header')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="body" :value="__('Article\'s body')" :required="true" />
				</div>

				<div
					wire:ignore
					wire:key="ckeditor-body-{{ $subComponentKey }}"
					x-data="{ 
						content: @entangle('body'),
					}"
					x-init="
						ClassicEditor
							.create($refs.editor, { 
								/* ... vos options de toolbar ici ... */ 
							})
							.then(editor => {
								// Chargement initial
								editor.setData(content || '');
								window.ckEditorInstance = editor;

								// 1. Mise à jour manuelle (appelée par votre bouton de sauvegarde)
								window.saveEditorData = () => {
									content = editor.getData();
								};

								// 2. Mise à jour auto quand on quitte le champ (sécurité)
								editor.editing.view.document.on('blur', () => {
									content = editor.getData();
								});

								// 3. Mise à jour en temps réel (optionnel mais conseillé pour éviter les pertes)
								editor.model.document.on('change:data', () => {
									content = editor.getData();
								});

								// 4. Watcher : si le serveur change 'body', l'éditeur se met à jour
								$watch('content', value => {
									if (value !== editor.getData()) {
										editor.setData(value || '');
									}
								});
							})
							.catch(error => { console.error(error); });
					"
				>
					<textarea x-ref="editor" placeholder="{{ __('Article\'s body') }}"></textarea>
				</div>

				@error('body')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="startPublicationDate" :value="__('Article\'s publication start date')" />
				</div>

				<x-front.text-input type="datetime-local" id="startPublicationDate" wire:model="startPublicationDate" placeholder="{{ __('DD/MM/YYYY hh:mm:ss') }}" :class="'mt-1 block w-full'" />

				@error('startPublicationDate')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="endPublicationDate" :value="__('Article\'s publication end date')" />
				</div>

				<x-front.text-input type="datetime-local" id="endPublicationDate" wire:model="endPublicationDate" placeholder="{{ __('DD/MM/YYYY hh:mm:ss') }}" :class="'mt-1 block w-full'" />

				@error('endPublicationDate')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="lastUpdateDate" :value="__('Article\'s last update date')" />
				</div>

				<x-front.text-input type="datetime-local" id="lastUpdateDate" wire:model="lastUpdateDate" placeholder="{{ __('DD/MM/YYYY hh:mm:ss') }}" :class="'mt-1 block w-full'" />

				@error('lastUpdateDate')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="authorSearch" :value="__('Article\'s author')" />
				</div>

				<x-front.text-input id="authorSearch" wire:model.live="authorSearch" wire:keyup.debounce="autocomplete" placeholder="{{ __('Write an author\'s name') }}" :class="'mt-1 block w-full'" />

				@if($authorFound)
					<div class="flex flex-wrap justify-start items-center py-4 gap-2">
						@if($authorFound->isNotEmpty())
							@foreach($authorFound as $authorFound)
								<span class="cursor-pointer inline-block p-2 border" wire:click="selectAuthor('{{ $authorFound->slug }}')">
									{{ $authorFound->name }}
								</span>
							@endforeach
						@else
							<span class="cursor-pointer inline-block p-2 border rounded-xl" wire:click="addAuthor">
								{{ __('Create new author') }}
							</span>
						@endif
					</div>
				@endif

				@if($authorSelected->count() > 0)
					<div class="flex flex-row pt-4">
						<x-front.input-label for="authorSelected" :value="__('Selected author')" />
					</div>

					<div class="flex flex-wrap justify-start items-center pt-2 gap-2">
						@foreach($authorSelected as $authorSelected)
							<span class="cursor-pointer inline-block p-2 border" title="{{ __('Forget this author') }}" wire:click="forgetAuthor('{{ $authorSelected->slug }}')">
								{{ $authorSelected->name }}
							</span>
						@endforeach
					</div>
				@endif

				@error('authorSelected')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="isInSelection" :value="__('In selection')" />
				</div>

				<div class="flex flex-row">
					<label for="isInSelection" class="inline-flex items-center">
						<input type="checkbox" name="isInSelection" id="isInSelection" wire:model="isInSelection" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('Yes') }}
						</span>
					</label>
				</div>
			</div>

			<div>
				<div class="flex flex-row">
					<x-front.input-label for="isPublished" :value="__('Publish')" />
				</div>

				<div class="flex flex-row">
					<label for="isPublished" class="inline-flex items-center">
						<input type="checkbox" name="isPublished" id="isPublished" wire:model="isPublished" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue" />

						<span class="ms-2">
							{{ __('Yes') }}
						</span>
					</label>
				</div>
			</div>

			<div class="flex flex-row justify-between">
				<x-front.secondary-button x-on:click="$dispatch('close');" :class="'flex justify-center mt-4 s:mt-0'">
					{{ __('Cancel') }}
				</x-front.secondary-button>

				<x-front.primary-button 
					x-on:click="window.saveEditorData(); $nextTick(() => { $wire.setArticle() })" 
					@article-validated.window="$dispatch('close')"
					class="flex justify-center mt-4 s:mt-0"
				>
					{{ $article->exists ? __('Update :element', ['element' => __('the article')]) : __('Add :element', ['element' => __('the article')]) }}
				</x-front.primary-button>
			</div>
		</div>
	</x-front.modal>

	<x-front.modal name="delete-article" :class="'w-full max-w-2xl'" focusable>
		<section class="p-10 flex flex-col flex-wrap content-center">
			<header class="flex flex-col flex-wrap content-center">
				<h2 class="text-lg font-semibold">
					{{ __('Are you sure to delete :element', ['element' => __('the article')]) }} ?
				</h2>
			</header>

			<div class="mt-6 flex flex-row flex-wrap justify-center">
				<x-front.secondary-button x-on:click="$dispatch('close');" :class="'mr-6'">
					{{ __('Cancel') }}
				</x-front.secondary-button>

				<x-front.primary-button wire:click="deleteArticle" @article-deleted.window="$dispatch('close');">
					{{ __('Delete :element', ['element' => __('the article')]) }}
				</x-front.primary-button>
			</div>
		</section>
	</x-front.modal>

	@push('scripts')
		<script src="{{ asset('js/ckeditor.js') }}"></script>
	@endpush

	@push('styles')
		<style>
			.ck.ck-content.ck-editor__editable {
				max-height: 600px;
			}
		</style>
	@endpush
</div>
