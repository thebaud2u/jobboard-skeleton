<x-space-layout>
	@push('seo')
		<title>{{ __('My space') }}</title>
		<meta name="description" content="{{ __(':siteName', ['siteName' => env('APP_NAME')]) }}">
		<meta name="keywords" content="{{ __(':siteName, ', ['siteName' => env('APP_NAME')]) }}" />
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
	@endpush

	@push('scripts')
		<script src="{!! asset('js/uppy.js') !!}"></script>
	@endpush

	@push('styles')
		<x-front.space.uppy-styles />
	@endpush

	<x-slot name="side_menu">
		@include('components.front.space.profile.side-menu')
	</x-slot>

	<div x-data="{uppyUploaderCollection: '', uppyUploaderMediaId: ''}" class="flex flex-col gap-6 mt-6 text-breeder-deepblue p-6">
		<a href="{{ route('space.posts.my-posts') }}">
			<div class="flex flex-wrap justify-start items-center font-bold gap-x-2">
				<svg width="12" height="17" viewBox="0 0 12 17" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path d="M9.63672 1.5L2.00035 8.5L9.63672 15.5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				{{ __('All my posts') }}
			</div>
		</a>

		<div class="flex flex-wrap justify-between items-center gap-2">
			<div class="text-[28px] md:text-[40px] font-bold">
				@if($type->getTranslation('slug', 'en') == 'litter' || $type->getTranslation('slug', 'en') == 'litter-yet-to-come')
					<div>
						{{ $type->getTranslation('slug', 'en') == 'litter' ? __('Litter') : __('Upcoming litter') }} <span class="font-bold">{{ $isPureBreed ? $breed->name : __('of appearance :breed', ['breed' => $breed->name]) }}</span>
					</div>
				@elseif($type->getTranslation('slug', 'en') == 'retired-breeder')
					<span class="font-bold">
						{{ __('Retired adult') }}
					</span>
				@elseif($type->getTranslation('slug', 'en') == 'stud')
					<span class="font-bold">
						{{ __('Stud') }}
					</span>
				@endif
			</div>

			<div class="flex flex-row max-sm:flex-wrap gap-4">
				@if($lastPublication)
					<a href="{{ route('post-search.post.show', ['company' => $post->model->company->slug, 'post' => $post->slug, 'breed' => $breed->slug]) }}">
						<x-front.secondary-button>
							<div class="flex flex-row justify-center items-center gap-x-2 px-2 font-bold text-sm">
								<svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M17 6.05028C17 6.05028 14.2174 11.2677 9.00001 11.2677C3.78261 11.2677 1 6.05028 1 6.05028C1 6.05028 3.78261 0.832886 9.00001 0.832886C14.2174 0.832886 17 6.05028 17 6.05028Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M8.99958 9.18074C10.7285 9.18074 12.13 7.77919 12.13 6.0503C12.13 4.32141 10.7285 2.91986 8.99958 2.91986C7.27069 2.91986 5.86914 4.32141 5.86914 6.0503C5.86914 7.77919 7.27069 9.18074 8.99958 9.18074Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

								{{ __('Preview') }}
							</div>
						</x-front-secondary-button>
					</a>
				@endif

				@if($post->isAvailable())
					<a href="{{ route('space.posts.update', ['post' => $post->slug]) }}">
						<x-front.secondary-button>
							<div class="flex flex-row justify-center items-center gap-x-2 px-2 font-bold text-sm">
								<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M7.7093 2.5814H2.49096C2.09553 2.5814 1.7163 2.73848 1.43669 3.01809C1.15708 3.2977 1 3.67693 1 4.07235V14.509C1 14.9045 1.15708 15.2837 1.43669 15.5633C1.7163 15.8429 2.09553 16 2.49096 16H12.9276C13.3231 16 13.7023 15.8429 13.9819 15.5633C14.2615 15.2837 14.4186 14.9045 14.4186 14.509V9.2907M13.3004 1.46318C13.597 1.16661 13.9992 1 14.4186 1C14.838 1 15.2402 1.16661 15.5368 1.46318C15.8334 1.75975 16 2.16198 16 2.5814C16 3.00081 15.8334 3.40304 15.5368 3.69961L8.45478 10.7817L5.47287 11.5271L6.21835 8.54522L13.3004 1.46318Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

								{{ __('Update') }}
							</div>
						</x-front-secondary-button>
					</a>
				@endif

				@if($post->isPublished())
					<x-front.secondary-button type="button" x-on:click.prevent="$dispatch('open-modal', 'unpublish-modal');">
						<svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M20 8.49938C20 8.49938 16.6957 14.8152 10.5 14.8152C4.30435 14.8152 1 8.49938 1 8.49938C1 8.49938 4.30435 2.18359 10.5 2.18359C16.6957 2.18359 20 8.49938 20 8.49938Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M10.4996 12.2899C12.5527 12.2899 14.217 10.5933 14.217 8.50041C14.217 6.40754 12.5527 4.71094 10.4996 4.71094C8.44656 4.71094 6.78223 6.40754 6.78223 8.50041C6.78223 10.5933 8.44656 12.2899 10.4996 12.2899Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M17.522 0.5L3.47852 16.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						{{ __('Unpublish') }}
					</x-front.secondary-button>
				@else
					<x-front.secondary-button type="button" x-on:click.prevent="$dispatch('open-modal', 'delete-modal');">
						<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 4.71693H2.77778M2.77778 4.71693H17M2.77778 4.71693V17.1614C2.77778 17.6329 2.96508 18.0851 3.29848 18.4185C3.63187 18.7519 4.08406 18.9392 4.55556 18.9392H13.4444C13.9159 18.9392 14.3681 18.7519 14.7015 18.4185C15.0349 18.0851 15.2222 17.6329 15.2222 17.1614V4.71693M5.44444 4.71693V2.93915C5.44444 2.46766 5.63175 2.01547 5.96514 1.68208C6.29854 1.34868 6.75073 1.16138 7.22222 1.16138H10.7778C11.2493 1.16138 11.7015 1.34868 12.0349 1.68208C12.3683 2.01547 12.5556 2.46766 12.5556 2.93915V4.71693M7.22222 9.16138V14.4947M10.7778 9.16138V14.4947" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						{{ __('Delete') }}
					</x-front.secondary-button>
				@endif
			</div>
		</div>

		<div class="flex flex-col items-center lg:justify-between w-full text-sm bg-breeder-violet rounded-xl p-4 flex-wrap lg:flex-row">
			@if(!$post->isAvailable())
				<div class="flex flex-col lg:flex-row justify-between items-center gap-x-2 font-bold">
					<svg class="shrink-0" width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.5556 1.22217V4.12363M5.44444 1.22217V4.12363M1 7.02509H17M2.77778 2.6729H15.2222C16.2041 2.6729 17 3.32241 17 4.12363V14.2787C17 15.08 16.2041 15.7295 15.2222 15.7295H2.77778C1.79594 15.7295 1 15.08 1 14.2787V4.12363C1 3.32241 1.79594 2.6729 2.77778 2.6729Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					<div class="flex flex-row justify-start items-center gap-x-2">
						@if($lastPublication->isArchived())
							{{ __(':status the :date', ['status' => __('Archived'), 'date' => $post->archived_at->format('d/m/Y')]) }}
						@elseif($lastPublication->isDeleted())
							{{ __(':status the :date', ['status' => __('Deleted'), 'date' => $post->deleted_at->format('d/m/Y')]) }}
						@endif
					</div>

					@if($lastPublication->isArchived())
						@if(
							($post->type->getTranslation('slug', 'en') == 'litter' && $post->model->hasAvailableChildren() && ($post->model->mother && !$post->model->mother->trashed()) && ($post->model->father && !$post->model->father->trashed())) ||
							($post->type->getTranslation('slug', 'en') == 'retired-breeder' && $post->model->lastLife->isAvailable() && !$post->model->trashed()) ||
							($post->type->getTranslation('slug', 'en') == 'litter-yet-to-come' && ($post->model->mother && !$post->model->mother->trashed()) && ($post->model->father && !$post->model->father->trashed())) ||
							($post->type->getTranslation('slug', 'en') == 'stud' && ($post->model && !$post->model->trashed()))
						)
							<span class="px-4">></span>
							<div class="flex flex-row justify-start items-center gap-x-2 font-normal">
								<a href="{{ route('space.posts.extend-offer', ['post' => $post->slug]) }}" class="flex flex-row justify-center items-center gap-x-2 font-bold text-sm hover:underline hover:underline-offset-4">
									{{ __('Republish') }}

									<svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.48828 1.47559L5.85192 5.47559L1.48828 9.47559" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</a>
							</div>
						@endif
					@endif
				</div>
			@else
				<div class="flex flex-col lg:flex-row items-center gap-x-2 font-bold">
					<svg class="shrink-0" width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.5556 1.22217V4.12363M5.44444 1.22217V4.12363M1 7.02509H17M2.77778 2.6729H15.2222C16.2041 2.6729 17 3.32241 17 4.12363V14.2787C17 15.08 16.2041 15.7295 15.2222 15.7295H2.77778C1.79594 15.7295 1 15.08 1 14.2787V4.12363C1 3.32241 1.79594 2.6729 2.77778 2.6729Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					{{ $post->offer()->name }}

					<div class="flex flex-row justify-start items-center gap-x-2 font-normal">
						@if($lastPublication->isDraft())
							{{ ucfirst(__('as draft')) }} <div class="w-2 h-2 bg-breeder-deepblue rounded-full"></div>
						@elseif($lastPublication->isWaitingToBePublished())
							@if($post->awaitingModeration())
								{{ ucfirst(__('waiting validation')) }} <div class="w-2 h-2 bg-breeder-orange rounded-full"></div>
							@elseif($post->lastModeration->isDenied())
								{{ ucfirst(__('moderation denied, update your post infos and resubmit')) }} <div class="w-2 h-2 bg-breeder-red rounded-full"></div>
							@endif
						@elseif($lastPublication->isPublished())
							{{ ucfirst(__('published the :date', ['date' => $post->published_at->format('d/m/Y')])) }} <div class="w-2 h-2 bg-breeder-green rounded-full"></div>
						@endif
					</div>

					@if($post->isPublished())
						<span class="px-4">></span>
						<div class="flex flex-row justify-start items-center gap-x-2 font-normal">
							@php
								$postArchivedAtDate = $post->archived_at->startOfDay();
								$now = now()->startOfDay();

								$dateDiffForArchiving = $now->diffInDays($postArchivedAtDate);
							@endphp

							{{ __('Publication end date :') }}<span class="font-bold">{{ $post->archived_at->format('d/m/Y') }}&nbsp;({{ __(':x :dayword left', ['x' => $dateDiffForArchiving, 'dayword' => $dateDiffForArchiving > 1 ? __('days') : __('day')]) }})</span>
						</div>
					@endif
				</div>

				@if($post->isPublished() && $dateDiffForArchiving <= 30)
					<a href="{{ route('space.posts.extend-offer', ['post' => $post->slug]) }}" class="flex flex-row justify-center items-center gap-x-2 font-bold text-sm hover:underline hover:underline-offset-4">
						{{ __('Extend the publication period') }}

						<svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.48828 1.47559L5.85192 5.47559L1.48828 9.47559" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				@endif
			@endif
		</div>

		<div class="w-full">
			<hr class="w-full hpx border-t border-breeder-deepblue bg-breeder-deepblue">
	
			<livewire:front.space.stats :element="$post" />
	
			<hr class="w-full hpx border-t border-breeder-deepblue bg-breeder-deepblue">
		</div>

		@include('components.front.space.posts.details.'.$post->type->getTranslation('slug', 'en'))

		<x-front.modal name="add_photo" :class="'w-full max-w-2xl'" focusable>
			<form id="uppyUploadForm" x-on:uploaded.window="setTimeout(()=>{ uppy.cancelAll(); $dispatch('close')}, 2000)" class="mt-6">
				@csrf

				<input type="hidden" id="uppyUploaderCollection" x-model="uppyUploaderCollection" />

				<div id="uppyUploader"></div>
			</form>
		</x-front.modal>

		<x-front.modal name="delete_photo" :class="'w-full max-w-xl'" focusable>
			<section class="p-10 flex flex-col flex-wrap content-center">
				<header class="flex flex-col flex-wrap content-center">
					<p class="mt-1 text-sm m-auto text-breeder-deepblue">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
						</svg>
					</p>

					<h2 class="text-lg font-semibold">
						{{ __('Are you sure you want to delete this image ?') }}
					</h2>
				</header>

				<div class="mt-6 flex flex-row flex-wrap justify-center">
					<x-front.secondary-button x-data="" x-on:click="$dispatch('close');" :class="'mr-6'">
						{{ __('Cancel') }}
					</x-front.secondary-button>

					<x-front.primary-button x-on:click="$dispatch('close'); setTimeout(()=>{ window.Livewire.dispatch('deleteMedia'+uppyUploaderCollection, { collection : uppyUploaderCollection, mediaId: uppyUploaderMediaId})}, 100)">
						{{ __('Delete') }}
					</x-front.primary-button>
				</div>
			</section>
		</x-front.modal>

		<x-front.modal name="unpublish-modal" :class="'w-full max-w-2xl'" focusable>
			<div class="space-y-8">
				<h2 class="my-6 text-xl text-center font-bold">
					{{ __('Are you sure you wish to unpublish your post ?') }}
				</h2>

				<div class="flex flex-row justify-between">
					<x-front.secondary-button x-on:click="$dispatch('close');" :class="'flex justify-center mt-4 s:mt-0'">
						{{ __('Cancel') }}
					</x-front.secondary-button>

					<a href="{{ route('space.posts.unpublish', ['post' => $post->slug]) }}">
						<x-front.primary-button>
							{{ __('Unpublish') }}
						</x-front-primary-button>
					</a>
				</div>
			</div>
		</x-front.modal>

		<x-front.modal name="delete-modal" :class="'w-full max-w-2xl'" focusable>
			<div class="space-y-8">
				<h2 class="my-6 text-xl text-center font-bold">
					{{ __('Are you sure you wish to delete your post ?') }}
				</h2>

				<div class="flex flex-row justify-between">
					<x-front.secondary-button x-on:click="$dispatch('close');" :class="'flex justify-center mt-4 s:mt-0'">
						{{ __('Cancel') }}
					</x-front.secondary-button>

					<form method="post" action="{{ route('space.posts.destroy', ['post' => $post->slug]) }}">
						@method('delete')
						@csrf

						<x-front.primary-button>
							<div class="flex flex-row justify-center items-center gap-x-2 px-2 font-bold text-sm">
								<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 4.71693H2.77778M2.77778 4.71693H17M2.77778 4.71693V17.1614C2.77778 17.6329 2.96508 18.0851 3.29848 18.4185C3.63187 18.7519 4.08406 18.9392 4.55556 18.9392H13.4444C13.9159 18.9392 14.3681 18.7519 14.7015 18.4185C15.0349 18.0851 15.2222 17.6329 15.2222 17.1614V4.71693M5.44444 4.71693V2.93915C5.44444 2.46766 5.63175 2.01547 5.96514 1.68208C6.29854 1.34868 6.75073 1.16138 7.22222 1.16138H10.7778C11.2493 1.16138 11.7015 1.34868 12.0349 1.68208C12.3683 2.01547 12.5556 2.46766 12.5556 2.93915V4.71693M7.22222 9.16138V14.4947M10.7778 9.16138V14.4947" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

								{{ __('Delete') }}
							</div>
						</x-front-primary-button>
					</form>
				</div>
			</div>
		</x-front.modal>
	</div>
</x-space-layout>
