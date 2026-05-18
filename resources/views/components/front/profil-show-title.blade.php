<div class="flex flex-row items-end">
	<div class="w-[54px] border-[3px] border-breeder-deepblue bg-breeder-deepblue rounded-full mb-3 mr-6"></div>

	<h2 {{ $attributes->merge(['class' => "mb-1 text-base lg:text-xl font-semibold text-breeder-deepblue"]) }}>
		{{ $slot }}
	</h2>
</div>
