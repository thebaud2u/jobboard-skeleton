@php $user = Auth::guard('web')->user(); @endphp

@if(Auth::guard('web')->check())
	@if( 
		($user->hasRole('adopter') && ($post->type->getTranslation('slug', 'en') == 'litter' || $post->type->getTranslation('slug', 'en') == 'litter-yet-to-come' || $post->type->getTranslation('slug', 'en') == 'retired-breeder')) ||
		($user->hasRole(['professionnal_breeder', 'individual_breeder']) && $post->type->getTranslation('slug', 'en') == 'stud')
	)
		@if($user->id != $post->user->id)
			<span class="w-full">
				<x-front.secondary-button x-on:click.prevent="$nextTick(() => { window.dataLayer = window.dataLayer || []; window.dataLayer.push({ event: 'appel_elevage', race: {{ json_encode($breed->name ?? 'non_renseignée') }} }); }); $dispatch('open-modal','call'); window.dispatchEvent(new CustomEvent('openCall'));" 
					:class="'w-full justify-center'">
					{{ __('Call') }}
				</x-front.secondary-button>
			</span>
		@endif
	@endif
@else
	<span class="w-full">
		<x-front.secondary-button x-on:click.prevent="$nextTick(() => { const breed = {{ json_encode($breed->name ?? 'non_renseignée') }}; window.dataLayer = window.dataLayer || []; window.dataLayer.push({ event: 'appel_elevage', race: breed }); }); $dispatch('open-modal','call'); window.dispatchEvent(new CustomEvent('openCall'));" 
			:class="'w-full justify-center'">
			{{ __('Call') }}
		</x-front.secondary-button>
	</span>
@endif