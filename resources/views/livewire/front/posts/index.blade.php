<div class="w-full">
	@if(!$results->isNotEmpty())
		<span class="max-md:block hidden mb-8">{{ __('Your research brings up no result') }}</span>
	@endif

	@if($breed && $breed->exists)
		@include('components.front.space.comparate-race', ['CTABreed' => $breed])
	@else
		@include('components.front.space.comparate-race')
	@endif

	@if($results->isNotEmpty())
		@php
			$cols = $postType->exists ? 3 : 4;
		@endphp

		<div class="flex flex-wrap gap-y-4 w-full {{ $cols == 3 ? 'justify-center gap-4 dc:grid dc:grid-cols-2 md:grid-cols-3 lg:grid lg:grid-cols-2 xlsm:grid-cols-3' : 'gap-2 max-sm:justify-center sm:grid sm:grid-cols-2 lg:grid-cols-3 xlsm:grid-cols-4 max-lg:place-items-center' }}">
			@foreach($results as $result)
				@php
					$isAnimal = false;

					if($result instanceof \App\Models\Animal) {
						$isAnimal = true;
						$litters = $result->litters;
						$post = $litters->isNotEmpty() ? $result->getPostFromLitter() : $result->post;
					}
					elseif($result instanceof \App\Models\Post) $post = $result;
				@endphp

				@if($isAnimal)
					<div class="w-full dc:col-span-1">
						@if($litters->isNotEmpty())
							<livewire:front.animals.litter-animals.litter-animal
								:animal="$result"
								:litter="$litters->first()"
								:showTitle="false"
								:showCount="false"
								:post="$post"
								:smallCard="true"
								:isIndex="true"
								:isSearchDone="$postType->exists"
								:key="'litter-animal-'.$post->id.'-'.Str::uuid()" />
						@else
							<livewire:front.animals.breeders.breeder
								:animal="$result"
								:company="$result->company"
								:showTitle="false"
								:showCount="false"
								:post="$post"
								:smallCard="true"
								:isIndex="true"
								:isSearchDone="$postType->exists"
								:key="'breeder-'.$post->id.'-'.Str::uuid()" />
						@endif
					</div>
				@else
					<div class="w-full dc:col-span-1 max-xlsm:flex max-xlsm:justify-center">
						@if($post->type->getTranslation('slug', 'en') == 'litter-yet-to-come')
							<div class="max-dc:w-full h-full max-xlsm:flex max-xlsm:justify-center">
								@include('components.front.posts.litter-yet-to-come-card', ['isIndex' => true])
							</div>
						@elseif($post->type->getTranslation('slug', 'en') == 'litter')
							@include('components.front.posts.litter-card', ['isIndex' => true])
						@else
							<livewire:front.animals.breeders.breeder
								:animal="$post->model"
								:company="$post->model->company"
								:showTitle="false"
								:showCount="false"
								:post="$post"
								:smallCard="true"
								:isIndex="true"
								:isSearchDone="$postType->exists"
								:key="'breeder-'.$post->id.'-'.Str::uuid()" />
						@endif
					</div>
				@endif
			@endforeach
		</div>
	@else
		<span class="max-md:hidden">{{ __('Your research brings up no result') }}</span>
	@endif

	@if($results->hasPages())
		<div class="my-8">
			{{ $results->links() }}
		</div>
	@endif
</div>
