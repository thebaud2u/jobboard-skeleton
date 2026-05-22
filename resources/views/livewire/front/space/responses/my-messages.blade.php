<div class="flex flex-col gap-y-2 max-lg:max-h-[300px] h-dvh overflow-hidden py-2 pr-1">
	<div {{-- wire:poll.5m="refreshList" --}} class="flex flex-col gap-y-2 h-dvh overflow-y-scroll md:max-h-[786px]">
		@if($responses->isNotEmpty())
			@foreach($responses as $response)
				@php
					$model = $response->model;
					$smallPhoto = null;

					if($response->to->id == Auth::guard('web')->user()->id) {
						$title = $response->from->name;
						$smallPhoto = $response->from->getFirstMedia('avatar');
					}
					else {
						$response->to->company ? $title = $response->to->company->name : $title = $response->to->name;
						$smallPhoto = $response->to->getFirstMedia('avatar');
					}

					if($response->model instanceof \App\Models\Company || $response->model instanceof \App\Models\ProfessionnalActivity) {
						// Dans le cas d'un éleveur qui prend contact avec un entreprise, on affiche le nom de son entreprise.
						if($response->model instanceof \App\Models\Company && $response->from->company) {
							if($response->to->id == Auth::guard('web')->user()->id) $title = $response->from->company->name;
							else $title = $response->to->company->name;
						}

						if($response->model instanceof \App\Models\ProfessionnalActivity) {
							if($response->to->id == Auth::guard('web')->user()->id) {
								$title = $response->from->name;
								$smallPhoto = $response->from->getFirstMedia('avatar');
							}
							else {
								$title = $response->model->name;
								$smallPhoto = $response->to->getFirstMedia('avatar');
							}
						}

						if($response->model->getFirstMedia('logo')) $photo = $response->model->getFirstMedia('logo');
						else $photo = $response->model->getFirstMedia('photos');

						if($response->from->company) $model = $response->from->company;
						else $model = $response->from;
					}

					if($response->model instanceof \App\Models\Animal) {
						if($response->model->getFirstMedia('photos'.$response->model->id)) $photo = $response->model->getFirstMedia('photos'.$response->model->id);
						else {
							$post = $response->model->getPostFromLitter();

							if($post) $photo = $post->getFirstMedia('photos'.$post->id);
							else $photo = null;
						}

						$model = $response->to->company;
					}
					elseif($response->model instanceof \App\Models\Post) {
						if($response->model->getFirstMedia('photos'.$response->model->id)) $photo = $response->model->getFirstMedia('photos'.$response->model->id);
						else $photo = null;

						// Dans le cas d'un éleveur qui postule à un étalon, on affiche le nom de son entreprise.
						if($response->model->type->getTranslation('slug', 'en') == 'stud' && $response->from->company) {
							if($response->to->id == Auth::guard('web')->user()->id) $title = $response->from->company->name;
							else $title = $response->to->company->name;
						}
					}

					if($response->type->value == 'figo') $title = 'Assur O\'Poil';
					elseif($response->type->value == 'eleveurs-online') $title = 'Eleveurs-Online';

					$lastMessage = null;
					if($response->thread->messages->isNotEmpty()) $lastMessage = $response->thread->messages()->latest('id')->first();

					$unreadMessages = Auth::guard('web')->user()->countResponseUnreadMessages($response);
				@endphp

				<div wire:click="show({{ $response->id }})" title="{{ $title }}" class="block relative group cursor-pointer border-l-2 border-transparent @if($response->id == $activeResponse->id) bg-jobboard-cream @endif hover:border-jobboard-greige hover:bg-jobboard-greige @if($response->isUnavailable() || ($response->isClosed() && ($response->type->value == 'application' || $response->type->value == 'messaging'))) opacity-50 @endif transition duration-200 ease-in-out rounded-xl p-3">
					<div class="flex flex-row">
						<div class="w-[65px] h-[65px] bg-white rounded-xl flex justify-center items-center relative shrink-0">
							@if($response->type->value == 'figo')
								<img src="{{ asset('storage/assuropoil-logo-message.png') }}" alt="Assur O'Poil" class="object-cover w-[65px] h-[65px] rounded-xl" />
							@elseif($response->type->value == 'eleveurs-online')
								<img src="{{ asset('storage/eleveurs_online.jpg') }}" alt="Eleveurs-Online" class="object-cover w-[65px] h-[65px] rounded-xl" />
							@elseif($photo)
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $model->name }}" class="object-cover w-[65px] h-[65px] rounded-xl" />
							@else
								<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $model->name }}" class="object-cover w-[65px] h-[65px] rounded-xl" />
							@endif

							@if($response->type->value != 'figo' && $response->type->value != 'eleveurs-online')
								<div class="absolute w-[40px] h-[40px] rounded-full border border-white -bottom-[8px] -right-[8px]">
									@if($smallPhoto)
										<img src="{{ $smallPhoto->getAvailableUrl(['optimized']) }}" alt="{{ $title }}" class="object-cover w-[40px] h-[40px] rounded-full" />
									@else
										<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $title }}" class="object-cover w-[40px] h-[40px] rounded-full" />
									@endif
								</div>
							@endif
						</div>

						<div class="flex-1 max-w-[calc(100%-3.5rem)] pl-3 text-jobboard-deepblue flex flex-col justify-between">
							<div class="flex flex-row justify-between items-center gap-x-4">
								<div class="max-w-fit text-sm xl:text-base text-jobboard-deepblue font-semibold truncate">
									{{ $title }}
								</div>

								<span class="text-xs font-medium text-jobboard-deepblue">
									{{ $response->updated_at->format('d/m') }}
								</span>
							</div>

							<div class="text-sm truncate font-medium">
								@if($lastMessage)
									@if($response->type->value == 'figo')
										{{ __('Congratulations on your reservation !') }}
									@elseif($response->type->value == 'eleveurs-online')
										{{ __('Informations') }}
									@else
										@php
											if($lastMessage->automated && $lastMessage->values) {
												if($lastMessage->values->has('answerer') && $response->to->id == Auth::guard('web')->user()->id) $text = $lastMessage->values->get('answerer');
												elseif($lastMessage->values->has('asking')) $text = $lastMessage->values->get('asking');
											}
											elseif(is_null($lastMessage->body)) {
												if($response->to->id == Auth::guard('web')->user()->id) $text = __('You\'ve sent a file');
												else $text = __('A file has been sent to you');
											}
											else $text = $lastMessage->body;
										@endphp
										{!! $text !!}
									@endif
								@endif
							</div>

							<div class="flex justify-between items-center">
								@if($response->type->value == 'application')
									<span class="flex flex-row items-center gap-x-2 text-xs">
										@if($response->isReceived())
											{{-- <div class="w-3 h-3 bg-jobboard-blue rounded-full"></div> {{  __('Inquire ongoing') }} --}}
										@elseif(__($response->state->inHuman()) == 'Non disponible')
											{{ __($response->state->inHuman()) }}
										@else
											<div class="w-3 h-3 bg-black rounded-full"></div> {{ __($response->state->inHuman()) }}
										@endif
									</span>
								@else
									<span class="flex flex-row items-center gap-x-2 text-xs font-medium">
										{{ __('Contacted') }}
									</span>
								@endif

								@if($unreadMessages > 0)
									<div class="self-end flex justify-center items-center size-5 rounded-full border-2 bg-red-500 group-hover:bg-red-600 border-white transition duration-150 ease-in-out text-white text-xs font-semibold">
										{{ $unreadMessages }}
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@endif
	</div>
</div>
