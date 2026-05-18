<x-space-layout>
	@push('seo')
		<title>{{ __('My space') }}</title>
		<meta name="keywords" content="{{ __(':siteName, ', ['siteName' => env('APP_NAME')]) }}" />
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
	@endpush

	@if($company)
		@push('scripts')
			<script src="{!! asset('js/uppy.js') !!}"></script>
		@endpush

		@push('styles')
			<x-front.space.uppy-styles />
		@endpush
	@endif

	<x-slot name="side_menu">
		@include('components.front.space.profile.side-menu')
	</x-slot>

	<div class="flex-1 py-5">
		<div class="w-full bg-white px-6 py-10 mb-6 rounded-md text-breeder-deepblue">
			@if($company)
				@if(session('company_published') || session('company_published_modified'))
					<div x-data="{}" x-init="$nextTick(() => { $dispatch('open-modal', 'company_published') })">
						<x-front.modal name="company_published" :class="'w-full max-w-2xl text-breeder-deepblue'" focusable>
							<h1 class="text-[40px] font-bold">
								{{ __('Bravo') }} !
							</h1>

							<div class="flex flex-col gap-y-4 text-base font-medium">
								<div>
									@if(session('company_published'))
										{{ __(':element has been created successfully', ['element' => __('Your company page')]) }}
									@elseif(session('company_published_modified'))
										{{ __(':element has been updated successfully', ['element' => __('Your company page')]) }}
									@endif
								</div>

								<div>
									{{ __(':element will be validated by our customer service within 24h working days', ['element' => __('Your company page')]) }}
								</div>

								<div>
									{{ __(':element will be published subject to the good reception of your payment', ['element' => __('Your company page')]) }}
								</div>

								<a href="{{ route('space.posts.show-offers') }}">
									<x-front.primary-button>
										{{ __('Create a post') }}
									</x-front.primary-button>
								</a>
							</div>
						</x-front.modal>
					</div>
				@endif

				<div x-data="{uppyUploaderCollection: '', uppyUploaderMediaId: '', isActive : 'myCompany'}" class="flex flex-col gap-y-6">
					<div class="flex flex-row justify-center items-center rounded-full w-[350px] mx-auto">
						<div x-on:click="isActive = 'myCompany'" :class="isActive == 'myCompany' ? '' : 'opacity-50'" class="w-full h-full bg-breeder-deepblue rounded-l-full flex justify-center items-center text-breeder-cream text-sm px-1 py-2 cursor-pointer font-bold">
							{{ __('My company') }}
						</div>

						<div x-on:click="isActive = 'myAnimals'" :class="isActive == 'myAnimals' ? '' : 'opacity-50'" class="w-full h-full bg-breeder-deepblue flex justify-center items-center text-breeder-cream text-sm px-1 py-2 cursor-pointer font-bold">
							{{ __('My animals') }}
						</div>

						<div x-on:click="isActive = 'myComments'" :class="isActive == 'myComments' ? '' : 'opacity-50'" class="w-full h-full bg-breeder-deepblue rounded-r-full flex justify-center items-center text-breeder-cream text-sm px-1 py-2 cursor-pointer font-bold">
							{{ __('Comment') }}
						</div>
					</div>

					<div class="w-full mt-8">
						<div class="flex justify-between items-center flex-wrap" x-show="isActive=='myCompany'">
							<x-front.form-part-title >
								{{ __('My company') }}
							</x-front.form-part-title>

							<div class="flex flex-row gap-2 flex-wrap">
								@if($offerLastPublication->slug != 'page-elevage-master')
									<x-front.secondary-button>
										<a href="{{ route('space.companies.show-offers', ['company' => $company->slug]) }}">
											{{ __('Upgrade my page visibility') }}
										</a>
									</x-front.secondary-button>
								@endif

								@if($lastPublication)
									<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}" target="_blank" class="flex flex-row gap-x-1 items-center">
										<x-front.secondary-button>
											<svg width="28" height="19" viewBox="0 0 28 19" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M27 9.5C27 9.5 22.4783 18 14 18C5.52175 18 1 9.5 1 9.5C1 9.5 5.52175 1 14 1C22.4783 1 27 9.5 27 9.5Z" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
												<path d="M14 14.6004C16.8095 14.6004 19.087 12.317 19.087 9.50039C19.087 6.68374 16.8095 4.40039 14 4.40039C11.1906 4.40039 8.91309 6.68374 8.91309 9.50039C8.91309 12.317 11.1906 14.6004 14 14.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
											</svg>

											{{ __('Visualize my page') }}
										</x-front.secondary-button>
									</a>
								@endif
							</div>
						</div>

						<x-front.form-part-title x-show="isActive=='myAnimals'">
							{{ __('My animals') }}
						</x-front.form-part-title>

						<x-front.form-part-title x-show="isActive=='myComments'">
							{{ __('Comment') }}
						</x-front.form-part-title>

						<hr class="h-px border border-breeder-deepblue w-full my-[30px]">
					</div>

					<div x-show="isActive == 'myCompany'">
						<div class="flex flex-col md:flex-row justify-between md:items-center gap-2">
							<div class="flex flex-row items-center gap-x-2">
								@if($lastPublication->isDraft())
									{{ __('Status : :status', ['status' => __('as draft')]) }} <div class="w-2 h-2 bg-breeder-deepblue rounded-full"></div>
								@elseif($lastPublication->isWaitingToBePublished())
									@if($company->awaitingModeration())
										{{ __('Status : :status', ['status' => __('waiting validation')]) }} <div class="w-2 h-2 bg-breeder-orange rounded-full"></div>
									@elseif($company->lastModeration->isDenied())
										{{ __('Status : :status', ['status' => __('moderation denied, update your company infos and resubmit')]) }} <div class="w-2 h-2 bg-breeder-red rounded-full"></div>
									@elseif($company->breeds->isEmpty())
										{{ __('Status : :status', ['status' => __('waiting update')]) }} <div class="w-2 h-2 bg-breeder-orange rounded-full"></div>
									@endif
								@elseif($lastPublication->isPublished())
									{{ __('Status : :status', ['status' => __('validated')]) }} <div class="w-2 h-2 bg-breeder-green rounded-full"></div>
								@endif
							</div>

							@if(Auth::guard('web')->user()->countCompanyCreditAvailable() > 0)
								<div class="flex flex-col md:flex-row my-2 gap-y-2 font-medium text-sm md:items-center">
									<div class="flex items-center">
										<svg class="mr-2 shrink-0" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M11.9676 25.7002C18.5771 25.7002 23.9352 20.1038 23.9352 13.2002C23.9352 6.29664 18.5771 0.700195 11.9676 0.700195C5.35808 0.700195 0 6.29664 0 13.2002C0 20.1038 5.35808 25.7002 11.9676 25.7002Z" fill="#C68CFF"/>
											<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" fill="#0E1954"/>
											<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" stroke="#0E1954" stroke-miterlimit="10"/>
											<path d="M14.4872 7.54373C14.4872 8.69339 13.5949 9.62536 12.4946 9.62536C11.3943 9.62536 10.502 8.69339 10.502 7.54373C10.502 6.39407 11.3943 5.4621 12.4946 5.4621C13.5949 5.4621 14.4872 6.39407 14.4872 7.54373Z" fill="#0E1954" stroke="#0E1954" stroke-miterlimit="10"/>
										</svg>
				
										<p class="whitespace-nowrap">
											{{ __('Credits available') }} :
										</p>
									</div>

									<div class="flex flex-col md:flex-row md:flex-wrap md:ml-1">
										@foreach(Auth::guard('web')->user()->getCompanyCreditAvailable() as $credit)
											<div class="flex flex-nowrap xseol:flex-row flex-col">
												<span class="font-semibold">
													&nbsp;{{ $credit['count'] }}&nbsp;
												</span>

												@if($credit['offer'] == 'Page entreprise Standard')
													<span class="font-semibold">
														{{ __('standard') }}&nbsp;
													</span>
												@elseif($credit['offer'] == 'Page entreprise Master')
													<span class="font-semibold">
														{{ __('master') }}&nbsp;
													</span>
													({{ __('available until :date', ['date' => $credit['end_date']]) }})
												@elseif($credit['offer'] == 'Page entreprise Premium')
													<span class="font-semibold">
														{{ __('premium') }}&nbsp;
													</span>
													({{ __('available until :date', ['date' => $credit['end_date']]) }})
												@endif

												@if($loop->last)@else<span class="ml-1 hidden md:inline-block">|&nbsp;</span>@endif
											</div>
										@endforeach
									</div>
								</div>
							@endif
						</div>

						@if($lastPublication->isPublished())
							<div class="flex flex-row justify-between w-full text-sm bg-breeder-violet p-4 text-breeder-deepblue rounded-xl mb-4">
								<div class="flex items-center font-medium">
									<svg class="shrink-0 mr-3" width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12.3056 0.75V3.65146M5.19444 0.75V3.65146M0.75 6.55292H16.75M2.52778 2.20073H14.9722C15.9541 2.20073 16.75 2.85025 16.75 3.65146V13.8066C16.75 14.6078 15.9541 15.2573 14.9722 15.2573H2.52778C1.54594 15.2573 0.75 14.6078 0.75 13.8066V3.65146C0.75 2.85025 1.54594 2.20073 2.52778 2.20073Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									<strong>
										{{  __($offer->name) }} &nbsp;
									</strong>

									{{ __('published the : :date', ['date' => $lastPublication->updated_at->format('d/m/Y')]) }}

									@if(!$offer->free && $dateDiffForArchiving > 30)
										<span class="mx-4">></span>

										<span>
											{!! __('end of publication : the <strong>:date</strong>', ['date' => $lastPublication->end_date->format('d/m/Y')]) !!}
										</span>

										&nbsp;

										@php
											$joursRestants = now()->startOfDay()->diffInDays($lastPublication->end_date, false);
										@endphp
										<span class="font-normal italic text-xs">
											({{ trans_choice(':count day remaining|:count days remaining', $joursRestants, ['count' => $joursRestants]) }})
										</span>
									@endif
								</div>


								@if($lastPublication->isPublishedUpgradedWaitingModeration())
									<span>
										{{ __('Upgrade pending to offer : :offer', ['offer' => __($offerLastPublication->name)]) }}
									</span>
								@endif

								@if($isPublished && !$offerLastPublication->free && $dateDiffForArchiving <= 30)
									<div class="flex gap-x-4">
										<span>
											{{ __('Offer end date : :date', ['date' => $lastPublication->end_date->format('d/m/Y')]) }} 
											<span class="font-bold">
												({{ __(':x :dayword left', ['x' => $dateDiffForArchiving, 'dayword' => $dateDiffForArchiving > 1 ? __('days') : __('day')]) }})
											</span>
										</span>
									</div>

									<div>
										<a href="{{ route('space.companies.extend-offer', ['company' => $company->slug]) }}">
											<div class="flex flex-row justify-center items-center gap-x-2 px-2 font-bold text-sm underline">
												{{ __('Extend the offer') }}
											</div>
										</a>
									</div>
								@endif
							</div>
						@endif

						<hr class="w-full hpx border-t border-breeder-deepblue bg-breeder-deepblue">

						<livewire:front.space.stats :element="$company" />

						<hr class="w-full hpx border-t border-breeder-deepblue bg-breeder-deepblue">

						<div class="flex flex-col bg-white gap-y-6 mt-8">
							<div class="flex flex-col gap-y-4 p-4 rounded-xl bg-breeder-cream">
								<div class="flex flex-row justify-between">
									<x-front.space-title>
										{{ __('Presentation') }}
									</x-front.space-title>

									<a href="{{ route('space.companies.update', ['company' => $company->slug]) }}" class="flex gap-x-2 items-center hover:underline hover:underline-offset-4 font-bold text-sm">
										<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M7.7093 2.43149H2.49096C2.09553 2.43149 1.7163 2.58858 1.43669 2.86819C1.15708 3.14779 1 3.52702 1 3.92245V14.3591C1 14.7546 1.15708 15.1338 1.43669 15.4134C1.7163 15.693 2.09553 15.8501 2.49096 15.8501H12.9276C13.3231 15.8501 13.7023 15.693 13.9819 15.4134C14.2615 15.1338 14.4186 14.7546 14.4186 14.3591V9.1408M13.3004 1.31328C13.597 1.01671 13.9992 0.850098 14.4186 0.850098C14.838 0.850098 15.2402 1.01671 15.5368 1.31328C15.8334 1.60985 16 2.01208 16 2.43149C16 2.85091 15.8334 3.25314 15.5368 3.54971L8.45478 10.6318L5.47287 11.3772L6.21835 8.39532L13.3004 1.31328Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>

										{{ __('Update my company') }}
									</a>
								</div>

								<hr>
								
								<div class="flex gap-4 flex-col lg:flex-row">
									@if($photos->isNotEmpty())
										<div class="flex flex-col gap-4 w-full lg:w-[368px] shrink-0">
											@foreach($photos as $index => $photo)
												@if($loop->first)
													<div class="w-full sm:w-[368px] h-[278px] rounded-xl bg-white">
														<img src="{{ $photo->getAvailableUrl(['optimized']) }}" title="{{ __('Photo n°:number', ['number' => $index]) }}" class="rounded-xl object-cover w-full h-full">
													</div>
												@endif
											@endforeach
											@if($photos->count() > 1)
												<div class="flex flex-wrap gap-4 w-full">
													@foreach($photos as $index => $photo)
														@if(!$loop->first)
															<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="" class="rounded-xl object-cover w-[76px] h-[76px]">
														@endif
													@endforeach
												</div>
											@endif
										</div>
									@endif

									<div class="flex flex-col gap-4">
										<div class="flex gap-4 p-4 bg-white">
											@if($logo->isNotEmpty())
												<img src="{{ $logo->first()->getAvailableUrl(['optimized']) }}" title="{{ $company->name }}" class="inline-block object-cover w-[100px] h-[100px] rounded-full shadow-[0_0_10px_0_rgba(0,0,0,0.25)]" />
											@endif

											<div class="flex flex-col gap-4 text-sm pt-4">
												<div class="flex max-sm:flex-wrap">
													<div class="max-w-[120px] font-medium w-full">
														{{ __('Name') }}
													</div>

													<div class="font-bold">
														{{ $company->name }}
													</div>
												</div>

												<div class="flex max-sm:flex-wrap">
													<div class="max-w-[120px] font-medium w-full">
														{{ __('Affixe ou préfixe') }}
													</div>

													<div class="font-bold">
														{{ $company->values->get('affix_name') }}
													</div>
												</div>

												<div class="flex max-sm:flex-wrap">
													<div class="max-w-[120px] font-medium w-full">
														{{ __('Localisation') }}
													</div>

													<div class="font-bold">
														{{ $address }}
													</div>
												</div>

												<div class="flex max-sm:flex-wrap">
													<div class="max-w-[120px] font-medium w-full">
														{{ __('Species') }}
													</div>

													<div class="font-bold capitalize">
														@if($company->species->count() > 1)
															{{ __('Dog & cat') }}
														@elseif($company->species->count() == 1)
															{{ __($company->species->first()?->name) }}
														@endif
													</div>
												</div>

												<div class="flex max-sm:flex-wrap">
													<div class="max-w-[120px] font-medium w-full">
														{{ __('Breeds') }}
													</div>

													<div class="font-bold">
														@foreach($breeds as $slug => $name)
															<span class="">
																{{ ucFirst(__($name)) }}
															</span>

															@if(!$loop->last)&nbsp;|&nbsp;@endif
														@endforeach
													</div>
												</div>

												@if(($company->values->has('dog_facebook') && $company->values->get('dog_facebook') != '') || ($company->values->has('cat_facebook') && $company->values->get('cat_facebook') != ''))
													<div class="flex max-sm:flex-wrap">
														<div class="max-w-[120px] font-medium w-full">
															{{ __('Facebook') }}
														</div>

														<div class="font-bold flex gap-2">
															@if($company->values->has('dog_facebook') && $company->values->get('dog_facebook') != '')
																<a href="{{ $company->values->get('dog_facebook') }}" target="_blank">
																	{{ '@' . Str::afterLast(rtrim($company->values->get('dog_facebook'), '/'), '/') }}
																</a>
															@endif
															@if($company->values->has('cat_facebook') && $company->values->get('cat_facebook') != '')
																<a href="{{ $company->values->get('cat_facebook') }}" target="_blank">
																	{{ '@' . Str::afterLast(rtrim($company->values->get('cat_facebook'), '/'), '/') }}
																</a>
															@endif
														</div>
													</div>
												@endif

												@if(($company->values->has('dog_instagram') && $company->values->get('dog_instagram') != '') || ($company->values->has('cat_instagram') && $company->values->get('cat_instagram') != ''))
													<div class="flex max-sm:flex-wrap">
														<div class="max-w-[120px] font-medium w-full">
															{{ __('Instagram') }}
														</div>

														<div class="font-bold flex gap-2">
															@if($company->values->has('dog_instagram') && $company->values->get('dog_instagram') != '')
																@php
																	preg_match('/instagram\.com\/([a-zA-Z0-9._]+)/', $company->values->get('dog_instagram'), $matches);
																	$handle = isset($matches[1]) ? '@' . $matches[1] : 'Inconnu';
																@endphp

																<a href="{{ $company->values->get('dog_instagram') }}" target="_blank">
																	{{ $handle }}
																</a>
															@endif
															@if($company->values->has('cat_instagram') && $company->values->get('cat_instagram') != '')
																@php
																	preg_match('/instagram\.com\/([a-zA-Z0-9._]+)/', $company->values->get('cat_instagram'), $matches);
																	$handle = isset($matches[1]) ? '@' . $matches[1] : 'Inconnu';
																@endphp

																<a href="{{ $company->values->get('cat_instagram') }}" target="_blank">
																	{{ $handle }}
																</a>
															@endif
														</div>
													</div>
												@endif
											</div>
										</div>

										<div class="font-medium">
											{{ strip_tags($company->description) }}
										</div>
									</div>
								</div>
							</div>

							@if($canDisplayBreeders)
								<div class="border p-4 rounded-lg">
									<livewire:front.animals.breeders.breeders
										:company="$company"
										:create="true"
										:update="true"
										:isDisplayedOnSpaceMyCompany="true"
										:key="'breeder-component'"
									/>
								</div>
							@endif

							<div class="border p-4 rounded-lg">
								<livewire:front.comments.comments
									:case="'company-about-breed'"
									:target="data_get($company->values, 'for_moderation.breeds') ? $company->constructBreedsFromModeration() : $company->breeds"
									:source="$company"
									:create="true"
									:update="true"
									:key="'comments-component'"
								/>
							</div>
						</div>
					</div>

					<div x-show="isActive == 'myAnimals'">
						<livewire:front.space.animals.filters :key="'company-animals-filters-component'" />

						<livewire:front.space.animals.animals
							:source="'company'"
							:company="$company"
							:key="'company-animals-component'" />
					</div>

					<div x-show="isActive == 'myComments'">
						<livewire:front.comments.recently-published
							:target="$company"
							:source="'user'"
							:withModeration="true"
							:key="'company-comments'"
							:isMyCompany="true" />
					</div>

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
				</div>
			@else
				<div class="flex flex-row justify-between items-center mb-8">
					<h1 class="text-[28px] md:text-[40px] font-bold">
						{{ __('My company') }}
					</h1>

					<div x-data="">
						<x-front.primary-button x-on:click.prevent="$dispatch('open-modal', 'show_offers_company');">
							{{ __('Create my company page') }}
						</x-front-primary-button>
					</div>
				</div>

				@if(Auth::guard('web')->user()->countCompanyCreditAvailable() > 0)
					<div class="flex flex-col md:flex-row my-2 gap-y-2 font-medium text-sm md:items-center">
						<div class="flex items-center">
							<svg class="mr-2 shrink-0" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11.9676 25.7002C18.5771 25.7002 23.9352 20.1038 23.9352 13.2002C23.9352 6.29664 18.5771 0.700195 11.9676 0.700195C5.35808 0.700195 0 6.29664 0 13.2002C0 20.1038 5.35808 25.7002 11.9676 25.7002Z" fill="#C68CFF"/>
								<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" fill="#0E1954"/>
								<path d="M8.51367 11.7427H13.8628L12.6741 18.7971C12.6463 18.9655 12.7707 19.1203 12.9361 19.1203H13.8628V20.6679C12.5382 21.6322 8.923 22.0964 9.36836 18.3226L10.467 11.923" stroke="#0E1954" stroke-miterlimit="10"/>
								<path d="M14.4872 7.54373C14.4872 8.69339 13.5949 9.62536 12.4946 9.62536C11.3943 9.62536 10.502 8.69339 10.502 7.54373C10.502 6.39407 11.3943 5.4621 12.4946 5.4621C13.5949 5.4621 14.4872 6.39407 14.4872 7.54373Z" fill="#0E1954" stroke="#0E1954" stroke-miterlimit="10"/>
							</svg>
	
							<p class="whitespace-nowrap">
								{{ __('Credits available') }} :
							</p>
						</div>

						<div class="flex flex-col md:flex-row md:flex-wrap md:ml-1">
							@foreach(Auth::guard('web')->user()->getCompanyCreditAvailable() as $credit)
								<div class="flex flex-nowrap xseol:flex-row flex-col">
									<span class="font-semibold">
										&nbsp;{{ $credit['count'] }}&nbsp;
									</span>
	
									<span class="font-semibold">
										@if($credit['offer'] == 'Page entreprise Master')
											{{ __('master') }}
										@elseif($credit['offer'] == 'Page entreprise Premium')
											{{ __('premium') }}
										@endif
									</span>
	
									@if($loop->last)@else<span class="ml-1 hidden md:inline-block">|&nbsp;</span>@endif
								</div>
							@endforeach
						</div>
					</div>
				@endif

				<div class="flex flex-col p-6 gap-y-6 justify-center items-center w-full bg-breeder-cream h-[337px] rounded-xl">
					<svg width="94" height="83" viewBox="0 0 94 83" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_3255_49587)">
							<path d="M7.33203 71.4752V16.8118C7.33203 15.339 8.53484 14.1497 10.0158 14.1497H20.6382" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M74.3438 14.1497H83.9888C85.4698 14.1497 86.6726 15.339 86.6726 16.8118V71.4715" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M1.62891 76.393V71.4751H35.4355L39.4273 75.3453H54.5752L58.5633 71.4751H92.3774V76.393C92.3774 79.4242 89.9003 81.8851 86.8407 81.8851H7.1656C4.10971 81.8851 1.62891 79.428 1.62891 76.393Z" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20.6367 71.4753V1.11865H74.3423V71.4753" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M38.3956 14.7427H23.2891V29.7275H38.3956V14.7427Z" fill="#FFA244"/>
							<path d="M42.3956 9.74268H27.2891V24.7275H42.3956V9.74268Z" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M50.7188 12.3486H67.5055" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M50.7188 22.125H67.5055" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M71.4317 46.2625H44.3008V65.2517H71.4317V46.2625Z" fill="#C68CFF"/>
							<path d="M67.4317 42.2625H40.3008V61.2517H67.4317V42.2625Z" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M26.6055 47.281H34.1231" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M26.6055 56.2295H34.1231" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M34.1211 33.687H61.1844" stroke="#0E1954" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
						</g>

						<defs>
							<clipPath id="clip0_3255_49587">
								<rect width="93" height="83" fill="white" transform="translate(0.5)"/>
							</clipPath>
						</defs>
					</svg>

					<h2 class="font-bold text-[40px] text-center">
						{{ __('Create my company page') }}
					</h2>

					<p class="font-medium">
						{{ __('To advertise, you need to create a company page.') }}
					</p>

					<div x-data="">
						<x-front.primary-button x-on:click.prevent="$dispatch('open-modal', 'show_offers_company');">
							{{ __('Create my company page') }}
						</x-front-primary-button>
					</div>
				</div>
			@endif
		</div>
	</div>

	<x-front.modal name="show_offers_company" :class="'w-full max-w-screen-xl'" focusable>
		<livewire:front.space.companies.show-offers
			:company="$company ? $company : new \App\Models\Company" />
	</x-front.modal>
</x-space-layout>
