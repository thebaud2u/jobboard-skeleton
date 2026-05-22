<div>
	<div class="border-transparent">
		<div class="flex flex-col s:flex-row lg:min-h-[600px] border-transparent">
			<div class="flex-1 border-transparent">
				{{-- @if(Auth::guard('web')->user()->countPostCreditAvailable() > 0)
					<div class="mb-4">
						<span class="mr-1 font-semibold">
							{{ __('Credits available') }} :
						</span>

						@foreach(Auth::guard('web')->user()->getPostCreditAvailable() as $credit)
							<span class="mr-1 font-semibold">
								{{ $credit['offer'] }} : {{ $credit['count'] }} @if($loop->last)@else,@endif
							</span>
						@endforeach
					</div>
				@endif --}}

				@if($posts->isNotEmpty())
					<div class="flex flex-wrap gap-4">
						@foreach($posts as $post)
							<a href="{{ route('space.posts.my-post', ['post' => $post->slug]) }}">
								@include('components.front.space.posts.card')
							</a>
						@endforeach

						<div class="mt-8">
							{!! $posts->links() !!}
						</div>
					</div>

					@if((session('post_published') || session('post_published_modified')) && session('post_type'))
						<div x-data="{}" x-init="$nextTick(() => { $dispatch('open-modal', 'post_published') })">
							<x-front.modal name="post_published" :class="'w-full max-w-2xl text-jobboard-deepblue'" focusable>
								<h1 class="text-[40px] font-bold">
									{{ __('Bravo') }} !
								</h1>

								<div class="flex flex-col gap-y-4 text-base font-medium">
									<span>
										{{ __('You have successfully completed your :element.', ['element' => __('post')]) }}
									</span>

									<span>
										{{ __('You can modify the information of your :element as long as it has not been validated by customer service.', ['element' => __('post')]) }}
									</span>

									<span>
										{{ __(':siteName will check your :element and broadcast it within 24 working days subject to the successful receipt of your payment.', ['siteName' => env('APP_NAME'), 'element' => __('post')]) }}
									</span>
								</div>
							</x-front.modal>
						</div>
					@endif
				@else
					<div class="flex flex-col p-6 gap-y-4 justify-center items-center">
						{{ __('You haven\'t created a post yet') }}

						<a href="{{ route('space.posts.show-offers') }}">
							<x-front.primary-button>
								{{ __('Create a post') }}
							</x-front-primary-button>
						</a>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
