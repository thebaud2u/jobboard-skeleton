<x-app-layout>
	@push('seo')
			@php
				$metaTitle = 'Trouvez une entreprise en France';
				$metaDescription = 'Trouvez une entreprise France.';
				$canonical = '/entreprises';
			@endphp
		@endif

		<title>{{ $metaTitle }}</title>
		<meta name="description" content="{{ $metaDescription }}">
		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ env('APP_URL') }}/{{ $canonical }}" />
		<meta property="og:title" content="{{ $metaTitle }}">
		<meta property="og:description" content="{{ $metaDescription }}">
		<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		<meta property="og:url" content="{{ env('APP_URL') }}/{{ $canonical }}">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="{{ env('APP_NAME') }}">
		<meta property="og:locale" content="fr_FR">
	@endpush

	{{-- Page main title (home) --}}
	<x-slot name="mainTitle">
		<div x-data="{searchVisible: false, advancedSearchDisplay: false}">
			<div class="bg-cover bg-center bg-breeder-cream flex flex-col items-center lg:justify-end py-10 min-h-[328px] h-full md:h-[450px] lg:h-[400px]">
				<div class="relative w-full block md:hidden lg:block">
					<div class="absolute w-full lg:h-full right-0 max-md:top-[83px] top-[23px]">
						<div class="absolute w-[800px] max-lg:w-[250px] h-[300px] top-0 md:-top-[85px] xlsm:-top-[148px] max-lg:left-[50%] max-lg:transform max-lg:translate-x-[-50%] right-[176px]">
							<div class="z-10 absolute block lg:hidden xlsm:block w-[440px] max-lg:w-[175px] lg:h-[220px] max-lg:left-[50%] max-lg:transform max-lg:translate-x-[-100%] bottom-[95px] lg:-bottom-[156px] xlmd:right-[345px]">
								<img src="{{ asset('/storage/home_cat_green_e.png') }}" alt="puppy" class="object-cover xl:w-full">
							</div>

							<div class="absolute top-[62px] lg:top-[9px] right-[110px] lg:right-[322px] z-[12]">
								<img src="{{ asset('/storage/home_cat_left.png') }}" alt="stalion" class="object-cover w-[96px] lg:w-[250px]">
							</div>

							<div class="absolute top-[89px] lg:top-[59px] right-[29px] lg:right-[100px] z-[13]">
								<img src="{{ asset('/storage/home_cat_right.png') }}" alt="puppy" class="object-cover w-[100px] lg:w-[280px]">
							</div>

							<div class="relative block lg:hidden top-[119px] left-[148px] w-[116px] z-[11]">
								<div class="absolute">
									<img src="{{ asset('/storage/company_orange_e.png') }}" alt="puppy" class="w-full">
								</div>
							</div>

							<div class="relative hidden xlsm:block top-[50px] lg:top-[19px] lg:right-0 z-[11] h-[205px] w-full max-w-[100%]">
								<div class="absolute max-w-[100%] -right-[129px]">
									<img src="{{ asset('/storage/company_orange_e.png') }}" alt="puppy" class="w-[350px] h-[124px]">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="flex flex-row items-center justify-around md:justify-center gap-x-6 w-full z-20">
					<div class="flex flex-col max-md:gap-y-4 md:flex-row md:justify-center items-center w-full">
						<div class="flex flex-col items-center gap-6 text-[25px] md:text-[40px] text-breeder-deepblue w-full">
							<h1 class="flex flex-col max-lg:items-center w-full max-w-[1200px] px-4 xlsm:px-0 font-normal">
								<strong>
									{{ __('Trouvez un entreprise')}}<br>
								</strong>
							</h1>

							<div class="hidden md:block w-full px-4 xlsm:px-0">
								<livewire:front.companies.filters
									:displayCompany="'w-full'"
									:withRedirect="true"
									:key="'company-filters'" />
							</div>
						</div>

						<button class="md:hidden flex justify-center items-center w-[318px] h-[65px] cursor-pointer rounded-full bg-white text-breeder-deepblue font-bold gap-x-2" x-on:click="searchVisible = !searchVisible">
							<svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M11.1744 2.74419C6.51853 2.74419 2.74419 6.51853 2.74419 11.1744C2.74419 15.8303 6.51853 19.6047 11.1744 19.6047C15.8303 19.6047 19.6047 15.8303 19.6047 11.1744C19.6047 6.51853 15.8303 2.74419 11.1744 2.74419ZM1 11.1744C1 5.55524 5.55524 1 11.1744 1C16.7936 1 21.3488 5.55524 21.3488 11.1744C21.3488 16.7936 16.7936 21.3488 11.1744 21.3488C5.55524 21.3488 1 16.7936 1 11.1744Z" fill="#0E1954"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M17.5345 17.5345C17.8751 17.1939 18.4273 17.1939 18.7678 17.5345L25.7446 24.5112C26.0851 24.8518 26.0851 25.404 25.7446 25.7446C25.404 26.0851 24.8518 26.0851 24.5112 25.7446L17.5345 18.7678C17.1939 18.4273 17.1939 17.8751 17.5345 17.5345Z" fill="#0E1954"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M11.1744 2.74419C6.51853 2.74419 2.74419 6.51853 2.74419 11.1744C2.74419 15.8303 6.51853 19.6047 11.1744 19.6047C15.8303 19.6047 19.6047 15.8303 19.6047 11.1744C19.6047 6.51853 15.8303 2.74419 11.1744 2.74419ZM1 11.1744C1 5.55524 5.55524 1 11.1744 1C16.7936 1 21.3488 5.55524 21.3488 11.1744C21.3488 16.7936 16.7936 21.3488 11.1744 21.3488C5.55524 21.3488 1 16.7936 1 11.1744Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M17.5345 17.5345C17.8751 17.1939 18.4273 17.1939 18.7678 17.5345L25.7446 24.5112C26.0851 24.8518 26.0851 25.404 25.7446 25.7446C25.404 26.0851 24.8518 26.0851 24.5112 25.7446L17.5345 18.7678C17.1939 18.4273 17.1939 17.8751 17.5345 17.5345Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

							{{ __('Start my search') }}
						</button>
					</div>
				</div>

				<div class="fixed inset-0 bg-black bg-opacity-70 z-50 overflow-y-auto" x-show="searchVisible">
					<div class="bg-white w-full h-full p-5 flex flex-col justify-between">
						<div class="mb-5 h-full">
							<div class="flex justify-between items-center">
								<div class="text-lg font-bold">Ma recherche</div>

								<svg class="cursor-pointer" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" @click="searchVisible = false">
									<path d="M3 22L21 4M3 4L21 22" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>

							<livewire:front.companies.filters
								:displayCompany="'mx-3'"
								:withRedirect="true"
								:responsive="true"
								:key="'company-filters'" />
						</div>
					</div>
				</div>
			</div>

			<div x-show="advancedSearchDisplay">
				<livewire:front.companies.advanced-filters
					:responsive="true"
					:key="'company-advanced-filters-responsive'" />
			</div>
		</div>
	</x-slot>

	<div class="w-full mb-6 pt-10">
		<!-- Bannière haute, variante 'all' -->
		<div class="flex justify-center items-center mx-auto max-w-[1200px] bg-white w-full mb-10">
			<x-front.ad-slot slotName="banniere_haute" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'adoptant', 'espece' => $species->getTranslation('slug', 'fr')]" />
		</div>

		<div class="flex flex-col lg:flex-row gap-x-8 max-w-[1200px] mx-auto">
			<div x-data="{
					openSidemenu: false,
					updateWidth() {
						this.openSidemenu = window.innerWidth > 1024;
					}
				}" x-init="updateWidth()" @resize.window="updateWidth()">
				<div class="flex justify-center lg:hidden mb-10">
					<x-front.primary-button x-on:click="openSidemenu = !openSidemenu">
						<svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.375 16.5556C6.23896 16.5556 7.75 15.0632 7.75 13.2222C7.75 11.3813 6.23896 9.88889 4.375 9.88889M4.375 16.5556C2.51104 16.5556 1 15.0632 1 13.2222C1 11.3813 2.51104 9.88889 4.375 9.88889M4.375 16.5556V21M4.375 9.88889V1M15.625 12.1111C17.489 12.1111 19 10.6187 19 8.77778C19 6.93683 17.489 5.44445 15.625 5.44445M15.625 12.1111C13.761 12.1111 12.25 10.6187 12.25 8.77778C12.25 6.93683 13.761 5.44445 15.625 5.44445M15.625 12.1111L15.625 21M15.625 5.44445L15.625 1" stroke="#F7F6EF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						{{ __('Filters') }}
					</x-front.primary-button>
				</div>

				{{-- Left col --}}
				<div class="max-md:fixed max-md:inset-0 max-md:bg-black max-md:bg-opacity-70 max-md:z-50 max-md:overflow-y-auto" x-show="openSidemenu">
					<div class="bg-white w-full h-full flex">
						<div class="w-full h-full text-sm lg:text-base lg:w-[300px] max-lg:px-6 max-md:pt-6 flex flex-col items-center">
							<livewire:front.companies.advanced-filters :key="'company-advanced-filters'" />

							{{--
							x-front.ad-slot
								slotName="coeur_de_page"
								variant="all"
								:targeting="[
									'Targetingslug' => ['/chat/elevages'],
									'role' => 'adoptant',
									'espece' => ['chat']
								]"
							/>
							--}}
						</div>
					</div>
				</div>
			</div>

			{{-- Content --}}
			<section class="p-0">
				<div class="flex mb-4">
					<livewire:front.companies.company-count :key="'company-count'" />
				</div>

				<livewire:front.companies.index :key="'company-index'" />
			</section>
		</div>
	</div>

	{{-- Recently viewed/published companies
		<div class="w-full  py-6">
			@if(Auth::guard('web')->check())
				<livewire:front.companies.recently-viewed :key="'recently-viewed'" />
			@else
				<livewire:front.companies.recently-published :key="'recently-published'" />
			@endif
		</div>
	--}}

	@include('components.front.footer-partner-sitemap')
</x-app-layout>
