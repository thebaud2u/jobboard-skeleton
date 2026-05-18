<div class="text-breeder-deepblue mb-8 w-full">
	@if($companies->isNotEmpty())
		<div class="flex flex-col gap-y-6 max-md:px-6 md:pr-6">
			@foreach($companies as $company)
				@include('components.front.companies.banner')
			@endforeach
		</div>
	@else
		{{ __('Your research brings up no result') }}
	@endif

	<div class="mt-8">
		{{ $companies->links() }}
	</div>
</div>
