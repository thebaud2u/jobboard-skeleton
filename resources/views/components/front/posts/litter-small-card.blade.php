@props([
	'post' => null,
	'breed' => null,
	'isPureBreed' => false,
	'addressInFrance' => false,
	'species' => null
])

<a href="{{ route('post-search.post.show', ['company' => $post->model->company->slug, 'post' => $post->slug, 'breed' => $breed->slug]) }}">
	<article class="w-[220px] h-[220px] relative">
		<div class="absolute w-[220px] top-0 z-10">
			<div class="w-full flex flex-row items-start justify-end gap-2 p-2">
				<span class="py-1 px-2 rounded-md font-medium bg-breeder-cream text-breeder-deepblue text-xs text-right">
					{{ $isPureBreed ? $breed->name : __('Of appearance :breed', ['breed' => $breed->name]) }}
				</span>

				@if($isPureBreed)
					<span class="text-xs grow-0 rounded-md py-1 px-2 text-center @if($species->getTranslation('slug', 'en') == 'cat' && $addressInFrance) bg-breeder-green @elseif($species->getTranslation('slug', 'en') == 'dog' && $addressInFrance) bg-breeder-coral @else bg-breeder-cream @endif">
						@if($addressInFrance)
							@if($species->getTranslation('slug', 'en') == 'cat')
								LOOF
							@elseif($species->getTranslation('slug', 'en') == 'dog')
								LOF
							@endif
						@else
							{{ __('Origin book') }}
						@endif
					</span>
				@endif
			</div>
		</div>
		@if($post->type->getTranslation('slug', 'en') == 'litter-yet-to-come')
			<img src="{{ asset('storage/litter-yet-to-come-for-dogs.png') }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
		@else
			@if($photo = $post->getFirstMedia('photos'.$post->id))
				<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
			@else
				@php
					if($species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
					elseif($species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
				@endphp
				<img src="{{ $src }}" class="absolute w-[220px] h-[220px] object-cover rounded-xl top-0" />
			@endif
		@endif
	</article>
</a>