<div class="w-full max-md:mb-12">
	<div class="bg-white">
		<form>
			<div class="flex flex-col justify-between">
				<div class="flex flex-row justify-between pb-4 border-b border-breeder-deepblue">
					<div class="text-breeder-deepblue flex items-center mr-3">
						<div class="text-breeder-deepblue inline-block mr-3">
							<svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.16544 20.4445C7.46596 20.4445 9.33089 18.579 9.33089 16.2778C9.33089 13.9766 7.46596 12.1111 5.16544 12.1111M5.16544 20.4445C2.86493 20.4445 1 18.579 1 16.2778C1 13.9766 2.86493 12.1111 5.16544 12.1111M5.16544 20.4445V26M5.16544 12.1111V1M19.0503 14.8889C21.3508 14.8889 23.2157 13.0234 23.2157 10.7222C23.2157 8.42104 21.3508 6.55556 19.0503 6.55556M19.0503 14.8889C16.7497 14.8889 14.8848 13.0234 14.8848 10.7222C14.8848 8.42104 16.7497 6.55556 19.0503 6.55556M19.0503 14.8889L19.0503 26M19.0503 6.55556L19.0503 1" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>

						<div class="inline-block font-semibold text-breeder-deepblue">
							{{ __('Filters') }}
						</div>
					</div>

					<svg class="cursor-pointer md:hidden" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" @click="openSidemenu = false">
						<path d="M3 22L21 4M3 4L21 22" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					<div class="md:inline-block font-semibold hidden text-sm">
						<input type="reset" wire:click="resetForm" x-on:click="loc=''" value="{{ __('Reinitialize') }}" class="hover:underline hover:underline-offset-4 text-breeder-deepblue hover:text-breeder-deepblue cursor-pointer" />
					</div>
				</div>

				<div class="mt-4 text-center">
					<livewire:front.posts.save-search :key="'save-search-button-component'" />
				</div>

				<div class="flex flex-col">
					<div class="flex flex-col py-4 mt-4 border-b border-jobboard-transparentgray">
						<span class="flex-1 font-semibold text-breeder-deepblue">
							{{ __('Order by') }}
						</span>

						<select name="order" wire:model="filters.order_by" wire:change="search" class="border-gray-300 focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 text-gray-400">
							<option value="revelancy">
								{{ __('Relevancy') }}
							</option>

							<option value="publication">
								{{ __('Publication date') }}
							</option>
						</select>
					</div>

					<div wire:key="advanced-filters">
						@if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'stud')
							@include('components.front.posts.advanced-filters.'.$postType->getTranslation('slug', 'en'))
						@endif
						<hr>
						@if($postType->getTranslation('slug', 'en') != 'stud')
							@include('components.front.posts.advanced-filters.sex-filter')
						@endif
						<hr>
						@include('components.front.posts.advanced-filters.common-filters')
					</div>
				</div>

				<div class="flex justify-between gap-2 flex-wrap mt-8 md:hidden">
					<x-front.secondary-button :class="'flex-1 flex justify-center'">
						<input type="reset" wire:click="resetForm" x-on:click="loc=''" value="{{ __('Effacer') }}"/>
					</x-front.secondary-button>

					<x-front.primary-button :class="'flex-1 flex justify-center'" @click.prevent="openSidemenu = false">
						{{ __('Show') }}
					</x-front.primary-button>
				</div>
			</div>
		</form>
	</div>
</div>
