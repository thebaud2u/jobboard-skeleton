<x-app-layout>
	@push('seo')
		<title>S'inscrire aux newsletters d'Eleveurs-Online</title>
		<meta name="description" content="Une lettre dédiée selon votre profil : propriétaires d'animaux et passionés, éleveurs, professionnels de l'animal de compagnie">
		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
		<meta property="og:title" content="S'inscrire aux newsletters d'Eleveurs-Online">
		<meta property="og:description" content="Une lettre dédiée selon votre profil : propriétaires d'animaux et passionés, éleveurs, professionnels de l'animal de compagnie">
		<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		<meta property="og:url" content="{{ Request::url() }}">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="{{ env('APP_NAME') }}">
		<meta property="og:locale" content="fr_FR">
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
					<span itemprop="name">Newsletter</span>
                    <meta itemprop="position" content="1">
			</li>
        </ol>
	</nav>
    <div class="bg-breeder-cream w-full py-8 flex flex-col items-center text-breeder-deepblue" x-data="{ passionateShow: false, breederShow: false, proShow: false }">
        <h1 class="flex flex-col items-center text-[40px] font-bold">
            <svg width="56" height="55" viewBox="0 0 56 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                <mask id="mask0_1439_23553" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0"
                    width="56" height="55">
                    <path d="M54.8965 0.75V54.25H1.10352V0.75H54.8965Z" fill="white" stroke="white"
                        stroke-width="1.5" />
                </mask>
                <g mask="url(#mask0_1439_23553)">
                    <path d="M54.8201 20.6738L33.9883 37.7062" stroke="#0E1954" stroke-width="1.5"
                        stroke-miterlimit="10" />
                    <path d="M21.9969 37.7062L1.16504 20.6738" stroke="#0E1954" stroke-width="1.5"
                        stroke-miterlimit="10" />
                    <path d="M7.74525 14.749L1.16504 20.6384V54.1862H54.8253V20.6384L48.2451 14.749" stroke="#0E1954"
                        stroke-width="1.5" stroke-miterlimit="10" />
                    <path d="M1.16504 54.184L28.0051 32.2236L54.8451 54.184" stroke="#0E1954" stroke-width="1.5"
                        stroke-miterlimit="10" />
                    <path d="M7.75781 21.5294V0.816406H48.2576V21.5294" stroke="#0E1954" stroke-width="1.5"
                        stroke-miterlimit="10" />
                </g>
                <path d="M15.1289 8.57324H40.9811" stroke="#0E1954" stroke-width="1.5" stroke-miterlimit="10" />
                <path d="M15.1289 16.7578H40.9811" stroke="#0E1954" stroke-width="1.5" stroke-miterlimit="10" />
                <path d="M15.1289 24.9453H40.9811" stroke="#0E1954" stroke-width="1.5" stroke-miterlimit="10" />
            </svg>

			{{ __('Newsletter') }}

            <p class="text-center font-medium text-base">
                {{ __('Choose the newsletters you want to receive in your inbox') }}</p>
        </h1>
        
        @if($errors->any() || Session::has('error') || Session::has('success') || Session::has('warning') || Session::has('info'))
            <div class="py-5 px-4 lg:px-6" x-data="{}" x-ref="alert">
                @include('components.front.alerts')
            </div>
			@if (session('gtm'))
				<script>
					window.dataLayer = window.dataLayer || [];
					window.dataLayer.push(@json(session('gtm')));
				</script>
			@endif
        @endif

		<div class="flex justify-between max-w-[873px] mt-10">
			<div class="flex flex-col items-stretch md:flex-row max-md:gap-y-4 md:gap-x-4 w-full">
				<div class="flex flex-row md:flex-col w-full md:w-[281px] rounded-md"
					:class="{ 'opacity-50': breederShow || proShow, 'opacity-100': passionateShow }">
					<div
						class="relative bg-breeder-coral w-[115px] md:w-full h-[98px] dc:h-full md:h-[200px] max-md:rounded-l-md md:rounded-t-md">
						<div
							class="absolute w-[115px] md:w-[327px] h-[108px] md:h-[219px] left-0 md:-left-[23px] top-[21px] md:-top-[18px]">
							<img src="{{ asset('/storage/newsletter_passiones.png') }}" alt="" class="w-full">
						</div>
					</div>
					<div
						class="w-[235px] md:w-full flex flex-col items-center text-breeder-deepblue bg-white max-md:rounded-b-none max-md:rounded-r-md rounded-b-md py-3 md:py-6 px-6 md:px-4">
						<h4 class="max-md:text-lg md::text-[28px] font-semibold text-center max-md:mb-2">{{ __('For enthusiasts') }}
						</h4>
						<p class="hidden md:block text-center text-base mb-4">
							Conseils nutrition, santé, entretien, éducation et comportement... Recevez notre newsletter mensuelle
						</p>
						<x-front.secondary-button
							x-on:click="passionateShow = true, breederShow = false, proShow = false" :class="'max-md:px-3 max-md:py-2'">{{ __('I subscribe') }}</x-front.secondary-button>
					</div>
					<div class="relative w-full max-md:hidden" x-show="passionateShow && !proShow && !breederShow">
						<div class="absolute top-0 left-[50%] transform translate-x-[-50%]">
							<svg width="66" height="22" viewBox="0 0 66 22" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M33 22L65.909 0.25H0.0910339L33 22Z" fill="white" />
							</svg>
						</div>
					</div>
				</div>

				<div class="flex flex-row md:flex-col w-full md:w-[281px] rounded-md"
					:class="{ 'opacity-50': passionateShow || proShow, 'opacity-100': breederShow }">
					<div
						class="relative bg-breeder-violet w-[115px] md:w-full h-[98px] dc:h-full md:h-[200px] max-md:rounded-l-md md:rounded-t-md">
						<div
							class="absolute w-[96px] md:w-[265px] h-[113px] md:h-[219px] left-[13px] md:left-[21px] top-[20px] md:-top-[16px]">
							<img src="{{ asset('/storage/newsletter_breeders.png') }}" alt="" class="w-full">
						</div>
					</div>
					<div
						class="w-[235px] md:w-full flex flex-col items-center text-breeder-deepblue bg-white max-md:rounded-b-none max-md:rounded-r-md rounded-b-md py-3 md:py-6 px-6 md:px-4">
						<h4 class="max-md:text-lg md::text-[28px] font-semibold text-center max-md:mb-2">
							{{ __('Special breeders') }}</h4>
						<p class="hidden md:block text-center text-base mb-4">
							Reproduction, prévention, gestion de l'entreprise, législation... Recevez notre newsletter mensuelle
						</p>
						<x-front.secondary-button
							x-on:click="breederShow = true, passionateShow = false, proShow = false" :class="'max-md:px-3 max-md:py-2'">{{ __('I subscribe') }}</x-front.secondary-button>
					</div>
					<div class="relative w-full max-md:hidden" x-show="breederShow && !passionateShow && !proShow">
						<div class="absolute top-0 left-[50%] transform translate-x-[-50%]">
							<svg width="66" height="22" viewBox="0 0 66 22" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M33 22L65.909 0.25H0.0910339L33 22Z" fill="white" />
							</svg>
						</div>
					</div>
				</div>
				
				<div class="flex flex-row md:flex-col w-full md:w-[281px] rounded-md"
					:class="{ 'opacity-50': passionateShow || breederShow, 'opacity-100': proShow }">
					<div
						class="relative bg-breeder-orange w-[115px] md:w-full h-[98px] md:h-[200px] max-md:rounded-l-md md:rounded-t-md">
						<div
							class="absolute w-[81px] md:w-[237px] h-[111px] md:h-[219px] left-[15px] md:left-[15px] top-[24px] md:-top-[17px]">
							<img src="{{ asset('/storage/newsletter_pro.png') }}" alt="" class="w-full">
						</div>
					</div>
					<div
						class="w-[235px] md:w-full flex flex-col items-center text-breeder-deepblue bg-white max-md:rounded-b-none max-md:rounded-r-md rounded-b-md py-3 md:py-6 px-6 md:px-4">
						<h4 class="max-md:text-lg md::text-[28px] font-semibold text-center max-md:mb-2">
							{{ __('For the pros') }}</h4>
						<p class="hidden md:block text-center text-base mb-4">
							Produits, marchés, entreprises, distribution, agenda et évènements... Recevez notre newsletter mensuelle
						</p>
						<x-front.secondary-button
							x-on:click="proShow = true, passionateShow = false, breederShow = false" :class="'max-md:px-3 max-md:py-2'">{{ __('I subscribe') }}</x-front.secondary-button>
					</div>
					<div class="relative w-full max-md:hidden" x-show="proShow && !passionateShow && !breederShow">
						<div class="absolute top-0 left-[50%] transform translate-x-[-50%]">
							<svg width="66" height="22" viewBox="0 0 66 22" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M33 22L65.909 0.25H0.0910339L33 22Z" fill="white" />
							</svg>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Opt in -->
		<form method="POST" action="{{ route('newsletter.subscribe') }}"
			class="flex flex-col bg-white rounded-xl max-w-[873px] w-full mt-8 p-8 gap-4" x-show="passionateShow">
			@csrf

            <div class="flex flex-col items-center gap-3 mb-4">
                <p class="text-breeder-deepblue font-bold">Je m'abonne à la newsletter</p>
                <h2 class="text-center text-[28px] md:text-[40px]">
                    {{ __('Pour les passionnés') }}
                </h2>
            </div>

			<div class="w-full">
				<x-front.input-label for="email" :value="__('Email address')" :required="true" :class="'pl-4'" />
				<x-front.text-input name="email" id="email" value="{{ old('email') }}" required
					placeholder="{{ __('Email') }}" :class="'mt-1 block bg-white w-full'" />
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_NL_ADOPTANT" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I subscribe to the monthly newsletter of Eleveurs Online') }}
				</x-front.input-label>
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_MARKETING_ADOPTANT" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I would like to receive information from Eleveurs Online and their publishers') }}
				</x-front.input-label>
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_PARTENAIRE_ADOPTANT" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I would like to receive good deals from Eleveurs Online partners') }}
				</x-front.input-label>
			</div>

			<x-front.primary-button :class="'justify-center gap-x-2 mt-4'">
				{{ __('I subscribe') }}

				<svg width="11" height="13" viewBox="0 0 11 13" fill="none"
					xmlns="http://www.w3.org/2000/svg">
					<path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2"
						stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</x-front.primary-button>
		</form>

        <form method="POST" action="{{ route('newsletter.subscribe') }}"
            class="flex flex-col bg-white rounded-xl max-w-[873px] w-full mt-8 p-8 gap-4" x-show="breederShow">
            @csrf
            <div class="flex flex-col items-center gap-3 mb-4">
                <p class="text-breeder-deepblue font-bold">Je m'abonne à la newsletter</p>
                <h2 class="text-center text-[28px] md:text-[40px]">
                    {{ __('Spécial éleveurs') }}
                </h2>
            </div>

			<div class="w-full">
				<x-front.input-label for="email" :value="__('Email address')" :required="true" :class="'pl-4'" />
				<x-front.text-input name="email" id="email" value="{{ old('email') }}" required
					placeholder="{{ __('Email') }}" :class="'mt-1 block bg-white w-full'" />
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_NL_ELEVEUR" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I subscribe to the monthly newsletter of Eleveurs Online') }}
				</x-front.input-label>
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_MARKETING_ELEVEUR" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I would like to receive information from Eleveurs Online and their publishers') }}
				</x-front.input-label>
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_PARTENAIRE_ELEVEUR" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I would like to receive good deals from Eleveurs Online partners') }}
				</x-front.input-label>
			</div>

			<x-front.primary-button :class="'justify-center gap-x-2 mt-4'">
				{{ __('I subscribe') }}

                <svg width="11" height="13" viewBox="0 0 11 13" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </x-front.primary-button>
        </form>
        <form method="POST" action="{{ route('newsletter.subscribe') }}"
            class="flex flex-col bg-white rounded-xl max-w-[873px] w-full mt-8 p-8 gap-4" x-show="proShow">
            @csrf
            <div class="flex flex-col items-center gap-3 mb-4">
                <p class="text-breeder-deepblue font-bold">Je m'abonne à la newsletter</p>
                <h2 class="text-center text-[28px] md:text-[40px]">
                    {{ __('Pour les pros') }}
                </h2>
            </div>

			<div class="w-full">
				<x-front.input-label for="email" :value="__('Email address')" :required="true" :class="'pl-4'" />
				<x-front.text-input name="email" id="email" value="{{ old('email') }}" required
					placeholder="{{ __('Email') }}" :class="'mt-1 block bg-white w-full'" />
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_NL_PROFESSIONNEL" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I subscribe to the monthly newsletter of Eleveurs Online') }}
				</x-front.input-label>
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_MARKETING_PROFESSIONNEL" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I would like to receive information from Eleveurs Online and their publishers') }}
				</x-front.input-label>
			</div>

			<div class="flex flex-row justify-between flex-wrap gap-y-2 items-center">
				<x-front.input-label :class="'cursor-pointer'">
					<input checked type="checkbox" name="optins[]" value="OPTIN_PARTENAIRE_PROFESSIONNEL" class="rounded border-breeder-deepblue text-breeder-deepblue focus:ring-breeder-deepblue">

					{{ __('I would like to receive good deals from Eleveurs Online partners') }}
				</x-front.input-label>
			</div>

			<x-front.primary-button :class="'justify-center gap-x-2 mt-4'">
				{{ __('I subscribe') }}

				<svg width="11" height="13" viewBox="0 0 11 13" fill="none"
					xmlns="http://www.w3.org/2000/svg">
					<path d="M2.36231 1.5L7.81685 6.5L2.3623 11.5" stroke="#F7F6EF" stroke-width="2"
						stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</x-front.primary-button>
		</form>
		<div class="flex justify-center items-center mx-auto max-w-[1200px] bg-breeder-cream w-full mt-10">
			<x-front.ad-slot slotName="banniere_basse" variant="all" :targeting="['Targetingslug' => Request::url(), 'role' => ['adoptant', 'eleveur', 'pro'], 'espece' => ['chien', 'chat']]" />
		</div>
	</div>

</x-app-layout>
