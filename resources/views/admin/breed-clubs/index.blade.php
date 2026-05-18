@extends('admin.layouts.app')

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium mb-4">
		{{ __('Breed clubs') }}
	</h1>

	<div class="container mt-4">
		<div x-data="{tab: 'breed-clubs' }">
			<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
				<ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'breed-clubs'" id="breed-clubs-tab" data-tabs-target="#breed-clubs" type="button" role="tab" aria-controls="breed-clubs" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'breed-clubs'}">
							{{ __('Breed clubs') }}
						</button>
					</li>
				</ul>
			</div>

			<div id="myTabContent">
				<div x-show="tab == 'breed-clubs'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="breed-clubs" role="tabpanel" aria-labelledby="breed-clubs-tab">
					<livewire:admin.breed-clubs.breed-clubs />
				</div>
			</div>
		</div>
	</div>
@endsection
