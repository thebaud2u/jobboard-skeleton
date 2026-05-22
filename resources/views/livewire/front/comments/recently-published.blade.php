<div>
	@if($withModeration && $commentsWaitingModeration->isNotEmpty())
		<div class="flex flex-col gap-y-6 mb-6">
			@foreach($commentsWaitingModeration as $commentWaitingModeration)
				<div class="flex flex-col p-6 gap-4 bg-jobboard-darkviolet rounded-xl">
					<div class="flex flex-row text-sm p-3 gap-2 bg-jobboard-violet justify-between rounded-xl font-bold">
						<div class="flex flex-row items-center gap-3 pl-2">
							<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11 6.89844V10.8984M11 14.8984H11.01M21 10.8984C21 16.4213 16.5228 20.8984 11 20.8984C5.47715 20.8984 1 16.4213 1 10.8984C1 5.37559 5.47715 0.898438 11 0.898438C16.5228 0.898438 21 5.37559 21 10.8984Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

							{{ __('New comment') }}
						</div>

						<div class="flex flex-row gap-3">
							<div class="flex flex-row gap-1 items-center cursor-pointer" wire:click="publishComment({{ $commentWaitingModeration->id }})">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.1055 1.62389C10.17 1.15935 9.11364 0.898437 8 0.898437C4.13091 0.898437 1 4.02935 1 7.89844C1 11.7675 4.13091 14.8984 8 14.8984C11.8691 14.8984 15 11.7675 15 7.89844C15 7.00116 14.8282 6.14207 14.5227 5.35298M4.81818 7.89844L7.36364 10.4439L15 0.898436" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

								{{ __('Accept') }}
							</div>

							<div class="flex flex-row gap-1 items-center cursor-pointer" wire:click="denyComment({{ $commentWaitingModeration->id }})">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.74729 9.99024L10.2527 5.80661M5.74729 5.80661L10.2527 9.99024M15 7.89844C15 11.4883 11.866 14.3984 8 14.3984C4.13401 14.3984 1 11.4883 1 7.89844C1 4.30859 4.13401 1.39844 8 1.39844C11.866 1.39844 15 4.30859 15 7.89844Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

								{{ __('Deny') }}
							</div>
						</div>
					</div>

					<div class="flex flex-row items-center gap-x-2">
						<div class="w-[74px] h-[74px] bg-white rounded-xl flex justify-center items-center shadow-[0_0_20px_0_rgba(0,44,106,0.2)]">
							@if($photo = $commentWaitingModeration->source->getFirstMedia('avatar'))
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $commentWaitingModeration->source->name }}" class="object-cover w-[74px] h-[74px] rounded-xl" />
							@else
								<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $commentWaitingModeration->source->name }}" class="object-cover w-[74px] h-[74px] rounded-xl" />
							@endif
						</div>

						<div class="flex flex-row gap-x-1 font-bold">
							{{ $commentWaitingModeration->source->name }}
						</div>
					</div>

					<div class="flex bg-jobboard-lightcream p-6 rounded-xl">
						{{ $commentWaitingModeration->content }}
					</div>
				</div>
			@endforeach
		</div>
	@endif

	@if($comments->isNotEmpty())
		<div x-data="{}" class="flex justify-center items-stretch w-full @if($source != 'reply' && !$isMyCompany) py-4 @endif @if($countForSubComponent > 1) pl-6 pt-6 @endif">
			<div class="flex flex-col gap-y-4 w-full">
				@if($source == 'user' && !$isMyCompany)
					<div class="flex flex-row text-[28px] font-bold mt-6 mb-4 gap-x-2">
						{{ __('They trusted them') }}
					</div>
				@endif

				@if($source != 'reply' && !$isMyCompany)
					<div class="flex flex-row gap-2 font-bold">
						<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M19.487 16.2364C20.4435 14.7059 21 12.9059 21 10.9668C21 5.44506 16.5217 0.966797 11 0.966797C5.47824 0.966797 1 5.44506 1 10.9668C1 16.4885 5.47824 20.9668 11 20.9668C12.9391 20.9668 14.7391 20.4103 16.2696 19.4538L21 20.9668L19.487 16.2364Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M7.08594 8.79297H14.912" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M7.08594 13.1406H12.3033" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						@if($source != 'user')
							{{ __(':x :word', ['x' => $countComments, 'word' => $countComments > 1 ? __('comments') : __('comment')]) }}

							@if($source == 'company')
								{{ __('of breeders') }}
							@endif
						@elseif($source == 'user')
							{{ __(':x :word', ['x' => $countComments, 'word' => $countComments > 1 ? __('comments') : __('comment')]) }}
						@endif
					</div>
				@endif

				@foreach($comments as $comment)
					@if(!$isMyCompany)
						<hr />
					@endif

					<div class="flex flex-col gap-y-2 @if($isMyCompany) rounded-xl border border-jobboard-greige p-6 @endif">
						<div class="flex flex-row justify-between items-center">
							<div class="flex flex-row items-center gap-x-2">
								@if($logo = $source == 'company' ? $comment->source->getFirstMedia('logo') : $comment->source->getFirstMedia('avatar'))
									<img src="{{ $logo->getAvailableUrl(['optimized']) }}" alt="{{ $comment->source->name }}" class="inline-block object-cover w-[50px] h-[50px] rounded-full">
								@else
									<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $comment->source->name }}" class="inline-block object-cover w-[50px] h-[50px] rounded-full">
								@endif

								<span class="font-bold">
									{{ $comment->source->name }}
								</span>

								<span class="font-bold">
									&middot;
								</span>

								<span class="text-sm">
									{{ $comment->created_at->diffForHumans() }}
								</span>
							</div>

							@if($source == 'company' || ($comment->source->hasRole(['individual_breeder', 'professionnal_breeder'])))
								@php
									if($source == 'company') $company = $comment->source;
									elseif($comment->source->hasRole(['individual_breeder', 'professionnal_breeder'])) $company = $comment->source->company;
								@endphp
								<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}">
									<x-front.secondary-button>
										{{ __('Show the company') }}
									</x-front.secondary-button>
								</a>
							@endif
						</div>

						<div class="flex flex-row">
							{{ $comment->content }}
						</div>

						<div x-data="{ deploy: false }">
							<div class="flex flex-row gap-x-2 items-center @if(!$isMyCompany) justify-between @else justify-end @endif">
								@php
									$canReply = false;
								@endphp

								@if(!$isMyCompany)
									<div class="flex flex-row gap-x-2">
										<span class="flex flex-row gap-x-2 items-center cursor-pointer" wire:click="like({{ $comment->id }})">
											<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M4.08985 13.233L1 13.233L1 5.99564L3.93016 5.99564C4.36772 5.99564 4.7949 5.85028 5.10803 5.57104C6.37093 4.43876 7.8018 1.80698 8.34511 1.24658C8.58981 0.980723 8.92575 0.97881 9.14971 1.01898C9.15386 1.01898 9.15801 1.01898 9.16216 1.02089C10.7174 1.35369 10.0746 3.6431 9.49188 4.79833C9.24718 5.23441 9.59141 5.75656 10.1244 5.75656L13.4734 5.75656C14.5248 5.75656 15.261 6.71479 14.9126 7.62903L12.8762 12.971C12.6419 13.5869 12.0094 14 11.3002 14L7.32899 14C6.63844 14 5.95411 13.8852 5.30919 13.6596L4.08777 13.233L4.08777 6.07788" stroke="#0E1954" stroke-width="1.5" stroke-miterlimit="10"/>
											</svg>

											{{ $comment->likes->count() }}
										</span>


										@if($source != 'company' && Auth::guard('web')->check())
											@php
												$currentUser = Auth::guard('web')->user();

												if(
													($comment->source->hasRole('adopter') && ($currentUser->hasRole(['individual_breeder', 'professionnal_breeder']) && $currentUser->company?->breeds()->where('slug', $target->slug)->first())) ||
													($comment->source->hasRole(['individual_breeder', 'professionnal_breeder']) && $currentUser->hasRole('adopter'))
												) {

													if($currentUser->hasCommentWaitingModeration($comment)) $canReply = false;
													else $canReply = true;
												}
											@endphp
											@if($canReply)
												<div class="flex flex-row gap-2 font-bold cursor-pointer" x-on:click="deploy = !deploy">
													<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M19.487 16.2364C20.4435 14.7059 21 12.9059 21 10.9668C21 5.44506 16.5217 0.966797 11 0.966797C5.47824 0.966797 1 5.44506 1 10.9668C1 16.4885 5.47824 20.9668 11 20.9668C12.9391 20.9668 14.7391 20.4103 16.2696 19.4538L21 20.9668L19.487 16.2364Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M7.08594 8.79297H14.912" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M7.08594 13.1406H12.3033" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>

													{{ __('Reply') }}
												</div>
											@else
												@if($currentUser->id != $comment->source->id && !$isMyCompany)
													{{ __('Your comment will be moderated by our team within 24h.') }}
												@endif
											@endif
										@endif
									</div>
								@endif

								@if($withModeration)
									<div class="flex flex-row gap-2 font-bold cursor-pointer items-center" wire:click="denyComment({{ $comment->id }})">
										<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M1 4.23172L2.55556 4.23172M2.55556 4.23172L15 4.23171M2.55556 4.23172L2.55556 15.1206C2.55556 15.5332 2.71944 15.9288 3.01117 16.2205C3.30289 16.5123 3.69855 16.6762 4.11111 16.6762L11.8889 16.6762C12.3014 16.6762 12.6971 16.5123 12.9888 16.2205C13.2806 15.9288 13.4444 15.5332 13.4444 15.1206L13.4444 4.23172M4.88889 4.23172L4.88889 2.67616C4.88889 2.2636 5.05278 1.86794 5.3445 1.57622C5.63622 1.28449 6.03188 1.12061 6.44444 1.1206L9.55555 1.1206C9.96811 1.1206 10.3638 1.28449 10.6555 1.57622C10.9472 1.86794 11.1111 2.2636 11.1111 2.67616L11.1111 4.23172M6.44444 8.1206L6.44444 12.7873M9.55556 8.1206L9.55556 12.7873" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('Delete') }}
									</div>
								@endif
							</div>

							@if($canReply)
								<div x-show="deploy" x-transition class="mt-4 flex flex-col gap-y-2">
									<div>
										<div class="flex flex-row">
											<x-front.input-label for="replyContent" :value="__('My reply')" :required="true" />
										</div>

										<textarea id="replyContent" rows="5" wire:model="replyContent" class="border-jobboard-greige focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md text-jobboard-deepblue placeholder:text-jobboard-greige mt-1 block w-full"></textarea>

										@error('replyContent')
											<span class="error text-danger-700">
												{{ $message }}
											</span>
										@enderror
									</div>

									<div class="flex flex-row justify-end">
										<x-front.secondary-button wire:click="postReply({{ $comment->id }})" @reply-posted.window="deploy = false">
											{{ __('Publish') }}
										</x-front.secondary-button>
									</div>
								</div>
							@endif

							@if($comment->getCommentsReceivedPublished()->count() > 0)
								<livewire:front.comments.recently-published
									:target="$comment"
									:source="'reply'"
									:countForSubComponent="$countForSubComponent"
									:key="'replies-to-comment-'.$countForSubComponent" />
							@endif
						</div>
					</div>
				@endforeach
			</div>
		</div>
	@else
		<div class="flex flex-row border p-4 rounded-lg">
			@if($source == 'company')
				{{ __('No company comments yet') }}
			@elseif($source == 'user')
				{{ __('No adopter comments yet') }}
			@endif
		</div>
	@endif
</div>
