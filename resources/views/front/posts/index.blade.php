<x-app-layout>
	@php
		$canonical = '';
		if($postType->id) {
			if($breed->id) {
				if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
					$title = ucfirst($species->getTranslation('slug', 'en') == 'dog' ? 'chiot' : 'chaton').' '.$breed->name.' à vendre: portées disponibles en France et en Belgique';
					$description = "Recherchez votre ".($species->getTranslation('slug', 'en') == 'dog' ? 'chiot' : 'chaton')." de race ".$breed->name." avec notre liste d'annonces légales et contrôlées.";
					$canonical = __($species->getTranslation('slug', 'en')).'/portee/'.$breed->slug;
				}
				elseif($postType->getTranslation('slug', 'en') == 'retired-breeder') {
					$title = ucfirst($species->getTranslation('slug', 'en') == 'dog' ? 'chien' : 'chat').' '.$breed->name.' à vendre: '.($species->getTranslation('slug', 'en') == 'dog' ? 'chien' : 'chat').' disponibles en France et en Belgique';
					$description = "Recherchez un ".__($species->getTranslation('slug', 'en'))." adulté ou retraité d'entreprise avec notre liste d'annonces légales et contrôlées.";
					$canonical = __($species->getTranslation('slug', 'en')).'/adulte-retraite/'.$breed->slug;
				}
				elseif($postType->getTranslation('slug', 'en') == 'stud') {
					$title = ucfirst($species->getTranslation('slug', 'en') == 'dog' ? 'chien' : 'chat').' étalons '.$breed->name.' pour saillie: en France et en Belgique';
					$description = "Recherchez un ".__($species->getTranslation('slug', 'en'))." de race ".$breed->name." reproducteur pour saillie avec notre liste d'annonces légales et contrôlées.";
					$canonical = __($species->getTranslation('slug', 'en')).'/etalon/'.$breed->slug;
				}
			}
			else {
				if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
					$title = "Trouvez votre ".($species->getTranslation('slug', 'en') == 'dog' ? 'chiot' : 'chaton')." de race ou d'apparence";
					$description = "Recherchez votre ".($species->getTranslation('slug', 'en') == 'dog' ? 'chiot de race (LOF)' : 'chaton de race (LOOF)')." ou d'apparence avec notre liste d'annonces légales et contrôlées.";
					$canonical = __($species->getTranslation('slug', 'en')).'/portee';

				}
				elseif($postType->getTranslation('slug', 'en') == 'retired-breeder') {
					$title = "Vente de ".ucfirst(__($species->getTranslation('slug', 'en')))."s adultes ou retraités d'entreprise de race ".$breed->name;
					$description = "Recherchez un ".__($species->getTranslation('slug', 'en'))." de race ".$breed->name." adultes ou retraité d'entreprise avec notre liste d'annonces légales et contrôlées.";
					$canonical = __($species->getTranslation('slug', 'en')).'/adulte-retraite';
				}
				elseif($postType->getTranslation('slug', 'en') == 'stud') {
					$title = "Trouvez un ".__($species->getTranslation('slug', 'en'))." de race reproducteur pour saillie";
					$description = "Recherchez un ".__($species->getTranslation('slug', 'en'))." de race reproducteur pour saillie avec notre liste d'annonces légales et contrôlées.";
					$canonical = __($species->getTranslation('slug', 'en')).'/etalon';
				}
			}
		}
		elseif($breed->id) {
			if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
				$title = ucfirst($species->getTranslation('slug', 'en') == 'dog' ? 'chiot' : 'chaton').' '.$breed->name.' à vendre: portées disponibles en France et en Belgique';
				$description = "Recherchez votre ".($species->getTranslation('slug', 'en') == 'dog' ? 'chiot' : 'chaton')." de race d'apparence ".$breed->name." avec notre liste d'annonces légales et contrôlées.";
				$canonical = __($species->getTranslation('slug', 'en')).'/portee/'.$breed->slug;
			}
			elseif($postType->getTranslation('slug', 'en') == 'retired-breeder') {
				$title = ucfirst($species->getTranslation('slug', 'en') == 'dog' ? 'chien' : 'chat').' '.$breed->name.' à vendre: '.($species->getTranslation('slug', 'en') == 'dog' ? 'chien' : 'chat').' disponibles en France et en Belgique';
				$description = "Recherchez un ".__($species->getTranslation('slug', 'en'))." adulté ou retraité d'entreprise avec notre liste d'annonces légales et contrôlées.";
				$canonical = __($species->getTranslation('slug', 'en')).'/adulte-retraite/'.$breed->slug;
			}
			elseif($postType->getTranslation('slug', 'en') == 'stud') {
				$title = ucfirst($species->getTranslation('slug', 'en') == 'dog' ? 'chien' : 'chat').' étalons '.$breed->name.' pour saillie: en France et en Belgique';
				$description = "Recherchez un ".__($species->getTranslation('slug', 'en'))." de race ".$breed->name." reproducteur pour saillie avec notre liste d'annonces légales et contrôlées.";
				$canonical = __($species->getTranslation('slug', 'en')).'/etalon/'.$breed->slug;
			}
		}
		else {
			$title = "Adopter des ".__($species->getTranslation('slug', 'en'))."s en toute confiance";
			$description = "Recherchez votre ".($species->getTranslation('slug', 'en') == 'dog' ? 'chien de race (LOF)' : 'chat de race (LOOF)')." ou d'apparence avec notre liste d'annonces légales et contrôlées.";
			$canonical = __($species->getTranslation('slug', 'en'));
		}
	@endphp

	@push('seo')
		<title>{{ $title }}</title>
		<meta name="description" content="{{ $description }}">
		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ env('APP_URL') }}/{{ $canonical }}" />
		<meta property="og:title" content="{{ $title }}">
		<meta property="og:description" content="{{ $description }}">
		<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		<meta property="og:url" content="{{ env('APP_URL') }}/{{ $canonical }}">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="{{ env('APP_NAME') }}">
		<meta property="og:locale" content="fr_FR">
	@endpush

	{{-- Page main title (home) --}}
	<x-slot name="mainTitle">
		<div x-data="{searchVisible: false, advancedSearchDisplay: false}">
			<div class="bg-cover bg-center bg-breeder-cream flex flex-col items-center lg:justify-end py-10 min-h-[328px] h-full md:h-[500px] lg:h-[400px]">
				@if($species->getTranslation('slug', 'en') == 'dog')
					<div class="relative w-full block md:hidden lg:block">
						<div class="absolute w-full lg:h-full right-0 max-md:top-[83px] top-[23px]">
							<div class="absolute w-[800px] max-lg:w-[250px] h-[300px] top-0 md:-top-[85px] xlsm:-top-[144px] max-lg:left-[50%] max-lg:transform max-lg:translate-x-[-50%] right-[176px]">
								<div class="z-10 absolute block lg:hidden xlsm:block w-[440px] max-lg:w-[175px] lg:h-[220px] max-lg:left-[50%] max-lg:transform max-lg:translate-x-[-100%] bottom-[95px] lg:-bottom-[82px] xlmd:right-[345px]">
									<img src="{{ asset('/storage/home_coral_e.png') }}" alt="puppy" class="object-cover xl:w-full">
								</div>

								<div class="absolute top-[79px] lg:top-[1px] right-[110px] lg:right-[250px] z-[12]">
									<img src="{{ asset('/storage/company_old_dog.png') }}" alt="stalion" class="object-cover w-[96px] lg:w-[290px]">
								</div>

								<div class="absolute top-[99px] lg:top-[64px] right-[61px] lg:right-[100px] z-[13]">
									<img src="{{ asset('/storage/company_young_dog.png') }}" alt="puppy" class="object-cover w-[81px] lg:w-[242px]">
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
				@elseif($species->getTranslation('slug', 'en') == 'cat')
					<div class="relative w-full block md:hidden lg:block">
						<div class="absolute w-full lg:h-full right-0 max-md:top-[83px] top-[23px]">
							<div class="absolute w-[800px] max-lg:w-[250px] h-[300px] top-0 md:-top-[85px] xlsm:-top-[144px] max-lg:left-[50%] max-lg:transform max-lg:translate-x-[-50%] right-[176px]">
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
				@endif

				<div class="flex flex-row items-center justify-center gap-x-6 w-full z-20">
					<div class="flex flex-col max-md:gap-y-4 md:flex-row md:justify-center items-center w-full max-w-[1200px]">
						<div class="flex flex-col items-center gap-6 text-[25px] md:text-[40px] text-breeder-deepblue w-full">
							<div class="flex flex-col w-full md:max-w-[680px] lg:max-w-[628px] max-md:px-4 lg:px-4 xlsm:px-0 lg:self-start">
								@if($postType->id)
									<div class="mb-1 text-[28px] lg:text-[40px] font-bold text-breeder-deepblue">
										@if($postType->getTranslation('slug', 'en') == 'litter')
											{{ __('Find your :specie by breed or appearance', ['specie' => $species->getTranslation('slug', 'en') == 'dog' ? __('puppy') : __('kitty')]) }}
										@elseif($postType->getTranslation('slug', 'en') == 'stud')
											{{ __('Find a purebred :specie for mating', ['specie' => $species->getTranslation('slug', 'en') == 'dog' ? __('dog') :  __('cat')]) }}
										@elseif($postType->getTranslation('slug', 'en') == 'retired-breeder')
											{{ __('Find your adult or retired company :specie', ['specie' => $species->getTranslation('slug', 'en') == 'dog' ? __('dog') : __('cat')]) }}
										@endif
									</div>
								@else
									<div class="mb-1 text-[28px] lg:text-[40px] font-bold text-breeder-deepblue">
										@if($species->getTranslation('slug', 'en') == 'dog')
											{{ __('Adopting :specie with confidence', ['specie' => __('dogs')]) }}
										@else
											{{ __('Adopting :specie with confidence', ['specie' => __('cats')]) }}
										@endif
									</div>
								@endif
							</div>

							<div class="hidden md:block w-full px-4 xlsm:px-0 max-w-[1200px]">
								<livewire:front.posts.filters
									:species="$species"
									:postType="$postType"
									:breed="$breed"
									:displayPost="'w-full'"
									:withRedirect="true"
									:key="'post-filters'" />
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
							<livewire:front.posts.filters
								:species="$species"
								:postType="$postType"
								:breed="$breed"
								:displayPost="'mx-3'"
								:withRedirect="true"
								:responsive="true"
								:key="'post-filters'" />
						</div>
					</div>
				</div>
			</div>

			@if($postType->id)
				<div x-show="advancedSearchDisplay">
					<livewire:front.posts.advanced-filters
						:species="$species"
						:postType="$postType"
						:responsive="true"
						:key="'post-advanced-filters-responsive'" />
				</div>
			@endif
		</div>
	</x-slot>
	<x-slot name="headerAd">
		@php
			if(Auth::guard('web')->user()?->hasRole(['breeder', 'individual_breeder', 'professionnal_breeder'])) $isDog = 'Chien';
			else $isDog = 'non';
		@endphp
		{{-- <div class="flex justify-center items-center mx-auto max-w-[1200px] bg-white w-full">
			<x-front.ad-slot slotName="banniere_haute" variant="all" />

			<x-front.ad-slot slotName="banniere_haute" variant="all" :targeting="['Chien' => $isDog]" />
		</div>--}}
	</x-slot>
	<div class="w-full mb-6 pt-10">
		<nav class="w-full max-w-[1200px] px-4 md:px-8 lg:px-0 text-sm text-breeder-deepblue mb-2 hidden">
			{{-- Breadcrumb --}}
			@if(!empty($breadcrumb))
				@include('components.front.breadcrumb', [
					'breadcrumb' => $breadcrumb,
					'currentPage' => 'Recherche',
				])
			@endif
		</nav>
		<!-- Bannière haute, variante 'all' -->
		<div class="flex justify-center items-center mx-auto max-w-[1200px] bg-white w-full mb-10">
			<x-front.ad-slot slotName="banniere_haute" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'adoptant', 'espece' => $species->getTranslation('slug', 'fr')]" />
		</div>

		@if(is_null(($postType->getTranslation('slug', 'en'))))
			<div class="md:flex hidden max-sm:flex-col max-sm:justify-start justify-end max-w-[1200px] w-full mx-auto px-2">
				<livewire:front.posts.post-count
				:key="'post-count'"
				:breed="$breed"
				:postType="$postType"
				:species="$species" />
			</div>
		@endif

		<div class="flex flex-col lg:flex-row gap-x-8 max-w-[1200px] mx-auto max-md:px-6">
			{{-- Left col --}}
			@if($postType->id)
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

					<div class="max-md:fixed max-md:inset-0 max-md:bg-black max-md:bg-opacity-70 max-md:z-50 max-md:overflow-y-auto" x-show="openSidemenu">
						<div class="bg-white w-full h-full">
							<div class="w-full text-sm lg:text-base lg:w-[300px] max-lg:px-6 max-md:pt-6 flex flex-col items-center">
								<livewire:front.posts.advanced-filters
									:species="$species"
									:postType="$postType"
									:key="'post-advanced-filters'" />
	
								@if(Request::is('chat/*'))
									<x-front.ad-slot
										slotName="coeur_de_page"
										variant="all"
										:targeting="[
											'Targetingslug' => ['/chat/portee', '/chat/adulte-retraite', '/chat/etalon'],
											'role' => 'adoptant',
											'espece' => ['chat']
										]"
									/>
								@elseif(Request::is('chien/*'))
									<x-front.ad-slot
										slotName="coeur_de_page"
										variant="all"
										:targeting="[
											'Targetingslug' => ['/chien/portee', '/chien/adulte-retraite', '/chien/etalon'],
											'role' => 'adoptant',
											'espece' => ['chien']
										]"
									/>
								@endif
							</div>
						</div>
					</div>
				</div>

				{{-- <div class="flex md:hidden max-sm:flex-col max-sm:justify-start max-w-[1200px] w-full mx-auto px-2">
					<livewire:front.posts.post-count
					:key="'post-count'"
					:breed="$breed" />
				</div> --}}
			@endif

			{{-- Content --}}
			<section class="p-0">
				@if($postType->id)
					<div class="md:flex hidden max-sm:flex-col max-sm:justify-start justify-end max-w-[1200px] w-full mx-auto px-2">
						<livewire:front.posts.post-count
						:key="'post-count'"
						:breed="$breed"
						:postType="$postType"
						:species="$species" />
					</div>
				@endif

				<div class="flex mb-4">
					<livewire:front.posts.index
						:species="$species"
						:postType="$postType"
						:breed="$breed"
						:key="'post-index'" />
				</div>

				<div class="mb-8">
					<livewire:front.posts.save-search :key="'save-search-banner-component'" :button="false" :banner="true" />
				</div>

				<div class="mb-4">
					@if($breed && $breed->exists)
						@if(data_get($breed->values, 'caracteristics'))
							<div class="flex flex-col gap-2">
								<h2 class="font-bold text-lg">
									{{ __('Caracteristics of the :breed breed', ['breed' => $breed->name]) }}
								</h2>

								@include('components.front.breeds.caracteristics')

								@if(data_get($breed->values, 'informations.introduction'))
									<div class="flex flex-row mt-4">
										{!! nl2br(data_get($breed->values, 'informations.introduction')) !!}
									</div>
								@endif

								<a href="{{ route('breed-search.'.$species->getTranslation('slug', 'en').'-breeds.show', ['breed' => $breed->slug]) }}" class="mt-4">
									<x-front.secondary-button>
										{{ __('Show the breed sheet') }}
									</x-front.secondary-button>
								</a>
							</div>
						@endif
					@endif
				</div>
			</section>
		</div>
	</div>

	{{-- Actualité de :species --}}
	<div class="flex flex-col justify-center items-stretch w-full py-20">
		<h3 class="font-semibold text-breeder-deepblue text-[25px] sm:text-[40px] text-center mb-4">
			{{ __('Our latest news') }}
		</h3>

		<livewire:front.articles.recently-published
			:forSpecies="$species->getTranslation('slug', 'en')"
			:title="false"
			:key="'last-articles'" />
	</div>
	{{-- End Actualité de :species --}}

	{{-- Top races de :species --}}
	<div class="w-full py-12 bg-breeder-deepblue flex flex-col items-center justify-center gap-y-8">
		<h3 class="font-semibold text-white text-[25px] sm:text-[40px] text-center">
			{{ __('Top :specie breeds', ['specie' => $species->getTranslation('slug', 'en') == 'dog' ? __('dog') : __('cat')]) }}
		</h3>

		{{-- AJOUTER BREED CARDS--}}
			{{-- @foreach($breeds as $breed)
				<x-front.breeds.card :breed="$breed"/>
			@endforeach --}}
		{{-- FIN AJOUT --}}

		<div class="flex w-full bg-breeder-deepblue my-6">
			<div class="mx-auto max-w-[1200px]">
				<livewire:front.breeds.top-breeds
					:for="$species->getTranslation('slug', 'en')"
					:mode="10"
					:key="'top-'.$species->getTranslation('slug', 'en').'-breeds'" />
			</div>
		</div>

		{{--
			<div class="flex justify-center gap-4 flex-wrap">
				<article class="bg-white w-[228px] h-[251px] rounded-xl">
					<div class="overflow-hidden sm:flex-none flex justify-center items-stretch w-full h-[187px] rounded-t-xl bg-[#F8F8F8]">
						<img src="{{ asset('/storage/top_race_chien.png') }}" alt="" class="object-cover w-full rounded-t-xl" />
					</div>

					<div class="flex flex-col p-4 h-[64px]">
						<div class="text-[18px] font-bold">
							[Nom de la race]
						</div>
					</div>
				</article>
			</div>
		--}}

		<a href="{{ route('breed-search.'.$species->getTranslation('slug', 'en').'-breeds') }}" class="bg-breeder-deepblue hover:bg-breeder-cream border border-breeder-cream rounded-full text-breeder-cream hover:text-breeder-deepblue font-semibold text-sm py-4 px-8">
			{{ __('See all breeds') }}
		</a>
	</div>
	{{-- End Top races de :specie --}}

	{{-- Certified breeders --}}
	<div class="flex flex-col items-center px-4 md:px-8 py-8 lg:py-16 w-full bg-breeder-cream gap-y-12">
		<div class="flex flex-col items-center px-4 md:px-8 py-8 lg:py-16 w-full bg-breeder-cream gap-y-12 max-w-[1200px]">
			<livewire:front.companies.recently-published
				:forSpecies="$species->getTranslation('slug', 'en')"
				:mode="10"
				:doubleColumnDisplay="true"
				:key="$species->getTranslation('slug', 'en').'-companies'" />
		</div>
	</div>
	{{-- End Certified breeders --}}

	{{-- Best advices --}}
	@include('components.front.best-advice')
	{{-- End Best advices --}}

	{{-- Services --}}
	@include('components.front.home.adopter-services')
	{{-- End Services --}}

	{{-- Produits --}}
	@include('components.front.home.adopter-products')
	{{-- End Produits --}}

	@if(! auth()->check() || ! auth()->user()->hasRole(['adopter', 'breeder', 'professionnal_breeder', 'individual_breeder', 'professionnal', 'admin']))
		{{-- CTA Vous êtes professionnel ? --}}
		<div class="w-full flex justify-center p-4">
			<div class="mx-auto max-w-[1200px] w-full flex flex-col md:flex-row items-center max-md:gap-y-4 rounded-xl bg-breeder-orange justify-between px-8 lg:px-20 max-lg:py-8 my-20">
				<div class="flex items-center">
					<div class="relative w-[150px] md:h-[122px] max-lg:hidden">
						<div class="absolute w-[212px] h-[161px] right-[8px] bottom-[4px]">
							<img src="{{ asset('/storage/cta_professional.png') }}" alt="">
						</div>
					</div>

					<div class="flex flex-col max-md:items-center text-breeder-deepblue">
						<h6 class="font-semibold text-[20px] sm:text-[28px] max-md:text-center">
							{{ __('Are you professional?') }}
						</h6>

						<p class="text-[20px] sm:text-base max-md:text-center">
							{{ __('List your products and services in our directory!') }}
						</p>
					</div>
				</div>

				<div class="flex justify-center min-w-[225px]">
					<a href="{{ route('space.professionnal-activities.show-offers') }}">
						<x-front.primary-button :class="'flex justify-center items-center gap-x-1 rounded-full text-breeder-cream text-sm font-semibold bg-breeder-deepblue hover:bg-breeder-deepbluehover py-4 px-6'">
							{{ __('Create my post') }}

							<svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2.36237 1.5L7.81691 6.5L2.36237 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</x-front.primary-button>
					</a>
				</div>
			</div>
		</div>
		{{-- END CTA Vous êtes professionnel --}}
	@endif

	@if(auth()->check() && auth()->user()->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder', 'admin']))
		{{-- CTA Create post --}}
		<div class="w-full flex justify-center px-8 mt-10">
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
	@endif

	{{-- NL inscription --}}
	<div class="w-full flex justify-center p-4 mb-10">
		<div class="lg:min-h-[338px] w-full max-w-[1200px] rounded-3xl bg-breeder-coral flex flex-row max-lg:justify-center p-4 sm:p-6 md:py-12 md:px-14">
			<div class="flex-1 flex max-lg:justify-center">
				<div class="flex flex-col text-breeder-deepblue max-w-[450px]">
					<h4 class="s:text-[40px] text-[25px] font-semibold mb-6 s:mb-0 max-s:text-center leading-tight">
						{{ __('Join our community') }}
					</h4>

					<p class="text-base font-medium mb-6 hidden s:block">
						{{ __('and stay informed about news and the best advice for adopting or caring for your animals.') }}
					</p>

					<div class="rounded-full bg-white p-2 flex justify-between items-center w-full text-base">
						<input type="text" type="email" placeholder="Votre adresse email" class="border-0 rounded-full text-breeder-deepblue focus:ring-0 focus:outline-none focus:border-none placeholder:text-breeder-deepblue w-2/3">

						<button class="font-semibold mr-4 hidden s:block w-[102px]">
							{{ __('I\'m signing up') }}
						</button>

						<svg class="block s:hidden mr-4 w-[35px] max-xs:w-[20px]" viewBox="0 0 35 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M26.5 16.2144L34 8.71436L26.5 1.21436" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M34 8.71436H1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</div>
			</div>

			<div class="flex-1 max-lg:hidden">
				<div class="relative w-full">
					<div class="absolute md:w-[447px] md:h-[386px] -top-[90px] left-[25px]">
						<img src="{{ asset('/storage/home_nl.png') }}" alt="" class="w-full">
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- End NL inscription --}}

	{{-- CTA Create post --}}
	<div class="flex flex-col md:flex-row w-full">
		<div class="flex-1 flex sm:justify-center bg-breeder-violet px-8 py-8 md:py-16 w-full">
			<div class="flex flex-col items-start w-full sm:max-w-[340px] lg:max-w-[441px] text-breeder-deepblue">
				<h3 class="font-semibold text-[25px] md:text-[32px] lg:text-[40px]">
					{{ __('You are breeder') }} ?
				</h3>

				<p class="text-base hidden s:block">
					{{ __('Litters, stallions or retired adults, post your ads and promote your company to potential adopters') }}
				</p>

				<div class="mt-4 w-full">
					<a href="{{ route('space.posts.show-offers') }}">
						<button class="bg-breeder-deepblue hover:bg-breeder-deepbluehover border border-breeder-deepblue hover:border-breeder-deepbluehover rounded-full text-breeder-cream hover:text-breeder-cream font-semibold text-sm py-4 px-8 max-s:w-full">
							{{ __('Create my post') }}
						</button>
					</a>
				</div>
			</div>
		</div>

		<div class="flex-1 flex sm:justify-center bg-breeder-deepblue px-8 py-8 md:py-16 w-full">
			<div class="flex flex-col items-start text-white w-full sm:max-w-[340px] lg:max-w-[520px]">
				<h3 class= "font-semibold text-[25px] md:text-[32px] lg:text-[40px]">
					{{ __('You are professional') }} ?
				</h3>

				<p class="text-base hidden s:block">
					{{ __('Boarding kennels, groomers, trainers... Let our community know about your business') }}
				</p>

				<div class="mt-4 w-full">
					<a href="{{ route('space.professionnal-activities.show-offers') }}">
						<button class="bg-breeder-deepblue hover:bg-breeder-deepbluehover border border-breeder-cream hover:border-breeder-deepbluehover rounded-full text-breeder-cream font-semibold text-sm py-4 px-8 max-s:w-full">
							{{ __('Create my post') }}
						</button>
					</a>
				</div>
			</div>
		</div>
	</div>
	{{-- END Create post --}}

	@include('components.front.footer-partner-sitemap')
</x-app-layout>
