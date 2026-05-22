<div class="flex w-full @if($postType && $postType->exists) max-w-[868px] @endif">
	@if($postType && $postType->exists)
		<h1 class="text-[28px] text-jobboard-deepblue w-full p-1 flex gap-x-1">
			{{ $postCount > 1 ? __(':x posts found', ['x' => $postCount]) : __(':x post found', ['x' => $postCount]) }}
		</h1>
	@else
		<h1 class="text-[28px] text-jobboard-deepblue w-full p-1 flex gap-x-1 @if($postType && $postType->exists) @else justify-center @endif">
			{{ $postCount > 1 ? __(':x posts found', ['x' => $postCount]) : __(':x post found', ['x' => $postCount]) }}
		</h1>
	@endif
</div>