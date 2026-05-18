<div class="flex flex-col text-breeder-deepblue md:max-w-[264px]">
	<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="w-full mb-4 @if(!$loop->first) max-s:hidden @endif">
		@if($photo = $article->getFirstMedia('photo'))
			<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $article->title }}" class="object-cover md:w-[264px] md:h-[225px] rounded-sm" />
		@else
			<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $article->title }}" class="object-cover md:w-[264px] md:h-[225px] rounded-sm" />
		@endif
	</a>

	<h4 class="font-bold text-[18px] mb-2">
		<a href="{{ route('article.show', ['article' => $article->slug]) }}">
			{{ Str::limit($article->title, 45) }}
		</a>
	</h4>

	<div class="flex flex-wrap gap-2 max-s:hidden">
		@if($article->values->get('infomercial') == 'false')
			<div class="rounded-md py-2 px-3 text-center bg-breeder-orange text-xs font-medium">
				{{ __('Advertorial') }}
			</div>
		@endif
	</div>
</div>