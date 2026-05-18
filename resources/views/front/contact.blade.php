<x-app-layout>
	@push('seo')
		<title>Contacter le service client d'Eleveurs-online.com</title>
		<meta name="keywords" content="">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
		<link rel="canonical" href="{{ Request::url() }}" />
		<meta property="og:title" content="Contacter le service client d'Eleveurs-online.com">
		<meta property="og:description" content="Contacter le service client d'Eleveurs-online.com. Posez nous vos questions si vous rencontrez un problème sur notre plateforme.">
		<meta property="og:image" content="{{ asset('/storage/eleveurs_online.jpg') }}">
		<meta property="og:url" content="{{ Request::url() }}">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="Eleveurs Online">
		<meta property="og:locale" content="fr_FR">
	@endpush

	<x-slot name="page_title">
		{{ __('Contact us') }}
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
				<span itemprop="name">Contact</span>
				<meta itemprop="position" content="1">
			</li>
		</ol>
	</nav>
	<div class="w-full sm:max-w-4xl mx-auto mb-6 sm:px-6 sm:py-4 sm:rounded-md sm:border sm:border-gray-200 mt-10">
		<div class="flex flex-row flex-wrap my-6 mx-10">
			<h1 class="mb-4 leading-10 text-2xl text-left font-bold mr-4 text-breeder-deepblue">
				{{ __('Contact us') }}
			</h1>
		</div>

		<div class="mx-10">
			<p class="mb-6 text-sm sm:text-base lg:tracking-tight text-breeder-deepblue">
				{{ __('You can contact us via the contact form below. We are committed to responding to each of our customers as quickly as possible.') }}
			</p>

			<hr class="w-1/2 mx-auto my-8 h-px bg-gray-200 border-0 dark:bg-gray-700">

			<div class="flex flex-col lg:min-h-[600px]">
				<div>
					<form method="POST" action="{{ route('contact.submit') }}" enctype="multipart/form-data">
						@csrf

						<div class="grid gap-x-20 gap-y-10 grid-cols-1 mt-5">
							<div>
								<x-front.input-label for="object" :value="__('Object')" :required="true" :class="'pl-4'"/>

								<select id="object" name="object" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 w-full">
									<option value="">{{ __('Select an object') }}</option>
									<option {{ old('object') == 'information' ? 'selected' : '' }} value="information">{{ __('Information') }}</option>
									<option {{ old('object') == 'ad' ? 'selected' : '' }} value="ad">{{ __('Problem with an ad') }}</option>
									<option {{ old('object') == 'beeding-page' ? 'selected' : '' }} value="beeding-page">{{ __('Problem with a company page') }}</option>
									<option {{ old('object') == 'product-or-service-activity' ? 'selected' : '' }} value="product-or-service-activity">{{ __('Problem with a product or service activity page') }}</option>
									<option {{ old('object') == 'application' ? 'selected' : '' }} value="application">{{ __('Problem with an inquire') }}</option>
									<option {{ old('object') == 'report' ? 'selected' : '' }} value="report">{{ __('Report fraudulent behaviour or advertisement') }}</option>
									<option {{ old('object') == 'account' ? 'selected' : '' }} value="account">{{ __('Account Certification') }}</option>
									<option {{ old('object') == 'other' ? 'selected' : '' }} value="other">{{ __('Other request') }}</option>
									<option {{ old('object') == 'advertiser' ? 'selected' : '' }} value="advertiser">{{ __('I am an advertiser and want more information') }}</option>
									<option {{ old('object') == 'professionnal-breeder' ? 'selected' : '' }} value="professionnal-breeder">{{ __('I\'m a professionnal breeder and I\'d like to switch to an individual breeder') }}</option>
									<option {{ old('object') == 'application-rdv-issue' ? 'selected' : '' }} value="application-rdv-issue">{{ __('Report an issue about a inquire or a rendez-vous') }}</option>
									<option {{ old('object') == 'member-snpcc' ? 'selected' : '' }} value="member-snpcc">{{ __('Request to benefit from 20% as an SNPCC member') }}</option>
									<option {{ old('object') == 'data-deletion' ? 'selected' : '' }} value="data-deletion">{{ __('I wish to delete my account and the removal of all my personnal data') }}</option>
								</select>

								<div class="flex flex-row">
									@error('object')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>

							<div>
								<x-front.input-label for="firstname" :value="__('Firstname')" :required="true" :class="'pl-4'"/>

								<x-front.text-input id="firstname" name="firstname" :value="old('firstname')" placeholder="{{ __('Firstname') }}" required :class="'mt-1 block w-full'" />

								@error('firstname')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div>
								<x-front.input-label for="lastname" :value="__('Lastname')" :required="true" :class="'pl-4'"/>

								<x-front.text-input id="lastname" name="lastname" :value="old('lastname')" placeholder="{{ __('Lastname') }}" required :class="'mt-1 block w-full'" />

								@error('lastname')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div>
								<x-front.input-label for="phone" :value="__('Phone')" :required="true" :class="'pl-4'"/>

								<x-front.text-input id="phone" name="phone" :value="old('phone')" placeholder="{{ __('Phone') }}" required :class="'mt-1 block w-full'" />

								@error('phone')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div>
								<x-front.input-label for="email" :value="__('Email')" :required="true" :class="'pl-4'"/>

								<x-front.text-input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" required :class="'mt-1 block w-full'" />

								@error('email')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div>
								<x-front.input-label for="body" :value="__('Commentary')" :required="true" :class="'pl-4'"/>

								<textarea name="body" cols="30" rows="6" placeholder="{{ __('Commentary') }}" required class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm mt-1 block w-full text-breeder-deepblue">{{ old('body') }}</textarea>

								@error('body')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div>
								<x-front.input-label for="file" :value="__('Attachment')" :class="'pl-4'"/>

								<input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-breeder-deepblue hover:border-breeder-deepblue bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-breeder-greige transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-breeder-deepblue file:px-3 file:py-[0.32rem] file:text-breeder-cream file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-jobboard-blue dark:file:bg-jobboard-blue dark:file:text-neutral-100 dark:focus:border-primary" />

								@error('file')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>

							<div>
								<div class="flex flex-row" x-data="{checked: false}">
									<input type="checkbox" name="consent" {{ old('consent') ? 'checked' : '' }} value="true" class="w-4 h-4 mt-2 text-breeder-deepblue bg-gray-100 border-breeder-greige rounded focus:ring-0 focus:ring-offset-0 focus:outline-none cursor-pointer" />
									<x-front.input-label for="consent" :value="__('By submitting this form, I accept that the information entered is used as part of the contact request')" :required="true" :class="'ml-2 cursor-pointer'"/>
								</div>

								<div class="flex flex-row">
									@error('consent')
										<span class="error text-danger-700">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>

							<div :class="'mt-2'">
								<x-front.input-label for="captcha" :value="__('Verification')" :required="true" />

								<div class="captcha my-2 flex flex-row items-end">
									<img src="{{ captcha_src() }}" alt="captcha" onclick="this.src='{{ captcha_src() }}'+Math.random()">
								</div>

								<div class="flex flex-row">
									<x-front.text-input id="captcha" name="captcha" type="text" class="mt-1 block w-full s:w-1/2 lg:w-1/4" required />
								</div>

								@error('captcha')
									<span class="error text-danger-700">
										{{ $message }}
									</span>
								@enderror
							</div>
						</div>

						<div class="flex items-center justify-between mt-12">
							<x-front.primary-button>
								{{ __('Submit') }}
							</x-front.primary-button>
						</div>
					</form>
				</div>
			</div>
		</div>

		</div>
	</div>
</x-app-layout>
