<div>
	<div class="bg-jobboard-cream w-full flex flex-col justify-center items-center gap-y-4 s:gap-y-12 h-[304px] s:h-[281px] text-jobboard-deepblue">
		<h2 class="text-[25px] sm:text-[30px] lg:text-[40px] font-bold text-center mt-4 lg:mt-8">
			@if($postState == 'create')
				{{ __('Post creation') }}
			@elseif($postState == 'update')
				{{ __('Post update') }}
			@endif
		</h2>

		<div id="anchor" class="flex justify-between items-center font-bold @if($offer->slug != 'annonce-master') w-[278px] @else w-[323px] s:w-[493px] sm:w-[580px] @endif">
			@for($i = 1; $i <= $totalSteps; $i++)
				@if($i == 1)
					<div class="flex flex-col items-center text-center gap-y-4 w-[108px] cursor-pointer">
						@if($active == 1)
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2"/>
								<path d="M28.0796 27.08V24.756H33.3436V45H30.7676V27.08H28.0796Z" fill="#0E1954"/>
							</svg>
						@else
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2"/>
								<path d="M36.2391 24.5814C34.6609 23.7822 32.8787 23.3333 31 23.3333C24.4725 23.3333 19.1904 28.7199 19.1904 35.3764C19.1904 42.0329 24.4725 47.4194 31 47.4194C37.5274 47.4194 42.8095 42.0329 42.8095 35.3764C42.8095 33.8327 42.5196 32.3547 42.0043 30.9971M25.632 35.3764L29.9264 39.7556L42.8095 23.3333" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						@endif

						<div class="h-[47px] text-center">
							{{ __('Post type') }}
						</div>
					</div>
				@elseif($i == 2)
					<div class="flex flex-col items-center gap-y-4 w-[108px] @if($active == 1) text-jobboard-greige @else text-jobboard-deepblue cursor-pointer @endif" @if($active > 1) wire:click="goto(2)" @endif>
						@if($active <= 2)
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg" class="z-10">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="currentColor" stroke-width="2"/>
								<path d="M24.8753 42.956C27.2459 41.052 29.1033 39.4933 30.4473 38.28C31.7913 37.048 32.9206 35.7693 33.8353 34.444C34.7686 33.1 35.2353 31.784 35.2353 30.496C35.2353 29.2827 34.9366 28.3307 34.3393 27.64C33.7606 26.9307 32.8179 26.576 31.5113 26.576C30.2419 26.576 29.2526 26.9773 28.5433 27.78C27.8526 28.564 27.4793 29.6187 27.4233 30.944H24.9593C25.0339 28.8533 25.6686 27.2387 26.8633 26.1C28.0579 24.9613 29.5979 24.392 31.4833 24.392C33.4059 24.392 34.9273 24.924 36.0473 25.988C37.1859 27.052 37.7553 28.5173 37.7553 30.384C37.7553 31.9333 37.2886 33.4453 36.3553 34.92C35.4406 36.376 34.3953 37.664 33.2193 38.784C32.0433 39.8853 30.5406 41.1733 28.7113 42.648H38.3433V44.776H24.8753V42.956Z" fill="currentColor"/>
							</svg>
						@else
							<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M27.8203 1.8457C29.6627 0.788427 31.9124 0.722349 33.8057 1.64746L34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.3373 67.8708 30.0876 67.9368 28.1943 67.0117L27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291L3.81543 53.0703C2.06023 51.9104 1 49.9514 1 47.8496V20.8096C1 18.5708 2.21118 16.4953 4.17871 15.3662L4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="#0E1954" stroke-width="2"/>
								<path d="M36.2391 24.5814C34.6609 23.7822 32.8787 23.3333 31 23.3333C24.4725 23.3333 19.1904 28.7199 19.1904 35.3764C19.1904 42.0329 24.4725 47.4194 31 47.4194C37.5274 47.4194 42.8095 42.0329 42.8095 35.3764C42.8095 33.8327 42.5196 32.3547 42.0043 30.9971M25.632 35.3764L29.9264 39.7556L42.8095 23.3333" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						@endif

						<div class="h-[47px] text-center">
							{{ __('Descriptive') }}
						</div>
					</div>
				@else
					<div class="flex flex-col items-center gap-y-4 w-[108px] @if($active != 3) text-jobboard-greige @else text-jobboard-deepblue cursor-pointer @endif">
						<svg class="w-[54px] sm:w-[62px]" viewBox="0 0 62 70" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M27.8203 1.8457C29.7855 0.717939 32.2145 0.717939 34.1797 1.8457L34.1807 1.84668L57.3193 15.0781V15.0869L57.8252 15.375C59.7941 16.4957 61 18.5748 61 20.8164V47.8496C61 49.9485 59.9358 51.9038 58.1816 53.0703L57.8232 53.292L34.1807 66.8125L34.1797 66.8135C32.2145 67.9412 29.7855 67.9412 27.8203 66.8135L27.8193 66.8125L4.17676 53.292L4.1748 53.291C2.20595 52.1704 1 50.0912 1 47.8496V20.8096C1 18.5708 2.2102 16.4943 4.17773 15.3652L27.8193 1.84668L27.8203 1.8457Z" stroke="currentColor" stroke-width="2"/>
							<path d="M23.3153 40.492V38.56L33.1433 24.952H36.1953V38.28H38.9953V40.492H36.1953V45H33.6753V40.492H23.3153ZM33.7873 27.612L26.2553 38.28H33.7873V27.612Z" fill="currentColor"/>
						</svg>

						<div class="h-[47px] text-center">
							{{ __('Social network') }}
						</div>
					</div>
				@endif
			@endfor
		</div>
	</div>

	<div class="w-full bg-white max-lg:px-4 py-10 mb-6 max-w-[870px] mx-auto text-jobboard-deepblue">
		<div wire:key="errors-{{ $subComponentKey }}">
			@if($errors->any() || Session::has('error') || Session::has('success') || Session::has('warning') || Session::has('info'))
				<div class="py-5 px-4 lg:px-6" x-data="{}" x-ref="alert">
					@include('components.front.alerts')
				</div>
			@endif
		</div>

		<div class="flex flex-col py-5 gap-y-4">
			@if($active == 1)
				<div class="flex flex-row max-sm:items-start max-sm:space-y-4 sm:flex-row sm:justify-between">
					<x-front.space-title>
						{{ __('Select a post type') }}
					</x-front.space-title>
				</div>

				<div class="flex flex-col s:flex-row mt-4 gap-4 justify-center lmd:justify-between mb-8">
					@foreach($postTypes as $postType)
						<div class="w-full max-w-full s:max-w-[270px]">
							<input type="radio" name="postType" value="{{ $postType->getTranslation('slug', 'en') }}" id="postType{{ ucfirst($postType->getTranslation('slug', 'en')) }}" wire:model.live="postTypeSelected" @if($postType->getTranslation('slug', 'en') == 'litter') @disabled(!$canCreateLitters) @endif class="peer hidden" />
							<label for="postType{{ ucfirst($postType->getTranslation('slug', 'en')) }}" class="block cursor-pointer border border-jobboard-greige rounded-xl hover:bg-jobboard-cream peer-checked:bg-jobboard-cream peer-checked:border-jobboard-cream max-s:max-w-full">
								<div>
									<h3 class="flex flex-row gap-4 s:flex-col items-center max-s:pl-4 s:justify-center text-center text-base font-medium h-[85px] s:h-[144px] capitalize">
										{{-- SVG --}}

										{{ __($postType->name) }}
									</h3>
								</div>
							</label>
						</div>
					@endforeach
				</div>

				@error('postTypeSelected')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			@elseif($active == 2)
				@if($postType->getTranslation('slug', 'en') == '')
					@include('components.front.space.posts.forms.common-fields')
				@endif
			@elseif($active == 3)
				<div>
					<x-front.space-title>
						{{ __('Post sharing on our social network') }}
					</x-front.space-title>

					<div class="flex flex-col gap-y-4">
						{{ __('Write a summary of your ad that will appear on our page :site') }}

						<div x-data="{
							maxCaracters: 1000,
							caractersLeft: 1000,
							countCaractersLeft:function() {
								caractersLeft = 0;
								this.caractersLeft = this.maxCaracters - ($refs.shortDescriptionCount.value.length);

								if(this.caractersLeft <= 0) {
									$refs.shortDescriptionCount.value = $refs.shortDescriptionCount.value.substring(0, ($refs.shortDescriptionCount.value.length + (this.caractersLeft)));

									this.caractersLeft = this.maxCaracters - ($refs.shortDescriptionCount.value.length);
								}
							}}" x-init="$nextTick(() => { countCaractersLeft() })" wire:key="social_network_description">
							<div class="flex flex-row">
								<x-front.input-label for="socialNetworkDescription" :value="__('My summary of the post')" :required="true" />
							</div>

							<textarea id="socialNetworkDescription" rows="5" x-ref="shortDescriptionCount" x-on:keyup="countCaractersLeft()" wire:model="socialNetworkDescription" placeholder="{{ __('Describe the animal, its appearance, its behaviour. Talk about your company...') }}" maxlength="1000" class="border-jobboard-greige focus:border-jobboard-deepblue focus:ring-jobboard-deepblue rounded-md shadow-sm text-jobboard-deepblue placeholder:text-gray-400 mt-1 block w-full"></textarea>

							<div class="flex justify-end mt-2">
								<span class="text-sm text-gray">
									<span x-html="caractersLeft"></span> {{ __('caracters left') }}
								</span>
							</div>

							@error('socialNetworkDescription')
								<span class="error text-danger-700">
									{{ $message }}
								</span>
							@enderror
						</div>
					</div>
				</div>
			@endif
		</div>

		<hr class="w-full border border-jobboard-deepblue my-8">

		@if($active == $totalSteps && $postState == 'update' && $creditAvailable <= 0 && $lastPublication->isDraft())
			<div class="flex flex-row justify-end text-red-400 my-4">
				{{ __('You\'re missing 1 :offer credit to be able to publish your post.', ['offer' => $offer->name]) }}
			</div>
		@endif

		<div class="flex flex-col items-center s:flex-row gap-6 s:justify-between s:items-start sm:items-center sm:mt-0 mt-4">
			@if($active < 3)
				<a href="{{route('space.posts.my-posts')}}" class="flex items-center gap-x-2 text-jobboard-deepblue font-bold text-sm hover:underline hover:underline-offset-4">
					<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M8.00391 14C11.8699 14 15.0039 11.0899 15.0039 7.5C15.0039 3.91015 11.8699 0.999999 8.00391 0.999999C4.13791 1 1.00391 3.91015 1.00391 7.5C1.00391 11.0899 4.13791 14 8.00391 14Z" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M5.75195 9.59183L10.2574 5.4082" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M5.75195 5.4082L10.2574 9.59183" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					{{ __('Cancel') }}
				</a>
			@elseif($active > 2)
				<button class="flex items-center gap-x-2 text-jobboard-deepblue font-bold text-sm" wire:click="previous">
					<svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M6.51172 1.5L2.14808 5.5L6.51172 9.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>

					{{ __('Previous') }}
				</button>
			@endif

			<div class="flex flex-col items-center s:items-start s:flex-row s:justify-end gap-2 s:flex-wrap">
				@if($active > 1 && ($postState == 'create' || $lastPublication->isDraft()))
					<x-front.secondary-button wire:click="submitPostForm('draft')" :class="'font-bold'">
						<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M16.9961 16.8043V4.97826L13.5178 1.5H1.69175C1.30914 1.5 0.996094 1.81304 0.996094 2.19565V16.8043C0.996094 17.187 1.30914 17.5 1.69175 17.5H16.3004C16.6831 17.5 16.9961 17.187 16.9961 16.8043Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M14.2129 17.5H3.77811V11.9626C3.77811 11.5661 4.09811 11.2391 4.50159 11.2391H13.5172C13.8998 11.2391 14.2129 11.5522 14.2129 11.9348V17.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M5.16992 1.5H10.7351V5.67391C10.7351 6.05652 10.4221 6.36956 10.0395 6.36956H5.86557C5.48297 6.36956 5.16992 6.05652 5.16992 5.67391V1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						{{ __('Save as draft') }}
					</x-front.secondary-button>
				@endif

				@if($active < $totalSteps ||
					($active == $totalSteps &&
						(
							($creditAvailable > 0 && $postState == 'create') ||
							($postState == 'update' &&
								(
									($creditAvailable > 0 && !$lastPublication->isPublished()) ||
									$lastPublication->isPublished()
								)
							)
						)
					)
				)
					<x-front.primary-button wire:click="submitPostForm('publish')">
						@if($active < $totalSteps)
							{{ __('Next step') }}

							<svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.86133 1.5L7.31587 6.5L1.86133 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						@else
							@if($creditAvailable > 0 && $postState == 'create')
								{{ __('Publish my post') }}
							@elseif($postState == 'update')
								@if($creditAvailable > 0 && $lastPublication->isDraft())
									{{ __('Publish my post') }}
								@else
									{{ __('Update my post') }}
								@endif
							@endif
						@endif
					</x-front.primary-button>
				@else
					<x-front.primary-button wire:click="submitPostForm('buy-and-publish')">
						{{ __('Buy a credit and publish') }}

						<svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.86133 1.5L7.31587 6.5L1.86133 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</x-front.primary-button>
				@endif
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('livewire:init', () => {
			// S'exécute après chaque traitement de message Livewire
			Livewire.hook('request', ({ respond }) => {
				respond(() => {
					// On attend que le DOM soit mis à jour, puis on scrolle
					const anchor = document.getElementById('anchor');
					if (anchor) {
						anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
					}
				});
			});
		});
	</script>
</div>
