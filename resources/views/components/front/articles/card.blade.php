<div class="flex flex-row-reverse max-s:justify-between s:flex-col text-jobboard-deepblue sm:max-w-[377px]">
	<div class="w-full">
		<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="w-full max-s:max-w-[120px] mb-4">
			@if($photo = $article->getFirstMedia('photo'))
				<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $article->title }}" class="object-cover max-s:w-[120px] max-s:h-[90px] s:h-[302px] rounded-sm" />
			@else
				<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $article->title }}" class="object-cover max-s:w-[120px] max-s:h-[90px] s:h-[302px] rounded-sm" />
			@endif
		</a>
	</div>

	<div class="max-s:w-[225px] shrink-0 mt-5">
		<h4 class="font-bold text-[18px] mb-2">
			<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="hyphens-auto hover:underline hover:underline-offset-4">
				{{ Str::limit($article->title, 75) }}
			</a>
		</h4>

		<div class="hidden sm:flex flex-wrap gap-2">
			@if($article->tags->isNotEmpty())
				@foreach($article->tags as $value)
					<div class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs font-medium">
						<a href="{{ route('article.show', ['article' => $article->slug]) }}">
							{{ $value->name }}
						</a>
					</div>
				@endforeach
			@endif

			@if($article->values->get('infomercial') == 'false')
				<div class="rounded-md py-2 px-3 text-center bg-jobboard-orange text-xs font-medium">
					{{ __('Advertorial') }}
				</div>
			@endif
		</div>
	</div>
</div>