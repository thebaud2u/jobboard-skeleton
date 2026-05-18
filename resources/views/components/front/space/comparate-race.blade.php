@props(['thirdCard' => false, 'CTABreed' => null])

<div class="w-full flex max-sm:flex-row max-sm:gap-2 sm:grid max-sm:overflow-scroll sm:grid-cols-2 @if(!request()->segment(2) || $thirdCard || $CTABreed) lg:grid-cols-3 @endif gap-6 mb-8">
	@include('components.front.button-card', ['name' => 'which-'.$species->getTranslation('slug', 'en'), 'modal' => $species->getTranslation('slug', 'en') == 'dog' ? true : false])
	@include('components.front.button-card',['name' => 'compare-'.$species->getTranslation('slug', 'en').'s'])
	
	@if($CTABreed && $CTABreed->exists)
		@include('components.front.button-card',['name' => 'CTABreed', 'species' => $species->getTranslation('slug', 'en'), 'breed' => $CTABreed])
	@endif

	@if(!request()->segment(2) || $thirdCard)
		@include('components.front.button-card',['name' => 'animalname', 'species' => $species->getTranslation('slug', 'en')])
	@endif
</div>
