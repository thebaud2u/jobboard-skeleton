@props([
	'smallButton' => true,
	'moderation' => null,
	'history' => collect([])
])

@php
	if(!is_null($moderation)) $history = $moderation->model->moderations;
@endphp

<div>
	@if($smallButton)
		<button type="button" x-on:click.prevent="$dispatch('open-modal', 'view-moderation-history-{{ $moderation->id }}');" title="{{ __('View the moderation history') }}" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
			</svg>
		</button>
	@else
		<x-front.primary-button x-on:click.prevent="$dispatch('open-modal', 'view-moderation-history-{{ $moderation->id }}');" :class="'xs:block mb-8 mr-4'">
			{{ __('View the moderation history') }}
		</x-front.primary-button>
	@endif

	<x-front.modal name="view-moderation-history-{{ $moderation->id }}" class="w-[900px]" focusable>
		<section class="flex flex-col flex-wrap content-center">
			<header class="flex flex-col flex-wrap content-center">
				<h2 class="text-lg font-semibold">
					{{ __('Moderation history') }}
				</h2>
			</header>

			<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
				<div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
					<table class="min-w-full">
						<thead>
							<tr>
								<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Admin') }}</th>
								<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Status') }}</th>
								<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Reason') }}</th>
								<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Description') }}</th>
								<th class="px-2 py-2 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">{{ __('Moderation date') }}</th>
							</tr>
						</thead>

						<tbody class="bg-white">
							@if($history->isNotEmpty())
								@foreach($history as $step)
									<tr>
										<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
											@if($step->isWaiting())
												{{ __('Waiting') }}
											@else
												{{ $step->admin->name }} - <span class="text-sm text-gray font-bold">{{ $step->admin->email }}</span>
											@endif
										</td>

										<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
											@if($step->isWaiting())
												<div class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
													{{ __('Waiting') }}
												</div>
											@elseif($step->isValidated())
												<div class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
													{{ __('Validated') }}
												</div>
											@elseif($step->isDenied())
												<div class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
													{{ __('Denied') }}
												</div>
											@endif
										</td>

										<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
											@if(!is_null($step->reason))
												{{ $step->getReasonTitle() }}
											@endif
										</td>

										<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
											{{ $step->description }}
										</td>

										<td class="px-2 py-2 whitespace-no-wrap border-b border-gray-200">
											{{ Carbon::parse($step->updated_at)->format('d/m/Y H:i:s') }}
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</x-front.modal>
</div>
