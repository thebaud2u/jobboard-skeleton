<div>
	<div class="py-5 px-4 lg:px-6">
		<div class="flex flex-col s:flex-row">
			<div class="flex-1">
				{{-- <div class="flex flex-row justify-end">
					<x-front.space.space-title>
						{{ __('My saved searches') }}
					</x-front.space.space-title>

					<div class="justify-right">
						<a href="{{ route('posts') }}">
							<x-front.primary-button type="button">
								{{ __('Make a search') }}
							</x-front.primary-button>
						</a>
					</div>
				</div> --}}

				<div wire:key="alert">
					{{-- Flash message --}}
					@if($errors->any() || Session::has('error') || Session::has('success') || Session::has('warning') || Session::has('info'))
						<div class="py-5 px-4 lg:px-6" x-data="{}" x-ref="alert">
							@include('components.front.home.alert-message')
						</div>
					@endif
				</div>

				{{-- <div>{{ Carbon::now()->format('H:i:s') }}</div> --}}

				@if($searches->isNotEmpty())
					<div class="flex flex-col gap-2">
						@foreach($searches as $search)
							<article x-data="{initial:{{ $search->email_alert ? 'true' : 'false' }},active:{{ $search->email_alert ? 'true' : 'false' }}}"
								x-on:mouseenter="active=initial" wire:key="{{ $search->uuid }}"
								class="group relative min-w-[250px] flex flex-col sm:flex-row justify-center sm:items-stretch rounded bg-white opacity-75 hover:opacity-90 hover:bg-gray-50 border border-gray-100 hover:border-gray-200">
								<div class="sm:grow p-4 max-sm:pt-10 sm:pl-12 text-xs lg:text-sm">
									<div class="float-right text-right">
										<a href="#{{ $search->uuid }}" class="opacity-75 hover:opacity-100" title="{{ __('Delete') }}"
											x-on:click.prevent="$dispatch('open-modal','delete-{{ $search->uuid }}')">
											<svg class="size-8" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect y="0.507568" width="40" height="40" rx="20" fill="#FFE7E6"/>
												<path d="M26.9035 16.5652V28.6107C26.9035 29.6582 26.054 30.5075 25.006 30.5075H14.9172C13.8692 30.5075 13.0195 29.6584 13.0195 28.6107V16.5652" stroke="#FF2C2C" stroke-width="1.5" stroke-miterlimit="10"/>
												<path d="M13.1623 13.3354H26.834C27.5316 13.3354 28.0981 13.9015 28.0981 14.5988V16.4497H11.8984V14.5987C11.8984 13.9015 12.4648 13.3352 13.1625 13.3352L13.1623 13.3354Z" stroke="#FF2C2C" stroke-width="1.5" stroke-miterlimit="10"/>
												<path d="M16.4141 13.241V11.5222C16.4141 10.9618 16.8685 10.5076 17.4292 10.5076H22.4953C23.0559 10.5076 23.5104 10.9618 23.5104 11.5222V13.241" stroke="#FF2C2C" stroke-width="1.5" stroke-miterlimit="10"/>
												<path d="M17.6211 19.1477V27.3545" stroke="#FF2C2C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
												<path d="M22.375 19.1477V27.3545" stroke="#FF2C2C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
											</svg>
										</a>
									</div>
									<a href="{{ route('posts', [
											'thematic' => $search->thematic ?? null,
											'postType' => $search->postType ?? null,
											'search' => $search,
										]) }}" title="{{ __('Load this search') }}" class="group mt-4 cursor-pointer">
										<h2 class="inline-block mb-2 text-sm sm:text-base xl:text-lg font-semibold leading-normal text-jobboard-deepblue hover:text-jobboard-deepblue">
											{{ $search->name }}
										</h2>
									</a>
									{{-- <div class="mb-2 text-jobboard-deepblue transition duration-200 ease-in-out">
										<span class="capitalize font-semibold">
											{{ $search->updated_at->format('d/m/Y') }}
										</span>
									</div> --}}

									<div class="text-gray-400">
										@if(! empty($search->filters['price_min']) || ! empty($search->filters['price_max']))
											<div class="inline-flex items-center mr-4 text-jobboard-deepblue font-semibold">
												<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5 mr-1">
													<path d="M10.9969 21C16.5198 21 20.9969 16.5228 20.9969 11C20.9969 5.47715 16.5198 1 10.9969 1C5.4741 1 0.996948 5.47715 0.996948 11C0.996948 16.5228 5.4741 21 10.9969 21Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M15.4738 7.32233C13.4434 5.29113 10.1514 5.29113 8.121 7.32153C6.0906 9.35193 6.0898 12.6447 8.121 14.6751C10.1514 16.7063 13.4434 16.7063 15.4738 14.6751" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M5.797 9.80078H12.997" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M5.797 12.1992H12.997" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
												{{ __('Between :from and :to ', ['from' => ((empty($search->filters['price_min'])) ? '/' : $search->filters['price_min'].' €'), "to" => ((empty($search->filters['price_max'])) ? '/' : $search->filters['price_max'].' €')]) }}
											</div>
										@endif
										<div class="inline-flex items-center mr-4">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-1">
												<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path>
												<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path>
											</svg>
											@php
												if(! empty($search->filters['cities'])) {
													$cities = \App\Models\City::select('name')
														->whereIn('id', $search->filters['cities'])
														->first();
													$location = $cities->name.' ('.__('all city').')';
												} else if(! empty($search->filters['city_id'])) {
													$city = \App\Models\City::select('name', 'cp')
														->where('id', $search->filters['city_id'])
														->first();
													$location = $city->name.' ('.$city->cp.')';
												} else if(! empty($search->filters['department_id'])) {
													$department = \App\Models\Department::select('name')
														->where('id', $search->filters['department_id'])
														->first();
													$location = $department->name.' ('.__('department').')';
												} else if(! empty($search->filters['region_id'])) {
													$region = \App\Models\Region::select('name')
														->where('id', $search->filters['region_id'])
														->first();
													$location = $region->name.' ('.__('region').')';
												} else if(! empty($search->filters['country_id'])) {
													$country = \App\Models\Country::select('name')
														->where('id', $search->filters['country_id'])
														->first();
													$location = $country->name.' ('.__('country').')';
												} else {
													$location = __('No location');
												}
											@endphp
											{{ $location }}
										</div>
										<div class="inline-flex items-center mr-4">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
												<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"></path>
											</svg>
											{{-- ucfirst($search->updated_at->diffForHumans()) --}}
											{{ __('Search saved on').' '.$search->updated_at->format('d.m.y') }}
										</div>
									</div>

									@if(! empty($search->filters['vehicule_types']) || ! empty($search->filters['tractor_types']) || ! empty($search->filters['activity_types']) || ! empty($search->filters['notice_types']) || ! empty($search->filters['good_types']))
										<div class="mt-2 space-y-2">
											@if(! empty($search->filters['vehicule_types']))
											@php $vehiculeTypes = \App\Models\Criteria::whereIn('id', $search->filters['vehicule_types'])->get(); @endphp
												@foreach($vehiculeTypes as $vehiculeType)
													<div class="inline-block w-fit px-3 py-1 md:mr-2 rounded-md font-semibold text-sm">
														{{ $vehiculeType->name }}
													</div>
												@endforeach
											@endif
											@if(! empty($search->filters['tractor_types']))
												@php $tractorTypes = \App\Models\Criteria::whereIn('id', $search->filters['tractor_types'])->get(); @endphp
												@foreach($tractorTypes as $tractorType)
													<div class="inline-block w-fit px-3 py-1 md:mr-2 rounded-md font-semibold text-sm">
														{{ $tractorType->name }}
													</div>
												@endforeach
											@endif
											@if(! empty($search->filters['activity_types']))
												@php $activityTypes = \App\Models\Criteria::whereIn('id', $search->filters['activity_types'])->get(); @endphp
												@foreach($activityTypes as $activityType)
													<div class="inline-block w-fit px-3 py-1 md:mr-2 rounded-md font-semibold text-sm">
														{{ $activityType->name }}
													</div>
												@endforeach
											@endif
											@if(! empty($search->filters['notice_types']))
												@php $noticeTypes = \App\Models\Criteria::whereIn('id', $search->filters['notice_types'])->get(); @endphp
												@foreach($noticeTypes as $noticeType)
													<div class="inline-block w-fit px-3 py-1 md:mr-2 rounded-md font-semibold text-sm">
														{{ $noticeType->name }}
													</div>
												@endforeach
											@endif
											@if(! empty($search->filters['good_types']))
												@php $goodTypes = \App\Models\Criteria::whereIn('id', $search->filters['good_types'])->get(); @endphp
												@foreach($goodTypes as $goodType)
													<div class="inline-block w-fit px-3 py-1 md:mr-2 rounded-md font-semibold text-sm">
														{{ $goodType->name }}
													</div>
												@endforeach
											@endif
										</div>
									@endif

									<a href="#{{ $search->uuid }}" wire:ignore {{-- "wire:ignore" avoids breaking alpine properties @see https://github.com/livewire/livewire/discussions/6537#discussioncomment-7971231 --}}
										x-on:click.prevent="initial=!initial;$wire.toggleAlert('{{ $search->uuid }}')"
										class="group inline-flex flex-row items-center mt-4">
										<div class="mr-2">
											{{ __('Send me an email for each new post') }}
										</div>
										<div title="{{ $search->email_alert ? __('Disable') : __('Enable') }}">
											<div x-on:mouseenter="active=true;console.log('{{ $search->uuid }} '+(initial?'on':'off'))" x-show="!active">
												<svg class="size-8 pointer-events-none" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
													<rect x="0.75" y="0.765137" width="38.5" height="38.5" rx="19.25" fill="white"/>
													<rect x="0.75" y="0.765137" width="38.5" height="38.5" rx="19.25" stroke="#0082FF" stroke-width="1.5"/>
													<path d="M10.8696 13.0586H29.1304C29.6087 13.0586 30 13.4499 30 13.9282V25.2325C30 26.189 29.2174 26.9716 28.2609 26.9716H11.7391C10.7826 26.9716 10 26.189 10 25.2325V13.9282C10 13.4499 10.3913 13.0586 10.8696 13.0586Z" stroke="#0082FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M10.2695 13.2847L18.3391 19.8847C19.2521 20.6325 20.7304 20.6325 21.6434 19.8847L29.713 13.2847" stroke="#0082FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M25.654 23.4934L22.1758 20.0151" stroke="#0082FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M14.3477 23.4934L17.8259 20.0151" stroke="#0082FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</div>
											<div x-on:mouseleave="active=initial;console.log('{{ $search->uuid }} '+(initial?'on':'off'))" x-show="active">
												<svg class="size-8 pointer-events-none" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
													<rect x="0.75" y="1.25757" width="38.5" height="38.5" rx="19.25" fill="#0082FF"/>
													<rect x="0.75" y="1.25757" width="38.5" height="38.5" rx="19.25" stroke="#0082FF" stroke-width="1.5"/>
													<path d="M10.8696 13.551H29.1304C29.6087 13.551 30 13.9423 30 14.4206V25.7249C30 26.6815 29.2174 27.4641 28.2609 27.4641H11.7391C10.7826 27.4641 10 26.6815 10 25.7249V14.4206C10 13.9423 10.3913 13.551 10.8696 13.551Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M10.2695 13.7771L18.3391 20.3771C19.2521 21.1249 20.7304 21.1249 21.6434 20.3771L29.713 13.7771" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M25.654 23.9858L22.1758 20.5076" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M14.3477 23.9858L17.8259 20.5076" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</div>
										</div>
									</a>
								</div>
							</article>

							<x-front.modal name="delete-{{ $search->uuid }}" width="w-full max-w-2xl" wire:key="delete-{{ $search->uuid }}" focusable>
								<section class="p-10">
									<header class="flex flex-col flex-wrap content-center">
										<div class="mt-1 mb-6 text-sm m-auto text-jobboard-deepblue">
											<svg class="size-12" viewBox="0 0 18 22" stroke="currentColor" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M16.0051 7.05762V19.1031C16.0051 20.1506 15.1556 20.9999 14.1076 20.9999H4.0188C2.97077 20.9999 2.12109 20.1508 2.12109 19.1031V7.05762" stroke-width="1.5" stroke-miterlimit="10"/>
												<path d="M2.26388 3.82782H15.9356C16.6331 3.82782 17.1997 4.39389 17.1997 5.09128V6.9421H1V5.0911C1 4.39389 1.56635 3.82764 2.26407 3.82764L2.26388 3.82782Z" stroke-width="1.5" stroke-miterlimit="10"/>
												<path d="M5.51562 3.73339V2.0146C5.51562 1.45425 5.9701 1 6.53071 1H11.5968C12.1575 1 12.6119 1.45425 12.6119 2.0146V3.73339" stroke-width="1.5" stroke-miterlimit="10"/>
												<path d="M6.72266 9.64014V17.8469" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
												<path d="M11.4766 9.64014V17.8469" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
											</svg>
										</div>
										<h2 class="text-lg text-center font-semibold">
											{{ __('Are you sure you want to delete this search ?') }}
										</h2>
										<p class="text-base text-center italic my-4">
											&laquo; {{ $search->name }} &raquo;
										</p>
									</header>
									<div class="flex flex-row mt-4 justify-center">
										<form method="post" action="{{ route('space.searches.delete', ['search' => $search]) }}">
											@method('delete')
											@csrf

											<x-front.primary-button class="mr-6">
												{{ __('Delete') }}
											</x-front.primary-button>
										</form>
										<x-front.secondary-button x-on:click="$dispatch('close');">
											{{ __('No, get me back to the page') }}
										</x-front.secondary-button>
									</div>
								</section>
							</x-front.modal>
						@endforeach
					</div>

				@else
					<div x-data="{}" class="py-5 px-4 lg:px-6 flex flex-col items-center">
						<div class="my-3 text-center text-jobboard-deepblue">
							<svg width="70" height="70" class="mx-auto" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M37.2371 13C46.7493 13 54.459 20.7481 54.459 30.3077C54.459 34.0115 53.2917 37.4365 51.3189 40.2519L54.459 47.6153L47.132 44.4596C44.3306 46.4422 40.9226 47.6153 37.2371 47.6153C27.7249 47.6153 20.0152 39.8673 20.0152 30.3077C20.0152 20.7481 27.7249 13 37.2371 13Z" stroke="#002C6A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M35.5664 51.0077C32.4225 55.2577 27.4032 58 21.7372 58C18.0518 58 14.6418 56.8231 11.8442 54.8423L4.51538 58L7.65932 50.6346C5.68646 47.8231 4.51538 44.3962 4.51538 40.6924C4.51538 32.5751 10.0685 25.7655 17.5791 23.8962H17.5887" stroke="#002C6A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<rect x="33" y="23" width="8.66667" height="14" rx="4.33333" stroke="#002C6A" stroke-width="2"/>
								<path d="M69.75 27.9875L54.75 13L62.849 13C66.6552 13 69.75 16.0798 69.75 19.8953L69.75 28" fill="#002C6A"/>
								<path d="M50.1191 55.0125L35.1191 70H43.2181C47.0243 70 50.1191 66.9202 50.1191 63.1047V55" fill="#0082FF"/>
								<path d="M0.249998 19.9834L20.25 -1.90735e-06L9.45133 -9.63299e-07C4.37645 -5.19639e-07 0.249997 4.1064 0.249997 9.19368L0.249998 20" fill="#0082FF"/>
							</svg>
						</div>
						<h2 class="my-3 text-xl text-center font-bold">
							{{ __('You don\'t have any saved search yet') }}
						</h2>
						<p class="my-3 text-center">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
						</p>
						<div class="my-3 text-center">
							<a href="{{ route('posts') }}">
								<x-front.primary-button type="button">
									{{ __('Make a search') }}
								</x-front.primary-button>
							</a>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
