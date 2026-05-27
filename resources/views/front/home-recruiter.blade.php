<x-app-layout>
	@push('seo')
		<title>Annuaire des éleveurs de chiens et chats en France</title>
		<meta name="description" content="Eleveurs de chiens et de chats : Tous les services pour vendre votre chiot ou votre chaton sur le 1er réseau animalier de France.">
		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
		<meta property="og:title" content="Annuaire des éleveurs de chiens et chats en France">
		<meta property="og:description" content="Eleveurs de chiens et de chats : Tous les services pour vendre votre chiot ou votre chaton sur le 1er réseau animalier de France.">
		<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		<meta property="og:url" content="{{ Request::url() }}">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="Eleveurs Online">
		<meta property="og:locale" content="fr_FR">
	@endpush

	<x-slot name="mainTitle">
		@if($errors->any() || Session::has('error') || Session::has('success') || Session::has('warning') || Session::has('info'))
			<div class="bg-breeder-violet flex justify-center w-full" x-data="{}" x-ref="alert">
				@include('components.front.alerts')
			</div>
		@endif

		<div class="h-[420px] s:h-[324px] lg:h-[420px] bg white w-full overflow-hidden pb-8">
			<div class="h-[420px] lg:h-[420px] s:h-[324px] bg-breeder-deepblue w-full px-4">
				<div class="flex flex-col lg:flex-row max-lg:justify-center lg:items-stretch h-full max-w-[1200px] mx-auto">
					<div class="flex flex-col items-center lg:items-start lg:gap-y-3 md:mt-6 lg:mt-12 lg:flex-1">
						@if(! auth()->check() || ! auth()->user()->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder', 'admin']))
							<p class="text-[28px] text-white max-md:text-center">
								{{ __('You are dog or cat breeders') }} ?
							</p>
						@endif

						<h1 class="text-white text-[30px] lg:text-[40px] w-[97%] max-s:w-[350px] md:w-full xlsm:w-[700px] font-bold max-lg:text-center mb-8">
							{{ __('Litters, stallions or retired adults, post your ads') }} !
						</h1>

						<div class="flex max-md:flex-col max-md:items-center gap-2 gap-y-4">
							<a href="{{ route('space.posts.show-offers') }}" class="inline-flex items-center gap-x-2 px-5 py-3 whitespace-nowrap rounded-full text-sm focus:outline-none focus:ring-0 transition ease-in-out duration-150 text-breeder-deepblue font-bold bg-breeder-violet border-breeder-violet hover:bg-breeder-violethover hover:border-breeder-violet">
								{{ __('Create my post') }}
							</a>

							@if(auth()->check() && auth()->user()->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder', 'admin']))
								<a href="{{ route('space.posts.show-offers') }}" class="inline-flex items-center px-5 py-3 whitespace-nowrap rounded-full text-sm focus:outline-none focus:ring-0 transition ease-in-out duration-150 text-breeder-cream hover:text-breeder-deepblue font-bold bg-breeder-deepblue border border-breeder-cream hover:bg-breeder-cream z-[1]">
									{{ __('Go to my dashboard') }}
								</a>
							@endif
						</div>
					</div>

					<div class="relative w-full h-[300px] lg:h-[600px] lg:flex-1 max-lg:hidden">
						<div class="absolute w-full xlsm:w-[calc(180%)] max-lg:h-[300px] lg:h-full right-0 max-lg:top-[44px]">
							<div class="absolute block lg:hidden xlsm:block w-[440px] max-lg:w-[175px] lg:h-[220px] top-[116px] max-lg:left-[50%] max-lg:transform max-lg:translate-x-[-100%] lg:top-[180px] xlsm:left-[100px] xl:left-[142px] xlmd:left-[161px]">
								<img src="{{ asset('/storage/home_transparentblue_e.png') }}" alt="puppy" class="object-cover xl:w-full">
							</div>

							<div class="absolute w-[579px] max-lg:w-[250px] h-[200px] top-0 lg:top-[107px] max-lg:left-[50%] max-lg:transform max-lg:translate-x-[-50%] lg:-left-[35px] xlsm:left-[230px] xl:left-[273px] xlmd:left-[295px]">
								<div class="absolute top-[79px] lmd:top-[8px] lg:-top-[117px] right-0 z-20">
									<img src="{{ asset('/storage/home-breeder_header.png') }}" alt="kitty" class="object-cover w-[250px] lg:w-full">
								</div>

								<div class="relative block lg:hidden top-[50px] left-[160px] w-[206px] z-10">
									<div class="absolute">
										<img src="{{ asset('/storage/home_green_e.png') }}" alt="puppy" class="w-full">
									</div>
								</div>

								<div class="relative hidden xlsm:block top-[50px] lg:-top-[80px] xlsm:left-[370px] xl:left-[380px] xlmd:left-[405px] z-10 h-[205px] w-full max-w-[100%]">
									<div class="absolute max-w-[100%]">
										<img src="{{ asset('/storage/home_violet_e.png') }}" alt="puppy" class="xl:w-full w-[579px] max-lg:w-[206px] h-[205px]">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</x-slot>

	<x-slot name="headerAd">
		<div class="w-full bg-breeder-deepblue">
			@php
				if(Auth::guard('web')->user()?->hasRole(['breeder', 'individual_breeder', 'professionnal_breeder'])) $isBreeder = 'eleveurs';
				else $isBreeder = 'non';
			@endphp
			<div class="flex justify-center items-center mx-auto max-w-[1200px] w-full">
				<x-front.ad-slot slotName="banniere_haute" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'eleveur', 'espece' => ['chat', 'chien']]" />
			</div>
		</div>
	</x-slot>

	<nav class="breadcrumb-list hidden">
		<ol class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
				<a itemprop="item" href="/">
					<span itemprop="name">Accueil</span>
				</a>

				<meta itemprop="position" content="0">
			</li>

			<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem" class="current">
				<span itemprop="name">Home Éleveurs</span>
				<meta itemprop="position" content="1">
			</li>
		</ol>
	</nav>

	@if(auth()->check() && auth()->user()->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder', 'admin']))
		<livewire:front.space.profile.stats
			:where="'breeder'"
			:key="'dashboard-stats-component'"
			:isHome="true" />

		<hr class="bg-breeder-greige border-0 mb-4 mt-12 h-px w-full max-w-[1200px]">
	@endif

	@if(! auth()->check() || ! auth()->user()->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder', 'admin']))
		<div class="w-full flex justify-center px-4 my-10">
			<nav class="flex flex-row gap-x-4 md:gap-x-12 bg-white overflow-x-scroll scrollbar-none">
				<x-front.home.nav-link :href="route('post-search.dog-posts-with-post-type', ['postType' => 'etalon'])" :active="request()->routeIs('post-search.dog-posts*')" :class="' hover:bg-breeder-coral w-[165px] sm:w-[230px] shrink-0'">
					<svg width="37" height="30" viewBox="0 0 37 30" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
						<path d="M13.3372 0.372725C12.2471 -0.712824 9.99594 0.8876 8.90077 1.26551C5.93468 2.28765 2.74551 2.56919 0.925293 5.4606C-2.12445 10.3101 2.93564 21.0413 7.80306 17.4143C10.4092 15.4715 7.96531 10.2543 9.96298 7.40089C10.7641 6.25954 12.2471 5.82583 13.0279 4.38012C13.5071 3.49495 14.1003 1.13109 13.3347 0.370189L13.3372 0.372725ZM35.1088 4.20512C33.2911 2.38657 30.9613 2.34599 28.7254 1.58763C26.639 0.882527 22.6969 -2.09512 23.3078 2.69854C23.7185 5.91968 27.1967 6.34831 27.7367 8.92015C28.2868 11.5453 26.6238 17.0186 30.1222 17.9444C32.7435 18.6368 34.4015 16.7599 35.5017 14.6878C37.2028 11.4844 37.9202 7.01283 35.1113 4.20512H35.1088ZM12.8226 8.72486C10.8858 9.12306 11.4612 12.2427 13.2231 12.1667C15.5478 12.0652 15.5022 8.17447 12.8226 8.72486ZM22.3343 11.6594C23.9087 13.3181 26.5249 10.5662 24.7959 9.0698C23.067 7.57336 20.9705 10.2213 22.3343 11.6594ZM8.07179 18.3198V29.3528C8.07179 29.5151 8.68275 29.959 8.96668 29.9894C11.2052 30.2329 9.93256 26.19 10.1024 24.9142C12.7288 27.0955 15.7507 27.8767 18.3745 25.1882C21.0871 27.7296 23.7591 27.1589 26.5781 25.1679V29.0992C26.5781 30.3192 28.8597 30.1086 28.8597 29.3528V18.3198C26.1446 18.2183 26.7581 19.8035 26.1243 21.5435C25.3359 23.7019 22.4788 25.911 20.3848 23.8845C19.5609 23.0881 19.1984 20.7952 19.4773 19.768C19.599 19.3166 21.8349 18.6876 21.4623 16.7371C20.8995 13.7975 15.3222 14.1932 15.4414 17.1581C15.52 19.101 17.4238 19.5905 17.4644 19.7579C18.3111 23.2935 15.1701 26.4284 12.1204 23.5294C10.0619 21.5714 11.2914 18.0636 8.07179 18.3223V18.3198Z" fill="#0E1954" />
						<path d="M13.3373 0.372752C14.1029 1.13365 13.5072 3.49751 13.0306 4.38269C12.2497 5.8284 10.7642 6.26211 9.9656 7.40346C7.96539 10.2543 10.4092 15.4741 7.80568 17.4169C2.93572 21.0413 -2.12437 10.3101 0.925376 5.46063C2.74559 2.56921 5.93476 2.28768 8.90085 1.26554C9.99602 0.887627 12.2472 -0.715333 13.3373 0.372752Z" fill="#0E1954" />
						<path d="M35.1088 4.20505C37.9177 7.01277 37.2003 11.4843 35.4992 14.6877C34.399 16.7573 32.741 18.6368 30.1197 17.9443C26.6187 17.0186 28.2843 11.5452 27.7342 8.92009C27.1942 6.34825 23.716 5.91961 23.3053 2.69847C22.6943 -2.09519 26.6364 0.882463 28.7228 1.58756C30.9588 2.34592 33.2886 2.38651 35.1063 4.20505H35.1088Z" fill="#0E1954" />
						<path d="M8.07179 18.3197C11.2914 18.0636 10.0619 21.5688 12.1204 23.5268C15.1676 26.4258 18.3086 23.2909 17.4644 19.7553C17.4238 19.5879 15.52 19.0984 15.4414 17.1556C15.3222 14.1906 20.8995 13.7949 21.4623 16.7345C21.8349 18.685 19.599 19.3165 19.4773 19.7654C19.201 20.7927 19.5635 23.0855 20.3849 23.8819C22.4789 25.911 25.3359 23.6993 26.1244 21.5409C26.7607 19.801 26.1446 18.2157 28.8597 18.3172V29.3502C28.8597 30.1061 26.5781 30.3166 26.5781 29.0966V25.1653C23.7591 27.1563 21.0871 27.727 18.3745 25.1856C15.7507 27.8741 12.7288 27.0929 10.1024 24.9117C9.93257 26.1874 11.2052 30.2329 8.96669 29.9869C8.68276 29.9564 8.07179 29.5126 8.07179 29.3502V18.3172V18.3197Z" fill="#0E1954" />
						<path d="M22.3344 11.6593C20.9705 10.2212 23.034 7.54794 24.796 9.06973C26.5579 10.5915 23.9087 13.3181 22.3344 11.6593Z" fill="#0E1954" />
						<path d="M12.8226 8.72478C15.5048 8.1744 15.5479 12.0677 13.2232 12.1666C11.4612 12.2427 10.8858 9.12299 12.8226 8.72478Z" fill="#0E1954" />
					</svg>

					{{ __('Dogs for breeding') }}
				</x-front.home.nav-link>

				<x-front.home.nav-link :href="route('post-search.cat-posts-with-post-type', ['postType' => 'etalon'])" :active="request()->routeIs('post-search.cat-posts*')" :class="' hover:bg-breeder-green w-[165px] sm:w-[218px] shrink-0'">
					<svg width="32" height="30" viewBox="0 0 32 30" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
						<g clip-path="url(#clip0_366_9938)">
							<path d="M17.6585 17.2751C17.2829 17.036 15.264 17.3718 14.6302 17.2395C14.2316 18.3052 15.425 18.8012 15.3023 19.5312C14.9344 21.7363 12.9308 20.9555 12.8261 21.9449C12.7008 23.1352 13.9786 22.919 14.7785 22.5986C15.3381 22.3747 15.8543 21.6168 16.069 21.5786C16.3092 21.5354 18.7625 23.9924 19.6263 22.3289C20.1195 21.3828 17.5614 21.3853 17.0912 19.727C16.805 18.7147 18.6373 17.8957 17.6585 17.2751Z" fill="#0E1954" />
							<path d="M22.4245 16.7333C20.6638 16.7333 18.7702 13.4828 18.2028 12.033C17.7275 10.8198 17.3033 7.93554 16.8893 7.23864C14.9369 5.2522 14.9855 10.1916 14.4488 11.3361C13.8253 13.5642 12.2587 16.1687 9.90513 16.7333L3.12027 14.9428C2.99505 13.6151 4.86313 11.8372 5.1289 10.9546C5.45345 9.87874 4.32392 5.31579 4.4108 3.76174C4.4338 3.34207 4.33414 0.455257 5.68855 0.0533915C6.74142 -0.259453 7.88884 0.877469 8.24406 1.21829C13.1634 5.91859 11.3592 5.9898 16.2658 5.0589C19.455 4.45356 20.1144 5.99235 20.6331 5.5447C22.4041 2.74691 27.556 -3.83809 27.6659 3.5074C27.8345 5.46331 26.9324 9.82533 27.2033 10.9419C27.3004 11.3387 28.5731 13.114 28.913 13.8414C29.0688 14.1746 29.1685 14.9021 29.212 14.9402M10.4725 11.6897C8.62483 12.2187 9.29437 15.1996 11.1241 14.9122C13.4189 14.5536 12.7852 11.0258 10.4725 11.6897ZM22.4782 11.9771C20.8376 10.6494 18.5095 13.0835 20.5156 14.5612C22.1945 15.7999 23.9604 13.1776 22.4782 11.9771Z" fill="#0E1954" />
							<path d="M8.23637 20.3908C9.35312 20.1848 9.969 21.3548 9.19468 21.7566C8.53025 22.1 5.17743 23.4709 5.08288 23.2496C4.98832 23.0284 6.6724 24.9868 6.98417 25.2335C12.6855 29.9338 23.0685 29.4455 27.1522 23.0945C26.3447 22.8554 23.7815 22.2119 23.3164 21.6956C22.9305 21.2683 22.9126 20.4722 23.4774 20.312C24.4536 20.4061 28.4734 21.8914 29.7051 22.3289C24.5763 33.0394 8.01659 32.0652 2.36127 22.3289C2.36127 22.3289 7.28316 20.5663 8.23381 20.3908H8.23637Z" fill="#0E1954" />
							<path d="M17.6585 17.2751C18.6373 17.8982 16.805 18.7147 17.0912 19.727C17.5614 21.3853 20.1195 21.3827 19.6263 22.3289C18.7625 23.9923 16.3092 21.5353 16.069 21.5786C15.8543 21.6167 15.3356 22.3721 14.7785 22.5985C13.9786 22.919 12.7008 23.1377 12.8261 21.9448C12.9308 20.958 14.9344 21.7363 15.3023 19.5311C15.425 18.8011 14.2316 18.3052 14.6302 17.2395C15.3637 16.7308 17.2854 17.036 17.6585 17.2751Z" fill="#0E1954" />
							<path d="M7.96473 17.629L0.69407 18.0539C0.288296 18.0776 -0.021337 18.4242 0.00248621 18.8281C0.0263094 19.2319 0.374567 19.5401 0.780341 19.5164L8.051 19.0915C8.45678 19.0678 8.76641 18.7212 8.74259 18.3173C8.71876 17.9135 8.37051 17.6053 7.96473 17.629Z" fill="#0E1954" />
							<path d="M23.9479 19.0908L31.2186 19.5156C31.6244 19.5393 31.9726 19.2311 31.9964 18.8273C32.0203 18.4234 31.7106 18.0768 31.3049 18.0531L24.0342 17.6282C23.6284 17.6045 23.2802 17.9127 23.2563 18.3166C23.2325 18.7204 23.5421 19.067 23.9479 19.0908Z" fill="#0E1954" />
							<path d="M22.7364 16.7324L31.1999 14.9772C31.5978 14.8947 31.8532 14.5067 31.7703 14.1106C31.6874 13.7146 31.2976 13.4604 30.8996 13.543L22.4362 15.2981C22.0382 15.3807 21.7829 15.7686 21.8658 16.1647C21.9487 16.5607 22.3385 16.8149 22.7364 16.7324Z" fill="#0E1954" />
							<path d="M9.94975 15.2972L1.48626 13.542C1.08833 13.4595 0.698532 13.7136 0.615619 14.1097C0.532705 14.5057 0.788073 14.8937 1.186 14.9762L9.64949 16.7314C10.0474 16.8139 10.4372 16.5598 10.5201 16.1637C10.603 15.7677 10.3477 15.3797 9.94975 15.2972Z" fill="#0E1954" />
						</g>

						<defs>
							<clipPath id="clip0_366_9938">
								<rect width="32" height="30" fill="white" />
							</clipPath>
						</defs>
					</svg>

					{{ __('Cats for breeding') }}
				</x-front.home.nav-link>

				<x-front.home.nav-link :href="route('pages.quisommesnous')" :active="request()->routeIs('pages.quisommesnous')" :class="' hover:bg-breeder-orange w-[151px] shrink-0'">
					{{ __('Our guarantees') }}
				</x-front.home.nav-link>

				<x-front.home.nav-link :href="route('professionnal-activity-search.professionnal-activities')" :active="request()->routeIs('professionnal-activity-search.professionnal-activities')" :class="' hover:bg-breeder-orange w-[165px] sm:w-[188px] shrink-0'">
					{{ __('Products & services') }}
				</x-front.home.nav-link>

				<x-front.home.nav-link :href="route('article.index')" :active="request()->routeIs('article.index')" :class="' hover:bg-breeder-orange w-[112px] shrink-0'">
					{{ __('Advices') }}
				</x-front.home.nav-link>
			</nav>
		</div>

		{{-- Breeder charter --}}
		@include('components.front.home.breeder-charter')
		{{-- End Breeder charter --}}
	@endif

	<div class="max-w-[1200px] w-full mb-8 mt-10 max-xlsm:px-4">
		<h2 class="text-[28px] font-normal">
			<span class="font-bold">
				{{ __('Stalions') }}
			</span>

			{{ __('for breeding') }}
		</h2>

		<livewire:front.animals.breeders.recently-published
			:forSpecies="'dog'"
			:forType="'stud'"
			:key="'animal-posts'" />

		<livewire:front.animals.breeders.recently-published
			:forSpecies="'cat'"
			:forType="'stud'"
			:key="'animal-posts'" />
	</div>

	{{-- Best advices --}}
	@include('components.front.best-advice')
	{{-- End Best advices --}}

	{{-- Ad center page --}}
	<div class="w-full flex justify-center px-4 md:px-8">
		<x-front.ad-slot slotName="banniere_basse" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'eleveur', 'espece' => ['chien', 'chat']]" />
	</div>
	{{-- End Ad center page --}}

	{{-- Services --}}
	@include('components.front.home.breeder-services')
	{{-- End Services --}}

	{{-- Produits --}}
	@include('components.front.home.breeder-products')
	{{-- End Produits --}}

	{{-- CTA Create post --}}
	<div class="w-full flex justify-center px-8">
		<div
			class="mx-auto max-w-[1200px] w-full flex flex-col md:flex-row items-center max-md:gap-y-4 rounded-md bg-breeder-orange justify-between px-8 lg:px-20 max-lg:py-8 mb-20 mt-12">
			<div class="flex items-center">
				<div class="relative w-[120px] md:h-[122px] max-lg:hidden">
					<div class="absolute w-[212px] h-[161px] -right-[16px] bottom-[40px]">
						<img src="{{ asset('/storage/home_breeder_frame_man.png') }}" alt="">
					</div>
				</div>

				<div class="flex flex-col max-md:items-center text-breeder-deepblue">
					<h6 class="font-semibold text-[20px] sm:text-[28px] max-md:text-center">Vous avez une activité secondaire ?</h6>
					<p class="text-[20px] sm:text-base max-md:text-center">Apparaissez dans notre annuaire de produits et services.</p>
				</div>
			</div>

			<div class="flex justify-center min-w-[225px]">
				<a href="{{ route('space.professionnal-activities.show-offers') }}" class="flex justify-center items-center gap-x-1 rounded-full text-breeder-cream text-sm font-semibold bg-breeder-deepblue hover:bg-breeder-deepbluehover py-4 px-6">
					{{ __('Create my post') }}

					<svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.36237 1.5L7.81691 6.5L2.36237 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			</div>
		</div>
	</div>
	{{-- End CTA Create post --}}

	{{-- Certified breeders --}}
	<div class="flex flex-col items-center px-4 md:px-8 pt-8 lg:pt-16 pb-16 w-full bg-breeder-cream gap-y-12">
		<h3 class="font-semibold text-breeder-deepblue text-[40px] text-center">
			{{ __('They trust us') }}
		</h3>

		<div class="flex flex-row flex-wrap justify-center gap-12 w-full">
			<div class="flex flex-col w-[380px] rounded-md bg-white gap-y-2 p-8">
				<p class="text-breeder-deepblue italic h-[316px]">
					"Depuis que j’ai inscrit mon élevage de British Shorthair sur Eleveurs-Online, j’ai vu une vraie différence. Les familles qui me contactent sont déjà bien informées, sérieuses et réellement motivées. Cela me permet de consacrer plus de temps au suivi des chatons et moins aux démarches de tri. La visibilité apportée est incomparable et m’a permis de développer mon activité dans les meilleures conditions."
				</p>

				<hr class="bg-breeder-greige border-0 my-6 h-px w-full">

				<div class="flex flex-col justify-start">
					<a href="#">
						<div class="flex gap-x-2 sm:gap-x-8">
							<div class="flex flex-col gap-y-1 justify-center">
								<h5 class="text-md font-semibold">
									Sophie L., Éleveuse de chats British Shorthair
								</h5>

								<p class="text-sm text-breeder-deepblue font-medium">
									(Loire-Atlantique)
								</p>
							</div>
						</div>
					</a>
				</div>
			</div>

			<div class="flex flex-col w-[380px] rounded-md bg-white gap-y-2 p-8">
				<p class="text-breeder-deepblue italic h-[316px]">
					"Présent sur la plateforme depuis plusieurs années, je considère Eleveurs-Online comme un partenaire indispensable. Les adoptants qui passent par le site sont sensibilisés à l’importance de l’identification, du suivi vétérinaire et des conditions d’élevage. Cela valorise notre travail et renforce la confiance entre nous et les familles. C’est vraiment un gage de professionnalisme."
				</p>

				<hr class="bg-breeder-greige border-0 my-6 h-px w-full">

				<div class="flex flex-col justify-start">
					<a href="#">
						<div class="flex gap-x-2 sm:gap-x-8">
							<div class="flex flex-col gap-y-1 justify-center">
								<h5 class="text-md font-semibold">
									Jean-Marc D., Éleveur de Bergers Australiens
								</h5>

								<p class="text-sm text-breeder-deepblue font-medium">
									(Auvergne-Rhône-Alpes)
								</p>
							</div>
						</div>
					</a>
				</div>
			</div>

			<div class="flex flex-col w-[380px] rounded-md bg-white gap-y-2 p-8">
				<p class="text-breeder-deepblue italic h-[316px]">
					"En tant qu’éleveuse de Maine Coon depuis plus de 10 ans, j’ai essayé plusieurs plateformes avant de revenir définitivement sur Eleveurs-Online. C’est la seule qui m’apporte à la fois de la visibilité, des contacts qualifiés et un vrai sentiment de sécurité dans les échanges. Les adoptants qui me trouvent via le site connaissent déjà nos engagements et respectent notre travail, ce qui change tout dans la relation."
				</p>

				<hr class="bg-breeder-greige border-0 my-6 h-px w-full">

				<div class="flex flex-col justify-start">
					<a href="#">
						<div class="flex gap-x-2 sm:gap-x-8">
							<div class="flex flex-col gap-y-1 justify-center">
								<h5 class="text-md font-semibold">
									Claire B., Éleveuse de chats Maine Coon
								</h5>

								<p class="text-sm text-breeder-deepblue font-medium">
									(Bretagne)
								</p>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>

		<div class="w-full flex flex-row justify-center flex-wrap gap-x-8 gap-y-4">
			<a href="{{ route('post-search.dog-posts') }}">
				<button class="bg-breeder-cream hover:bg-breeder-deepblue border border-breeder-deepbluehover rounded-full text-breeder-deepbluehover hover:text-breeder-cream font-semibold text-sm py-4 px-8">
					{{ __('See posts') }}
				</button>
			</a>

			<a href="{{ route('space.posts.show-offers') }}">
				<button class="bg-breeder-deepblue hover:bg-breeder-deepbluehover border border-breeder-deepblue hover:border-breeder-deepbluehover rounded-full text-breeder-cream font-semibold text-sm py-4 px-8 flex items-center">
					{{ __('Create a post') }}

					<svg class="ml-4" width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>
			</a>
		</div>
	</div>
	{{-- End Certified breeders --}}

	{{-- Our last advices --}}
	<div class="flex justify-center items-stretch w-full pb-10 pt-10">
		<livewire:front.articles.recently-published
			:forArticleTargets="['eleveurs']"
			:key="'last-articles'" />
	</div>
	{{-- End Our last advices --}}

	{{-- Certified breeders --}}
	<div class="flex flex-col items-center px-4 md:px-8 py-8 lg:py-16 w-full bg-breeder-cream gap-y-12">
		<h3 class="font-semibold text-breeder-deepblue text-[40px] text-center">
			{{ __('These companies have joined us') }}
		</h3>

		<div class="flex flex-col max-lg:gap-y-12 lg:flex-row lg:justify-between max-w-[1200px] w-full">
			<livewire:front.companies.recently-published
				:mode="10"
				:key="'dog-companies'" />

			<livewire:front.companies.recently-published
				:mode="10"
				:key="'cat-companies'" />
		</div>
	</div>
	{{-- End Certified breeders --}}

	{{-- NL inscription --}}
	<div class="w-full flex justify-center p-4 my-10">
		<div class="lg:h-[314px] w-full max-w-[1200px] rounded-3xl bg-breeder-violet flex flex-row max-lg:justify-center p-6 md:py-12 md:px-14">
			<div class="flex-1 flex max-lg:justify-center">
				<div class="flex flex-col text-breeder-deepblue max-w-[610px]">
					<h4 class="s:text-[40px] text-[25px] font-semibold mb-6 s:mb-0 leading-tight">
						{{ __('Join our community of breeders') }}
					</h4>
					<p class="text-base mb-6 hidden s:block mt-4">
						{{ __('and stay informed of the latest news in the sector.') }}
					</p>
					<form method="POST" action="{{ route('newsletter.subscribe') }}" class="rounded-full bg-white p-2 flex justify-between items-center w-full text-base">
						 @csrf

						<input type="hidden" name="optins[]" value="OPTIN_NL_ELEVEUR">
						<input type="text" name="email" id="email" value="{{ old('email') }}" required placeholder="Votre adresse email" class="border-0 rounded-full text-breeder-deepblue focus:ring-0 focus:outline-none focus:border-none placeholder:text-breeder-deepblue">

						<button type="submit" class="font-semibold mr-4 hidden s:block">{{ __('I\'m signing up') }}</button>
						<svg class="block s:hidden mr-4" width="35" height="18" viewBox="0 0 35 18"
							fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M26.5 16.2144L34 8.71436L26.5 1.21436" stroke="#0E1954" stroke-width="2"
								stroke-linecap="round" stroke-linejoin="round" />
							<path d="M34 8.71436H1" stroke="#0E1954" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg>

					</form>
				</div>
			</div>
			<div class="flex-1 max-lg:hidden">
				<div class="relative w-full">
					<img src="{{ asset('/storage/home_breeder_nl.png') }}" alt="" class="absolute md:w-[417px] md:h-[364px] -top-[98px] left-[95px]">
				</div>
			</div>
		</div>
	</div>
	{{-- End NL inscription --}}

	@include('components.front.footer-partner-sitemap',['role'=>'eleveur'])
</x-app-layout>
