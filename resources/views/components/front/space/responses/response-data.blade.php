<div>
	<hr class="my-4">

	<div class="flex flex-col gap-4">
		@if($response->from->phone)
			<div class="flex flex-row gap-x-1 text-sm">
				<span class="w-[126px] text-sm font-medium shrink-0">
					{{ __('Phone') }} :
				</span>

				<span class="px-3 py-1 rounded-md font-medium bg-breeder-cream text-breeder-deepblue border border-breeder-greige text-xs w-fit">
					{{ $response->from->phone }}
				</span>
			</div>
		@endif

		@if($response->values->has('message') && $message->body != $response->values->get('message'))
			<hr class="border border-breeder-greige">

			<div class="flex flex-col gap-y-3 text-sm">
				{{ __('Reminder of the request :') }}

				<p class="text-sm font-medium">
					{{ $response->values->get('message') }}
				</p>
			</div>
		@endif
	</div>
</div>