<div>
	@if($breed->exists)
		<h1 class="text-xl md:text-[28px] text-breeder-deepblue font-semibold w-full p-1">
			{{ $companyCount > 1 ? __(':x companies of :specie :breed found', ['x' => $companyCount, 'specie' => $species->getTranslation('slug', 'fr'), 'breed' => $breed->name]) : __(':x company of :specie :breed found', ['x' => $companyCount, 'specie' => $species->getTranslation('slug', 'fr'), 'breed' => $breed->name]) }}
		</h1>
	@else
		<div class="text-xl md:text-[28px] text-breeder-deepblue font-semibold w-full p-1">
			{{ $companyCount > 1 ? __(':x companies found', ['x' => $companyCount]) : __(':x company found', ['x' => $companyCount]) }}
		</div>
	@endif
</div>
