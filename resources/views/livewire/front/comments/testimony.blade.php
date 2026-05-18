<div>
	@php
		if($comment->id) $key = 'comment'.$comment->id;
		else $key = rand();

		$modalKey = 'form'.$key;
	@endphp

	@if(($comment->exists && $case != 'user-about-breed') || $case == 'user-about-breed')
		<div class="flex flex-row pb-4 text-breeder-deepblue flex-wrap break-words hyphens-auto text-xl gap-x-1">
			@if($comment->exists && $case != 'user-about-breed')
				<span class="font-semibold">
					{{ $target->name }}
				</span>
			@elseif($case == 'user-about-breed')
				<span class="font-bold">
					{{ __('Share with the community') }}
				</span>

				{{ __('about the :breed breed', ['breed' => $target->name]) }}
			@endif
		</div>
	@endif

	<div class="flex flex-col">
		@if($create && !$comment->exists)
			@if(!Auth::guard('web')->user()->hasCommentWaitingModeration($target))
				@if($case == 'user-about-breed')
					<div class="flex flex-row gap-x-2">
						<div class="flex flex-row pt-8 w-[50px] h-[50px] rounded-full">
							@if($photo = $source->getFirstMedia('avatar'))
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $source->name }}" class="inline-block object-cover w-[50px] h-[50px] rounded-full">
							@else
								<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $source->name }}" class="inline-block object-cover w-[50px] h-[50px] rounded-full">
							@endif
						</div>

					<div class="w-full">
				@endif

				<div class="flex flex-row">
					<x-front.input-label for="{{ $modalKey.'Content' }}" :value="$contentLabel" :class="'pl-4'" />
				</div>

				<textarea id="{{ $modalKey.'Content' }}" rows="5" wire:model="content" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>

				@if(!$comment->exists && $case != 'user-about-breed')
					<div class="flex flex-row text-sm text-gray-400">
						{{ __('Your comment will be moderated by our team within 24h.') }}
					</div>
				@endif

				@if($case == 'user-about-breed')
					</div>
					</div>
				@endif

				@error('content')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror

				<div class="flex flex-row justify-end mt-4">
					@if($inModal)
						<x-front.secondary-button wire:click="submitCommentForm" @comment-form-done.window="$dispatch('close');">
							{{ __('Publish my comment') }}
						</x-front.secondary-button>
					@else
						<x-front.secondary-button wire:click="submitCommentForm">
							{{ __('Publish my comment') }}
						</x-front.secondary-button>
					@endif
				</div>
			@else
				<div class="flex flex-row text-sm text-gray-400">
					{{ __('Your comment will be moderated by our team within 24h.') }}
				</div>
			@endif
		@endif

		@if($update && $comment->exists)
			<div class="flex flex-row justify-end text-breeder-deepblue mt-4">
				<div class="cursor-pointer flex flex-row items-center gap-x-1" x-on:click.prevent="$dispatch('open-modal', '{{ $modalKey }}');">
					<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.7093 2.52476H2.49096C2.09553 2.52476 1.7163 2.68184 1.43669 2.96145C1.15708 3.24106 1 3.62029 1 4.01571V14.4524C1 14.8478 1.15708 15.2271 1.43669 15.5067C1.7163 15.7863 2.09553 15.9434 2.49096 15.9434H12.9276C13.3231 15.9434 13.7023 15.7863 13.9819 15.5067C14.2615 15.2271 14.4186 14.8478 14.4186 14.4524V9.23406M13.3004 1.40654C13.597 1.10997 13.9992 0.943359 14.4186 0.943359C14.838 0.943359 15.2402 1.10997 15.5368 1.40654C15.8334 1.70311 16 2.10534 16 2.52476C16 2.94417 15.8334 3.3464 15.5368 3.64297L8.45478 10.725L5.47287 11.4705L6.21835 8.48858L13.3004 1.40654Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					<span class="text-sm font-bold">
						{{ __('Update') }}
					</span>
				</div>
			</div>
		@endif
	</div>

	@if($comment->exists && $case != 'user-about-breed')
		<div class="flex flex-col p-4 text-breeder-deepblue flex-wrap break-words hyphens-auto">
			{{ $comment->content }}

			@if($comment->isWaitingModeration())
				<div class="flex flex-row text-sm text-gray-400">
					{{ __('Your comment will be moderated by our team within 24h.') }}
				</div>
			@endif
		</div>
	@endif

	{{-- Form --}}
	@if($update)
		<x-front.modal name="{{ $modalKey }}" :class="'w-full max-w-2xl'" focusable>
			<section class="flex flex-col content-center">
				<header class="flex flex-col flex-wrap content-center">
					<x-front.space-title>
						@if($comment->exists)
							{{ __('Comment update') }}
						@else
							{{ __('Comment creation') }}
						@endif
					</x-front.space-title>
				</header>

				<div class="flex flex-col w-full gap-y-4 p-4">
					<div class="w-full mb-8">
						<div class="flex flex-row">
							<x-front.input-label for="{{ $modalKey.'Content' }}" :value="__('Your experience with this breed')" :class="'pl-4'" />
						</div>

						<textarea id="{{ $modalKey.'Content' }}" rows="5" wire:model="content" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>

						@error('content')
							<span class="error text-danger-700">
								{{ $message }}
							</span>
						@enderror
					</div>
				</div>

				<div class="flex flex-row justify-between">
					<x-front.secondary-button x-on:click="$dispatch('close');">
						{{ __('Cancel') }}
					</x-front.secondary-button>

					<x-front.primary-button wire:click="submitCommentForm" @comment-form-done.window="$dispatch('close');">
						@if($comment->exists)
							{{ __('Update :element', ['element' => __('the comment')]) }}
						@else
							{{ __('Create :element', ['element' => __('the comment')]) }}
						@endif
					</x-front.primary-button>
				</div>
			</section>
		</x-front.modal>
	@endif
</div>
