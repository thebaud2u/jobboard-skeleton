<div>
	<div class="mb-5 text-sm sm:text-base lg:text-xl">
		<div class="flex flex-wrap gap-4">
			<select id="user" wire:model.live="user" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400">
				<option value="">{{ __('Select a user') }}</option>
				@foreach($usersList as $userList)
					<option value="{{ $userList->slug }}">{{ $userList->lastname }} {{ $userList->firstname }}</option>
				@endforeach
			</select>

			<select id="state" wire:model.live="state" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400">
				<option value="">{{ __('Select a state') }}</option>
				@foreach($statesList as $index => $value)
					<option value="{{ $index }}">{{ __($value) }}</option>
				@endforeach
			</select>

			<select id="offer" wire:model.live="offer" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400">
				<option value="">{{ __('Select an offer') }}</option>
				@foreach($offersList as $offerEntry)
					<option value="{{ $offerEntry->slug }}">{{ $offerEntry->name }}</option>
				@endforeach
			</select>

			<div class="bg-white border-b border-gray-400 shadow-md px-2 py-1 lg:p-0 min-w-[250px]">
				<div class="relative mt-1 border-b-4 border-transparent">
					<div class="absolute inset-y-0 left-1 lg:left-2 flex items-center pointer-events-none">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
						</svg>
					</div>

					<input type="text" wire:model.live="keyword" name="keyword" id="keyword" placeholder="{{ __('Keyword(s)') }}" class="block w-full p-1.5 pl-8 lg:pl-9 text-gray-500 text-sm xl:text-base bg-white border border-transparent focus:border-transparent focus:ring-0 rounded-md" />
				</div>
			</div>
		</div>
	</div>

	<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
		<div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
			<table class="min-w-full">
				<thead>
					<tr>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Slug') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Name') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Author') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('State') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Offer') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Archive date') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Refreshed at') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Action') }}</th>
					</tr>
				</thead>

				<tbody class="bg-white">
					@if($companies->isNotEmpty())
						@foreach($companies as $company)
							@php
								$lastPublication = $company->lastPublication;
							@endphp
							<tr>
								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">{{ $company->slug }}</div>
										</div>
									</div>
								</td>


								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ $company->name }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">{{ $company->user->name }}</div>
											<div class="text-sm leading-5 text-gray-500">{{ $company->user->email }}</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									@switch($lastPublication->state->value)
										@case('archived')
											<div class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
											@break
										@case('deleted')
											<div class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
											@break
										@case('draft')
											<div class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
											@break
										@case('draft-waiting-moderation-for-publication')
											<div class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
											@break
										@case('published')
											<div class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
											@break
										@case('published-updated-waiting-moderation')
											<div class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
											@break
										@case('published-upgraded-waiting-moderation')
											<div class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
											@break
									@endswitch
										{{ __($lastPublication->state->inHuman()) }}
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											{{ __($lastPublication->subscription?->offer->name) }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">
											@if(!$lastPublication->isDraft() && $lastPublication->subscription && !$lastPublication->subscription->offer->free)
												{{ __($lastPublication->end_date->format('d/m/Y')) }}
											@endif
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												@if($company->refreshed_at)
													{{ $company->refreshed_at->format('d/m/Y H:i:s') }}
												@else
													{{ __('Not yet refreshed') }}
												@endif
											</div>
										</div>
									</div>
								</td>

								<td class="border-b border-gray-200">
									<a href="{{ route('company-search.company.show', ['company' => $company->slug]) }}" class="text-white inline-block">
										<button type="button" title="{{ __('View :element', ['element' => __('the company')]) }}" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
												<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
											</svg>
										</button>
									</a>

									@if(!$lastPublication->subscription?->offer->free)
										<div wire:click="getCompany({{ $company->id }})" x-on:click.prevent="$dispatch('open-modal', 'update-expiration-date-company-modal');" class="text-white inline-block">
											<button type="button" title="{{ __('Update :element', ['element' => __('the expiration date')]) }}" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
												</svg>
											</button>
										</div>
									@endif

									<div wire:click="toggleSNPCC({{ $company->id }})" class="text-white inline-block">
										@if($company->values->has('snpcc') && $company->values->get('snpcc') === true)
											<button type="button" title="{{ __('Disable SNPCC') }}" class="flex flex-row text-black bg-breeder-green focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2 items-center gap-1">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
												</svg>
												SNPCC
											</button>
										@else
											<button type="button" title="{{ __('Enable SNPCC') }}" class="flex flex-row text-white bg-gray-500 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2 items-center gap-1">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
												</svg>
												SNPCC
											</button>
										@endif
									</div>

									<a href="{{ route('admin.log-as-user', $company->user->slug) }}" class="text-white inline-block">
										<button type="button" title="{{ __('Log as the user') }}" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
											</svg>
										</button>
									</a>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="8" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
								{{ __('No result for this search') }}
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>

	<div class="mt-8 px-5 py-6 bg-white shadow-sm rounded-md">
		{{ $companies->links() }}
	</div>

	<x-front.modal name="update-expiration-date-company-modal" :class="'w-full max-w-2xl'" focusable>
		<section class="p-10 flex flex-col flex-wrap content-center text-breeder-deepblue">
			<header class="flex flex-col flex-wrap content-center">
				<h2 class="text-lg font-semibold">
					{{ __('Update expiration date') }}
				</h2>
			</header>

			<div class="container mt-4">
				<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
					<div class="p-5 align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 bg-white">
						<div class="mb-6">
							<h1 class="mb-1 text-base lg:text-xl font-semibold leading-6">
								{{ __('Current expiration date') }}
							</h1>

							<hr class="w-24 h-1 mb-5 border-0 bg-breeder-deepblue">

							<div class="pl-6">
								{{ $currentExpirationDate }}
							</div>
						</div>

						<div class="mb-6">
							<h1 class="mb-1 text-base lg:text-xl font-semibold leading-6">
								{{ __('New expiration date') }}
							</h1>

							<hr class="w-24 h-1 mb-5 border-0 bg-breeder-deepblue">

							<div class="pl-6">
								<div class="mb-4">
									<x-front.text-input type="date" id="newExpirationDate" min="{{ Carbon::now()->addDay()->format('Y-m-d') }}" wire:model="newExpirationDate" placeholder="{{ __('New expiration date') }}" :class="'mt-1 block w-full'" />

									@error('newExpirationDate')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="mt-6 flex flex-row flex-wrap justify-center">
				<x-front.secondary-button x-on:click="$dispatch('close');" :class="'mr-6'">
					{{ __('Cancel') }}
				</x-front.secondary-button>

				<x-front.primary-button wire:click="setExpirationDate" @company-validated.window="$dispatch('close');">
					{{ __('Update :element', ['element' => __('the expiration date')]) }}
				</x-front.primary-button>
			</div>
		</section>
	</x-front.modal>
</div>
