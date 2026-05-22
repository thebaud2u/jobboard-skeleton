<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="max-md:w-full md:w-[264px] max-md:shrink-0 max-md:snap-center">
	<div class="flex flex-col text-jobboard-deepblue w-full flex-1 md:max-w-[350px]">
		<div class="w-full mb-4">
			@if($photo = $article->getFirstMedia('photo'))
				<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $article->title }}" class="object-cover h-[225px] md:h-[280px]" />
			@else
				<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $article->title }}" class="object-cover h-[225px] md:h-[280px]" />
			@endif
		</div>

		<h4 class="font-semibold text-[18px] mb-2">
			{{ $article->title }}
		</h4>

		<div class="flex flex-wrap gap-2 max-s:hidden">
			@if($article->values->get('infomercial') == 'false')
				<div class="rounded-md py-2 px-3 text-center bg-jobboard-orange text-xs font-medium">
					{{ __('Advertorial') }}
				</div>
			@endif
		</div>
	</div>
</a>