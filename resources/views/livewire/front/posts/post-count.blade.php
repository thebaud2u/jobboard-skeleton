<div class="flex w-full @if($postType && $postType->exists) max-w-[868px] @endif">
	@if($breed->exists)
		<h1 class="text-[28px] text-breeder-deepblue w-full flex gap-x-1">
			@if($postCount == 0)
				@if($postType && $postType->exists)
					@if($postType->getTranslation('slug', 'en') == 'litter')
						{{ __('No post for :breed :specie found', ['breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiot' : 'de chaton')]) }}
					@elseif($postType->getTranslation('slug', 'en') == 'retired-breeder')
						{{ __('No post for :breed :specie found', ['breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chien' : 'de chat')]) }}
					@elseif($postType->getTranslation('slug', 'en') == 'stud')
						{{ __('No post for :breed :specie found', ['breed' => $breed->name, 'specie' => __('of stud')]) }}
					@endif
				@endif
			@else
				@if($postType && $postType->exists)
					@if($postType->getTranslation('slug', 'en') == 'litter')
						@if($postCount > 1)
							{{ __(':x posts for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiots' : 'de chatons')]) }}
						@else
							{{ __(':x post for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiot' : 'de chaton')]) }}
						@endif
					@elseif($postType->getTranslation('slug', 'en') == 'retired-breeder')
						@if($postCount > 1)
							{{ __(':x posts for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiens' : 'de chats')]) }}
						@else
							{{ __(':x post for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chien' : 'de chat')]) }}
						@endif
					@elseif($postType->getTranslation('slug', 'en') == 'stud')
						@if($postCount > 1)
							{{ __(':x posts for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => __('of studs')]) }}
						@else
							{{ __(':x post for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => __('of stud')]) }}
						@endif
					@endif
				@else
					@if($postCount > 1)
						{{ __(':x posts for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiens' : 'de chats')]) }}
					@else
						{{ __(':x post for :breed :specie found', ['x' => $postCount, 'breed' => $breed->name, 'specie' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chien' : 'de chat')]) }}
					@endif	
				@endif
			@endif
		</h1>
	@elseif($postType && $postType->exists)
		<h1 class="text-[28px] text-breeder-deepblue w-full p-1 flex gap-x-1">
			@if($postType->getTranslation('slug', 'en') == 'litter')
				{{ $postCount > 1 ? __(':x posts :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiots' : 'de chatons')]) : __(':x post :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiot' : 'de chaton')]) }}
			@elseif($postType->getTranslation('slug', 'en') == 'stud')
				{{ $postCount > 1 ? __(':x posts :breed found', ['x' => $postCount, 'breed' => "d'étalons"]) : __(':x post :breed found', ['x' => $postCount, 'breed' => "d'étalon"]) }}
			@elseif($postType->getTranslation('slug', 'en') == 'retired-breeder')
				{{ $postCount > 1 ? __(':x posts :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiens' : 'de chats')]) : __(':x post :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chien' : 'de chat')]) }}
			@else
				{{ $postCount > 1 ? __(':x posts :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiens' : 'de chats')]) : __(':x post :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chien' : 'de chat')]) }}
			@endif
		</h1>
	@else
		<h1 class="text-[28px] text-breeder-deepblue w-full p-1 flex gap-x-1 @if($postType && $postType->exists) @else justify-center @endif">
			{{ $postCount > 1 ? __(':x posts :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chiens' : 'de chats')]) : __(':x post :breed found', ['x' => $postCount, 'breed' => ($species->getTranslation('slug', 'en') == 'dog' ? 'de chien' : 'de chat')]) }}
		</h1>
	@endif
</div>