@extends('admin.layouts.app')

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium mb-4">
		{{ __('Professionnal activities') }}
	</h1>

	<div class="container mt-4">
		<div x-data="{ tab: 'professionnalActivities' }">
			<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
				<ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'professionnalActivities'" id="professionnalActivities-tab" data-tabs-target="#professionnalActivities" type="button" role="tab" aria-controls="professionnalActivities" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'professionnalActivities'}">
							{{ __('Professionnal activities') }}
						</button>
					</li>
				</ul>
			</div>

			<div id="myTabContent">
				<div x-show="tab == 'professionnalActivities'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="professionnalActivities" role="tabpanel" aria-labelledby="professionnalActivities-tab">
					<livewire:admin.professionnalActivities.professionnalActivities />
				</div>
			</div>
		</div>
	</div>
@endsection
