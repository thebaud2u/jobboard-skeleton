<div>
	<form>
		<div class="flex flex-row gap-4 mb-8 flex-wrap">
			<div class="flex-1 flex-col gap-y-2">
				<x-front.input-label for="filter_post_type" :value="__('Type')" :class="'pl-4 mb-2'" />

				<select class="flex-1 min-w-[251px] flex flex-col p-4 rounded-xl border border-jobboard-deepblue w-full" id="filter_post_type" wire:model.live="postType" wire:change.debounce.500ms="search">
					<option value="">
						{{ __('All the types') }}
					</option>

					@foreach($filterPostTypes as $postType)
						<option value="{{ $postType->getTranslation('slug', 'en') }}">
							{{ ucfirst(__($postType->name)) }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="flex-1 flex-col gap-y-2">
				<x-front.input-label for="filter_post_type" :value="__('Offers')" :class="'pl-4 mb-2'" />

				<select class="flex-1 min-w-[251px] flex flex-col p-4 rounded-xl border border-jobboard-deepblue w-full" id="filter_offer" wire:model.live="offer" wire:change.debounce.500ms="search">
					<option value="">
						{{ __('All the offers') }}
					</option>

					@foreach($filterOffers as $offer)
						<option value="{{ $offer->slug }}">
							{{ ucfirst(__($offer->name)) }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="flex-1 flex-col gap-y-2">
				<x-front.input-label for="filter_post_type" :value="__('States')" :class="'pl-4 mb-2'" />

				<select class="flex-1 min-w-[251px] flex flex-col p-4 rounded-xl border border-jobboard-deepblue w-full" wire:model.live="state" wire:change.debounce.500ms="search">
					<option value="">
						{{ __('All the states') }}
					</option>

					@foreach($filterStates as $state)
						<option value="{{ $state->value }}">
							{{ __($state->inHuman()) }}
						</option>
					@endforeach
				</select>
			</div>
		</div>
	</form>
</div>
