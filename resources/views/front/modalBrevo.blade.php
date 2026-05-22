{{-- resources/views/components/front/compare-modal.blade.php --}}
<div>
	<x-front.modal name="choix_race" class="w-full max-w-2xl" focusable>
		<img
			src="{{ asset(request()->segment(1) == __('dog') ? '/storage/dog_search_white.svg?v1' : '/storage/cat_search_white.svg') }}" />

		<div class="text-jobboard-deepblue text-3xl mb-4 ">
			<span class="font-bold">{{ __('What breed of') }} {{ request()->segment(1) }}&nbsp;</span>
			<span class="font-normal">{{ __('suits me') }}&nbsp;?</span>
		</div>
		<hr class="my-6 border-t border-gray-200">

		<span class="flex justify-start text-jobboard-deepblue  text-base font-semibold mb-4">
			{{ __('To access the results, please fill in your email address') }}:
		</span>


		<form id="compare-popup-form" method="POST" action="">
			@csrf
			<div class="mb-4">
				<x-front.input-label for="email_confirmation" :value="__('Email address')" />
				<x-front.text-input type="email" name="email_confirmation" id="email_confirmation"
					placeholder="{{ __('Email') }}" class="mt-1 block w-full bg-white" />
				<p id="email_error" class="text-red-600 text-sm mt-1 hidden">
					{{ __('Please enter your email address') }}
				</p>
			</div>

			<div class="flex flex-col gap-2 mt-4">
				<x-front.input-label for="OPTIN_NL_ADOPTANT" class="cursor-pointer">
					<input type="checkbox" name="OPTIN_NL_ADOPTANT" id="OPTIN_NL_ADOPTANT" checked>
					{{ __('I subscribe to the monthly newsletter of Eleveurs Online') }}.
				</x-front.input-label>

				<x-front.input-label for="OPTIN_MARKETING_ADOPTANT" class="cursor-pointer">
					<input type="checkbox" name="OPTIN_MARKETING_PROSPECT" id="OPTIN_MARKETING_PROSPECT" checked>
					{{ __('I agree to receive good deals from Eleveurs Online and its publishers') }}.
				</x-front.input-label>

				<x-front.input-label for="OPTIN_PARTENAIRE_PROSPECT" class="cursor-pointer">
					<input type="checkbox" name="OPTIN_PARTENAIRE_PROSPECT" id="OPTIN_PARTENAIRE_PROSPECT" checked>
					{{ __('I agree to receive offers from Eleveurs Online partners') }}.
				</x-front.input-label>
			</div>

			<div class="mt-6 flex justify-start">
				<button type="submit"
					class="flex items-center gap-2 bg-jobboard-deepblue text-white px-6 py-2 rounded-full font-semibold"
					id="confirmCompareBtn">

					<img src="{{ asset(request()->segment(1) == __('dog') ? '/storage/icone_dog_pink.svg' : '/storage/icone_cat_green.svg') }}"
						alt="" class="w-5 h-5" />

					{{ __('Discover the result') }}
				</button>

			</div>
		</form>
	</x-front.modal>

	{{-- Alpine to auto-open modal on condition --}}
	@guest
		<div x-data x-init="if (!document.cookie.includes('compare_access_granted=true') &&
			localStorage.getItem('show_comparateur_popup') === '1') {
			localStorage.removeItem('show_comparateur_popup');
			$dispatch('open-modal', 'choix_race');
		}">
		</div>
	@endguest

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const confirmBtn = document.querySelector('#confirmCompareBtn');
			const mainForm = document.getElementById('breedForm');

			confirmBtn?.addEventListener('click', function(e) {
				e.preventDefault();

				const email = document.querySelector('#email_confirmation')?.value;
				const errorMsg = document.getElementById('email_error');
				const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

				if (!email || !emailRegex.test(email)) {
					errorMsg?.classList.remove('hidden');
					return;
				} else {
					errorMsg?.classList.add('hidden');
				}

				const optin1 = document.getElementById('OPTIN_NL_ADOPTANT')?.checked ? '1' : '0';
				const optin2 = document.getElementById('OPTIN_MARKETING_PROSPECT')?.checked ? '1' : '0';
				const optin3 = document.getElementById('OPTIN_PARTENAIRE_PROSPECT')?.checked ? '1' : '0';

				// Save access cookie for 30 days
				document.cookie = "compare_access_granted=true; path=/; max-age=" + (60 * 60 * 24 * 30);

				// Close modal
				window.dispatchEvent(new CustomEvent('close'));

				// Récupérer les données du formulaire stockées
				const storedFormData = JSON.parse(localStorage.getItem('pendingFormData'));
				localStorage.removeItem('pendingFormData');

				// Créer des champs cachés pour les nouvelles données
				const emailInput = document.createElement('input');
				emailInput.type = 'hidden';
				emailInput.name = 'email_confirmation';
				emailInput.value = email;

				const optin1Input = document.createElement('input');
				optin1Input.type = 'hidden';
				optin1Input.name = 'OPTIN_NL_ADOPTANT';
				optin1Input.value = optin1;

				const optin2Input = document.createElement('input');
				optin2Input.type = 'hidden';
				optin2Input.name = 'OPTIN_MARKETING_PROSPECT';
				optin2Input.value = optin2;

				const optin3Input = document.createElement('input');
				optin3Input.type = 'hidden';
				optin3Input.name = 'OPTIN_PARTENAIRE_PROSPECT';
				optin3Input.value = optin3;

				// Ajouter les champs au formulaire principal
				mainForm.appendChild(emailInput);
				mainForm.appendChild(optin1Input);
				mainForm.appendChild(optin2Input);
				mainForm.appendChild(optin3Input);

				let questionType = '';
				if (window.location.pathname.includes('chien')) {
					questionType = 'chien_race';
				} else if (window.location.pathname.includes('chat')) {
					questionType = 'chat_race';
				}

				window.dataLayer = window.dataLayer || [];
				window.dataLayer.push({
					event: 'lead_questionnaire',
					question_type: questionType
				});

				// Soumettre le formulaire principal
				mainForm.submit();
			});
		});
	</script>
</div>
