<div class="w-full">
	@php
		$canonical = '';
		if($articleSection) {
			if($articleTarget) {
				if($articleTarget->slug == 'eleveurs') {
					$title = 'Les actualités et conseils pour les éleveurs canins et félins';
					$description = 'Découvrez tous les articles et conseils pour les éleveurs canins et félins';
				}
				elseif($articleTarget->slug == 'professionnels') {
					$title = 'Les articles et conseils pour les pros de l\'animal de compagnie';
					$description = 'Découvrez tous les articles et conseils pour les professionnels de l\'animal de compagnie par Eleveurs-Online';
				}
				elseif($articleTarget->slug == 'proprietaires') {
					$title = 'Les articles et actualités pour les propriétaires de chiens et chats';
					$description = 'Découvrez tous les articles et actualités pour les propriétaires de chiens et chats';
				}
				$canonical = 'articles/'.$articleSection->slug.'/'.$articleTarget->slug;
			}
			else {
				if($articleSection->slug == 'produits') {
					$title = 'Les articles et actualités produits pour les pros animaliers';
					$description = 'Découvrez tous les articles et actualités produits pour les professionnels de l\'animal de compagnie';
				}
				elseif($articleSection->slug == 'marches-entreprises') {
					$title = 'Les articles et actualités du marché de l\'animal de compagnie';
					$description = 'Découvrez tous les articles et actualités du marché de l\'animal de compagnie';
				}
				elseif($articleSection->slug == 'agenda') {
					$title = 'L\'agenda des professionnels de l\'animal de compagnie';
					$description = 'Découvrez tous les articles et conseils pour les éleveurs canins et félins';
				}
				elseif($articleSection->slug == 'reproduction-genetique') {
					$title = 'Les conseils reproduction pour les éleveurs canins et félins';
					$description = 'Découvrez tous les articles et conseils reproduction en entreprise canin et félin';
				}
				elseif($articleSection->slug == 'prevention') {
					$title = 'Les articles et conseils prévention pour les éleveurs canins et félins';
					$description = 'Découvrez tous les articles et conseils prévention pour les éleveurs canins et félins';
				}
				elseif($articleSection->slug == 'gestion-elevage') {
					$title = 'Les articles et conseils pour gérer son entreprise canin ou félin';
					$description = 'Découvrez tous les articles et conseils pour gérer son entreprise canin ou félin';
				}
				elseif($articleSection->slug == 'legislation') {
					$title = 'Les actualités législation pour les éleveurs canins et félins';
					$description = 'Découvrez tous les articles et conseils législation pour les éleveurs canins et félins';
				}
				elseif($articleSection->slug == 'nutrition') {
					$title = 'Les articles et actualités nutrition pour chiens et chats';
					$description = 'Découvrez tous les articles et actualités nutrition pour chiens et chats';
				}
				elseif($articleSection->slug == 'sante') {
					$title = 'Les articles et actualités santé et entretien pour chiens et chats';
					$description = 'Découvrez tous les articles et actualités santé et entretien pour chiens et chats';
				}
				elseif($articleSection->slug == 'conseils-entretien') {
					$title = 'Les articles et conseils pour propriétaires de chiens et chats';
					$description = 'Découvrez tous les articles et conseils pour propriétaires de chiens et chats';
				}
				elseif($articleSection->slug == 'education-comportement') {
					$title = 'Les conseils éducation et comportement pour chiens et chats';
					$description = 'Découvrez tous les conseils éducation et comportement pour chiens et chats';
				}
				elseif($articleSection->slug == 'inspiration') {
					$title = 'Des parcours et histoires inspirantes autour des chiens et des chats';
					$description = 'Retrouvez ici des interviews et des histoires inspirantes d\'entreprise et de vies autour des chiens et des chats';
				}

				$canonical = 'articles/'.$articleSection->slug;
			}
		}
		elseif($articleSpecies && $articleSpecies->id) {
			$title = 'Les articles et conseils pour les propriétaires de '.__($articleSpecies->getTranslation('slug', 'en')).'s';
			$description = 'Découvrez tous les articles et conseils pour les propriétaires de '.__($articleSpecies->getTranslation('slug', 'en')).'s';
			$canonical = 'articles/'.__($articleSpecies->getTranslation('slug', 'en'));
		}
		elseif($articleTag && $articleTag->id) {
			$title = 'Les articles et conseils '.$articleTag->name;
			$description = 'Découvrez tous les articles et conseils '.$articleTag->name;
			$canonical = 'articles/'.$articleTag->name;
		}
		elseif($articleAuthor && $articleAuthor->id) {
			$title = 'Les articles et conseils de '.$articleAuthor->name;
			$description = 'Découvrez tous les articles et conseils de '.$articleAuthor->name;
			$canonical = 'articles/'.strtolower($articleAuthor->name);
		}
		else {
			$title = 'Les articles et conseils du 1er réseau animalier Eleveurs-Online';
			$description = 'Découvrez tous les articles d\'Eleveurs-Online à destination des professionnels, des éleveurs et des propriétaires d\'animaux';
			$canonical = 'articles';
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

	<div class="flex justify-center items-center mx-auto max-w-[1200px] bg-white w-full">
		<x-front.ad-slot slotName="banniere_haute" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => 'eleveur', 'espece' => ['chien', 'chat']]" />
	</div>

	<div class="w-full mb-6 pt-10 max-w-[1100px] mx-auto px-2 md:px-6 flex items-center gap-3"
		x-data="{
			canScrollLeft: false,
			canScrollRight: false,

			init() {
				this.$nextTick(() => this.updateArrows());
			},

			updateArrows() {
				const el = this.$refs.scrollable;
				if (!el) return;

				const tolerance = 5;
				this.canScrollLeft = el.scrollLeft > tolerance;
				this.canScrollRight = (el.scrollLeft + el.clientWidth) < (el.scrollWidth - tolerance);
			}
		}" x-init="init">
		<div class="flex items-center justify-center rounded-full bg-jobboard-cream cursor-pointer" x-show="canScrollLeft" @click="$refs.scrollable.scrollBy({ left: -300, behavior: 'smooth' }); updateArrows()">
			<svg class="rotate-180 w-[30px] s:w-[47px] h-[30px] s:h-[47px]" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M23.5 47C36.4787 47 47 36.4787 47 23.5C47 10.5213 36.4787 0 23.5 0C10.5213 0 0 10.5213 0 23.5C0 36.4787 10.5213 47 23.5 47Z" fill="#F7F6EF"/>
				<path d="M19.2273 12.8184L29.9091 23.5002L19.2273 34.182" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</div>

		<div class="flex flex-row items-center gap-2 md:gap-3 w-full overflow-x-scroll scrollbar-none" x-ref="scrollable" @scroll="updateArrows">
			<a href="{{ route('home') }}">
				<x-front.primary-button :class="'max-s:px-3 max-s:py-2'">
					<svg class="w-[14px] s:w-[19px] h-[16px] s:h-[22px]" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.01685 21.011V9.7002L9.49995 1.98828L17.9831 9.7002V21.011H1.01685Z" stroke="#F7F6EF" stroke-width="1.5"/>
					</svg>
				</x-front.primary-button>
			</a>

			<svg class="shrink-0" width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1 0.775391L5.725 5.50039L1 10.2254" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>

			<a href="{{ route('article.index') }}">
				<x-front.primary-button :class="'max-s:px-3 max-s:py-2 max-s:text-xs'">
					{{ __('Articles & advices') }}
				</x-front.primary-button>
			</a>

			@if($articleAuthor || $articleTag || $articleSection || $articleSpecies || $articleTarget)
				<svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.72498 0.775391L6.44998 5.50039L1.72498 10.2254" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				@if($articleAuthor && $argument1 == $articleAuthor->slug)
					<a href="{{ route('article.index', ['arg1' => $articleAuthor->slug]) }}">
						<x-front.primary-button :class="'max-s:px-3 max-s:py-2 max-s:text-xs'">
							{{ __($articleAuthor->name) }}
						</x-front.primary-button>
					</a>
				@elseif($articleTag && $argument1 == $articleTag->slug)
					<a href="{{ route('article.index', ['arg1' => $articleTag->slug]) }}">
						<x-front.primary-button :class="'max-s:px-3 max-s:py-2 max-s:text-xs'">
							{{ __($articleTag->name) }}
						</x-front.primary-button>
					</a>
				@elseif($articleSection && $argument1 == $articleSection->slug)
					<a href="{{ route('article.index', ['arg1' => $articleSection->slug]) }}">
						<x-front.primary-button :class="'max-s:px-3 max-s:py-2 max-s:text-xs'">
							{{ __($articleSection->name) }}
						</x-front.primary-button>
					</a>
				@elseif($articleSpecies && $argument1 == $articleSpecies->getTranslation('slug', 'fr'))
					<a href="{{ route('article.index', ['arg1' => $articleSpecies->getTranslation('slug', 'fr')]) }}">
						<x-front.primary-button :class="'max-md:px-3 max-md:py-2 max-s:text-sm'">
							{{ __(ucfirst($articleSpecies->name)) }}
						</x-front.primary-button>
					</a>
				@elseif($articleTarget && $argument1 == $articleTarget->slug)
					<a href="{{ route('article.index', ['arg1' => $articleTarget->slug]) }}">
						<x-front.primary-button :class="'max-s:px-3 max-s:py-2 max-s:text-xs'">
							{{ __(ucfirst($articleTarget->name)) }}
						</x-front.primary-button>
					</a>
				@endif
			@endif

			@if($argument2 && ($articleTarget || $articleSpecies || $articleTag))
				<svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.72498 0.775391L6.44998 5.50039L1.72498 10.2254" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				@if($articleTarget)
					<x-front.breadcrumb-element :href="route('article.index', ['arg1' => $argument1, 'arg2' => $articleTarget->slug])" :class="'flex-shrink-0'">
						{{ __($articleTarget->name) }}
					</x-front.breadcrumb-element>
				@elseif($articleSpecies)
					<x-front.breadcrumb-element :href="route('article.index', ['arg1' => $argument1, 'arg2' => $articleSpecies->getTranslation('slug', 'fr')])" :class="'flex-shrink-0'">
						{{ __(ucfirst($articleSpecies->name)) }}
					</x-front.breadcrumb-element>
				@elseif($articleTag)
					<x-front.breadcrumb-element :href="route('article.index', ['arg1' => $argument1, 'arg2' => $articleTag->slug])" :class="'flex-shrink-0'">
						{{ __($articleTag->name) }}
					</x-front.breadcrumb-element>
				@endif
			@endif

			@if((!$argument1 || ($argument1 && $articleSection)) && $menuEntries && $menuEntries->isNotEmpty())
				<svg class="shrink-0" width="2" height="28" viewBox="0 0 2 28" fill="none" xmlns="http://www.w3.org/2000/svg">
					<line x1="0.75" y1="-3.27835e-08" x2="0.750001" y2="28" stroke="#0E1954" stroke-width="1.5"/>
				</svg>

				@foreach($menuEntries as $menuEntry)
					@php
						$link = false;

						if($menuEntry instanceof \App\Models\ArticleSection) {
							$link = true;
							$route = route('article.index', ['arg1' => $menuEntry->slug]);
						}
						elseif($menuEntry instanceof \App\Models\ArticleTarget || $menuEntry instanceof \App\Models\ArticleTag || $menuEntry instanceof \App\Models\Species) {
							if($menuEntry instanceof \App\Models\ArticleTarget || $menuEntry instanceof \App\Models\ArticleTag) $slug = $menuEntry->slug;
							elseif($menuEntry instanceof \App\Models\Species) $slug = $menuEntry->getTranslation('slug', 'fr');
						}
					@endphp

					@if($link)
						<a href="{{ $route }}" class="text-jobboard-deepblue bg-jobboard-cream py-3 px-5 rounded-full flex flex-row justify-between items-center font-bold text-sm shrink-0 max-s:px-3 max-s:py-2 max-s:text-xs">
							{{ __(ucfirst($menuEntry->name)) }}
						</a>
					@else
						<div wire:click="setFilter('{{ $slug }}')" class="flex items-center gap-x-1 rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs cursor-pointer">
							{{ __(ucfirst($menuEntry->name)) }}

							@if(in_array($slug, $this->filters))
								<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.24729 9.75271L9.75271 5.24727M5.24729 5.24727L9.75271 9.75271M14.5 7.5C14.5 11.366 11.366 14.5 7.5 14.5C3.63401 14.5 0.5 11.366 0.5 7.5C0.5 3.63401 3.63401 0.5 7.5 0.5C11.366 0.5 14.5 3.63401 14.5 7.5Z" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							@endif
						</div>
					@endif
				@endforeach
			@endif
		</div>

		<div class="flex items-center justify-center rounded-full bg-jobboard-cream cursor-pointer" x-show="canScrollRight" @click="$refs.scrollable.scrollBy({ left: 300, behavior: 'smooth' }); updateArrows()">
			<svg class="w-[30px] s:w-[47px] h-[30px] s:h-[47px]" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M23.5 47C36.4787 47 47 36.4787 47 23.5C47 10.5213 36.4787 0 23.5 0C10.5213 0 0 10.5213 0 23.5C0 36.4787 10.5213 47 23.5 47Z" fill="#F7F6EF"/>
				<path d="M19.2273 12.8184L29.9091 23.5002L19.2273 34.182" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</div>
	</div>
	
	<div class="flex flex-col lg:flex-row w-full max-w-[1100px] mx-auto gap-x-6 mb-8 px-2 md:px-6">
		<div class="max-md:flex max-md:flex-col md:grid md:grid-cols-2 gap-x-2 gap-y-4 w-full lg:w-[770px] content-start">
			@if($argument1 && !$argument2)
				@if($articleTag)
					<div class="font-bold text-jobboard-deepblue mb-2 text-[28px] md:text-[40px] col-span-2">
						{{ $articleTag->name }}
					</div>
				@elseif($articleSection)
					<div class="font-bold text-jobboard-deepblue mb-2 text-[28px] md:text-[40px] col-span-2">
						{{ $articleSection->name }}
					</div>
				@elseif($articleSpecies)
					<div class="font-bold text-jobboard-deepblue mb-2 text-[28px] md:text-[40px] col-span-2">
						{{ __(ucfirst($articleSpecies->name)) }}
					</div>
				@elseif($articleTarget)
					<div class="font-bold text-jobboard-deepblue mb-2 text-[28px] md:text-[40px] col-span-2">
						{{ $articleTarget->name }}
					</div>
				@endif
			@elseif ($argument1 && $argument2)
				<div class="font-bold text-jobboard-deepblue mb-2 text-[28px] md:text-[40px] col-span-2 capitalize">
					{{ $argument2 }}
				</div>
			@endif
			@if($articles->isNotEmpty())
				@foreach($articles as $index => $article)
					{{-- TO DO organisation page subsection avec widgets --}}
					{{-- @if(!$argument2) --}}
						<div class="flex @if($index > 0) flex-row-reverse max-s:justify-between s:flex-col @else flex-col @endif text-jobboard-deepblue sm:max-w-[377px] @if(!$loop->first && !$loop->last) max-s:border-b-2 max-s:border-jobboard-greige @endif max-s:py-2">
							<div class="w-full max-s:flex max-s:justify-end max-s:grow-0 max-s:shrink-0 @if($index > 0) max-s:max-w-[120px] @endif">
								<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="w-full @if($index > 0) max-s:max-w-[120px] @else shrink-0 @endif mb-4">
									@if($photo = $article->getFirstMedia('photo'))
										<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $article->title }}" class="object-cover @if($index > 0) max-s:w-[120px] max-s:h-[90px] @endif h-[258px] s:h-[302px] rounded-sm" />
									@else
										<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $article->title }}" class="object-cover @if($index > 0) max-s:w-[120px] max-s:h-[90px] @endif h-[258px] s:h-[302px] rounded-sm" />
									@endif
									{{-- {{ $loop->iteration }} --}}
								</a>
							</div>

							@if($index > 0)
								<div class="max-s:w-[225px] shrink-0 s:mt-4">
									@if(!$argument1)
										<div class="flex flex-wrap gap-2 mb-2">
											@foreach($article->sections as $value)
												<a href="{{ route('article.index', ['arg1' => $value->slug]) }}" class="text-jobboard-orange hover:text-jobboard-darkorange hover:font-bold text-xs font-medium">
													{{ $value->name }}
												</a>
												@if(!$loop->last)
													<span class="font-medium text-xs text-jobboard-greige">|</span>
												@endif
											@endforeach
										</div>
									@endif
									
									<h4 class="font-bold text-[18px] mb-2">
										<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="hyphens-auto hover:underline hover:underline-offset-4">
											{{ Str::limit($article->title, 75) }}
										</a>
									</h4>

									<div class="hidden sm:flex flex-wrap gap-2">
										@if($argument1)
											@foreach($article->tags as $value)
												<div class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs font-medium">
													<a href="{{ route('article.show', ['article' => $article->slug]) }}">
														{{ $value->name }}
													</a>
												</div>
											@endforeach
										@endif

										@if($article->values->get('infomercial') == 'false')
											<div class="rounded-md py-2 px-3 text-center bg-jobboard-orange text-xs font-medium">
												{{ __('Advertorial') }}
											</div>
										@endif
									</div>
								</div>
							@endif
						</div>

						@if($index == 10)
							<x-front.ad-slot slotName="banniere_basse" variant="all" :targeting="['Targetingslug' => Request::url()]" :class="'mx-auto my-8'"/>
						@endif

						@if($index === 0)
							<div class="flex flex-col text-jobboard-deepblue md:max-w-[377px] gap-y-1">
								@if(!$argument1)
									<div class="flex flex-wrap gap-2 mb-2">
										@foreach($article->sections as $value)
											<a href="{{ route('article.index', ['arg1' => $value->slug]) }}" class="text-jobboard-orange hover:text-jobboard-darkorange hover:font-bold text-xs font-medium">
												{{ $value->name }}
											</a>
											@if(!$loop->last)
												<span class="font-medium text-xs text-jobboard-greige">|</span>
											@endif
										@endforeach
									</div>
								@endif

								<a href="{{ route('article.show', ['article' => $article->slug]) }}">
									<h4 class="font-semibold text-[25px] md:text-[28px] hyphens-auto leading-tight hover:underline hover:underline-offset-4">
										{{ Str::limit($article->title, 75) }}
									</h4>
								</a>

								<div class="flex flex-wrap gap-2 mt-2">
									@if($argument1)
										@foreach($article->tags as $value)
											<div class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs font-medium">
												<a href="{{ route('article.show', ['article' => $article->slug]) }}">
													{{ $value->name }}
												</a>
											</div>
										@endforeach
									@endif

									@if($article->values->get('infomercial') == 'false')
										<div class="rounded-md py-2 px-3 text-center bg-jobboard-orange text-xs font-medium">
											{{ __('Advertorial') }}
										</div>
									@endif
								</div>

								<a href="{{ route('article.show', ['article' => $article->slug]) }}">
									<div class="text-lg mt-2 hyphens-auto">
										{{ html_entity_decode(strip_tags(Str::limit($article->header, 107, '...'))) }}
									</div>
								</a>
							</div>
						@endif
				@endforeach

				@if($argument1)
					<div class="flex flex-row w-full my-8 col-span-2">
						{{ $articles->links() }}
					</div>
				@endif
			@else
				{{ __('No articles yet') }}
			@endif
		</div>

		<div class="max-lg:mb-10 w-full lg:w-[300px] flex flex-col gap-y-4">
			<h2 class="font-bold text-[25px] md:text-[28px] m-0">
				{{ __('The most read') }}
			</h2>
			
			<div class="border-6 border-jobboard-orange w-[56px] h-1 bg-jobboard-orange -mt-[13px]"></div>

			@foreach($mostRead as $index => $articleMostRead)
				<a href="{{ route('article.show', ['article' => $articleMostRead->slug]) }}">
					<div class="text-lg font-bold pb-4 text-jobboard-deepblue w-full @if(!$loop->last) border-b border-jobboard-greige @endif">
						@if($index === 0)
							@if($photo = $articleMostRead->getFirstMedia('photo'))
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $articleMostRead->title }}" class="object-cover md:w-[300px] md:h-[200px] mb-2" />
							@else
								<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $articleMostRead->title }}" class="object-cover md:w-[300px] md:h-[200px] mb-2" />
							@endif
						@endif

						<span class="hover:underline hover:underline-offset-4">{{ $articleMostRead->title }}</span>
					</div>
				</a>
			@endforeach

			@php
				if($argument1) {
					switch ($argument1) {
						case 'professionnels':
							$roleSection = 'pro';
							break;

						case 'eleveurs':
							$roleSection = 'eleveur';
							break;

						case 'proprietaires':
							$roleSection = 'adoptant';
							break;

						default:
							$roleSection = ['eleveur', 'adoptant', 'pro'];
							break;
					}
				}
				else $roleSection = ['eleveur', 'adoptant', 'pro'];
			@endphp
			<div class="w-full flex justify-center">
				<x-front.ad-slot slotName="coeur_de_page" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => $roleSection]" />
			</div>
		</div>
	</div>

	{{-- Section propre aux catégories --}}
	{{-- @if(!$argument1 || ($argument1 && $articleTarget)) --}}
	@if(!$argument1)
		<div class="w-full bg-jobboard-deepblue">
			<div class="flex flex-col w-full max-w-[1100px] mx-auto py-10 max-lg:px-2 md:px-6">
				@if(!$argument1)
					<h2 class="text-white font-bold text-[25px] md:text-[28px] mb-4">
						{{ __('Our articles & advice') }}
					</h2>
				{{-- @elseif($articleTarget->slug == 'eleveurs')
					<h2 class="text-jobboard-violet font-bold text-[25px] md:text-[28px] mb-4">
						{{ __('Spécial éleveurs') }}
					</h2>
				@elseif($articleTarget->slug == 'professionnels')
					<h2 class="text-jobboard-orange font-bold text-[25px] md:text-[28px] mb-4">
						{{ __('Spécial pros') }}
					</h2>
				@elseif($articleTarget->slug == 'proprietaires')
					<h2 class="text-jobboard-coral font-bold text-[25px] md:text-[28px] mb-4">
						{{ __('Spécial propriétaire') }}
					</h2> --}}
				@endif

				@if(!$argument1)
					<div class="flex flex-row gap-4 items-stretch sm-justify-center sm:flex-wrap xlsm:flex-nowrap max-sm:overflow-x-scroll scrollbar-none">
						@foreach($articleTargets as $entryArticleSection)
							@if($entryArticleSection->slug == 'proprietaires')
								<div class="rounded-xl w-[208px] shrink-0">
									<div class="w-full h-[155px] rounded-t-xl bg-jobboard-cream relative">
										<a href="{{ route('article.index', ['arg1' => $entryArticleSection->slug]) }}" class="hover:underline hover:underline-offset-4">
											<img src="{{ asset('storage/home_nl.png') }}" alt="" class="absolute bottom-0 left-[4px] w-[198px] h-[171px]" />
										</a>
									</div>
									
									<div class="w-full h-[64px] rounded-b-xl bg-white p-3">
										<div class="flex flex-col items-center justify-center">
											<h4 class="font-bold text-lg">
												<a href="{{ route('article.index', ['arg1' => $entryArticleSection->slug]) }}" class="hover:underline hover:underline-offset-4">
													{{ __('Owners') }}
												</a>
											</h4>
										</div>
									</div>
								</div>
							@elseif($entryArticleSection->slug == 'eleveurs')
								<div class="rounded-xl w-[208px] shrink-0">
									<div class="w-full h-[155px] rounded-t-xl bg-jobboard-violet relative">
										<a href="{{ route('article.index', ['arg1' => $entryArticleSection->slug]) }}" class="hover:underline hover:underline-offset-4">
											<img src="{{ asset('storage/home_article_1.png') }}" alt="" class="absolute bottom-0 left-[4px] w-[187px] h-[174px]" />
										</a>
									</div>

									<div class="w-full h-[64px] rounded-b-xl bg-white p-3">
										<div class="flex flex-col items-center justify-center">
											<h4 class="font-bold text-lg">
												<a href="{{ route('article.index', ['arg1' => $entryArticleSection->slug]) }}" class="hover:underline hover:underline-offset-4">
													{{ __('Éleveurs') }}
												</a>
											</h4>
										</div>
									</div>
								</div>
							@elseif($entryArticleSection->slug == 'professionnels')
								<div class="rounded-xl w-[208px] shrink-0">
									<div class="w-full h-[155px] rounded-t-xl bg-jobboard-orange relative">
										<a href="{{ route('article.index', ['arg1' => $entryArticleSection->slug]) }}" class="hover:underline hover:underline-offset-4">
											<img src="{{ asset('storage/home_article_2.png') }}" alt="" class="absolute bottom-0 left-0 w-[203px] h-[162px]" />
										</a>
									</div>

									<div class="w-full h-[64px] rounded-b-xl bg-white p-3">
										<div class="flex flex-col items-center justify-center">
											<h4 class="font-bold text-lg">
												<a href="{{ route('article.index', ['arg1' => $entryArticleSection->slug]) }}" class="hover:underline hover:underline-offset-4">
													{{ __('Professionials') }}
												</a>
											</h4>
										</div>
									</div>
								</div>
							@endif
						@endforeach

						@foreach($allSpecies as $articleSpeciesSection)
							@if($articleSpeciesSection->name == 'dog')
								<div class="rounded-xl w-[208px] shrink-0">
									<div class="w-full h-[155px] rounded-t-xl bg-jobboard-coral relative">
										<a href="{{ route('article.index', ['arg1' => $articleSpeciesSection->getTranslation('slug', 'fr')]) }}" class="hover:underline hover:underline-offset-4">
											<img src="{{ asset('storage/home_dog_advice_2.png') }}" alt="" class="absolute bottom-0 left-[25px] w-[160px] h-[176px]" />
										</a>
									</div>
									<div class="w-full h-[64px] rounded-b-xl bg-white p-3">
										<div class="flex flex-col items-center justify-center">
											<h4 class="font-bold text-lg">
												<a href="{{ route('article.index', ['arg1' => $articleSpeciesSection->getTranslation('slug', 'fr')]) }}" class="hover:underline hover:underline-offset-4">
													{{ __('Dogs') }}
												</a>
											</h4>
										</div>
									</div>
								</div>
							@elseif($articleSpeciesSection->name == 'cat')
								<div class="rounded-xl w-[208px] shrink-0">
									<div class="w-full h-[155px] rounded-t-xl bg-jobboard-green relative">
										<a href="{{ route('article.index', ['arg1' => $articleSpeciesSection->getTranslation('slug', 'fr')]) }}" class="hover:underline hover:underline-offset-4">
											<img src="{{ asset('storage/home_cat_advice_2.png') }}" alt="" class="absolute bottom-0 left-[22px] w-[168px] h-[164px]" />
										</a>
									</div>
									<div class="w-full h-[64px] rounded-b-xl bg-white p-3">
										<div class="flex flex-col items-center justify-center">
											<h4 class="font-bold text-lg">
												<a href="{{ route('article.index', ['arg1' => $articleSpeciesSection->getTranslation('slug', 'fr')]) }}" class="hover:underline hover:underline-offset-4">
													{{ __('Cats') }}
												</a>
											</h4>
										</div>
									</div>
								</div>
							@endif
						@endforeach
						{{--


						<div class="rounded-xl w-[180px]">
							<div class="w-full h-[155px] rounded-t-xl bg-jobboard-coral relative">
								<img src="{{ asset('storage/home_dog_advice_2.png') }}" alt="" class="absolute bottom-0 left-0 w-[160px] h-[176px]" />
							</div>
							<div class="w-full h-[212px] rounded-b-xl bg-white p-3">
								<div class="flex flex-col">
									<h4 class="font-bold text-lg">
										{{ __('Dogs') }}
									</h4>

									<a href="#" class="flex justify-between items-center font-medium text-sm">
										{{ __('All articles') }}

										<svg class="shrink-0" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14 12L18 16L14 20" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
								</div>
							</div>
						</div>
						<div class="rounded-xl w-[179px]">
							<div class="w-full h-[155px] rounded-t-xl bg-jobboard-green relative">
								<img src="{{ asset('storage/home_cat_advice_2.png') }}" alt="" class="absolute bottom-0 left-0 w-[168px] h-[164px]" />
							</div>
							<div class="w-full h-[212px] rounded-b-xl bg-white p-3">
								<div class="flex flex-col">
									<h4 class="font-bold text-lg">
										{{ __('Cats') }}
									</h4>

									<a href="#" class="flex justify-between items-center font-medium text-sm">
										{{ __('All articles') }}

										<svg class="shrink-0" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14 12L18 16L14 20" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
								</div>
							</div>
						</div> --}}
					</div>
				{{-- @elseif($argument1 && $articleTarget && !$argument2)
					@if($articleTarget->slug == 'eleveurs' || $articleTarget->slug == 'professionnels' || $articleTarget->slug == 'proprietaires')
						<div class="w-full flex flex-row gap-4 items-stretch sm:justify-center sm:flex-wrap xlsm:justify-between xlsm:flex-nowrap max-sm:overflow-x-scroll scrollbar-none">
							@foreach($menuEntries as $articleTarget)
								@php
									switch($articleTarget->slug) {
										case 'eleveurs':
											$bgCards = 'bg-jobboard-violet';
											break;
										case 'professionnels':
											$bgCards = 'bg-jobboard-orange';
											break;
										case 'proprietaires':
											$bgCards = 'bg-jobboard-coral';
											break;

										default:
											$bgCards = 'bg-jobboard-cream';
											break;
									}
									
									switch($articleTarget->slug) {
										case 'reproduction':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'right-0 bottom-0 w-[217px]';
											break;
										case 'prevention':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-0 bottom-0 w-[219px]';
											break;
										case 'gerer-elevage':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[50%] transform -translate-x-[50%] bottom-0 w-[165px]';
											break;
										case 'legislation':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-0 bottom-0 w-[187px]';
											break;
										case 'produits':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[50%] transform -translate-x-[50%] bottom-0 w-[257px]';
												$width = 'w-[273px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[130px] sm:h-[145px]';
											break;
										case 'marches-entreprises':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[50%] transform -translate-x-[50%] bottom-0 w-[143px]';
												$width = 'w-[238px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[130px] sm:h-[145px]';
											break;
										case 'distribution':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[50%] transform -translate-x-[50%] bottom-0 w-[263px]';
												$width = 'w-[273px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[130px] sm:h-[145px]';
											break;
										case 'agenda':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-0 bottom-0 w-[291px]';
												$width = 'w-[273px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[130px] sm:h-[145px]';
											break;
										case 'nutrition':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[50%] transform -translate-x-[50%] bottom-0 w-[173px]';
												$width = 'w-[264px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[120px] sm:h-[145px]';
											break;
										case 'sante':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[50%] transform -translate-x-[50%] bottom-0 w-[218px]';
												$width = 'w-[264px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[120px] sm:h-[145px]';
											break;
										case 'conseils':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[26px] bottom-0 w-[199px]';
												$width = 'w-[264px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[120px] sm:h-[145px]';
											break;
										case 'education-comportement':
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-[50%] transform -translate-x-[50%] bottom-0 w-[158px]';
												$width = 'w-[264px]';
												$height = 'h-[300px]';
												$subHeight = 'h-[120px] sm:h-[145px]';
											break;

										default:
												$imgSubSection = 'home_article_'.$argument1.'_'.$articleTarget->slug.'.png';
												$classes = 'left-0 bottom-0 w-[198px]';
											break;
									}
								@endphp

								<div class="rounded-xl shrink-0 {{ $width ?? '' }} {{ $height ?? '' }} flex flex-col items-stretch">
									<div class="w-full h-[155px] rounded-t-xl {{ $bgCards }} relative">
										<img src="{{ asset('storage/'.$imgSubSection) }}" alt="" class="absolute {{ $classes }}" />
									</div>

									<div class="w-full rounded-b-xl bg-white p-3 {{ $subHeight ?? '' }}">
										<div class="flex flex-col items-center gap-4 p-4">
											<h4 class="font-bold text-lg sm:text-[28px] text-center">
												{{ $articleTarget->name }}
											</h4>

											<svg class="shrink-0" width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					@endif --}}
				@endif
			</div>
		</div>
	@endif
	{{-- END Section propre aux catégories --}}

	{{-- Home blocs article + cta nl --}}
	@if(!$argument1)
		<div class="flex flex-col gap-y-4 mt-6 w-full max-w-[1100px] mx-auto max-md:px-2">
			@if($articlesNutrition->isNotEmpty())
				<div class="flex flex-col border-b border-jobboard-deepblue py-8 w-full">
					<h4 class="font-bold text-[28px] lg:text-[40px] mb-2">
						{{ __('Nutrition') }}
					</h4>

					<div class="flex flex-col max-lg:items-center lg:flex-row w-full max-w-[1100px] mx-auto gap-6 mb-8">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4 w-full lg:w-[770px]">
							@foreach($articlesNutrition as $article)
								@include('components.front.articles.card')
							@endforeach
						</div>

						<div class="w-[300px] max-s:hidden">
							<div class="w-full flex justify-center">
								<x-front.ad-slot
									slotName="coeur_de_page"
									variant="all"
									size="[300,600]"
									:targeting="['Targetingslug' => Request::url(), 'role' => ['adoptant', 'eleveur', 'pro'], 'espece' => ['chien', 'chat']]" />
							</div>
						</div>
					</div>

					<div class="w-full flex justify-center my-8">
						<a href="{{ route('article.index', ['arg1' => 'nutrition']) }}">
							<x-front.primary-button>
								{{ __('See more articles') }}
							</x-front.primary-button>
						</a>
					</div>

						<x-front.ad-slot slotName="banniere_basse" variant="all" :targeting="['Targetingslug' => Request::url()]" :class="'mx-auto my-8'"/>
				</div>
			@endif

			@if($articlesSelection->isNotEmpty())
				<div class="flex flex-col border-b border-jobboard-deepblue py-8"
					x-data="{
						canScrollLeft: false,
						canScrollRight: false,
						screenWidth: window.innerWidth, // Variable pour stocker la largeur

						init() {
							this.$nextTick(() => this.updateArrows());
							// Optionnel : mettre à jour screenWidth si on redimensionne la fenêtre
							window.addEventListener('resize', () => {
								this.screenWidth = window.innerWidth;
								this.updateArrows();
							});
						},

						updateArrows() {
							const el = this.$refs.scrollable;
							if (!el) return;
							const tolerance = 5;
							this.canScrollLeft = el.scrollLeft > tolerance;
							this.canScrollRight = (el.scrollLeft + el.clientWidth) < (el.scrollWidth - tolerance);
						},

						scrollNext() {
							const el = this.$refs.scrollable;
							// On récupère la largeur d'un seul enfant (un article) + le gap
							// C'est souvent plus précis sur iPhone que de calculer l'écran - padding
							const firstChild = el.firstElementChild;
							const gap = parseInt(window.getComputedStyle(el).gap) || 0;
							
							if (firstChild) {
								const scrollAmount = firstChild.offsetWidth + gap;
								el.scrollBy({ left: scrollAmount, behavior: 'smooth' });
							} else {
								// Fallback si pas d'enfant trouvé
								el.scrollBy({ left: el.clientWidth - 16, behavior: 'smooth' });
							}

							setTimeout(() => this.updateArrows(), 500);
						},

						scrollPrev() {
							const el = this.$refs.scrollable;
							const firstChild = el.firstElementChild;
							const gap = parseInt(window.getComputedStyle(el).gap) || 0;

							if (firstChild) {
								const scrollAmount = firstChild.offsetWidth + gap;
								el.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
							} else {
								el.scrollBy({ left: -(el.clientWidth - 16), behavior: 'smooth' });
							}

							setTimeout(() => this.updateArrows(), 500);
						}
					}" x-init="init">
					<h4 class="font-bold text-[28px] lg:text-[40px] mb-2 max-md:flex max-md:justify-between max-md:items-center">
						
						{{ __('Our selection') }}

						<div class="md:hidden flex gap-x-2">
							<svg x-show="canScrollLeft" @click="scrollPrev()" class="md:hidden w-[50px] h-[50px] cursor-pointer" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g filter="url(#filter0_d_7150_65749)">
								<path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF"/>
								</g>
								<path d="M56.0459 36.6364L42.1823 50.5L56.0459 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<defs>
								<filter id="filter0_d_7150_65749" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
								<feFlood flood-opacity="0" result="BackgroundImageFix"/>
								<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
								<feOffset/>
								<feGaussianBlur stdDeviation="10"/>
								<feComposite in2="hardAlpha" operator="out"/>
								<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
								<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_7150_65749"/>
								<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_7150_65749" result="shape"/>
								</filter>
								</defs>
							</svg>
	
							<svg x-show="canScrollRight" @click="scrollNext()" class="md:hidden rotate-180 w-[50px] h-[50px] cursor-pointer" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g filter="url(#filter0_d_7150_65749)">
								<path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF"/>
								</g>
								<path d="M56.0459 36.6364L42.1823 50.5L56.0459 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<defs>
								<filter id="filter0_d_7150_65749" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
								<feFlood flood-opacity="0" result="BackgroundImageFix"/>
								<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
								<feOffset/>
								<feGaussianBlur stdDeviation="10"/>
								<feComposite in2="hardAlpha" operator="out"/>
								<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
								<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_7150_65749"/>
								<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_7150_65749" result="shape"/>
								</filter>
								</defs>
							</svg>
						</div>
					</h4>

					<div class="flex flex-row gap-4 md:flex-1 md:w-full max-md:overflow-x-auto max-md:scrollbar-none max-md:snap-x max-md:snap-mandatory md:flex-wrap lg:flex-nowrap" x-ref="scrollable" @scroll.debounce.100ms="updateArrows">
						@foreach($articlesSelection as $article)
							@include('components.front.articles.inline-big-card')
						@endforeach
					</div>
				</div>
			@endif

			@if($articlesHealth->isNotEmpty())
				<div class="flex flex-col border-b border-jobboard-deepblue py-8">
					<h4 class="font-bold text-[28px] lg:text-[40px] mb-2">
						{{ __('Health') }}
					</h4>

					<div class="flex flex-col max-lg:items-center lg:flex-row w-full max-w-[1100px] mx-auto gap-6 mb-8">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4 w-full lg:w-[770px]">
							@foreach($articlesHealth as $article)
								@include('components.front.articles.card')
							@endforeach
						</div>

						<div class="w-[300px] max-s:hidden">
							<div class="w-full flex justify-center">
								<x-front.ad-slot
									slotName="coeur_de_page"
									variant="all"
									size="[300,250]"
									:targeting="['Targetingslug' => Request::url(), 'role' => ['adoptant', 'eleveur', 'pro'], 'espece' => ['chien', 'chat']]" />
							</div>
						</div>
					</div>

					<div class="w-full flex justify-center my-8">
						<a href="{{ route('article.index', ['arg1' => 'sante']) }}">
							<x-front.primary-button>
								{{ __('See more articles') }}
							</x-front.primary-button>
						</a>
					</div>
				</div>
			@endif

			@if($articlesDog->isNotEmpty())
				<div class="flex flex-col border-b border-jobboard-deepblue py-8">
					<h4 class="font-bold text-[28px] lg:text-[40px] mb-2 flex gap-x-2 items-center">
						<svg width="50" height="40" viewBox="0 0 50 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.828 0.496567C16.3708 -0.950852 13.3616 1.18308 11.8977 1.68697C7.93294 3.04984 3.66995 3.42522 1.23686 7.2805C-2.83975 13.7465 3.92411 28.055 10.4304 23.219C13.914 20.6285 10.6473 13.6721 13.3176 9.86759C14.3884 8.34577 16.3708 7.76748 17.4145 5.83984C18.055 4.65959 18.848 1.50773 17.8246 0.493185L17.828 0.496567ZM46.9301 5.60649C44.5004 3.18173 41.3862 3.12762 38.3974 2.11646C35.6085 1.17631 30.339 -2.79394 31.1557 3.59769C31.7047 7.8926 36.354 8.46413 37.0758 11.8933C37.8111 15.3935 35.5881 22.6914 40.2646 23.9258C43.7685 24.849 45.9847 22.3465 47.4554 19.5836C49.7292 15.3123 50.6882 9.35017 46.9335 5.60649H46.9301ZM17.14 11.6329C14.5511 12.1638 15.3203 16.3235 17.6755 16.222C20.7829 16.0868 20.7219 10.899 17.14 11.6329ZM29.8545 15.5457C31.9588 17.7574 35.456 14.0881 33.1449 12.0928C30.8338 10.0976 28.0313 13.6282 29.8545 15.5457ZM10.7896 24.4263V39.1372C10.7896 39.3537 11.6063 39.9455 11.9858 39.9861C14.9781 40.3107 13.2769 34.9201 13.504 33.219C17.0147 36.1274 21.054 37.169 24.5613 33.5843C28.1872 36.9729 31.7589 36.212 35.5271 33.5572V38.799C35.5271 40.4257 38.577 40.145 38.577 39.1372V24.4263C34.9477 24.291 35.7677 26.4047 34.9206 28.7246C33.8667 31.6025 30.0476 34.5481 27.2486 31.846C26.1472 30.7841 25.6626 27.727 26.0354 26.3573C26.1981 25.7554 29.1869 24.9167 28.6887 22.3161C27.9365 18.3965 20.4813 18.9241 20.6406 22.8774C20.7456 25.4679 23.2905 26.1206 23.3448 26.3438C24.4766 31.0581 20.278 35.238 16.2014 31.3726C13.4498 28.7618 15.0933 24.0848 10.7896 24.4297V24.4263Z" fill="#FF7E71"/>
							<path d="M17.828 0.49701C18.8514 1.51156 18.0551 4.66341 17.418 5.84367C16.3743 7.7713 14.3885 8.34959 13.3211 9.87141C10.6474 13.6726 13.9141 20.6324 10.4339 23.2228C3.9242 28.0555 -2.83965 13.747 1.23696 7.28094C3.67004 3.42567 7.93303 3.05028 11.8978 1.68741C13.3617 1.18352 16.3709 -0.953791 17.828 0.49701Z" fill="#FF7E71"/>
							<path d="M46.9301 5.60649C50.6848 9.35016 49.7258 15.3123 47.452 19.5835C45.9813 22.3431 43.7651 24.849 40.2611 23.9258C35.5813 22.6914 37.8077 15.3935 37.0724 11.8933C36.3506 8.46413 31.7013 7.8926 31.1523 3.59769C30.3356 -2.79395 35.6051 1.17631 38.394 2.11645C41.3828 3.12762 44.497 3.18173 46.9267 5.60649H46.9301Z" fill="#FF7E71"/>
							<path d="M10.7896 24.4263C15.0933 24.0847 13.4497 28.7584 16.2014 31.3692C20.2746 35.2346 24.4732 31.0547 23.3448 26.3404C23.2905 26.1172 20.7456 25.4645 20.6406 22.874C20.4813 18.9207 27.9365 18.3931 28.6887 22.3127C29.1869 24.9133 26.198 25.7554 26.0354 26.3539C25.666 27.7236 26.1506 30.7807 27.2485 31.8426C30.0476 34.5481 33.8667 31.5991 34.9206 28.7212C35.7711 26.4013 34.9477 24.2877 38.577 24.4229V39.1338C38.577 40.1416 35.5271 40.4223 35.5271 38.7957V33.5538C31.7589 36.2086 28.1872 36.9695 24.5613 33.5809C21.054 37.1656 17.0147 36.124 13.504 33.2157C13.2769 34.9167 14.978 40.3107 11.9858 39.9827C11.6063 39.9421 10.7896 39.3503 10.7896 39.1338V24.4229V24.4263Z" fill="#FF7E71"/>
							<path d="M29.8544 15.5455C28.0313 13.628 30.7897 10.0636 33.1449 12.0927C35.5 14.1218 31.9588 17.7572 29.8544 15.5455Z" fill="#FF7E71"/>
							<path d="M17.14 11.6335C20.7253 10.8997 20.7829 16.0908 17.6754 16.2227C15.3203 16.3241 14.5511 12.1645 17.14 11.6335Z" fill="#FF7E71"/>
						</svg>

						{{ __('Specially for dogs') }}
					</h4>

					<div class="flex flex-row gap-4 flex-wrap xlsm:flex-nowrap">
						@foreach($articlesDog as $article)
							@include('components.front.articles.inline-card')
						@endforeach
					</div>

					<div class="w-full flex justify-center my-8">
						<a href="{{ route('article.index', ['arg1' => 'chien']) }}">
							<x-front.primary-button>
								{{ __('See more articles') }}
							</x-front.primary-button>
						</a>
					</div>
				</div>
			@endif

			@if($articlesEducation->isNotEmpty())
				<div class="flex flex-col border-b border-jobboard-deepblue py-8">
					<h4 class="font-bold text-[28px] lg:text-[40px] mb-2">
						{{ __('Education & behavior') }}
					</h4>

					<div class="flex flex-col max-lg:items-center lg:flex-row w-full max-w-[1100px] mx-auto gap-6 mb-8">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4 w-full lg:w-[770px]">
							@foreach($articlesEducation as $article)
								@include('components.front.articles.card')
							@endforeach
						</div>

						<div class="w-[300px] max-s:hidden">
							<div class="w-full flex justify-center">
								<x-front.ad-slot slotName="coeur_de_page" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => $roleSection]" />
							</div>
						</div>
					</div>

					<div class="w-full flex justify-center my-8">
						<a href="{{ route('article.index', ['arg1' => 'education-comportement']) }}">
							<x-front.primary-button>
								{{ __('See more articles') }}
							</x-front.primary-button>
						</a>
					</div>
				</div>
			@endif

			@if($articlesCat->isNotEmpty())
				<div class="flex flex-col py-8">
					<h4 class="font-bold text-[28px] lg:text-[40px] mb-2 flex items-center gap-x-2">
						<svg width="50" height="40" viewBox="0 0 50 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_7474_54774)">
							<path d="M27.2924 23.0331C26.7118 22.7143 23.5915 23.1619 22.612 22.9856C21.9959 24.4066 23.8404 25.0679 23.6508 26.0412C23.082 28.9814 19.9855 27.9403 19.8235 29.2595C19.63 30.8467 21.6048 30.5584 22.8411 30.1311C23.7061 29.8327 24.5039 28.8221 24.8357 28.7712C25.207 28.7135 28.9987 31.9895 30.3337 29.7716C31.096 28.5101 27.1423 28.5134 26.4156 26.3023C25.9732 24.9526 28.8051 23.8606 27.2924 23.0331Z" fill="#3DD8AC"/>
							<path d="M34.6586 22.3111C31.9373 22.3111 29.0105 17.977 28.1337 16.044C27.3991 14.4263 26.7434 10.5805 26.1036 9.65133C23.086 7.00271 23.161 13.5886 22.3316 15.1147C21.3679 18.0855 18.9467 21.5582 15.309 22.3111L4.82259 19.9236C4.62906 18.1534 7.51628 15.7828 7.92705 14.606C8.42866 13.1715 6.6829 7.0875 6.81719 5.0154C6.85274 4.45583 6.6987 0.606692 8.79204 0.0708641C10.4193 -0.346268 12.1927 1.16965 12.7417 1.62409C20.3449 7.89124 17.5564 7.98619 25.1398 6.74497C30.069 5.93784 31.0881 7.98958 31.8899 7.39271C34.627 3.66227 42.5896 -5.11785 42.7594 4.67627C43.0201 7.28419 41.6259 13.1003 42.0445 14.5891C42.1946 15.1181 44.1616 17.4853 44.6869 18.4552C44.9278 18.8994 45.0818 19.8694 45.149 19.9202M16.1859 15.5861C13.3302 16.2915 14.3651 20.2661 17.193 19.8829C20.7399 19.4048 19.7603 14.701 16.1859 15.5861ZM34.7415 15.9693C32.2058 14.1991 28.6077 17.4446 31.7082 19.4149C34.3031 21.0665 37.0324 17.57 34.7415 15.9693Z" fill="#3DD8AC"/>
							<path d="M12.7299 27.1881C14.4559 26.9134 15.4078 28.4734 14.211 29.0093C13.1841 29.4671 8.0021 31.295 7.85596 31C7.70982 30.7049 10.3127 33.3162 10.7945 33.6452C19.6063 39.9124 35.6539 39.2612 41.9655 30.7931C40.7174 30.4743 36.7559 29.6163 36.037 28.9279C35.4406 28.3581 35.413 27.2967 36.2859 27.083C37.7947 27.2085 44.0075 29.189 45.9113 29.7723C37.9842 44.0531 12.3902 42.7543 3.64954 29.7723C3.64954 29.7723 11.2567 27.4221 12.7259 27.1881H12.7299Z" fill="#3DD8AC"/>
							<path d="M27.2924 23.0338C28.8051 23.8646 25.9732 24.9532 26.4156 26.303C27.1423 28.5141 31.096 28.5107 30.3337 29.7723C28.9987 31.9902 25.207 28.7142 24.8357 28.7719C24.5039 28.8227 23.7021 29.83 22.8411 30.1318C21.6048 30.5591 19.63 30.8507 19.8235 29.2602C19.9855 27.9444 23.082 28.9821 23.6508 26.0419C23.8404 25.0685 21.9959 24.4072 22.612 22.9863C23.7456 22.308 26.7157 22.715 27.2924 23.0338Z" fill="#3DD8AC"/>
							<path d="M12.31 23.5062L1.07269 24.0726C0.44554 24.1043 -0.0330176 24.5664 0.00380271 25.1049C0.040623 25.6434 0.578878 26.0543 1.20603 26.0227L12.4433 25.4562C13.0705 25.4246 13.549 24.9624 13.5122 24.4239C13.4754 23.8855 12.9371 23.4745 12.31 23.5062Z" fill="#3DD8AC"/>
							<path d="M37.0131 25.4544L48.2504 26.0209C48.8775 26.0525 49.4158 25.6416 49.4526 25.1031C49.4894 24.5646 49.0109 24.1025 48.3837 24.0708L37.1464 23.5044C36.5193 23.4728 35.981 23.8837 35.9442 24.4221C35.9074 24.9606 36.3859 25.4228 37.0131 25.4544Z" fill="#3DD8AC"/>
							<path d="M35.1406 22.31L48.2215 19.9697C48.8365 19.8597 49.2312 19.3424 49.103 18.8143C48.9749 18.2863 48.3724 17.9474 47.7574 18.0574L34.6765 20.3977C34.0615 20.5077 33.6668 21.025 33.795 21.5531C33.9231 22.0811 34.5256 22.42 35.1406 22.31Z" fill="#3DD8AC"/>
							<path d="M15.378 20.3969L2.29713 18.0567C1.68211 17.9466 1.07965 18.2855 0.951499 18.8136C0.82335 19.3417 1.21804 19.8589 1.83306 19.969L14.9139 22.3092C15.529 22.4193 16.1314 22.0804 16.2596 21.5523C16.3877 21.0242 15.993 20.507 15.378 20.3969Z" fill="#3DD8AC"/>
							</g>
							<defs>
							<clipPath id="clip0_7474_54774">
							<rect width="49.4581" height="40.0006" fill="white"/>
							</clipPath>
							</defs>
						</svg>

						{{ __('Specially for cats') }}
					</h4>

					<div class="flex flex-row gap-4 flex-wrap xlsm:flex-nowrap">
						@foreach($articlesCat as $article)
							@include('components.front.articles.inline-card')
						@endforeach
					</div>

					<div class="w-full flex justify-center my-8">
						<a href="{{ route('article.index', ['arg1' => 'chat']) }}">
							<x-front.primary-button>
								{{ __('See more articles') }}
							</x-front.primary-button>
						</a>
					</div>
				</div>
			@endif

			@if($articlesReproduction->isNotEmpty())
				<div class="flex flex-col py-8">
					<h4 class="font-bold text-[28px] lg:text-[40px] mb-2">
						{{ __('Reproduction & genetic') }}
					</h4>

					<div class="flex flex-col max-lg:items-center lg:flex-row w-full max-w-[1100px] mx-auto gap-6 mb-8">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4 w-full lg:w-[770px]">
							@foreach($articlesReproduction as $article)
								@include('components.front.articles.card')
							@endforeach
						</div>

						<div class="w-[300px] max-s:hidden">
							<div class="w-full flex justify-center">
								<x-front.ad-slot slotName="coeur_de_page" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => $roleSection]" />
							</div>
						</div>
					</div>

					<div class="w-full flex justify-center my-8">
						<a href="{{ route('article.index', ['arg1' => 'reproduction-genetique']) }}">
							<x-front.primary-button>
								{{ __('See more articles') }}
							</x-front.primary-button>
						</a>
					</div>
				</div>
			@endif
		</div>

		@include('components.front.nl', ['bgcolor' => 'bg-jobboard-coral'])
	@endif
	{{-- End Home blocs article --}}

	{{-- Blocs article quand dans articleSection + cta nl --}}
	@if(($argument1 && $articleSection) && (!$argument2 || ($argument2 && !$articleTarget)))
		<div class="flex flex-col gap-y-4 mt-6 w-full max-w-[1100px] mx-auto px-2 md:px-6">
			{{-- 
			@foreach($articleSection->subSections as $subSections)
				@if($subSections->publishedArticles->isNotEmpty())
					<div class="flex flex-col @if(!$loop->last) border-b border-jobboard-deepblue @endif py-8 w-full">
						<h4 class="font-bold text-[28px] lg:text-[40px] mb-2">
							{{ $subSections->name }}
						</h4>

						<div class="flex flex-col max-lg:items-center lg:flex-row w-full max-w-[1100px] mx-auto gap-6 mb-8">
							<div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4 w-full lg:w-[770px]">
								@foreach($subSections->publishedArticles->take(4) as $article)
									<div class="flex flex-row-reverse justify-between s:flex-col text-jobboard-deepblue sm:max-w-[377px]">
										<div class="w-full">
											<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="w-full max-s:max-w-[120px] mb-4">
												@if($photo = $article->getFirstMedia('photo'))
													<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $article->title }}" class="object-cover max-s:w-[120px] max-s:h-[90px] s:h-[302px] rounded-sm" />
												@else
													<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $article->title }}" class="object-cover max-s:w-[120px] max-s:h-[90px] s:h-[302px] rounded-sm" />
												@endif
											</a>
										</div>

										<div class="max-s:w-[225px] shrink-0 mt-5">
											<h4 class="font-bold text-[18px] mb-2">
												<a href="{{ route('article.show', ['article' => $article->slug]) }}" class="hyphens-auto">
													{{ Str::limit($article->title, 75) }}
												</a>
											</h4>

											<div class="hidden sm:flex flex-wrap gap-2">
												<div class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs font-medium">
													<a href="{{ route('article.show', ['article' => $article->slug]) }}">
														{{ $article->sections->first()->name }}
													</a>
												</div>

												<div class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs font-medium">
													<a href="{{ route('article.show', ['article' => $article->slug]) }}">
														{{ $article->targets->first()->name }}
													</a>
												</div>

												{{-- To do gestion des tags
												<div class="rounded-md py-2 px-3 text-center bg-jobboard-cream text-xs font-medium">
													<a href="{{ route('article.show', ['article' => $article->slug]) }}">
														{{ $article->articleTarget->name }}
													</a>
												</div>
												--}}

												{{--
												@if($article->values->get('infomercial') == 'false')
													<div class="rounded-md py-2 px-3 text-center bg-jobboard-orange text-xs font-medium">
														{{ __('Advertorial') }}
													</div>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>

							<div class="w-[300px]">
								<div class="w-full flex justify-center">
									<x-front.ad-slot slotName="coeur_de_page" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => $roleSection]" />
								</div>
							</div>
						</div>

						<div class="w-full flex justify-center my-8">
							<a href="{{ route('article.index', ['arg1' => $articleSection->slug, 'arg2' => $subSections->slug]) }}">
								<x-front.primary-button>
									{{ __('See more articles') }}
								</x-front.primary-button>
							</a>
						</div>
					</div>
				@endif
			@endforeach
			--}}
		</div>

		@if($argument1 == 'eleveurs')
			{{-- NL inscription breeder --}}
			<div class="w-full flex justify-center p-4 mb-10">
				<div class="lg:h-[314px] w-full max-w-[1200px] rounded-3xl bg-jobboard-violet flex flex-row max-lg:justify-center p-6 md:py-12 md:px-14">
					<div class="flex-1 flex max-lg:justify-center">
						<div class="flex flex-col text-jobboard-deepblue max-w-[610px]">
							<h4 class="s:text-[40px] text-[25px] font-semibold mb-6 s:mb-0 leading-tight">
								{{ __('Join our community of breeders') }}
							</h4>

							<p class="text-base mb-6 hidden s:block mt-4">
								{{ __('and stay informed of the latest news in the sector.') }}
							</p>

							<form method="POST" action="{{ route('newsletter.subscribe') }}" class="rounded-full bg-white p-2 flex justify-between items-center w-full text-base">
								@csrf

								<input type="hidden" name="optins[]" value="OPTIN_NL_ELEVEUR">

								<input type="text" name="email" id="email" value="{{ old('email') }}" required placeholder="Votre adresse email" class="border-0 rounded-full text-jobboard-deepblue focus:ring-0 focus:outline-none focus:border-none placeholder:text-jobboard-deepblue">

								<button type="submit" class="font-semibold mr-4 hidden s:block">
									{{ __('I\'m signing up') }}
								</button>
								
								<svg class="block s:hidden mr-4" width="35" height="18" viewBox="0 0 35 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M26.5 16.2144L34 8.71436L26.5 1.21436" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M34 8.71436H1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
			{{-- End NL inscription breeder --}}
		@elseif($argument1 == 'professionnels')
		@elseif($argument1 == 'proprietaires')
			@include('components.front.nl', ['bgcolor' => 'bg-jobboard-coral'])
		@endif
	@endif
	{{-- End Blocs article quand dans articleSection + cta nl --}}

	@if($argument2 && $articleTarget)
		@if($argument1 == 'eleveurs')
			{{-- NL inscription breeder --}}
				<div class="w-full flex justify-center p-4 mb-10">
					<div class="lg:h-[314px] w-full max-w-[1200px] rounded-3xl bg-jobboard-violet flex flex-row max-lg:justify-center p-6 md:py-12 md:px-14">
						<div class="flex-1 flex max-lg:justify-center">
							<div class="flex flex-col text-jobboard-deepblue max-w-[610px]">
								<h4 class="s:text-[40px] text-[25px] font-semibold mb-6 s:mb-0 leading-tight">
									{{ __('Join our community of breeders') }}
								</h4>

								<p class="text-base mb-6 hidden s:block">
									{{ __('and stay informed of the latest news in the sector.') }}
								</p>

								<form method="POST" action="{{ route('newsletter.subscribe') }}" class="rounded-full bg-white p-2 flex justify-between items-center w-full text-base">
									@csrf

									<input type="hidden" name="optins[]" value="OPTIN_NL_ELEVEUR">

									<input type="text" name="email" id="email" value="{{ old('email') }}" required placeholder="Votre adresse email" class="border-0 rounded-full text-jobboard-deepblue focus:ring-0 focus:outline-none focus:border-none placeholder:text-jobboard-deepblue">

									<button type="submit" class="font-semibold mr-4 hidden s:block">{{ __('I\'m signing up') }}</button>
									<svg class="block s:hidden mr-4" width="35" height="18" viewBox="0 0 35 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M26.5 16.2144L34 8.71436L26.5 1.21436" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M34 8.71436H1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
			{{-- End NL inscription breeder --}}
		@elseif($argument1 == 'professionnels')
			{{-- NL inscription --}}
			<div class="w-full flex justify-center p-4 my-10">
				<div class="lg:min-h-[338px] w-full max-w-[1200px] rounded-3xl bg-jobboard-orange flex flex-row max-lg:justify-center p-6 md:py-12 md:px-14">
					<div class="flex-1 flex max-lg:justify-center">
						<div class="flex flex-col text-jobboard-deepblue w-full max-w-[610px]">
							<h4 class="s:text-[40px] text-[25px] font-semibold mb-6 s:mb-0 w-full max-s:px-4 leading-tight">
								{{ __('Join our community of pet professionals') }}
							</h4>

							<p class="text-base mb-6 hidden s:block">
								{{ __('and stay informed of the latest news in the sector.') }}
							</p>

							<form method="POST" action="{{ route('newsletter.subscribe') }}" class="rounded-full bg-white p-2 flex justify-between items-center w-full text-base">
								@csrf

								<input type="hidden" name="optins[]" value="OPTIN_NL_PROFESSIONNEL">

								<input type="text" name="email" id="email" value="{{ old('email') }}" required placeholder="Votre adresse email" class="border-0 rounded-full text-jobboard-deepblue focus:ring-0 focus:outline-none focus:border-none placeholder:text-jobboard-deepblue">

								<button type="submit" class="font-semibold mr-4 hidden s:block">{{ __('I\'m signing up') }}</button>

								<svg class="block s:hidden mr-4" width="35" height="18" viewBox="0 0 35 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M26.5 16.2144L34 8.71436L26.5 1.21436" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M34 8.71436H1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</form>
						</div>
					</div>

					<div class="relative w-[400px] max-lg:hidden">
						<div class="absolute w-[400px] md:h-[386px] lg:-top-[33px] xlsm:-top-[93px] left-0">
							<img src="{{ asset('/storage/home_pro_nl.png') }}" alt="" class="w-full">
						</div>
					</div>
				</div>
			</div>
			{{-- End NL inscription --}}
		@elseif($argument1 == 'proprietaires')
			@include('components.front.nl', ['bgcolor' => 'bg-jobboard-coral'])
		@endif
	@endif
</div>