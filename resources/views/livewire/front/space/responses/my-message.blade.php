<div class="md:max-h-[930px] w-full">
	@if(!$response->exists)
		<div class="grow flex flex-col items-center md:rounded-l-md lg:rounded-md bg-white my-3">
			<div class="my-6 text-center text-breeder-deepblue">
				<svg width="27" height="28" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M24.1087 20.512C25.3043 18.599 26 16.349 26 13.925C26 7.02287 20.4021 1.42505 13.5 1.42505C6.59779 1.42505 1 7.02287 1 13.925C1 20.8272 6.59779 26.425 13.5 26.425C15.9239 26.425 18.1739 25.7294 20.0869 24.5337L26 26.425L24.1087 20.512Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					<path d="M8.6084 11.2078H18.391" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					<path d="M8.6084 16.6426H15.1301" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
			</div>

			@if(!$applications && !$applicants)
				<h2 class="my-6 text-xl text-center font-bold text-breeder-deepblue">
					{{ __('You don\'t have any message yet') }}
				</h2>

				<div class="my-6 text-center">
					<a href="{{ route('home') }}">
						<x-front.primary-button type="button">
							{{ __('Find a post') }}
						</x-front.primary-button>
					</a>
				</div>
			@elseif($applications || $applicants)
				<h2 class="my-6 text-xl text-center font-bold text-breeder-deepblue">
					{{ __('Select a conversation to start chatting') }}
				</h2>
			@endif
		</div>
	@else
		<div class="md:grow max-md:order-last rounded-xl border border-breeder-greige bg-white w-full md:h-full md:max-h-[930px] flex flex-col mb-8">
			<div class="flex flex-col gap-4 rounded-t-xl">
				@include('components.front.space.responses.header-info')
			</div>

			<div {{-- wire:poll.5s.visible="refreshConversation" --}} class="flex flex-col p-6 md:max-h-[760px]">
				@if($response->type->value != 'figo' && $response->type->value != 'eleveurs-online')
					@if($appointment && !$appointmentPassed)
						<div class="flex flex-row justify-between items-center w-full bg-breeder-blue text-breeder-deepblue rounded-xl px-4 py-2">
							<div class="flex flex-row items-center gap-x-1">
								<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.5833 0.75V3.75M4.91667 0.75V3.75M0.75 6.75H15.75M2.41667 2.25H14.0833C15.0038 2.25 15.75 2.92157 15.75 3.75V14.25C15.75 15.0784 15.0038 15.75 14.0833 15.75H2.41667C1.49619 15.75 0.75 15.0784 0.75 14.25V3.75C0.75 2.92157 1.49619 2.25 2.41667 2.25Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

								{!! __(':typeAppointment appointment the <strong>:date</strong> at <strong>:hour</strong>', ['typeAppointment' => strtolower(__($appointment->type->inHuman())), 'date' => $appointment->date->translatedFormat('l d F'), 'hour' => $appointment->values->get('start_hour')]) !!}
							</div>

							@if($situation == 'answerer')
								<div class="flex flex-row gap-x-2">
									<a href="{{ route('space.appointments.my-appointments', ['appointment' => $appointment->id]) }}" title="{{ __('Update the appointment') }}">
										<svg width="18" height="18" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M7.7093 2.5814H2.49096C2.09553 2.5814 1.7163 2.73848 1.43669 3.01809C1.15708 3.2977 1 3.67693 1 4.07235V14.509C1 14.9045 1.15708 15.2837 1.43669 15.5633C1.7163 15.8429 2.09553 16 2.49096 16H12.9276C13.3231 16 13.7023 15.8429 13.9819 15.5633C14.2615 15.2837 14.4186 14.9045 14.4186 14.509V9.2907M13.3004 1.46318C13.597 1.16661 13.9992 1 14.4186 1C14.838 1 15.2402 1.16661 15.5368 1.46318C15.8334 1.75975 16 2.16198 16 2.5814C16 3.00081 15.8334 3.40304 15.5368 3.69961L8.45478 10.7817L5.47287 11.5271L6.21835 8.54522L13.3004 1.46318Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>

									<div x-on:click.prevent="$dispatch('open-modal', 'cancel-appointment-modal');" title="{{ __('Cancel the appointment') }}" class="cursor-pointer">
										<svg width="18" height="18" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M1 4H2.66667M2.66667 4H16M2.66667 4V14.5C2.66667 14.8978 2.84226 15.2794 3.15482 15.5607C3.46738 15.842 3.89131 16 4.33333 16H12.6667C13.1087 16 13.5326 15.842 13.8452 15.5607C14.1577 15.2794 14.3333 14.8978 14.3333 14.5V4M5.16667 4V2.5C5.16667 2.10218 5.34226 1.72064 5.65482 1.43934C5.96738 1.15804 6.39131 1 6.83333 1H10.1667C10.6087 1 11.0326 1.15804 11.3452 1.43934C11.6577 1.72064 11.8333 2.10218 11.8333 2.5V4M6.83333 7.75V12.25M10.1667 7.75V12.25" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>

									@include('components.front.space.responses.cancel-appointment-modal')
								</div>
							@endif
						</div>
					@endif

					@if($messages->isNotEmpty())
						<div class="flex flex-col space-y-4 mt-4 h-[60%] overflow-y-scroll" x-data>
							@foreach($messages as $message)
								@if($message->user_id == $fromUser->id)
									@if($message->automated && $message->values && $message->values->has($situation))
										<div class="flex flex-wrap gap-x-1 justify-center w-full text-breeder-deepblue p-4 text-sm">
											{!! $message->values->get($situation) !!}
										</div>
									@else
										<div class="flex flex-row-reverse gap-x-3 items-center">
											<div class="flex flex-col max-w-sm gap-y-2 lg:w-full lg:max-w-[470px] items-end">
												<span class="text-sm text-breeder-deepblue font-medium">
													@if($loop->first)
														@if($response->values->has('message') && $message->body != $response->values->get('message'))
															{{ $message->created_at->format('d/m/Y - H:i:s') }}
														@else
															{{ $response->created_at->format('d/m/Y - H:i:s') }}
														@endif
													@else
														{{ $message->created_at->format('d/m/Y - H:i:s') }}
													@endif
												</span>

												@if($message->body)
													<div class="rounded-lg bg-breeder-deepblue p-4 text-sm xl:text-base text-breeder-cream">
														@if($message->automated)
															{!! $message->body !!}
														@else
															{!! nl2br(e($message->body)) !!}
														@endif

														@if($loop->first && $response->hasDataToShow($type, $message->body))
															@include('components.front.space.responses.response-data')
														@endif
													</div>
												@endif

												@if($message->file)
													<a href="{{ route('documents.show', ['filename' => $message->file]) }}" target="_blank" class="flex gap-x-2 text-breeder-deepblue underline underline-offset-4">
														<svg width="18" height="20" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M22.8421 11.7954L14.0902 3.04052C11.0372 -0.0135062 6.09274 -0.0135062 3.03974 3.04052C-0.0132481 6.09454 -0.0132481 11.0407 3.03974 14.0947L13.1041 24.1624C15.2202 26.2792 18.6521 26.2792 20.7682 24.1624C22.8842 22.0457 22.8842 18.6125 20.7682 16.4958L12.5918 8.31661C11.3776 7.10202 9.40542 7.09851 8.18774 8.31661C6.97356 9.5312 6.97356 11.504 8.18774 12.7221L15.0868 19.6235" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
														</svg>

														{{ __('Open the file') }}
													</a>
												@endif

												<div class="flex flex-row text-xs text-gray-500">
													@if($message->is_read)
														{{ __('Read the :date', ['date' => $message->updated_at->format('d/m/Y H:i:s')]) }}
													@else
														{{ __('Not read message') }}
													@endif
												</div>
											</div>
										</div>
									@endif
								@else
									{{-- Messages I've sent --}}
									@if($message->automated && $message->values && $message->values->has($situation))
										<div class="flex flex-wrap gap-x-1 justify-center w-full text-breeder-deepblue p-4 text-sm">
											{!! $message->values->get($situation) !!}
										</div>
									@else
										<div class="flex flex-row gap-x-3 items-end">
											<div class="shrink-0">
												<div class="w-[46px] h-[46px] bg-white rounded-full flex justify-center items-center">
													@if($photo = $toUser->getFirstMedia('avatar'))
														<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $toUser->name }}" class="object-cover w-[46px] h-[46px] rounded-full" />
													@else
														<img src="{{ asset('storage/default-card-image.png') }}" alt="{{ $toUser->name }}" class="object-cover w-[46px] h-[46px] rounded-full" />
													@endif
												</div>
											</div>

											<div class="flex flex-col max-w-sm gap-y-2 lg:w-full lg:max-w-[470px]">
												<span class="text-sm text-breeder-deepblue font-medium">
													@if($loop->first)
														@if($response->values->has('message') && $message->body != $response->values->get('message'))
															{{ $message->created_at->format('d/m/Y - H:i:s') }}
														@else
															{{ $response->created_at->format('d/m/Y - H:i:s') }}
														@endif
													@else
														{{ $message->created_at->format('d/m/Y - H:i:s') }}
													@endif
												</span>

												@if($message->body)
													<div class="rounded-lg bg-breeder-cream text-sm xl:text-base text-breeder-deepblue p-4">
														@if($message->automated)
															{!! $message->body !!}
														@else
															{!! nl2br(e($message->body)) !!}
														@endif

														@if($loop->first && $response->hasDataToShow($type, $message->body))
															@include('components.front.space.responses.response-data')
														@endif
													</div>
												@endif

												@if($message->file)
													<a href="{{ route('documents.show', ['filename' => $message->file]) }}" target="_blank" class="flex gap-x-2 text-breeder-deepblue underline underline-offset-4">
														<svg width="18" height="20" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M22.8421 11.7954L14.0902 3.04052C11.0372 -0.0135062 6.09274 -0.0135062 3.03974 3.04052C-0.0132481 6.09454 -0.0132481 11.0407 3.03974 14.0947L13.1041 24.1624C15.2202 26.2792 18.6521 26.2792 20.7682 24.1624C22.8842 22.0457 22.8842 18.6125 20.7682 16.4958L12.5918 8.31661C11.3776 7.10202 9.40542 7.09851 8.18774 8.31661C6.97356 9.5312 6.97356 11.504 8.18774 12.7221L15.0868 19.6235" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
														</svg>

														{{ __('Open the file') }}
													</a>
												@endif
											</div>
										</div>
									@endif
								@endif
							@endforeach

							<div x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'end' })"></div>
						</div>
					@else
						<p class="text-breeder-deepblue font-medium mt-4">
							{{ __('No message have been sent yet, start the conversation !') }}
						</p>
					@endif

					<div class="pt-6">
						<div class="flex flex-col gap-y-2">
							@if($response->state->value != 'closed')
								<div class="flex flex-row gap-2">
									<textarea rows="4" wire:model.lazy="newMessage" placeholder="{{ __('Write a message') }}" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md text-breeder-deepblue placeholder:text-breeder-greige mt-1 block w-full"></textarea>
								</div>

								<div class="flex flex-col gap-2">
									@error('newMessage')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror

									@error('file')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div class="flex items-center gap-x-2">
									<div>
										<input type="file" wire:model="file" id="fileUpload" class="hidden" />
										<label for="fileUpload" class="cursor-pointer w-[202px] h-[45px] rounded-full flex justify-center items-center gap-2 font-bold text-sm border border-breeder-deepblue hover:bg-breeder-deepblue hover:text-breeder-cream text-breeder-deepblue">
											<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M16.75 7.81905L10.4115 2.21593C8.20041 0.261356 4.61943 0.261356 2.40833 2.21593C0.197225 4.17051 0.197225 7.33602 2.40833 9.2906L9.69735 15.734C11.2299 17.0887 13.7154 17.0887 15.248 15.734C16.7805 14.3792 16.7805 12.182 15.248 10.8273L9.32629 5.59263C8.44693 4.81529 7.01861 4.81305 6.13671 5.59263C5.25735 6.36997 5.25735 7.63258 6.13671 8.41216L11.1333 12.8291" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
											</svg>

											{{ __('Attach a file') }}
										</label>
									</div>

									@if($file)
										<span class="mr-2 text-sm text-breeder-deepblue block">
											{{ $file->getClientOriginalName() }}
										</span>
									@endif
								</div>
							@endif

							<div class="flex flex-row justify-between items-center mt-2">
								@if(($situation == 'asking' && data_get($response->values, 'archive.asking') === false) || ($situation == 'answerer' && data_get($response->values, 'archive.answerer') === false))
									<div x-on:click.prevent="$dispatch('open-modal', 'archive-conversation-modal');" class="flex flex-row gap-x-2 items-center text-breeder-deepblue font-bold cursor-pointer">
										<svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M7.5 0.5L7.5 4.50001" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M0.5 4.5L14.5 4.5L14.5 12.5C14.5 12.7652 14.3865 13.0196 14.1846 13.2071C13.9826 13.3946 13.7087 13.5 13.4231 13.5L1.57692 13.5C1.2913 13.5 1.01739 13.3946 0.815424 13.2071C0.613462 13.0196 0.500001 12.7652 0.500001 12.5L0.5 4.5Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M0.5 4.50001L2.11538 1.61C2.28953 1.28427 2.55603 1.0088 2.8862 0.813215C3.21638 0.617632 3.59773 0.509344 3.98923 0.5L11.0108 0.499999C11.4115 0.500196 11.8041 0.604187 12.1448 0.800279C12.4853 0.996371 12.7601 1.27679 12.9385 1.61L14.5 4.50001" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M10.1893 7L6.96244 11L4.80859 9.50182" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('Archive the conversation') }}
									</div>

									<x-front.modal name="archive-conversation-modal" :class="'w-full max-w-2xl'" focusable>
										<div class="space-y-8 text-breeder-deepblue">
											<div class="flex flex-col">
												<x-front.space-title :class="'mb-4'">
													{{ __('Archive the conversation') }}
												</x-front.space-title>

												<span>
													{{ __('Are you sure to archive this conversation ?') }}
												</span>
											</div>

											<div class="flex flex-row justify-between">
												<x-front.secondary-button x-on:click="$dispatch('close');" :class="'flex justify-center mt-4 s:mt-0'">
													<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M6.42547 12.0745L11.5745 6.92545M6.42547 6.92545L11.5745 12.0745M17 9.5C17 13.9183 13.4183 17.5 9 17.5C4.58172 17.5 1 13.9183 1 9.5C1 5.08172 4.58172 1.5 9 1.5C13.4183 1.5 17 5.08172 17 9.5Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>

													{{ __('Cancel') }}
												</x-front.secondary-button>

												<x-front.primary-button wire:click="archiveConversation" @click="document.body.style.overflow = 'auto';" @conversation-archived.window="$dispatch('close');" :class="'flex justify-center mt-4 s:mt-0'">
													<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M12.5491 2.32909C11.48 1.79818 10.2727 1.5 9 1.5C4.57818 1.5 1 5.07818 1 9.5C1 13.9218 4.57818 17.5 9 17.5C13.4218 17.5 17 13.9218 17 9.5C17 8.47455 16.8036 7.49273 16.4545 6.59091M5.36364 9.5L8.27273 12.4091L17 1.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>

													{{ __('Confirm') }}
												</x-front.primary-button>
											</div>
										</div>
									</x-front.modal>
								@endif

								@if($response->state->value != 'closed')
									<x-front.primary-button wire:click="send" @click="document.body.style.overflow = 'auto';
										if ({{ $messages->isEmpty() ? 'true' : 'false' }}) {
												pushContactEvent('non_renseignee');
											}">
										{{ __('Send') }}
									</x-front.primary-button>
								@endif
							</div>
						</div>
					</div>

					@if($situation == 'answerer')
						@if($showAutomaticMessageTemplatesModal)
							<livewire:front.space.responses.mail-templates
								:response="$response"
								:model="$model"
								:key="'mail-templates'" />
						@endif
					@endif

					@if($situation == 'asking')
						@if($showCommentModal)
							<div x-data="{}" x-init="$nextTick(() => { $dispatch('open-modal', 'comment-modal') })">
								<x-front.modal name="comment-modal" :class="'w-full max-w-2xl'" focusable>
									<div class="space-y-8 text-breeder-deepblue">
										<livewire:front.comments.comments
											:target="$response->to->company"
											:source="$response->from"
											:inModal="true"
											:case="'user-about-company'"
											:key="'comments-component'" />
									</div>
								</x-front.modal>
							</div>
						@endif
					@endif
				@else
					<div class="flex flex-row gap-x-3 items-end">
						<div class="shrink-0">
							<div class="w-[46px] h-[46px] bg-white rounded-full flex justify-center items-center">
								<img src="{{ $response->type->value == 'figo' ? asset('storage/assuropoil-logo.png') : asset('storage/eleveurs_online.jpg') }}" alt="{{ $toUser->name }}" class="object-cover w-[46px] h-[46px] rounded-full" />
							</div>
						</div>

						<div class="flex flex-col max-w-sm gap-y-2 lg:w-full lg:max-w-[470px]">
							<div class="flex flex-col space-y-4 mt-4 max-h-[700px] overflow-y-scroll" x-data>
								@if($messages->isNotEmpty())
									@foreach($messages as $message)
										<div class="flex flex-row-reverse gap-x-3 items-center">
											<div class="flex flex-col max-w-sm gap-y-2 lg:w-full lg:max-w-[470px] items-end">
												<span class="text-sm text-breeder-deepblue font-medium">
													{{ $message->created_at->format('d/m/Y - H:i:s') }}
												</span>

												<div class="rounded-lg bg-breeder-deepblue p-4 text-sm xl:text-base text-breeder-cream">
													{!! $message->body !!}
												</div>

												<div class="flex flex-row text-xs text-gray-500">
													@if($message->is_read)
														{{ __('Read the :date', ['date' => $message->updated_at->format('d/m/Y H:i:s')]) }}
													@else
														{{ __('Not read message') }}
													@endif
												</div>
											</div>
										</div>
									@endforeach

									<div x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'end' })"></div>
								@elseif($response->type->value == 'figo')
									<div class="rounded-lg bg-breeder-cream px-6 py-4 text-sm xl:text-base text-breeder-deepblue">
										<div class="flex flex-col gap-y-2">
											<span class="font-bold">
												{{ __('Congratulations for your reservation !') }}
											</span>

											<span>
												{{ __('Your new companion is waiting for you... What if you were already thinking about his health ?') }}
											</span>

											<span>
												{{ __('Assur O\'Poil, the health insurance recommended by Éleveurs Online, accompanies you from the start with advice, tips and exclusive offers.') }}
											</span>

											<form id="figo" action="{{ route('api-assuropoil') }}" method="POST" class="my-4" target="_blank">
												@csrf

												<input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}" />
												<input type="hidden" name="from" value="eol-conversation-message" />

												<x-front.primary-button>
													{{ __('I want to protect my pet') }}
												</x-front.primary-button>
											</form>
										</div>
									</div>

									<div x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'end' })"></div>
								@endif
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	@endif
</div>
