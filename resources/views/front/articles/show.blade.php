<x-app-layout>
	@php
		 // Préparer les données pour JSON-LD
		$jsonLdArticle = [
			'@context' => 'https://schema.org',
			'@type' => 'Article',
			'headline' => $article->title,
			'url' => Request::url(),
			'description' => Str::limit(str_replace(["\r", "\n"], '', strip_tags($article->body)), 250),
			'publisher' => [
				'@type' => 'Organization',
				'name' => 'Eleveurs Online',
				'url' => config('app.url'),
			],
			'inLanguage' => 'fr_FR',
			'author' => [
				'@type' => 'Person',
				'name' => $article->author?->name,
			],
			'articleSection' => $article->mainSection()->name,
		];

		// Ajouter datePublished si non null
		if ($article->start_publication_date instanceof \Carbon\Carbon) {
			$jsonLdArticle['datePublished'] = $article->start_publication_date->toIso8601String();
		}

		// Ajouter l'image si disponible
		if ($photo = $article->getFirstMedia('photo')) {
			$jsonLdArticle['image'] = $photo->getAvailableUrl(['optimized']);
		}

		// Ajouter la date de modification si disponible
		if ($article->updated_at) {
			$jsonLdArticle['dateModified'] = $article->updated_at->toIso8601String();
		}

		// Ajouter les tags si disponibles
		if ($article->tags->isNotEmpty()) {
			$jsonLdArticle['keywords'] = $article->tags->take(4)->pluck('name')->toArray();
		}

		// Préparer les données pour JSON-LD BreadcrumbList
		$jsonLdBreadcrumb = [
			'@context' => 'https://schema.org',
			'@type' => 'BreadcrumbList',
			'itemListElement' => [
				[
					'@type' => 'ListItem',
					'position' => 1,
					'name' => 'Home', // Remplacer par le nom de votre page d'accueil
					'item' => config('app.url') // Remplacer par l'URL de votre page d'accueil
				],
				[
					'@type' => 'ListItem',
					'position' => 2,
					'name' => 'Home article', // Nom de la section ou catégorie
					'item' => url('articles/') // Remplacer par l'URL de la section
				],
				[
					'@type' => 'ListItem',
					'position' => 3,
					'name' => __($article->mainSection()->name), // Nom de la section ou catégorie
					'item' => url('articles/' . $article->mainSection()->slug) // Remplacer par l'URL de la section
				],
				[
					'@type' => 'ListItem',
					'position' => 4,
					'name' => __($article->targets->first()->name), // Nom de la section ou catégorie
					'item' => url('articles/' . $article->mainSection()->slug . '/' . $article->targets->first()->slug) // Remplacer par l'URL de la section
				],
				[
					'@type' => 'ListItem',
					'position' => 5,
					'name' => $article->title, // Titre de l'article
					'item' => Request::url() // URL de l'article actuel
				]
			]
		];
	@endphp

	@push('seo')
		<title>{{ $article->title }}</title>
		<meta name="description" content="{{ Str::limit(str_replace(array("\r", "\n"), '', strip_tags($article->body)), 250) }}">
		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
		<meta property="og:title" content="{{ $article->title }}" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="{{ Request::url() }}" />
		@if($photo = $article->getFirstMedia('photo'))
			<meta property="og:image" content="{{ $photo->getAvailableUrl(['optimized']) }}" />
		@else
			<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		@endif
		<meta property="og:description" content="{{ Str::limit(str_replace(array("\r", "\n"), '', strip_tags($article->body)), 250) }}">
		<meta property="og:site_name" content="{{ env('APP_NAME') }}">
		<meta property="og:locale" content="fr_FR">
		<!-- Balises spécifiques à article -->
		@if($article->start_publication_date)
			<meta property="article:published_time" content="{{ $article->start_publication_date->toIso8601String() }}">
		@endif
		@if($article->updated_at)
			<meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
		@endif
		<meta property="article:author" content="{{ $article->author->name }}">
		<meta property="article:section" content="{{ __($article->sections->first()->name) }}">
		@if($article->tags->isNotEmpty())
			@foreach($article->tags->take(4) as $articleTags)
				<meta property="article:tag" content="{{ $articleTags->name }}">
			@endforeach
		@endif

		<script type="application/ld+json">
			{!! json_encode($jsonLdArticle, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
		</script>
		<script type="application/ld+json">
			{!! json_encode($jsonLdBreadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
		</script>
	@endpush

	<div class="w-full mb-6 pt-10 max-w-[1100px] mx-auto max-xlsm:px-6">
		<div class="flex flex-row items-center gap-2 md:gap-3 w-full overflow-x-scroll scrollbar-none">
			<a href="{{ route('home') }}">
				<x-front.primary-button :class="'max-s:px-3 max-s:py-2'">
					<svg class="w-[14px] s:w-[19px] h-[16px] s:h-[22px]" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.01685 21.011V9.7002L9.49995 1.98828L17.9831 9.7002V21.011H1.01685Z" stroke="#F7F6EF" stroke-width="1.5"/>
					</svg>
				</x-front.primary-button>
			</a>

			<svg class="shrink-0" width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1 0.775391L5.725 5.50039L1 10.2254" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>

			<a href="{{ route('article.index') }}">
				<x-front.primary-button :class="'max-s:px-3 max-s:py-2 max-s:text-xs'">
					{{ __('Articles & advices') }}
				</x-front.primary-button>
			</a>

			<svg class="shrink-0" width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.72498 0.775391L6.44998 5.50039L1.72498 10.2254" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>

			<a href="{{ route('article.index', ['arg1' => $article->mainSection()->slug]) }}">
				<x-front.primary-button :class="'max-s:px-3 max-s:py-2 max-s:text-xs'">
					{{ $article->mainSection()->name }}
				</x-front.primary-button>
			</a>

			@if($article->tags->isNotEmpty() || $article->species->isNotEmpty() || $article->targets->isNotEmpty())
				<svg class="shrink-0" width="3" height="29" viewBox="0 0 3 29" fill="none" xmlns="http://www.w3.org/2000/svg">
					<line x1="1.4751" y1="0.5" x2="1.4751" y2="28.5" stroke="#0E1954" stroke-width="1.5"/>
				</svg>

				@if($article->targets->isNotEmpty())
					@foreach($article->targets as $articleTarget)
						<span class="text-jobboard-deepblue bg-jobboard-cream p-2 rounded-xl flex flex-row justify-between items-center font-medium text-xs">
							{{ $articleTarget->name }}
						</span>
					@endforeach
				@endif

				@if($article->species->isNotEmpty())
					@foreach($article->species as $articleSpecies)
						<span class="text-jobboard-deepblue bg-jobboard-cream p-2 rounded-xl flex flex-row justify-between items-center font-medium text-xs">
							{{ __($articleSpecies->name) }}
						</span>
					@endforeach
				@endif

				@if($article->tags->isNotEmpty())
					@foreach($article->tags as $articleTag)
						<span class="text-jobboard-deepblue bg-jobboard-cream p-2 rounded-xl flex flex-row justify-between items-center font-medium text-xs">
							{{ $articleTag->name }}
						</span>
					@endforeach
				@endif
			@endif
		</div>
	</div>
	
	<div class="gap-4 flex flex-col items-center mt-2 max-w-[1200px] w-full mx-auto">
		{{-- Content --}}
		<article class="article text-sm lg:text-base max-w-[1200px] w-full mb-8">
			<div class="flex flex-col gap-4 md:px-4 max-sm:p-4 pl-0 md:border-t md:border-transparent w-full">
				<div class="flex flex-col gap-4 max-sm:p-4 pl-0 md:border-t md:border-transparent w-full max-md:px-6 max-w-[1100px] mx-auto">
					<h1>
						{{ $article->title }}
					</h1>

					<div class="flex flex-row gap-x-2 mb-4">
						@if($article->values->has('infomercial') && $article->values->get('infomercial') == true)
							<div>
								<div class="rounded-md py-2 px-3 text-center bg-jobboard-orange text-xs grow-0">
									{{ __('Infomercial') }}
								</div>
							</div>
						@endif

						<div class="flex flex-col article-header">
							{!! $article->header !!}
						</div>
					</div>

					<div class="text-sm mb-8 font-medium border-l-8 border-jobboard-deepblue w-full bg-jobboard-cream flex items-center p-4">
						@php
							$publicationDate = '';
							if($article->start_publication_date) $publicationDate = $article->start_publication_date->format('d/m/Y H:i:s');
							else $publicationDate = $article->updated_at->format('d/m/Y H:i:s');
						@endphp

						<a href="{{ route('article.index', ['arg1' => $article->author->slug]) }}">
							{!! __('Written by :author - the :date', ['author' => $article->author->name, 'date' => $publicationDate]) !!}
						</a>
					</div>
				</div>

				@if($photo = $article->getFirstMedia('photo'))
					<div class="w-full">
						<div class="w-full mb-8">
							<div class="overflow-hidden sm:max-h-[700px] flex flex-col justify-center items-stretch rounded-sm">
								<img src="{{ $photo->getAvailableUrl(['optimized']) }}" class="object-cover w-full lg:h-[700px] brightness-45 rounded-sm" />
							</div>

							@if($article->values->has('photoCredit'))
								<div class="flex flex-row text-sm mt-2 font-medium">
									{{ __('Credit :credit', ['credit' => $article->values->get('photoCredit')]) }}
								</div>
							@endif
						</div>
					</div>
				@endif

				<div class="flex flex-col lg:flex-row justify-between w-full max-w-[1100px] max-xlsm:px-6 mx-auto">
					<div class="flex flex-col w-full lg:max-w-[750px]">

						<div class="flex flex-col font-sans article-body">
							{!! $article->body !!}
						</div>

						<div class="font-medium text-sm mt-4">
							{{ __('All rights reserved - copying, even partial, is not authorized') }}
						</div>
					</div>

					<div class="w-full lg:max-w-[300px] flex flex-col gap-y-4 max-lg:mt-8">
						@if($relatedArticles->isNotEmpty())
							<div class="flex flex-col gap-y-2">
								<h2 class="sidebar leading-snug font-bold">
									{!! __('Our last articles  <br><span class=\'font-medium\'>:section<span>', ['section' => strtolower($article->mainSection()->name)]) !!}
								</h2>

								<div class="border-6 border-jobboard-orange w-[56px] h-1 bg-jobboard-orange -mt-[13px] mb-4"></div>

								@foreach($relatedArticles as $relatedArticle)
									<a href="{{ route('article.show', ['article' => $relatedArticle->slug]) }}">
										<div class="text-lg font-bold pb-4 text-jobboard-deepblue w-full @if(!$loop->last) border-b border-jobboard-greige @endif">
											@if($loop->first)
												@if($photo = $relatedArticle->getFirstMedia('photo'))
													<img src="{{ $photo->getAvailableUrl(['optimized']) }}" alt="{{ $relatedArticle->title }}" class="object-cover md:w-[300px] md:h-[200px] mb-2" />
												@else
													<img src="{{ asset('/storage/default-image.png') }}" alt="{{ $relatedArticle->title }}" class="object-cover md:w-[300px] md:h-[200px] mb-2" />
												@endif
											@endif

											{{ $relatedArticle->title }}
										</div>
									</a>
								@endforeach
							</div>
						@endif

						@php
							if($article->mainSection()->slug) {
								$targeting = ['Targetingslug' => Request::url()];

								switch ($article->mainSection()->slug) {
									case 'professionnels':
										$targeting['role'] = 'pro';
										$targeting['espece'] = ['chien', 'chat'];
										break;

									case 'eleveurs':
										$targeting['role'] = 'eleveur';
										$specieTarget = "";
										break;

									case 'proprietaires':
										$targeting['role'] = 'adoptant';
										$specieTarget = "";
										break;

									default:
										$targeting['role'] = ['eleveur', 'adoptant', 'pro'];
										$specieTarget = "";
										break;
								}
							}
							else $targeting['role'] = ['Targetingslug' => Request::url(), 'role' =>['eleveur', 'adoptant', 'pro']];
						@endphp
						<div class="w-full flex justify-center">
							<x-front.ad-slot slotName="coeur_de_page" variant="all" :targeting="$targeting" />
						</div>
					</div>
				</div>

			</div>
		</article>
	</div>

	{{-- Best advices --}}
	@include('components.front.best-advice')
	{{-- End Best advices --}}

	@include('components.front.footer-partner-sitemap')
	{{-- End Bloc bottom nl, cta breeder/pro & partners --}}
</x-app-layout>
