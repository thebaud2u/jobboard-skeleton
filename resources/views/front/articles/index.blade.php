<x-app-layout>
	<livewire:front.articles.index 
		:argument1="$argument1"
		:argument2="$argument2" 
		:key="'articles-component'" />

	{{-- Bloc bottom cta breeder/pro & partners --}}
	@include('components.front.cta-post')

	@include('components.front.footer-partner-sitemap')
	{{-- End Bloc bottom nl, cta breeder/pro & partners --}}
	
	@if (session('gtm'))
		<script>
			window.dataLayer = window.dataLayer || [];
			window.dataLayer.push(@json(session('gtm')));
		</script>
	@endif
	
</x-app-layout>
