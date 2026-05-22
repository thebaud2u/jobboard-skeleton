<div>
	<div class="mb-5 text-sm sm:text-base lg:text-xl">
		<div class="flex flex-wrap items-center gap-4">
			<select id="offer" wire:model.live="offer" class="block mt-1 border border-gray-300 focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md shadow-sm">
				<option value="">{{ __('Select an offer') }}</option>
				@foreach($offersList as $offerEntry)
					<option value="{{ $offerEntry->slug }}">{{ __(ucfirst($offerEntry->type)) }} - {{ $offerEntry->name }}</option>
				@endforeach
			</select>

			<div class="bg-white border-b border-gray-400 shadow-md px-2 py-1 lg:p-0 text-gray-400 min-w-[250px]">
				<div class="relative mt-1 border-b-4 border-transparent">
					<div class="absolute inset-y-0 left-1 lg:left-2 flex items-center pointer-events-none">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
						</svg>
					</div>
					<input type="text" wire:model.live="keyword" name="keyword" id="keyword" placeholder="{{ __('Keyword(s)') }} {{ __('ex : email, reference') }}" class="block w-full p-1.5 pl-8 lg:pl-9 text-gray-500 text-sm xl:text-base bg-white border border-transparent focus:border-transparent focus:ring-0 rounded-md" />
				</div>
			</div>

			<div x-on:click="$dispatch('open-modal', 'add-subscription-modal')" class="text-white inline-block">
				<button type="button" title="{{ __('Create :element', ['element' => __('a new subscription')]) }}" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
				</button>
			</div>
		</div>
	</div>

	<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
		<div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
			<table class="min-w-full">
				<thead>
					<tr>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('User') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Offer') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Credits bought') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Credits remaining') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Bought on') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Expire on') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Deleted from the account on') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Created from') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Synchronized with Stripe') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Comment') }}</th>
						<th class="px-2 py-2 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Action') }}</th>
					</tr>
				</thead>

				<tbody class="bg-white">
					@if($subscriptions->isNotEmpty())
						@foreach($subscriptions as $subscription)
							<tr>
								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												{{ $subscription->user->name }} - {{ $subscription->user->email }}
											</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												{{ __(ucfirst($subscription->offer->type)) }} - "{{ $subscription->offer->name }}"
											</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												{{ $subscription->quantity }}
											</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												{{ $subscription->remaining_quantity }}
											</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												{{ $subscription->created_at->format('d/m/Y H:i:s') }}
											</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												{{ $subscription->end_date?->format('d/m/Y') }}
											</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<div class="text-sm leading-5 font-medium text-gray-900">
												{{ $subscription->deleted_at?->format('d/m/Y H:i:s') }}
											</div>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<button type="button" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2 mr-2 mb-2">
												{{ $subscription->from }}
											</button>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4">
											<button type="button" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
												@if($subscription->synchronized_with_stripe)
													{{ __('Yes') }}
												@else
													{{ __('No') }}
												@endif
											</button>
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="ml-4" title="{{ $subscription->comment }}">
											{{ Str::limit($subscription->comment, 40) }}
										</div>
									</div>
								</td>

								<td class="px-2 py-2 whitespace-no-wrap text-left border-b border-gray-200 text-sm leading-5 font-medium">
									<div class="flex flex-nowrap items-center">
										<a href="{{ route('admin.log-as-user', $subscription->user->slug) }}" class="text-white inline-block">
											<button type="button" title="{{ __('Log as the user') }}" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
												</svg>
											</button>
										</a>

										<div wire:click="getSubscription({{ $subscription->id }})" x-on:click="$dispatch('open-modal', 'update-subscription-modal')" class="text-white inline-block">
											<button type="button" title="{{ __('Update an existing subscription') }}" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
													<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
												</svg>
											</button>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="11" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
								{{ __('No result for this search') }}
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>

	<div class="mt-8 px-5 py-6 bg-white shadow-sm rounded-md">
		{{ $subscriptions->links() }}
	</div>

	<x-front.modal name="add-subscription-modal" :class="'w-full max-w-2xl'" focusable>
		<section class="p-10 flex flex-col flex-wrap content-center text-jobboard-deepblue">
			<header class="flex flex-col flex-wrap content-center">
				<h2 class="text-lg font-semibold">
					{{ __('Create :element', ['element' => __('a new subscription')]) }}
				</h2>
			</header>

			<div class="container mt-4">
				<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
					<div class="p-5 align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 bg-white">
						<div class="mb-6">
							<div class="pl-6 flex flex-col gap-y-4">
								<div>
									<div class="flex flex-row">
										<x-front.input-label for="userEmail" :value="__('User\'s email address')" :required="true" />
									</div>

									<div class="flex flex-row mt-2">
										<x-front.text-input type="email" name="userEmail" wire:model="userEmail" wire:keydown.debounce.500ms="searchRegistered" placeholder="{{ __('User\'s email address') }}" class="mt-1 block text-gray-400 " />
									</div>

									@if($userEmail && $foundUsers)
										<div class="flex flex-col mt-2">
											@if($foundUsers->isNotEmpty())
												<h4 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
													{{ __('Accounts found') }} :
												</h4>
												<ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
													@foreach($foundUsers as $foundUser)
														<li wire:click="selectUser({{ $foundUser->id }})" class="cursor-pointer">{{ $foundUser->name }} - {{ $foundUser->email }}</li>
													@endforeach
												</ul>
											@else
												{{ __('No registered found') }}
											@endif
										</div>
									@endif

									@error('userEmail')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div>
									<div class="flex flex-row">
										<x-front.input-label for="offerSelected" :value="__('Offer')" :required="true" />
									</div>

									<select name="offerSelected" wire:model="offerSelected" class="block mt-1 border border-gray-300 focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md shadow-sm">
										<option value="">{{ __('Select an offer') }}</option>
										@foreach($offersList as $offerEntry)
											<option value="{{ $offerEntry->id }}">{{ __(ucfirst($offerEntry->type)) }} - {{ $offerEntry->name }}</option>
										@endforeach
									</select>

									@error('offerSelected')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div>
									<div class="flex flex-row">
										<x-front.input-label for="creditRemaining" :value="__('Credits remaining')" :required="true" />
									</div>

									<div class="flex flex-row mt-2">
										<x-front.text-input type="number" name="creditRemaining" wire:model="creditRemaining" class="mt-1 block text-gray-400 " placeholder="{{ __('Credits remaining') }}" />
									</div>

									@error('creditRemaining')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div>
									<div class="flex flex-row">
										<x-front.input-label for="expirationDate" :value="__('Expire on')" :required="true" />
									</div>

									<div class="flex flex-row mt-2">
										<x-front.text-input type="date" name="expirationDate" min="{{ Carbon::now()->addDay()->format('Y-m-d') }}" wire:model="expirationDate" class="mt-1 block text-gray-400 " placeholder="{{ __('DD/MM/YYYY') }}" />
									</div>

									@error('expirationDate')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div>
									<div class="flex flex-row">
										<x-front.input-label for="comment" :value="__('Comment')" />
									</div>

									<div class="flex flex-row mt-2">
										<textarea name="comment" wire:model.lazy="comment" placeholder="{{ __('Comment') }}" class="mt-1 block w-full border-jobboard-greige focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md shadow-sm text-jobboard-deepblue placeholder:text-jobboard-greige mt-1 block text-gray-400"></textarea>
									</div>
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

				<x-front.primary-button wire:click="setSubscription" @subscription-validated.window="$dispatch('close');">
					{{ __('Create :element', ['element' => __('the subscription')]) }}
				</x-front.primary-button>
			</div>
		</section>
	</x-front.modal>

	<x-front.modal name="update-subscription-modal" :class="'w-full max-w-2xl'" focusable>
		<section class="p-10 flex flex-col flex-wrap content-center text-jobboard-deepblue">
			<header class="flex flex-col flex-wrap content-center">
				<h2 class="text-lg font-semibold">
					{{ __('Update :element', ['element' => __('a subscription')]) }}
				</h2>
			</header>

			<div class="container mt-4">
				<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
					<div class="p-5 align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 bg-white">
						<div class="mb-6">
							<div class="pl-6 flex flex-col gap-y-4">
								<div>
									<div class="flex flex-row">
										<x-front.input-label for="creditRemaining" :value="__('Credits remaining')" :required="true" />
									</div>

									<div class="flex flex-row mt-2">
										<x-front.text-input type="number" name="creditRemaining" wire:model="creditRemaining" class="mt-1 block text-gray-400 " placeholder="{{ __('Credits remaining') }}" />
									</div>

									@error('creditRemaining')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div>
									<div class="flex flex-row">
										<x-front.input-label for="expirationDate" :value="__('Expire on')" :required="true" />
									</div>

									<div class="flex flex-row mt-2">
										<x-front.text-input type="date" name="expirationDate" min="{{ Carbon::now()->addDay()->format('Y-m-d') }}" wire:model="expirationDate" class="mt-1 block text-gray-400 " placeholder="{{ __('DD/MM/YYYY') }}" />
									</div>

									@error('expirationDate')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>

								<div>
									<div class="flex flex-row">
										<x-front.input-label for="comment" :value="__('Comment')" />
									</div>

									<div class="flex flex-row mt-2">
										<textarea name="comment" wire:model.lazy="comment" placeholder="{{ __('Comment') }}" class="mt-1 block w-full border-jobboard-greige focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md shadow-sm text-jobboard-deepblue placeholder:text-jobboard-greige mt-1 block text-gray-400"></textarea>
									</div>
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

				<x-front.primary-button wire:click="updateSubscription" @subscription-validated.window="$dispatch('close');">
					{{ __('Update :element', ['element' => __('the subscription')]) }}
				</x-front.primary-button>
			</div>
		</section>
	</x-front.modal>
</div>
