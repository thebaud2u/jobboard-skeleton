@extends('admin.layouts.app')

@push('scripts')
	<script src="{!! asset('js/uppy.js') !!}"></script>
@endpush

@push('styles')
	<x-front.space.uppy-styles />
@endpush

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium mb-4">
		{{ __('Benefits') }}
	</h1>

	<div class="container mt-4">
		<div x-data="{ tab: 'tab1' }">
			<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
				<ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'tab1'" id="benefits-tab" data-tabs-target="#benefits" type="button" role="tab" aria-controls="benefits" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'tab1'}">
							{{ __('Benefits') }}
						</button>
					</li>

					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'tab2'" id="benefit-types-tab" data-tabs-target="#benefit-types" type="button" role="tab" aria-controls="benefit-types" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'tab2'}">
							{{ __('Benefits types') }}
						</button>
					</li>
				</ul>
			</div>

			<div id="myTabContent">
				<div x-data="{uppyUploaderCollection: '', uppyUploaderMediaId: ''}" x-show="tab == 'tab1'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="benefits" role="tabpanel" aria-labelledby="benefits-tab">
					<livewire:admin.benefits.benefits />

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

				<div x-show="tab == 'tab2'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="benefit-types" role="tabpanel" aria-labelledby="benefit-types-tab">
					<livewire:admin.benefits.benefit-types />
				</div>
			</div>
		</div>
	</div>
@endsection
