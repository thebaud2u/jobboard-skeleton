<x-app-layout>
	@push('seo')
		<title>{{ env('APP_NAME') }}</title>
		<meta name="description" content="{{ __(':siteName', ['siteName' => env('APP_NAME')]) }}">
		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
	@endpush

	<nav class="breadcrumb-list hidden">
		<ol class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
				<a itemprop="item" href="/">
					<span itemprop="name">Accueil</span>
				</a>
				<meta itemprop="position" content="0">
			</li>
			<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem" class="current">
					<span itemprop="name">Désinscription</span>
					<meta itemprop="position" content="1">
			</li>
		</ol>
	</nav>

	<div class="bg-white w-full py-8 flex flex-col items-center text-breeder-deepblue">
		@if($errors->any() || Session::has('error') || Session::has('success') || Session::has('warning') || Session::has('info'))
			<div class="py-5 px-4 lg:px-6" x-data="{}" x-ref="alert">
				@include('components.front.alerts')
			</div>
		@endif

		<h2 class="font-bold text-xl">
			{{  __('Unsubscribe') }}
		</h2>
		@php
			switch ($optin) {
				case 'OPTIN_NL_ADOPTANT':
						$optinTrad = "Les Newsletter des adoptants et propriétaires d'animaux";
					break;
				case 'OPTIN_MARKETING_ADOPTANT':
						$optinTrad = "Les informations d'Eleveurs Online et de leurs éditeurs";
					break;
				case 'OPTIN_PARTENAIRE_ADOPTANT':
						$optinTrad = "Les offres des partenaires d'Eleveurs Online";
					break;
				case 'OPTIN_NL_ELEVEUR':
						$optinTrad = "Les Newsletter des éleveurs canins et félins";
					break;
				case 'OPTIN_MARKETING_ELEVEUR':
						$optinTrad = "Les informations d'Eleveurs Online et de leurs éditeurs";
					break;
				case 'OPTIN_PARTENAIRE_ELEVEUR':
						$optinTrad = "Les offres des partenaires d'Eleveurs Online";
					break;
				case 'OPTIN_NL_PROFESSIONNEL':
						$optinTrad = "Les Newsletter des professionnels de l'animal de compagnie";
					break;
				case 'OPTIN_MARKETING_PROFESSIONNEL':
						$optinTrad = "Les informations d'Eleveurs Online et de leurs éditeurs";
					break;
				case 'OPTIN_PARTENAIRE_PROFESSIONNEL':
						$optinTrad = "Les offres des partenaires d'Eleveurs Online";
					break;
				case 'OPTIN_MARKETING_PROSPECT':
						$optinTrad = "Les informations d'Eleveurs Online et de leurs éditeurs";
					break;
				case 'OPTIN_PARTENAIRE_PROSPECT':
						$optinTrad = "Les offres des partenaires d'Eleveurs Online";
					break;
				
				default:
					$optinTrad = $optin;
					break;
			}
		@endphp

		<p>Cliquez sur "me désinscrire" pour ne plus recevoir de courriel de <strong>{{ $optinTrad }}</strong> sur cette adresse mail : {{ $email }}</p>

		<form method="POST" action="{{ route('newsletter.form-unsubscribe') }}" class="mt-8">
			@csrf

			<input type="hidden" name="email" value="{{ $email }}" />
			<input type="hidden" name="optin" value="{{ $optin }}" />

			<x-front.primary-button type="submit">
				{{ __('Unsubscribe') }}
			</x-front.primary-button>
		</form>
	</div>
</x-app-layout>
