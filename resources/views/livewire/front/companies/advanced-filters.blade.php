<div class="w-full max-md:mb-12">
	<div class="bg-white">
		<form>
			<div class="flex flex-col justify-between">
				<div class="flex flex-row justify-between items-center pb-8 border-b border-breeder-deepblue">
					<div class="text-breeder-deepblue flex items-center gap-x-4">
						<div class="text-breeder-deepblue inline-block">
							<svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.16544 20.4445C7.46596 20.4445 9.33089 18.579 9.33089 16.2778C9.33089 13.9766 7.46596 12.1111 5.16544 12.1111M5.16544 20.4445C2.86493 20.4445 1 18.579 1 16.2778C1 13.9766 2.86493 12.1111 5.16544 12.1111M5.16544 20.4445V26M5.16544 12.1111V1M19.0503 14.8889C21.3508 14.8889 23.2157 13.0234 23.2157 10.7222C23.2157 8.42104 21.3508 6.55556 19.0503 6.55556M19.0503 14.8889C16.7497 14.8889 14.8848 13.0234 14.8848 10.7222C14.8848 8.42104 16.7497 6.55556 19.0503 6.55556M19.0503 14.8889L19.0503 26M19.0503 6.55556L19.0503 1" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>

						<div class="inline-block font-bold text-lg">
							{{ __('Filters') }}
						</div>
					</div>

					<svg class="cursor-pointer md:hidden" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" @click="openSidemenu = false">
						<path d="M3 22L21 4M3 4L21 22" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					<div class="md:inline-block font-semibold text-sm hidden">
						<input type="reset" wire:click="resetForm" x-on:click="loc=''" value="{{ __('Reinitialize') }}" class="hover:underline hover:underline-offset-4 text-breeder-deepblue hover:text-breeder-deepblue cursor-pointer" />
					</div>
				</div>

				<div class="flex flex-col">
					<div class="flex flex-col pb-8 mt-6 border-b border-jobboard-transparentgray">
						<span class="flex-1 font-semibold text-breeder-deepblue">
							{{ __('Order by') }}
						</span>

						<select name="order" wire:model="filters.company_order_by" wire:change="search" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-deepblue mt-1">
							<option value="revelancy">
								{{ __('Relevancy') }}
							</option>

							<option value="publication">
								{{ __('Publication date') }}
							</option>
						</select>
					</div>

					<div class="flex flex-col gap-2 py-8">
						<span class="flex-1 font-bold text-lg text-breeder-deepblue mb-2">
							{{ __('Only display companies with :') }}
						</span>

						@foreach($postsTypesAvailable as $key => $label)
							<x-front.input-label for="postTypesAvailable-{{ $key }}">
								<input type="checkbox" name="postTypesAvailable-{{ $key }}" id="postTypesAvailable-{{ $key }}" value="{{ $key }}" wire:model="filters.company_post_type_available" wire:change="search" class="cursor-pointer rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue mr-2">
								
								{{ __($label) }}
							</x-front.input-label>
						@endforeach
					</div>
				</div>

				<div class="flex justify-between gap-2 flex-wrap mt-8 md:hidden">
					<x-front.secondary-button :class="'flex-1 flex justify-center'">
						<input type="reset" wire:click="resetForm" x-on:click="loc=''" value="{{ __('Effacer') }}" />
					</x-front.secondary-button>

					<x-front.primary-button :class="'flex-1 flex justify-center'" @click.prevent="openSidemenu = false">
						Afficher
					</x-front.primary-button>
				</div>
			</div>
		</form>
	</div>

	@if(Auth::guard('web')->check())
		@php
			$searchName = ((empty($breed->name)) ? '' : ' - '.$breed->name);
		@endphp
		<div class="my-6 text-center" x-data="{}">
			{{-- <a href="#" class="mx-auto" x-on:click.prevent="$dispatch('open-modal','save-search')">
				<x-front.primary-button :class="' flex justify-center gap-2 lg:w-full px-4 py-1 bg-breeder-deepblue text-white hover:bg-breeder-deepblue hover:text-white xl:text-sm'">
					<svg class="size-5 xl:size-6" viewBox="0 0 19 18" stroke="currentColor" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M15.4978 17H3.50136C2.39669 17 1.50195 16.105 1.50195 15V3C1.50195 1.895 2.39669 1 3.50136 1H12.6712C13.201 1 13.7109 1.21001 14.0858 1.58501L16.9124 4.41251C17.2873 4.78751 17.4972 5.2975 17.4972 5.8275V15C17.4972 16.105 16.6025 17 15.4978 17Z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M13.4976 1.17999V6C13.4976 7.105 12.6029 8 11.4982 8H7.49941C6.39474 8 5.5 7.105 5.5 6V1" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M5.5 17V15C5.5 13.895 6.39474 13 7.49941 13H11.4982C12.6029 13 13.4976 13.895 13.4976 15V17" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					<span>
						{{ __('Save my search') }}
					</span>
				</x-front.primary-button>
			</a> --}}

			<x-front.modal name="save-search" width="w-full max-w-2xl" wire:key="save-search" focusable>
				<section class="p-10">
					{{--  
					<form method="post" action="{{ route('space.searches.save', ['search' => $savedSearch]) }}">
						@csrf

						<header class="flex flex-col flex-wrap content-center">
							<div class="mt-1 mb-6 text-sm m-auto text-breeder-deepblue">
								<svg class="size-12" viewBox="0 0 19 18" stroke="currentColor" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M15.4978 17H3.50136C2.39669 17 1.50195 16.105 1.50195 15V3C1.50195 1.895 2.39669 1 3.50136 1H12.6712C13.201 1 13.7109 1.21001 14.0858 1.58501L16.9124 4.41251C17.2873 4.78751 17.4972 5.2975 17.4972 5.8275V15C17.4972 16.105 16.6025 17 15.4978 17Z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M13.4976 1.17999V6C13.4976 7.105 12.6029 8 11.4982 8H7.49941C6.39474 8 5.5 7.105 5.5 6V1" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5.5 17V15C5.5 13.895 6.39474 13 7.49941 13H11.4982C12.6029 13 13.4976 13.895 13.4976 15V17" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>

							<h2>
								<x-front.input-label for="search_name" :value="__('Search title')" {{-- :value="__('Choose a title for this search')" :required="true"
									:class="'lg:text-lg text-center font-semibold'" />
							</h2>

							<p class="text-base text-center italic my-4">

								{{-- <x-front.text-input name="search_name" :value="$searchName" readonly :class="'mt-1 block bg-white w-full'" /> 
								{{ $searchName }}
								<input type="hidden" name="search_name" value="{{ $searchName }}">

								<input type="hidden" name="search_uuid" value="{{ $savedSearch?->uuid ?? '' }}">
								
								<input type="hidden" name="post_type_id" value="{{ $postType?->id ?? 0 }}">
								<input type="hidden" name="category_id" value="{{ $category?->id ?? 0 }}">
								<input type="hidden" name="filters" value="{{ (empty($filters)) ? '{}' : json_encode($filters) }}">
							</p>
						</header>

						<div class="flex flex-row mt-4 justify-center">
							<x-front.primary-button class="mr-6">
								{{ __('Save my search') }}
							</x-front.primary-button>

							<x-front.secondary-button x-on:click="$dispatch('close');">
								{{ __('Cancel') }}
							</x-front.secondary-button>
						</div>
					</form>--}}
				</section>
			</x-front.modal>
		</div>
	@endif
</div>
