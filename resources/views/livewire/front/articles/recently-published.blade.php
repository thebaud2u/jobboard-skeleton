<div @if($isGrid) class="h-full max-sm:hidden" @endif>
	<div class="flex flex-col items-center gap-y-8 @if($isGrid) h-full @endif">
		@if($title)
			<h3 class="font-semibold text-jobboard-deepblue text-[25px] sm:text-[40px] text-center">
				{{ __('Our last advices') }}
			</h3>
		@endif

		<div class="max-[1200px] flex flex-wrap justify-center gap-6 @if(!$isGrid) max-md:p-4 @endif @if($isGrid) h-full self-start max-dc:w-full @endif">
			@foreach($articles as $article)
				<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="group @if($smallCard && !$isGrid) h-[326px] @elseif($isGrid) max-dc:w-full w-[275px] h-full @endif">
					<div class="flex flex-col text-jobboard-deepblue @if(!$isGrid) max-w-[350px] s:max-w-[280px] @endif @if($smallCard) rounded-xl h-full border border-jobboard-greige @endif">
						<div class="w-full relative mb-4 overflow-hidden @if($smallCard) rounded-t-xl @endif">
							@if($isGrid)
								<div class="absolute rounded-md bg-jobboard-orange text-jobboard-deepblue font-medium text-xs px-3 py-2 top-2 right-2">
									{{ __('Advice') }}
								</div>
							@endif
							@if($photo = $article->getFirstMedia('photo'))
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $article->name }}" class="object-cover transition-all group-hover:scale-105 @if($smallCard) rounded-t-xl h-[220px] @else md:h-[280px] @endif @if($isGrid) max-dc:w-full @endif" />
							@else
								<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $article->name }}" class="object-cover transition-all group-hover:scale-105 @if($smallCard) rounded-t-xl h-[220px] @else md:h-[280px] @endif @if($isGrid) max-dc:w-full @endif" />
							@endif
						</div>

						<h4 class="font-semibold text-[18px] mb-2 leading-tight @if($isGrid) px-2 hyphens-auto @endif">
							@if(!$smallCard)
								{{ $article->title }}
							@elseif($isGrid)
								{{ Str::limit($article->title, 40) }}
							@else
								{{ Str::limit($article->title, 50) }}
							@endif
						</h4>

						@php
							$tags = $article->tags;

							if($displayAllTags) {
								$targets = $article->targets;
								$species = $article->species;
							}
							else {
								$targets = null;
								$species = null;
							}
						@endphp
						
						@if((!$smallCard || $isGrid) && 
							(
								($displayAllTags && ($targets->isNotEmpty() || $species->isNotEmpty() || $tags->isNotEmpty())) || 
								(!$displayAllTags && $tags->isNotEmpty())
							)
						)
							<div class="flex flex-wrap gap-2 pb-4">
								@if($displayAllTags && $targets->isNotEmpty())
									@foreach($targets as $articleTarget)
										<span class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs w-fit">
											{{ $articleTarget->name }}
										</span>
									@endforeach
								@endif

								@if($displayAllTags && $species->isNotEmpty())
									@foreach($species as $articleSpecies)
										<span class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs w-fit max-s:hidden">
											{{ __($articleSpecies->name) }}
										</span>
									@endforeach
								@endif

								@if($tags->isNotEmpty())
									@foreach($tags as $articleTag)
										<span class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs w-fit @if($loop->index > 1) max-s:hidden @endif">
											{{ $articleTag->name }}
										</span>
									@endforeach
								@endif
							</div>
						@endif
					</div>
				</a>
			@endforeach
		</div>
	</div>

	@if(!$smallCard)
		<div class="flex justify-center mt-8">
			<a href="{{ route('article.index') }}" class="bg-jobboard-white hover:bg-jobboard-deepblue border border-jobboard-deepbluehover rounded-full text-jobboard-deepbluehover hover:text-jobboard-cream font-semibold text-sm py-4 px-8">
				{{ __('All our advice') }}
			</a>
		</div>
	@endif
</div>
