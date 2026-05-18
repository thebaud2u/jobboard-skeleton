@extends('admin.layouts.app')

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium mb-4">
		{{ __('Posts') }}
	</h1>

	<div class="container mt-4">
		<div x-data="{ tab: 'posts' }">
			<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
				<ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'posts'" id="posts-tab" data-tabs-target="#posts" type="button" role="tab" aria-controls="posts" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'posts'}">
							{{ __('Posts') }}
						</button>
					</li>
				</ul>
			</div>

			<div id="myTabContent">
				<div x-show="tab == 'posts'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="posts" role="tabpanel" aria-labelledby="posts-tab">
					<livewire:admin.posts.posts />
				</div>
			</div>
		</div>
	</div>
@endsection
